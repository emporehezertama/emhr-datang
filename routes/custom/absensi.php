<?php 
Route::get('iclock/cdata', function(){

	#\Log::info('POST : '. json_decode($_POST));
    #\Log::info('URL :'. full_url( $_SERVER ));
    #\Log::info('Testing ini ');

    #$data = file_get_contents('php://input');
    #
    #$header = '';
    #foreach (getallheaders() as $name => $value) { 
	#    $header .=$name .' : '. $value ."\n"; 
	#}

	#\Log::info('header : '. $header);
  
    #$request = \Illuminate\Http\Request::instance(); // Access the instance
    #$data  = $request->getContent(); // Get its content
    \Log::info('Request Method : '. $_SERVER['REQUEST_METHOD']);
    
    $data = $entityBody = file_get_contents('php://input');
    \Log::info('Data Request : '. $data);
    
    #$data = stream_get_contents(STDIN);
    
    #$rawInput = fopen('php://input', 'r');
    #$tempStream = fopen('php://temp', 'r+');
    #stream_copy_to_stream($rawInput, $tempStream);
    #rewind($tempStream);
    #\Log::info('Data Request : '. $tempStream);
});
