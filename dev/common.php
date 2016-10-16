<?php

$config = array(
	'mysqlhost' => 'localhost',
	'mysqldb' => 'wolf_kingdom',
	'mysqluser' => 'wk',
	'mysqlpass' => 'wolf'
);	
function error($s) {
		global $db;
		if($db) {
			$db->close();
		}
		exit($s);
	}

	include 'data_conversions.php';
	include 'mysql.php';
	$db = new DBLayer($config['mysqlhost'], $config['mysqluser'], $config['mysqlpass'], $config['mysqldb'], '', false);
	
	$con = mysqli_connect($config['mysqlhost'], $config['mysqluser'], $config['mysqlpass'], $config['mysqldb']) or die("Error " . mysqli_error($con));
