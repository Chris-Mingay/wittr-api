<?php

	/**
	 * This page is not called directly, rebuild.php runs it on a schedule and dumps the output to index.php
	 * The prevents the stats from building with each and every call made by a user
	 */

	if(!file_exists("../settings.php")){
		die("settings.php is required. Please copy from settings.example.php and setup as required");
	}else{
		include("../settings.php");
	}

	$conn = new mysqli($gc['database_host'],$gc['database_user'],$gc['database_pass'],$gc['database_name']) or die("DB error");

	$total = array();

	$continents = array(
		'EU'=>'Europe',
		'OC'=>'Oceania',
		'NA'=>'North America',
		'SA'=>'South America',
		'AF'=>'Africa',
		'AS'=>'Asia',
		'AN'=>'Antarctica'
	);
	$countries = array();
	$sql = "SELECT `country` FROM `wittee` GROUP BY `country`";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()){
		$countries[$row['country']] = ($row['country'] != '' ? $row['country'] : 'Unknown');	
	}

	$g = array(
		'pipe_smoker'=>'Pipe Smoker',
		'clergy_corner'=>'Clergy Corner',
		'ltl'=>'L.T.L.',
		'ceramicists_corner'=>'Ceramicists\' Corner',
		'norwegian_branch'=>'Norwegian Branch',
		'colonial_commoner'=>'Colonial Commoner',
		'cravateer'=>'Cravateer',
		'diafls'=>'D.I.A.F.L.S.',
		'aals'=>'A.A.L.S.',
		'pils'=>'P.I.L.S.',
		'hils'=>'H.I.L.S.',
		'ncg'=>'N.C.G',
		'iji'=>'I\'m Jason Isaacs',
		'niji'=>'No I\'M Jason Isaacs!',
		'battenberg'=>'Battenberg'
	);

	foreach($g as $key=>$name){
		$sql = "SELECT COUNT(*) as total FROM `wittee` WHERE `".$key."` = 1";
		$row = $conn->query($sql)->fetch_assoc();
		$totals[$name] = $row['total'];
	}

	arsort($totals);


	$o = '<h3>Demographics</h3>';
	$o .= '<table class="table table-striped table-condensed"><thead><tr><th>Group</th><th>Count</th></tr><thead><tbody>';
	foreach($totals as $name => $value){
		$o .= '<tr><td>'.$name.'</td><td>'.$value.'</td></tr>';
	}
	$o .= '</tbody></table>';
	$demo = $o;

	$continentTotals = array();
	foreach($continents as $key=>$name){
		$sql = "SELECT COUNT(*) as total FROM `wittee` WHERE `continent` = '".$key."'";
		$row = $conn->query($sql)->fetch_assoc();
		$continentTotals[$name] = $row['total'];
	}

	arsort($continentTotals);

	$o = '<h3>Continents</h3>';
	$o .= '<table class="table table-striped table-condensed"><thead><tr><th>Group</th><th>Count</th></tr><thead><tbody>';
	foreach($continentTotals as $name => $value){
		$o .= '<tr><td>'.$name.'</td><td>'.$value.'</td></tr>';
	}
	$o .= '</tbody></table>';
	$continents = $o;

	$countryTotals = array();
	foreach($countries as $key=>$name){
		$sql = "SELECT COUNT(*) as total FROM `wittee` WHERE `country` = '".$key."'";
		$row = $conn->query($sql)->fetch_assoc();
		$countryTotals[$name] = $row['total'];
	}

	arsort($countryTotals);

	$o = '<h3>Countries</h3>';
	$o .= '<table class="table table-striped table-condensed"><thead><tr><th>Group</th><th>Count</th></tr><thead><tbody>';
	$i = 0;
	foreach($countryTotals as $name => $value){
		if($name!='Unknown' &&  $name != 'ERROR'){
			$o .= '<tr '.($i>=10 ? 'class="row-hidden"' : '').' ><td>'.$name.'</td><td>'.$value.'</td></tr>';
			$i++;
		}	
	}
	$o .= '<tr class="row-shown"><td colspan="2"><a id="showMore" href="#nowhere" class="showMore pull-right">Show More &gt;&gt;</a></td></tr>';
	$o .= '<tr class="row-hidden"><td colspan="2"><a id="showMore" href="#nowhere" class="showMore pull-right">Show Less &lt;&lt;</a></td></tr>';
	$o .= '</tbody></table>';

	$countries = $o;

