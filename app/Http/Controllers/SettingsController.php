<?php

namespace App\Http\Controllers;

use App\Models\SuggestionConfigurations\SilkConfiguration;
use App\Settings;
use Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Yajra\Datatables\Datatables;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware('web');
    }

    /**
     * Show the application dashboard.
     *
     * @return Response
     */
    public function index()
    {
        $user = Auth::user();
        $providers = \App\Models\SuggestionProvider::all();

        return view('settings', ['user' => $user, 'providers' => $providers]);
    }

    public function create()
    {
        $input = array_filter(request()->all());
        $settings = Settings::create($input);
        $settings->provider->validate($settings);

        return redirect()->route('settings')->with('notification', 'Settings Created!!!');
    }

    public function destroy()
    {
        $id = request()->id;
        Settings::destroy($id);

        return 'Settings with id '.$id.' was deleted';
    }

    public function render()
    {
        $file = '/app/projects/default_config.xml';
        $filename = storage_path().$file;
        $xml = file_get_contents($filename);
        $silk = new SilkConfiguration();
        if ($silk->validateSchema($file)) {
            $result = $silk->parseXML($xml);
        } else {
            return 'Validation error. Your settings file is not a valid Silk LSL settings file';
        }
        foreach ($silk->nodes as $node) {
            dd($silk->getNode($result, $node));
        }
    }

    public function export()
    {
        $setting = Settings::find(request()->id);

        return response()->download($setting->resource->path());
    }

    public function copy()
    {
        $setting = Settings::find(request()->id);

        return response()->download($setting->resource->path());
    }

    public function errors()
    {
        try {
            $validation = \App\ValidationError::where('setting_id', '=', request()->id)->latest()->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return 'There is no errors Found';
        }
        $bag = json_decode($validation->bag);
        $valid = $bag->valid;
        $errors = $bag->errors;

        return view('settings.partials.validation', [
            'validation' => $validation,
            'valid' => $valid,
            'errors' => $errors,
        ]);
    }

    public function ajax()
    {
        $settings = Settings::select(['id', 'name', 'public', 'valid']);

        return Datatables::of($settings)
                        ->addColumn('action', function ($setting) {
                            return view('settings.partials.actions', [
                                'setting' => $setting,
                            ]);
                        })
                        ->make(true);
    }
}
