<?php

	if(!isset($gc)){
		$gc = array();
	}

	if(!isset($gc['database_host'])){ $gc['database_host'] = "localhost"; }
	if(!isset($gc['database_user'])){ $gc['database_user'] = "wittr"; }
	if(!isset($gc['database_pass'])){ $gc['database_pass'] = "password"; }
	if(!isset($gc['database_name'])){ $gc['database_name'] = "wittr"; }