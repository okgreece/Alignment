<?php

namespace App;

use Codesleeve\Stapler\ORM\EloquentTrait;
use Codesleeve\Stapler\ORM\StaplerableInterface;
use Illuminate\Database\Eloquent\Model;

class Import extends Model implements StaplerableInterface
{
    use EloquentTrait;

    protected $fillable = ['resource', 'filetype', 'project_id', 'user_id'];

    public function __construct(array $attributes = [])
    {
        $this->hasAttachedFile('resource', [
        ]);

        parent::__construct($attributes);
    }

    public function user()
    {
        return $this->belongsTo("App\User");
    }

    public function project()
    {
        return $this->belongsTo("App\Project");
    }

    public function getDirty()
    {
        $dirty = parent::getDirty();

        return array_filter($dirty, function ($var) {
            return ! ($var instanceof \Codesleeve\Stapler\Attachment);
        });
    }

    private function convertImported()
    {
        $command = 'rapper -i '.$this->filetype.' -o rdfxml-abbrev '.$this->resource->path().' > '.$this->resource->path().'.rdf';
        $out = [];
        exec($command, $out);
    }

    public function importGraph()
    {
        $graph = new \EasyRdf_Graph();
        try {
            if ($this->filetype != 'rdfxml') {
                $this->convertImported();
                $graph->parseFile($this->resource->path().'.rdf', 'rdfxml');
            } else {
                $graph->parseFile($this->resource->path(), 'rdfxml');
            }
            $this->parsed = true;
            $this->save();

            return $graph;
        } catch (\Exception $ex) {
            $this->parsed = false;
            $this->save();
            logger('Fail to parse file. Check filetype or valid syntax. Error:'.$ex);

            return;
        }
    }

    private function createLink(
            \EasyRdf_Resource $subject,
            $property,
            \EasyRdf_Resource $object)
    {
        $data = [
            'source' => $subject->getUri(),
            'target' => $object->getUri(),
            'link_type' => $property,
            'project_id' => $this->project_id,
        ];
        $request = \Illuminate\Support\Facades\Request::create('/', 'GET', $data);
        Link::create($request);
    }

    private function iterateLinks(\EasyRdf_Resource $resource, $property)
    {
        $links = $resource->allResources(new \EasyRdf_Resource($property));
        foreach ($links as $link) {
            $this->createLink($resource, $property, $link);
        }
    }

    private function iterateProperties(\EasyRdf_Resource $resource)
    {
        $properties = $resource->propertyUris();
        foreach ($properties as $property) {
            $this->iterateLinks($resource, $property);
        }
    }

    private function iterateResources(\EasyRdf_Graph $graph)
    {
        $resources = $graph->resources();
        foreach ($resources as $resource) {
            $this->iterateProperties($resource);
        }
    }

    public function importLinks()
    {
        $graph = $this->importGraph();
        $this->iterateResources($graph);
        $this->imported = true;
        $this->save();

        return $this;
    }
}
