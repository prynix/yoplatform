<?php
Route::group(array('before' => 'basicAuth', 'prefix'    => Config::get('backend.uri').'/'.Config::get('backend.group_advertiser_manager_url') ),function(){
    Route::group(array('prefix' => 'ad_flight' ),function() {
        $prefixName = Str::studly(pathinfo(__DIR__, PATHINFO_BASENAME));
        $prefixSlug = Str::snake($prefixName,'-');        

        //--Show List
        Route::get('show-list',     array('before' =>   'hasPermissions:'.$prefixSlug.'-read','as'  =>  $prefixName.'ShowList','uses'   =>  $prefixName.'Controller@showList'));
        Route::post('get-list',     array('before' =>   'hasPermissions:'.$prefixSlug.'-read','as'  =>  $prefixName.'GetList','uses'    =>  $prefixName.'Controller@getList'));
        //--Create
        Route::get('create',        array('before' =>   'hasPermissions:'.$prefixSlug.'-create','as'    =>  $prefixName.'ShowCreate','uses' =>  $prefixName.'Controller@showUpdate'));
        Route::post('create',       array('before' =>   'hasPermissions:'.$prefixSlug.'-create|csrf','as'   =>  $prefixName.'ShowCreate','uses' =>  $prefixName.'Controller@showUpdate'));
        //--View
        Route::get('view/{id}',        array('before' =>   'hasPermissions:'.$prefixSlug.'-read','as'    =>  $prefixName.'ShowView','uses' =>  $prefixName.'Controller@showView'));
        //--Update
        Route::get('update/{id}',   array('before' =>   'hasPermissions:'.$prefixSlug.'-edit','as'    =>  $prefixName.'ShowUpdate','uses' =>  $prefixName.'Controller@showUpdate'));
        Route::post('update/{id}',  array('before' =>   'hasPermissions:'.$prefixSlug.'-edit|csrf','as'   =>  $prefixName.'ShowUpdate','uses' =>  $prefixName.'Controller@showUpdate'));
        //--Delete
        Route::post('delete',       array('before' =>   'hasPermissions:'.$prefixSlug.'-delete','as'    =>  $prefixName.'Delete','uses' =>  $prefixName.'Controller@delete'));
    });
});
