<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . 'config.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'system' . DIRECTORY_SEPARATOR . 'functions.php';
	
//foreach($config_logs as $name => $file) {
// For now we just use 1 static file, later we can add multiple files to be worked with at the same time..

$file = __DIR__ . DIRECTORY_SEPARATOR . $config_combo_list;

if(!file_exists($file)) 
    die("File not found.");

$data = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

if($data === false) 
    die("Error reading the file.");

//}

if(isset($_POST["search_url"])) {
	foreach ($data as $key => $line) {
	    list($url, $username, $password) = explode(':', $line);
	    $data_row[] = array('url' => $url, 'login' => $username, 'password' => $password);
	}
	$search_keyword = $_POST["search_url"];
	$result = arrayKeyValueSearch($data_row, 'url', $search_keyword);
	if(count($result) == 0) {
		//pp($result_array);
		header("Location: ../?veryVeryIdiot");
	}
}

?>