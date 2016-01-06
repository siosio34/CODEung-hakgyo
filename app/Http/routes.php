<?php

Route::group(['middleware' => ['web']], function () {
	Route::auth();
	
	// resouces
	//by MANAPIE
	
	Route::get('images/{filename}', function ($filename)
	{
	    $path=base_path().'/resources/views/_images/'.$filename;
	
	    $file = File::get($path);
	    $type = File::mimeType($path);
	
	    $response = Response::make($file, 200);
	    $response->header("Content-Type", $type);
	
	    return $response;
	});
	
	Route::get('styles/{filename}', function ($filename)
	{
	    $path=base_path().'/resources/views/_styles/'.$filename;
	
	    $file = File::get($path);
	
	    $response = Response::make($file, 200);
	    $response->header("Content-Type", 'text/css');
	
	    return $response;
	});
	
	Route::get('scripts/{filename}', function ($filename)
	{
	    $path=base_path().'/resources/views/_scripts/'.$filename;
	
	    $file = File::get($path);
	
	    $response = Response::make($file, 200);
	    $response->header("Content-Type", 'text/javascript');
	
	    return $response;
	});
	

    // index
    // by MANAPIE
	Route::get('/', function () {
		return view('index');
	});
    
    
    // rooms
    // by MANAPIE
    Route::get('room', 'RoomController@getRoomList');
    Route::get('room/create', 'RoomController@getRoomCreate');
    Route::post('room/create', 'RoomController@postRoomCreate');
    Route::get('room/code/{id}', 'RoomController@getRoomCode');
    Route::post('room/code/{id}', 'RoomController@postRoomCode');
    Route::get('room/{id}', 'RoomController@getRoomRead');
    
    
});

/*
Route::group(array('domain' => array('https://crackling-heat-3070.firebaseapp.com')), function() {
	return view('welcome');
});
*/
