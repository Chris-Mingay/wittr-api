<?php

	namespace Wittr {

		class Demographic {

			public $fieldName = "";
			public $title = "";
			public $description = "";
			public $checked = false;


			public static $demographics = array('pipe_smoker','clergy_corner','ltl','ceramicists_corner','norwegian_branch','colonial_commoner','cravateer','diafls','aals','pils','hils','ncg');
			public static function getAll($uuid=''){

				$user = array();
				$hasUser = false;

				if($uuid != ''){
					$sql = "SELECT * FROM `wittee` WHERE `uuid` = ?";
					$stmt = \Wittr\PDO::$conn->prepare($sql);
					$stmt->execute([$uuid]);
					while($row = $stmt->fetch(\PDO::FETCH_ASSOC)){
						$user = $row;
						$hasUser = true;
					}
				}

				$r = array();

				foreach(self::$demographics as $fieldName)
				{
					$d = new Demographic();
					$d->fieldName = $fieldName;
					$d->checked = ($hasUser && $user[$fieldName]==1);
					switch($fieldName)
					{
						case 'pipe_smoker':
							$d->title = "Pipe Smoker";
							$d->description = "";
							break;
						case 'clergy_corner':
							$d->title = "Clergy Corner";
							$d->description = "";
							break;
						case 'ltl':
							$d->title = "L.T.L.";
							$d->description = "Long Time Listener";
							break;
						case 'ceramicists_corner':
							$d->title = "Ceramicists Corner";
							$d->description = "";
							break;
						case 'norwegian_branch':
							$d->title = "Norwegian Branch";
							$d->description = "";
							break;
						case 'colonial_commoner':
							$d->title = "Colonial Commoner";
							$d->description = "";
							break;
						case 'cravateer':
							$d->title = "Cravateer";
							$d->description = "";
							break;
						case 'diafls':
							$d->title = "D.I.A.F.L.S.";
							$d->description = "Deep In A Flu Lachrymosity Syndrome";
							break;
						case 'aals':
							$d->title = "A.A.L.S.";
							$d->description = "Altitude Adjusted Lachrymosity Syndrome";
							break;
						case 'pils':
							$d->title = "P.I.L.S.";
							$d->description = "Pregnancy Induced Lachrymosity Syndrome";
							break;
						case 'hils':
							$d->title = "H.I.L.S.";
							$d->description = "Hotel Induced Lachrymosity Syndrome";
							break;
						case 'ncg':
							$d->title = "N.C.G";
							$d->description = "Non Cinema Goer";
							break;
					}
					$r[] = $d;
				}

				return $r;


			}

		}

	}