?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
		<meta name="description" content="">
		<meta name="author" content="">
		<link rel="icon" href="favicon.ico">

		<title>Wittr App</title>

		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

		<!-- Optional theme -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

		<!-- Latest compiled and minified JavaScript -->
		<script   src="https://code.jquery.com/jquery-1.12.2.min.js"   integrity="sha256-lZFHibXzMHo3GGeehn1hudTAP3Sc0uKXBXAzHX1sjtk="   crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
		<script src="sparkle.jquery.js"></script>

		<link href='https://fonts.googleapis.com/css?family=Lato:400,700,900' rel='stylesheet' type='text/css'>

		<!-- Custom styles for this template -->
		<link href="jtn.css" rel="stylesheet">

		<link href="style.css" rel="stylesheet">
		<link href="sparkle.css" rel="stylesheet">
	</head>

	<body>

		<div class="container">
			<div class="header clearfix">
				<nav>
					<ul class="nav nav-pills pull-right">
						<li role="presentation"><a href="https://twitter.com/wittr_app"><img src="tlw.png" class="tlw"/> @wittr_app</a></li>
					</ul>
				</nav>
				<h3 class="text-muted"><b>Wittr</b>App <small>- How do you Wittr? You just Wittr.</small></h3>
			</div>	

			<div class="jumbotron">
				<h1><b>Wittr</b>App - out now!</h1>
				<p class="lead">Available on all good fruit, robot and South American rainforest based devices!</p>
				<p>
					<a href="https://play.google.com/store/apps/details?id=it.ct14.wittr&hl=en_GB" target="_blank" role="button"><img src="gpb.png" class="gpb"/></a>
					<a href="https://itunes.apple.com/gb/app/iwittr/id1084218610?mt=8" target="_blank"  role="button"><img src="asb.svg" class="gpb"/></a>
					<a href="http://www.amazon.co.uk/CT14-IT-Solutions-Ltd-Wittr/dp/B01D21YEPA/ref=sr_1_1?s=mobile-apps&ie=UTF8&qid=1458752741&sr=1-1&keywords=wittr" target="_blank"  role="button"><img src="amazon.png" class="gpb"/></a>
				</p>
				<p class="smaller">(and on Windows Phone as well one day)</p>
			</div>

			<div class="row marketing">
				<div class="col-md-12">
					<h2>Total Wittrers: <span id="total">0</span></h2>
				</div>
				<div class="col-md-4">
					<?=$demo;?>
				</div>
				<div class="col-md-4">
					<?=$continents;?>
				</div>
				<div class="col-md-4">
					<?=$countries;?>
				</div>
				<div class="col-md-12">
					<h3>Wait, the breakdowns don't add up to the total?</h3>
					<p>Yeah about that.... I use the Google Geocoding API to convert coordinates into country codes, I then map countries to continents. I'm allowed to make 2,500 calls a day, so currently I'm limiting that to 100 every hour (so 2,400 in 24 hours).</p>
					<p>I kind of missed the boat with this, so I'm running through a bit of a backlog!</p>
				</div>
			</div>



			<footer class="footer">
				<p>&copy; 2016 CT14.IT Solutions Ltd. <span class="pull-right">Last Updated: [UPDATE_TIME]</span></p>
			</footer>
		</div> <!-- /container -->
		
		<script type="text/javascript">

			var currentCount = '0';

			counts = {};

			function format_number(text){
				return text.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
			};

			function magic_number(element_name, value) {
				var elem = $(element_name);
				var current = counts[element_name] || 0;
				$({count: current}).animate({count: value}, {
					duration: 2500,
					step: function() {
						elem.text(format_number(String(parseInt(this.count))));
					}}
				);
				counts[element_name] = value;
			};

			function updateNumber()
			{
				$.ajax({
					url: 'total.php',
					success: function(d){
						if(d!=currentCount){
							// TODO - Sparkles
							currentCount = d;

							magic_number("#total", currentCount);
						}
					}
				});
			}




			$(document).ready(function(){
				$(".showMore").click(function(){
					$(".row-hidden").toggle();
					$(".row-shown").toggle();
				});

				
				var checkInterval = setInterval(function(){
					updateNumber();
				},5000);

				setTimeout(function(){
					updateNumber();
				},500);

				$('.jumbotron h1').sparkle({

				  // fill color
				  fill: "#fff",

				  // stroke color
				  stroke: "#9af",

				  // size in pixels
				  size: 30,

				  // delay before first sparkle
				  delay: 1500,

				  // animation duration
				  duration: 1500,

				  // delay between two sparkles
				  pause: 600
				  
				});



			});
		</script>
		
		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

		  ga('create', 'UA-47707178-10', 'auto');
		  ga('send', 'pageview');

		</script>

		
	</body>
</html>
