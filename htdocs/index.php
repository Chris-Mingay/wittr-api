<?php

	require_once("php-analytics-event/src/There4/Analytics/AnalyticsEvent.php");
	use There4\Analytics\AnalyticsEvent;

	function recordGAEvent($location,$event)
	{
		$events = new AnalyticsEvent('UA-47707178-10', 'wittr.ct14hosted.co.uk');
		$events->trackEvent($location,$event);
	}

	header("Access-Control-Allow-Origin: *");
	header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
	header("Access-Control-Allow-Methods: GET, POST, OPTIONS");

	include("classes/db.class.php");
	include("classes/demographic.class.php");
	include("classes/response.class.php");
	include("classes/id.class.php");
	include("classes/rooms.class.php");
	include("classes/wittees.class.php");
	include("functions.php");
	if(!file_exists("settings.php")){
		die("settings.php is required. Please copy from settings.example.php and setup as required");
	}else{
		include("settings.php");
	}


	\Wittr\DB::create($gc['database_host'],$gc['database_user'],$gc['database_pass'],$gc['database_name']);
	\Wittr\PDO::Create($gc['database_host'],$gc['database_user'],$gc['database_pass'],$gc['database_name']);

	// Kickstart the framework
	$f3=require('lib/base.php');

	$f3->set('DEBUG',1);
	if ((float)PCRE_VERSION<7.9)
		trigger_error('PCRE version is out of date');

	// Load configuration
	$f3->config('config.ini');

	include("api-versions/5.php");	// Uses UUID for Wittertanee identification
	
	$f3->run();


	/*

	 _    _  _  _    _           _                      _    _      _
	| |  | |(_)| |  | |         (_)                    | |  | |    (_)
	| |  | | _ | |_ | |_  _ __   _  ___   _ __    ___  | |_ | |__   _  _ __    __ _
	| |/\| || || __|| __|| '__| | |/ __| | '_ \  / _ \ | __|| '_ \ | || '_ \  / _` |
	\  /\  /| || |_ | |_ | |    | |\__ \ | | | || (_) || |_ | | | || || | | || (_| |
	 \/  \/ |_| \__| \__||_|    |_||___/ |_| |_| \___/  \__||_| |_||_||_| |_| \__, |
	 _                _                    _  _    _       _    _              __/ |
	| |              | |                  (_)| |  | |     | |  | |            |___/
	| |_   ___     __| |  ___   __      __ _ | |_ | |__   | |_ | |__    ___
	| __| / _ \   / _` | / _ \  \ \ /\ / /| || __|| '_ \  | __|| '_ \  / _ \
	| |_ | (_) | | (_| || (_) |  \ V  V / | || |_ | | | | | |_ | | | ||  __/
	\__| \___/   \__,_| \___/    \_/\_/  |_| \__||_| |_|  \__||_| |_| \___|
	______ ______  _____  _
	| ___ \| ___ \/  __ \| |
	| |_/ /| |_/ /| /  \/| |
	| ___ \| ___ \| |    | |
	| |_/ /| |_/ /| \__/\|_|
	\____/ \____/  \____/(_)

                                                                                http://patorjk.com/software/taag/
	*/

