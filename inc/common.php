<?php
include 'data_conversions.php';
include 'mysql.php';

$config = array(
	'mysqlhost' => 'localhost',
	'mysqldb' => 'wolf_kingdom',
	'mysqluser' => 'root',
	'mysqlpass' => ''
);

$db = new DBLayer($config['mysqlhost'], $config['mysqluser'], $config['mysqlpass'], $config['mysqldb'], '', false);
$con = mysqli_connect($config['mysqlhost'], $config['mysqluser'], $config['mysqlpass'], $config['mysqldb']) or die("Error " . mysqli_error($con));

function error($s) {
        global $db;
        if($db) {
                $db->close();
        }
        exit($s);
}