<?php

if(!defined('IN_PHPBB'))
{
	die("You do not have permission to access this file.");
}

class DarscapeDatabase {

var $settings;

function getSettings() {

// System variables
$settings['siteDir'] = $site;

// Database variables
$settings['dbhost'] = 'localhost';
$settings['dbusername'] = 'wk';
$settings['dbpassword'] = 'wolf';
$settings['dbname'] = 'wolf_kingdom';
                
return $settings;

}

}

class DarscapeDbc extends DarscapeDatabase {
var $theQuery;
var $link;
	function DarscapeDbc(){
		$settings = DarscapeDatabase::getSettings();

		$host = $settings['dbhost'];
                $db = $settings['dbname'];
                $user = $settings['dbusername'];
                $pass = $settings['dbpassword'];

                $con=mysqli_connect($host,$user,$pass,$db);

		$this->link = mysqli_connect($host, $user, $pass);
		mysqli_select_db($con, $db);
		register_shutdown_function(array(&$this, 'close'));
	}
	function query($query) {
		$this->theQuery = $query;
                $settings = DarscapeDatabase::getSettings();

		$host = $settings['dbhost'];
                $db = $settings['dbname'];
                $user = $settings['dbusername'];
                $pass = $settings['dbpassword'];

                $con=mysqli_connect($host,$user,$pass,$db);
		return mysqli_query($con, $query);
	}
	function fetchArray($result) {
		return mysqli_fetch_assoc($result);
	}
	function close() {
		mysqli_close($this->link);
	}
}
?>
