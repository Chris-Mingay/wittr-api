<?php

	namespace Wittr {

		/**
		 * An extended version of the php5 mysqli class
		 **/
		class DB
		{

			/**
			 * @var \mysqli $object
			 */
			public static $conn;

			public static function create($host,$username,$password,$database){
				DB::$conn = new \mysqli($host,$username,$password,$database);
			}

			public static $queries = 0;

			/**
			 * Pass the query on to the parent class and if required log the sql
			 **/
			public static function query($query){

				$return = DB::$conn->query($query);
				DB::$queries++;
				if($return===false){
					echo $query."<br/>".DB::$conn->error;
					die();
					throw new \Exception('SQL Error: '.DB::$conn->error.'<br/>'.$query);
				}else{
					return $return;
				}
			}

			public static function affected_rows(){
				return DB::$conn->affected_rows;
			}

			public static function insert_id(){
				return DB::$conn->insert_id;
			}

			public static function escape_string($string){
				return DB::$conn->escape_string($string);
			}

		}

		class PDO {

			/**
			 * @var \PDO $object
			 */
			public static $conn;

			public static function Create($host,$username,$password,$database)
			{

				$charset = 'utf8';

				$dsn = "mysql:host=$host;dbname=$database;charset=$charset";
				$opt = [
					\PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
					\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
					\PDO::ATTR_EMULATE_PREPARES   => false,
				];
				self::$conn = new \PDO($dsn, $username, $password, $opt);

			}
		}

	}