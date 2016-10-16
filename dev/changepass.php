<?php

//include 'common.php';
	
if(isset($_POST['submit']))
{	
$name = $_POST['name']; 
$pass = $_POST['pass']; 
$newpass = $_POST['newpass'];

if("$name" == "")
{
echo "<fieldset class=\"menu main\"><Divine>Change Password Error</Divine>Please enter a username.<br><br><a href='changepass.php'>Go Back</a></fieldset>";
define('ROOT', './');
exit;
} 
else

if("$pass" == "")
{
echo "<fieldset class=\"menu main\"><Divine>Change Password Error</Divine>Please enter your current password.<br><br><a href='changepass.php'>Go Back</a></fieldset>";
define('ROOT', './');
exit;
} 
else

if("$newpass" == "")
{
echo "<fieldset class=\"menu main\"><Divine>Change Password Error</Divine>Please enter a new password.<br><br><a href='changepass.php'>Go Back</a></fieldset>";
define('ROOT', './');
} 
else
$con = mysql_connect("localhost","wk","wolf");
if (!$con)
  {
  die('' . mysql_error());
  }
mysql_select_db("wolf_kingdom", $con);

$result = mysql_query("SELECT pass FROM wk_players where username='$name'"); 
$thepass = mysql_result($result, 0);
$lol = sha1($thepass);
$lol2 = sha1($pass);
$lol3 = sha1($newpass);

if("'$lol2'" == "'$thepass'")
    {
	mysql_query("UPDATE wk_players SET pass='$lol3' where username='$name'");
	echo 'Your password has been changed.<br><br><a href="index.php">Go Back</a>';
	exit;
	}
	else 
	{
	echo 'Invalid Username or Current Password.<br><br><a href="changepass.php">Go Back</a>';
define('ROOT', './');
	exit;
	}
	mysql_close($con);
	}
	
?>

 	<br />
	<form action="changepass.php" method="POST">
<table>
  <tr>
    <td><span class="style7">Username:</span></td>
    <td><input name="name" type="text" id="name" /></td>
  </tr>
  <tr>
    <td><span class="style7">Current Password:</span></td>
    <td><input name="pass" type="text" id="pass" value="" maxlength="20" /></td>
  </tr>
  <tr>
    <td><span class="style7">New Password:</span></td>
    <td><input name="newpass" type="text" id="newpass" value="" maxlength="20" /></td>
  </tr>
  <tr>
    <td colspan="2"><input type="submit" name="submit" value="Change" /></td>
  </tr>
</table>
</form>