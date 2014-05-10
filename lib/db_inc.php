<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/lib/meekrodb.2.2.class.php");

/*------------ DB ------------*/

DB::$user = 'villagealert';
DB::$password = 'villagealert1';
DB::$dbName = 'villagealert';
DB::$host = '127.0.0.1'; //defaults to localhost if omitted
DB::$encoding = 'utf8'; // defaults to latin1 if omitted

