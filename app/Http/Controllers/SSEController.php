<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class SSEController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function sse() {
        //support for firefox
        
        $response = new \Symfony\Component\HttpFoundation\StreamedResponse(function() {
            $counter = 1;
            while ( true ) {
                $data = $this->getData();
                if ($data != null) {
                    echo 'data: ' . json_encode($data) . "\n\n";
                    ob_flush();
                    flush();
                }
                else{
                    if($counter == 1){
                        echo 'data: ' . json_encode(array("message" => "System ready!!!", "status" => -1)) . "\n\n";
                        ob_flush();
                        flush();
                    }
                    
                }
                $counter ++;
                sleep(5);
            }
        });
        $response->headers->set('Content-Type', 'text/event-stream');
        return $response;
    }

    public function getData(){
        $user = auth()->user()->id;
        $notification = \App\Notification::where('user_id', '=', $user)
                ->where('read', '=', 0)
                ->first();
        return $notification;
    }
    
    public function read(Request $request){
        $user = auth()->user()->id;
        
        $notification = \App\Notification::where('user_id', '=', $user)
                ->where('read', '=', '0')
                ->first();
        $notification->read = true;
        $notification->save();
        return $user;
    }

}
