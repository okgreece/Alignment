<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

trait RDFTrait
{
    /*
     * Currently this works because of a hack in easyrdf library
     * I have created an issue but untill this get resolved we continue
     * using the hack on Namespace.php. I have commented out the lines where get
     * method checks for \W preg_match. When hyphens are included on the prefix,
     * these lines cause this method to fail when serializing graphs into files
     */
    public static function setNamespaces()
    {
        $namespaces = \App\rdfnamespace::where('added', '=', '1')->get();
        foreach ($namespaces as $namespace) {
            \EasyRdf_Namespace::set($namespace->prefix, $namespace->uri);
        }

        return 0;
    }

    public static function uknownNamespace($uri)
    {
        $tempnamespace = new \EasyRdf_Resource($uri);
        $local = $tempnamespace->localName();

        $namespace = mb_substr($uri, 0, -mb_strlen($local));
        $existing = \App\rdfnamespace::where('uri', '=', $namespace)->get();
        if ($existing->isEmpty()) {
            \App\rdfnamespace::create(['prefix'=>'null',
                                    'uri'=>$namespace,
                                    'added'=> 0,
                                    ]);
        }

        return $uri;
    }

    /*
     * Function to merge two graphs. Taken from https://gist.github.com/indeyets/a1e5c9882c778dd60713.
     *
     * @param EasyRdf_Graph $graph1
     * @param EasyRdf_Graph $graph2
     *
     * @return EasyRdf_Graph
    */

    public static function mergeGraphs(\EasyRdf_Graph $graph1, \EasyRdf_Graph $graph2)
    {
        $data1 = $graph1->toRdfPhp();
        $data2 = $graph2->toRdfPhp();
        $merged = array_merge_recursive($data1, $data2);
        unset($data1, $data2);

        return new \EasyRdf_Graph('urn:easyrdf:merged', $merged, 'php');
    }

    /* function to get the label of a resource based on 4 rules by priority:
     * 1)Get the browser locale setting and request this language
     * 2)Get the label for the default language set
     * 3)Get any label in any language
     * 4)Return the IRI as a string to use for label
     *
     */
    public static function label(\EasyRdf_Graph $graph, $uri)
    {
        $label_properties =
                \App\LabelExtractor::where('enabled', '=', '1')
                ->orderBy('priority', 'asc')
                ->get();
        $label = null;
        $locale = Cookie::get('locale');
        foreach ($label_properties as $property) {
            if ($label == null) {
                $label = $graph
                        ->getLiteral(
                                $uri,
                                new \EasyRdf_Resource($property->property),
                                $locale
                                );
            } else {
                break;
            }
            if ($label == null) {
                //get default label in English. This should be configurable on .env
                $label = $graph
                        ->getLiteral(
                                $uri,
                                new \EasyRdf_Resource($property->property),
                                'en'
                                );
            }
            if ($label == null) {
                //if no english label found try a label in any language
                $label = $graph
                        ->getLiteral(
                                $uri,
                                new \EasyRdf_Resource($property->property)
                                );
            }
        }
        if ($label == null) {
            $label = \EasyRdf_Namespace::shorten($uri, true);
        }

        return $label;
    }
}
