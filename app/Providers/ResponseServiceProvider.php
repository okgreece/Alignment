<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;

class ResponseServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Response::macro("downloadFromCache", function($content, $format, $filename){
            $File_Ext = \EasyRdf_Format::getFormat($format)->getDefaultExtension(); //get file extention
            $headers = [
                'Content-Description' => 'File Transfer',
                'Content-Disposition' => 'attachment; filename=' . $filename. '.' .$File_Ext,
                'Content-Transfer-Encoding' => 'binary',
                'Expires' => '0',
                'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
                'Pragma' => 'public',                
                'Content-Type' => $format
                ];
            return Response::make($content, 200, $headers);
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
