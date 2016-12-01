<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/
    Route::get('/', function () {
    return view('welcome');
});


Route::group(['middleware' => ['web']], function () {
    //
    Route::auth();
    
    Route::get('auth/github', ['uses' => 'Auth\GithubSocialAuthController@redirectToProvider', 'as' => 'github.redirect']);
    Route::get('auth/github/callback', ['uses' => 'Auth\GithubSocialAuthController@handleProviderCallback', 'as' => 'github.callback']);
    
    Route::get('auth/google', ['uses' => 'Auth\GoogleSocialAuthController@redirectToProvider', 'as' => 'google.redirect']);
    Route::get('auth/google/callback', ['uses' => 'Auth\GoogleSocialAuthController@handleProviderCallback', 'as' => 'google.callback']);
    
    Route::get('mylinks/', ['uses'=>'LinkController@index', 'as' => 'mylinks']);
    
    Route::post('createlinks/utility/link_table/{project?}', ['uses'=>'LinkController@project_links', 'as' => 'createlinks.project_links']);
    
    Route::post('createlinks/{project?}', ['uses'=>'CreatelinksController@index', 'as' => 'createlinks']);
    
    Route::get('createlinks/json_serializer/{file}', ['uses'=>'CreatelinksController@json_serializer', 'as' => 'createlinks.json']);
    
    Route::post('createlinks/utility/infobox', ['uses'=>'CreatelinksController@short_infobox', 'as' => 'createlinks.infobox']);
    
    Route::post('createlinks/utility/comparison/{project?}', ['uses'=>'CreatelinksController@comparison', 'as' => 'createlinks.comparison']);
    
    Route::post('createlinks/utility/create', ['uses'=>'LinkController@create', 'as' => 'mylinks.create']);
    
    Route::get('createlinks/utility/delete_all', ['uses'=>'LinkController@delete_all', 'as' => 'mylinks.delete_all']);
    
    Route::get('createlinks/utility/export_table', ['uses'=>'LinkController@export', 'as' => 'mylinks.export']);
    
    Route::get('mylinks/utility/export_table', ['uses'=>'LinkController@export', 'as' => 'mylinks.export2']);
    
    Route::delete('createlinks/utility/delete/{link}', ['uses'=>'LinkController@destroy', 'as' => 'mylinks.delete']);
    
    Route::get('mygraphs/', ['uses'=>'FileController@mygraphs', 'as' => 'mygraphs']);
    
    Route::post('mygraphs/', ['uses'=>'FileController@store', 'as' => 'mygraphs.store']);

    Route::delete('file/delete/{file}', ['uses'=>'FileController@destroy', 'as'=>'mygraphs.delete']);
    
    Route::post('file/parse/{file}', ['uses'=>'FileController@parse', 'as'=>'mygraphs.parse']);
    
    Route::post('file/show', ['uses'=>'FileController@show', 'as' => 'mygraphs.show']);
    
    Route::put('file/', ['uses'=>'FileController@update', 'as' => 'mygraphs.update']);
    
    Route::get('dashboard/', ['uses'=>'DashboardController@index', 'as' => 'dashboard']);
    
    Route::get('myprojects/', ['uses'=>'ProjectController@index', 'as' => 'myprojects']);
    
    Route::post('myprojects/show', ['uses'=>'ProjectController@show', 'as' => 'myprojects.show']);
    
    Route::post('myprojects/', ['uses'=>'ProjectController@create', 'as' => 'myprojects.create']);
    
    Route::put('myprojects/', ['uses'=>'ProjectController@update', 'as' => 'myprojects.update']);
    
    Route::delete('project/delete/{project}', ['uses'=>'ProjectController@destroy', 'as' => 'myprojects.delete']);
    
    Route::get('settings/', ['uses'=>'SettingsController@index', 'as' => 'settings']);
    
    Route::post('settings/', ['uses'=>'SettingsController@create', 'as' => 'settings.create']);
    
    Route::put('settings/', ['uses'=>'SettingsController@update', 'as' => 'settings.update']);
    
    Route::delete('settings/delete/{settings}', ['uses'=>'SettingsController@destroy', 'as' => 'settings.delete']);
    
    Route::post('settings/create_config/{project_id}', ['uses'=>'SettingsController@create_config', 'as' => 'settings.create_config']);
    
    Route::get('myvotes/', ['uses'=>'VoteController@index', 'as' => 'myvotes']);
    
    Route::post('/vote', ['uses'=>'VoteController@vote', 'as' => 'vote']);
    
    Route::post('/preview', ['uses'=>'VoteController@preview', 'as' => 'preview']);
    
    Route::post('/comments/show', ['uses'=>'CommentController@show', 'as' => 'comment.show']);
    
    Route::post('/comments/create', ['uses'=>'CommentController@create', 'as' => 'comment.create']);
    
    Route::get('play/', function(){
    
        return view('play');
    });
    Route::get('about/',['as'=>'about', function(){
    
        return view('about');
    }]);
    
   
    
    
    
    
});



