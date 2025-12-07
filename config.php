<?php

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	ini_set('memory_limit', '-1');
	error_reporting(E_ALL);
	
	// Main website settings..
	$config_app = array(
		"title" => "The Dancing Hunter",
		"slogan" => "Private Logs Extractor",
		"url" => "",
		"combo_lists_dir" => "waiting-room"
	);

	// Todo: Add multiple files support, for now we use 1 static file..
	$config_combo_lists = array();
	$config_combo_list = "starlink2.txt";
?>