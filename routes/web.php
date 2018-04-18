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
if (env('APP_ENV') != 'local') {
    \URL::forceRootUrl(env('APP_URL'));
}

Route::get('/', ['uses' => 'HomeController@welcome', 'as' => 'home']);

Route::group(['middleware' => ['web']], function () {
    Auth::routes();

    if (env('APP_REGISTRATION')) {
        Route::get('register', 'Auth\RegisterController@showRegistrationForm');
        Route::post('register', 'Auth\RegisterController@register');
    }

    if (env('GITHUB_driver')) {
        Route::get('auth/github', ['uses' => 'Auth\GithubSocialAuthController@redirectToProvider', 'as' => 'github.redirect']);
        Route::get('auth/github/callback', ['uses' => 'Auth\GithubSocialAuthController@handleProviderCallback', 'as' => 'github.callback']);
    }

    if (env('GOOGLE_driver')) {
        Route::get('auth/google', ['uses' => 'Auth\GoogleSocialAuthController@redirectToProvider', 'as' => 'google.redirect']);
        Route::get('auth/google/callback', ['uses' => 'Auth\GoogleSocialAuthController@handleProviderCallback', 'as' => 'google.callback']);
    }

    if (env('FACEBOOK_driver')) {
        Route::get('auth/facebook', ['uses' => 'Auth\FacebookSocialAuthController@redirectToProvider', 'as' => 'facebook.redirect']);
        Route::get('auth/facebook/callback', ['uses' => 'Auth\FacebookSocialAuthController@handleProviderCallback', 'as' => 'facebook.callback']);
    }

    Route::group(['middleware' => 'auth'], function () {
        Route::get('mylinks/', ['uses' => 'LinkController@index', 'as' => 'mylinks']);

        Route::get('sse/', ['uses' => 'SSEController@sse', 'as' => 'sse']);

        Route::post('linktype/update', ['uses' => 'LinkTypeController@updateForm', 'as' => 'linktypes.update']);

        Route::post('notification/read', ['uses' => 'SSEController@read', 'as' => 'notification.read']);

        Route::post('notification/get', ['uses' => 'SSEController@get', 'as' => 'notification.get']);

        Route::post('createlinks/utility/link_table/{project?}', ['uses' => 'LinkController@projectLinks', 'as' => 'createlinks.project_links']);

        Route::get('createlinks/{project?}', ['uses' => 'CreatelinksController@index', 'as' => 'createlinks']);

        Route::get('createlinks/json_serializer/{file}', ['uses' => 'CreatelinksController@json_serializer', 'as' => 'createlinks.json']);

        Route::post('createlinks/utility/infobox', ['uses' => 'CreatelinksController@short_infobox', 'as' => 'createlinks.infobox']);

        Route::post('createlinks/utility/comparison/{project?}', ['uses' => 'CreatelinksController@comparison', 'as' => 'createlinks.comparison']);

        Route::post('createlinks/utility/create', ['uses' => 'LinkController@create', 'as' => 'mylinks.create']);

        Route::get('createlinks/utility/delete_all', ['uses' => 'LinkController@deleteAll', 'as' => 'mylinks.delete_all']);

        Route::get('createlinks/utility/export_table', ['uses' => 'LinkController@export', 'as' => 'mylinks.export']);

        Route::get('createlinks/utility/connected', ['uses' => 'LinkController@connected', 'as' => 'mylinks.connected']);

        Route::get('mylinks/utility/export_table', ['uses' => 'LinkController@export', 'as' => 'mylinks.export2']);

        Route::post('myvotes/export', ['uses' => 'LinkController@exportVoted', 'as' => 'myvotes.export']);

        Route::delete('createlinks/utility/delete', ['uses' => 'LinkController@destroy', 'as' => 'mylinks.delete']);

        Route::get('mygraphs/', ['uses' => 'FileController@mygraphs', 'as' => 'mygraphs']);

        Route::post('mygraphs/', ['uses' => 'FileController@store', 'as' => 'mygraphs.store']);

        Route::delete('file/delete/{file}', ['uses' => 'FileController@destroy', 'as' => 'mygraphs.delete']);

        Route::post('file/parse/{file}', ['uses' => 'FileController@parse', 'as' => 'mygraphs.parse']);

        Route::post('file/show', ['uses' => 'FileController@show', 'as' => 'mygraphs.show']);

        Route::put('file/', ['uses' => 'FileController@update', 'as' => 'mygraphs.update']);

        Route::get('file/download/{file}', ['uses' => 'FileController@download', 'as' => 'mygraphs.download']);

        Route::get('dashboard/', ['uses' => 'DashboardController@index', 'as' => 'dashboard']);

        Route::get('profile/{id}', ['uses' => 'ProfileController@index', 'as' => 'profile']);

        Route::get('myprojects/', ['uses' => 'ProjectController@index', 'as' => 'myprojects']);

        Route::post('myprojects/show', ['uses' => 'ProjectController@show', 'as' => 'myprojects.show']);

        Route::post('myprojects/', ['uses' => 'ProjectController@create', 'as' => 'myprojects.create']);

        Route::put('myprojects/', ['uses' => 'ProjectController@update', 'as' => 'myprojects.update']);

        Route::get('myprojects/prepare/{id}', ['uses' => 'ProjectController@prepareProject', 'as' => 'myprojects.prepareproject']);

        Route::delete('project/delete/{project}', ['uses' => 'ProjectController@destroy', 'as' => 'myprojects.delete']);

        Route::get('settings/', ['uses' => 'SettingsController@index', 'as' => 'settings']);

        Route::post('settings/', ['uses' => 'SettingsController@create', 'as' => 'settings.create']);

        Route::get('settings/export', ['uses' => 'SettingsController@export', 'as' => 'settings.export']);

        Route::get('settings/copy', ['uses' => 'SettingsController@copy', 'as' => 'settings.copy']);

        Route::put('settings/', ['uses' => 'SettingsController@update', 'as' => 'settings.update']);

        Route::delete('settings/delete', ['uses' => 'SettingsController@destroy', 'as' => 'settings.delete']);

        Route::get('myvotes/', ['uses' => 'VoteController@index', 'as' => 'myvotes']);

        Route::post('myvotes/project', ['uses' => 'VoteController@project_vote', 'as' => 'project_vote']);

        Route::get('myvotes/project', ['uses' => 'VoteController@project_vote', 'as' => 'project_vote']);

        Route::get('myvotes/mylinks', ['uses' => 'VoteController@mylinks', 'as' => 'vote.mylinks']);

        Route::post('/vote', ['uses' => 'VoteController@vote', 'as' => 'vote']);

        Route::post('/preview', ['uses' => 'VoteController@preview', 'as' => 'preview']);

        Route::post('/comments/show', ['uses' => 'CommentController@show', 'as' => 'comment.show']);

        Route::post('/comments/create', ['uses' => 'CommentController@create', 'as' => 'comment.create']);

        Route::resource('rdfnamespace', 'rdfnamespaceController', ['names' => ['create' => 'rdfnamespace.create',
                'show' => 'rdfnamespace.show',
                'index' => 'rdfnamespace.index',
                'store' => 'rdfnamespace.store',
                'update' => 'rdfnamespace.update',
                'edit' => 'rdfnamespace.edit',
                'destroy' => 'rdfnamespace.destroy', ]]);

        Route::resource('label-extractor', 'LabelExtractorController', ['names' => ['create' => 'label-extractor.create',
                'show' => 'label-extractor.show',
                'index' => 'label-extractor.index',
                'store' => 'label-extractor.store',
                'update' => 'label-extractor.update',
                'edit' => 'label-extractor.edit',
                'destroy' => 'label-extractor.destroy', ]]);

        Route::get('about/', ['as' => 'about', 'uses' => 'HomeController@about']);

        Route::get('voteApp/', ['as' => 'voteApp', 'uses' => 'PollController@index']);

        Route::get('getPoll/', ['as' => 'getPoll', 'uses' => 'PollController@getPoll']);

        Route::get('api/projects', ['as' => 'api.projects', 'uses' => 'PollController@projects']);

        Route::post('api/project', ['as' => 'api.project', 'uses' => 'PollController@project']);

        Route::post('mylinks/import', ['as' => 'links.import', 'uses' => 'LinkController@import']);

        Route::get('link/ajax', ['as' => 'links.ajax', 'uses' => 'LinkController@ajax']);

        Route::get('settings/ajax', ['as' => 'settings.ajax', 'uses' => 'SettingsController@ajax']);

        Route::get('settings/validation/errors', ['as' => 'settings.validation.errors', 'uses' => 'SettingsController@errors']);

        Route::get('settings/reconstruct', ['as' => 'settings.reconstruct', 'uses' => 'SettingsController@reconstruct']);

        Route::get('settings/validate', ['as' => 'settings.validate', 'uses' => 'SettingsController@validateSettingsFile']);
    });
});
