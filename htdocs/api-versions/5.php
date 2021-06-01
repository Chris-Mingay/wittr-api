<?php

	/// V4



	$f3->route('GET /av5',
		function($f3) {
			$r = array(
				'message'=>'Hello again',
				'recipient'=>'Jason Isaacs'
			);
			header("Content-Type: application/json", true);
			echo json_encode($r);
		}
	);

	$f3->route('GET /av5/id/@uuid',
		function($f3,$params) {

			$uuid = isset($params['uuid']) ? $params['uuid'] : '';
			$r = new \Wittr\ID();
			$r->success = true;
			$r->id = uuidV4($uuid);

			recordGAEvent('api-5','/id');

			header("Content-Type: application/json", true);
			echo json_encode($r);
		}
	);

	$f3->route('POST /av5/demographics',
		function($f3){

			recordGAEvent('api-5','/demographics');

			$uuid = '';
			$post = json_decode($f3->get('BODY'),true);
			$response = new \Wittr\Response();
			$good = true;
			if(!isset($post['uuid'])){
				$good = false;
			}

			if($good){
				$uuid = uuidV4($post['uuid']);
			}

			if($good){
				$fields = array('pipeSmoker','clergyCorner','ltl','ceramicistsCorner','norwegianBranch','colonialCommoner','cravateer','diafls','aals','pils','hils','ncg','iji','niji','battenberg');
				foreach($fields as $field){
					if(!isset($field)){
						$post[$field] = 0;
					}
				}

				if($good) {
					
					$sql = "UPDATE
						`wittee`
					SET
						`pipe_smoker` = ?,
						`ltl` = ?,
						`clergy_corner` = ?,
						`ceramicists_corner` = ?,
						`norwegian_branch` = ?,
						`colonial_commoner` = ?,
						`cravateer` = ?,
						`diafls` = ?,
						`aals` = ?,
						`pils` = ?,
						`hils` = ?,
						`ncg` = ?,
						`iji` = ?,
						`niji` = ?,
						`battenberg` = ?
					WHERE
						`uuid` = ? LIMIT 1";

					$stmt = \Wittr\PDO::$conn->prepare($sql);
					$stmt->execute([
						$post['pipeSmoker'],
						$post['ltl'],
						$post['clergyCorner'],
						$post['ceramicistsCorner'],
						$post['norwegianBranch'],
						$post['colonialCommoner'],
						$post['cravateer'],
						$post['diafls'],
						$post['aals'],
						$post['pils'],
						$post['hils'],
						$post['ncg'],
						$post['iji'],
						$post['niji'],
						$post['battenberg'],
						$uuid,
					]);

					$response->success = true;
				}
			}else{
				$response->error = "Missing UUID";
			}

			if($good)
			{
				$response->id = $uuid;
			}

			header("Content-Type: application/json", true);
			echo json_encode($response);
		}
	);

	$f3->route('POST /av5/message',
		function($f3){

			recordGAEvent('api-5','/message');

			$post = json_decode($f3->get('BODY'),true);

			$uuid = '';

			$response = new \Wittr\Response();

			$good = true;

			if(!isset($post['uuid'])){
				$good = false;
			}

			if($good){
				$uuid = uuidV4($post['uuid']);
			}

			if($good){

				if(!isset($post['message'])){
					$good = false;
				}
			}

			if($good){
				if(strlen($post['message']) > 140){
					$good = false;
				}
			}

			if($good)
			{
				$sql = "UPDATE `wittee` SET `message` =? WHERE `uuid` = ? LIMIT 1";
				$upStmt = \Wittr\PDO::$conn->prepare($sql);
				$upStmt->execute([strip_tags($post['message']),$uuid]);
				$response->success = true;
			}

			if($good)
			{
				$response->id = $uuid;
			}

			header("Content-Type: application/json", true);
			echo json_encode($response);
		}
	);

	$f3->route('POST /av5/battenburg',
		function($f3){

			recordGAEvent('api-5','/battenburg');

			$post = json_decode($f3->get('BODY'),true);

			$uuid = '';

			$response = new \Wittr\Response();

			$good = true;

			if(!isset($post['uuid'])){
				$good = false;
			}

			if($good){
				$uuid = uuidV4($post['uuid']);
			}

			if($good){

				if(!isset($post['battenburg'])){
					$good = false;
				}
			}

			if($good)
			{
				$sql = "UPDATE `wittee` SET `battenberg` =? WHERE `uuid` = ? LIMIT 1";
				$upStmt = \Wittr\PDO::$conn->prepare($sql);
				$upStmt->execute([strip_tags($post['battenburg']),$uuid]);
				$response->success = true;
			}

			if($good)
			{
				$response->id = $uuid;
			}

			header("Content-Type: application/json", true);
			echo json_encode($response);
		}
	);

	$f3->route('POST /av5/wittees',
		function($f3){

			recordGAEvent('api-5','/wittees');

			$post = json_decode($f3->get('BODY'),true);

			$uuid = '';

			$response = new \Wittr\Wittees();

			$good = true;

			if(!isset($post['uuid'])){
				$good = false;
			}

			if($good){
				$uuid = uuidV4($post['uuid']);
			}

			if($good){

				if(!isset($post['longitude']) or !isset($post['latitude'])){
					$good = false;
				}
			}


			if($good){
				if($post['longitude']=="" or $post['latitude']==""){
					$good = false;
				}
			}

			if($good){
				$distance = 500;
				$limit = 500;

				$sql = "SELECT * FROM `wittee` WHERE ( 3959 * acos( cos( radians( latitude) ) * cos( radians( ? ) ) * cos( radians( ? ) - radians( longitude ) ) + sin( radians( latitude) ) * sin( radians( ? ) ) ) ) < ? AND `uuid` != ? ORDER BY ( 3959 * acos( cos( radians( latitude) ) * cos( radians( ? ) ) * cos( radians( ? ) - radians( longitude ) ) + sin( radians( latitude) ) * sin( radians( ? ) ) ) ) ASC LIMIT ?";

				$stmt = \Wittr\PDO::$conn->prepare($sql);
				$stmt->execute([$post['latitude'],$post['longitude'],$post['latitude'],$distance,$uuid,$post['latitude'],$post['longitude'],$post['latitude'],$limit]);


				while($row = $stmt->fetch(PDO::FETCH_ASSOC))
				{
					$r = array(
						'latitude'=>$row['latitude'],
						'longitude'=>$row['longitude'],
						'hash'=>($row['uuid']!='' ? $row['uuid'] : $row['hash']),
						'bb'=>($row['battenberg']==1),
						'message'=>$row['message']
					);
					$response->wittees[] = $r;
				}

				$response->success = true;
			}else{
				$response->error = "Missing Details";
			}

			if($good)
			{
				$response->id = $uuid;
			}

			header("Content-Type: application/json", true);
			echo json_encode($response);

		}
	);

	$f3->route('POST /av5/fund',
		function ($f3) {

			recordGAEvent('api-5','/fund');

			$post = json_decode($f3->get('BODY'),true);
			$uuid = '';
			$good = true;

			if(!isset($post['uuid'])){
				$good = false;
			}

			if($good){
				$uuid = uuidV4($post['uuid']);
			}

			$response = new \Wittr\Response();
			if($good){
				$response->success = true;
				$sql = "UPDATE `wittee` SET `fund` = `fund`+1 WHERE `uuid` = ? LIMIT 1";
				$stmt = \Wittr\PDO::$conn->prepare($sql);
				$stmt->execute([$uuid]);

				$sql = "UPDATE `global` SET `fund` = `fund`+1";
				$stmt = \Wittr\PDO::$conn->prepare($sql);
				$stmt->execute();

				$sql = "SELECT `fund` FROM `global`";
				$stmt = \Wittr\PDO::$conn->prepare($sql);
				$stmt->execute();
				$row = $stmt->fetch();

				$response->funding = $row['fund'];
			}

			header("Content-Type: application/json", true);
			echo json_encode($response);

		}
	);

	$f3->route('GET /av5/funding',
		function ($f3) {

			recordGAEvent('api-5','/funding');

			$sql = "SELECT `fund` FROM `global`";
			$stmt = \Wittr\PDO::$conn->prepare($sql);
			$stmt->execute();
			$row = $stmt->fetch();


			$response = new \Wittr\Response();
			$response->success = true;
			$response->funding = $row['fund'];

			header("Content-Type: application/json", true);
			echo json_encode($response);

		}
	);

	$f3->route('POST /av5/demographics',
		function ($f3) {

			recordGAEvent('api-5','/demographics');

			$post = json_decode($f3->get('BODY'),true);
			$uuid = '';
			$good = true;

			if(!isset($post['uuid'])){
				$good = false;
			}

			if($good){
				$uuid = uuidV4($post['uuid']);
			}

			$response = new \Wittr\Response();
			$response->demographics = \Wittr\Demographic::getAll($uuid);


			header("Content-Type: application/json", true);
			echo json_encode($response);

		}
	);

	$f3->route('POST /av5/demographic',
		function ($f3) {

			recordGAEvent('api-5','/demographic');
			$response = new \Wittr\Response();

			$post = json_decode($f3->get('BODY'),true);
			$uuid = '';

			$good = true;

			if(!isset($post['uuid'])){
				$good = false;
			}

			if($good){
				if(!isset($post['demographic'])){
					$good = false;
				}
			}

			if($good){
				if(!isset($post['checked'])){
					$good = false;
				}
			}

			if($good){
				if(!in_array($post['demographic'],\Wittr\Demographic::$demographics)){
					$good = false;
				}
			}


			if($good){
				$uuid = uuidV4($post['uuid']);
			}

			if($good){
				$response->success = true;
				$sql = "UPDATE `wittee` SET `".$post['demographic']."` = ? WHERE `uuid` = ?";
				$stmt = \Wittr\PDO::$conn->prepare($sql);
				$stmt->execute([$post['checked'],$uuid]);

			}


			header("Content-Type: application/json", true);
			echo json_encode($response);

		}
	);

	$f3->route('POST /av5/locate',
		function ($f3) {

			recordGAEvent('api-5','/locate');

			$post = json_decode($f3->get('BODY'),true);
			$uuid = '';

			$response = new \Wittr\Response();

			$good = true;

			if(!isset($post['uuid'])){
				$good = false;
			}

			if($good){
				$uuid = uuidV4($post['uuid']);
			}

			if($good){

				if(!isset($post['longitude']) or !isset($post['latitude'])){
					$good = false;
				}
			}


			if($good){
				if($post['longitude']=="" or $post['latitude']==""){
					$good = false;
				}
			}

			if($good){

				$sql = "UPDATE `wittee` SET `latitude` = ?, `longitude` = ? , `when` = NOW() WHERE `uuid` = ? LIMIT 1";
				$stmt = \Wittr\PDO::$conn->prepare($sql);
				$stmt->execute([$post['latitude'],$post['longitude'],$uuid]);


				$response->success = true;
			}else{
				$response->error = "Missing Details";
			}

			if($good)
			{
				$response->id = $uuid;
			}

			header("Content-Type: application/json", true);
			echo json_encode($response);
		}
	);

	$f3->route('GET /av5/cull',
		function ($f3) {


			recordGAEvent('api-5','/cull');

			$oneMonthAgo = date("Y-m-d H:i:s",strtotime("now -1 month"));
			$stmt = \Wittr\PDO::$conn->prepare("DELETE FROM `wittee` WHERE `when` < ?");
			$stmt->execute([$oneMonthAgo]);
			echo $stmt->rowCount()." old records deleted";


		}
	);


	$f3->route('GET /av5/refreshpodcast',
		function($f3) {

			recordGAEvent('api-5','/refreshpodcast');

			$podcastUrl = "http://www.bbc.co.uk/programmes/b00lvdrj/episodes/downloads.rss";
			$raw = file_get_contents($podcastUrl);
			file_put_contents("podcast.rss",$raw);
		}
	);


	$f3->route('GET /av5/podcast',
		function($f3){

			recordGAEvent('api-5','/podcast');

			$podcastUrl = "podcast.rss";
			$raw = file_get_contents($podcastUrl);
			$xml = simplexml_load_string($raw);
			//var_dump($xml);

			$r = array();

			$r['header_image'] = (string)$xml->channel->image->url[0];
			$r['title'] = (string)$xml->channel->title;
			$r['description'] = (string)$xml->channel->description;
			$r['podcasts'] = array();

			$i = 0;
			foreach($xml->channel->item as $item) {
				$p = array(
					'title'=>(string)$item->title,
					'description'=>(string)$item->description,
					'mp3'=>(string)$item->link,
					'pubDate'=>(string)$item->pubDate,
				);
				if($i < 20)
				{
					$r['podcasts'][] = $p;
				}
				$i++;
			}


			header("Content-Type: application/json", true);
			echo json_encode($r);

		}
	);
