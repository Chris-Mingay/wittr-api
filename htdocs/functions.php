<?php


	/**
	 * Indents a flat JSON string to make it more human-readable.
	 * @param string $json The original JSON string to process.
	 * @return string Indented version of the original JSON string.
	 */
	function indent($json) {

		$result      = '';
		$pos         = 0;
		$strLen      = strlen($json);
		$indentStr   = '  ';
		$newLine     = "\n";
		$prevChar    = '';
		$outOfQuotes = true;

		for ($i=0; $i<=$strLen; $i++) {

			// Grab the next character in the string.
			$char = substr($json, $i, 1);

			// Are we inside a quoted string?
			if ($char == '"' && $prevChar != '\\') {
				$outOfQuotes = !$outOfQuotes;

				// If this character is the end of an element,
				// output a new line and indent the next line.
			} else if(($char == '}' || $char == ']') && $outOfQuotes) {
				$result .= $newLine;
				$pos --;
				for ($j=0; $j<$pos; $j++) {
					$result .= $indentStr;
				}
			}

			// Add the character to the result string.
			$result .= $char;

			// If the last character was the beginning of an element,
			// output a new line and indent the next line.
			if (($char == ',' || $char == '{' || $char == '[') && $outOfQuotes) {
				$result .= $newLine;
				if ($char == '{' || $char == '[') {
					$pos ++;
				}

				for ($j = 0; $j < $pos; $j++) {
					$result .= $indentStr;
				}
			}

			$prevChar = $char;
		}

		return $result;
	}

	function findUUID($insertIntoDB = false,$post=array()){
		$unique = false;
		$newid = '';
		while(!$unique){
			$newid = uniqid('w_',true);
			$escaped = \Wittr\DB::$conn->escape_string($newid);
			$sql = "SELECT `uuid` FROM `wittee` WHERE `uuid` = '".$escaped."' LIMIT 1";
			$result = \Wittr\DB::query($sql);
			if($result->num_rows == 0){
				$unique = true;
				if($insertIntoDB){

					$existingRecord = false;
					if(isset($post['userID']) and isset($post['deviceID'])){
						error_log("We have userID and deviceID");
						$sql = "SELECT * FROM `wittee` WHERE `user` = '".\Wittr\DB::$conn->escape_string($post['userID'])."' AND `device` = '".\Wittr\DB::$conn->escape_string($post['deviceID'])."' LIMIT 1";
						$result = \Wittr\DB::query($sql);
						if($result->num_rows == 1) {
							error_log("Record already exists");
							$existingRecord = true;
						}
					}

					if($existingRecord){
						$sql = "UPDATE `wittee` SET `uuid` = '".$escaped."' WHERE `user` = '".\Wittr\DB::$conn->escape_string($post['userID'])."' AND `device` = '".\Wittr\DB::$conn->escape_string($post['deviceID'])."' LIMIT 1";
						\Wittr\DB::query($sql);
					}else{
						$sql = "INSERT INTO `wittee` ( `uuid`,`device`,`user` ) VALUES ( '".$escaped."', '".\Wittr\DB::$conn->escape_string($post['deviceID'])."', '".\Wittr\DB::$conn->escape_string($post['userID'])."' )";
						\Wittr\DB::query($sql);
					}


				}
			}
		}
		return $newid;
	}
	
	function uuidExists($uuid)
	{
		$sql = "SELECT * FROM `wittee` WHERE `uuid` = '".\Wittr\DB::$conn->escape_string($uuid)."' LIMIT 1";
		$result = \Wittr\DB::query($sql);
		if($result->num_rows == 1){ return true; }

		$id = findUUID(true,array('userID'=>$uuid,'deviceID'=>$uuid));
		return true;


	}

	function findUUIDV4(){
		$unique = false;
		$newid = '';
		$hash = uniqid('h_',true);
		while(!$unique){
			$newid = uniqid('w_',true);
			$sql = "SELECT `uuid` FROM `wittee` WHERE `uuid` = ? LIMIT 1";
			$stmt = \Wittr\PDO::$conn->prepare($sql);
			$stmt->execute([$newid]);
			$unique = true;
			while($row = $stmt->fetch(PDO::FETCH_ASSOC))
			{
				$unique = false;
			}
		}

		$sql = "INSERT INTO `wittee` ( `uuid`,`hash`,`when` ) VALUES ( ?, ?, NOW() )";
		$stmt = \Wittr\PDO::$conn->prepare($sql);
		$stmt->execute([$newid,$hash]);

		return $newid;
	}

	function uuidV4($uuid)
	{
		if(strlen($uuid) < 8){
			return findUUIDV4();
		}

		$sql = "SELECT * FROM `wittee` WHERE `uuid` = ? LIMIT 1";
		$stmt = \Wittr\PDO::$conn->prepare($sql);
		$stmt->execute([$uuid]);
		while($row = $stmt->fetch(PDO::FETCH_ASSOC))
		{
			$sql = "UPDATE `wittee` SET `when` = NOW() WHERE `uuid` = ? LIMIT 1";
			$upStmt = \Wittr\PDO::$conn->prepare($sql);
			$upStmt->execute([$uuid]);
			return $uuid;
		}

		return findUUIDV4();


	}


	function updateWittee($post)
	{
		if(isset($post['userID']) and isset($post['deviceID']) and $post['deviceID']!='' and $post['userID']!='' and isset($post['uuid'])){

			$hash = md5("WIT".$post['deviceID']."2".$post['userID']."TEE");

			$sql = "UPDATE `wittee` SET `hash` = '".$hash."', `user` = '".\Wittr\DB::$conn->escape_string($post['userID'])."', `device` = '".\Wittr\DB::$conn->escape_string($post['deviceID'])."' WHERE `uuid` = '".\Wittr\DB::$conn->escape_string($post['uuid'])."' LIMIT 1";
			\Wittr\DB::query($sql);
		}
	}

