<?php
session_start();

include_once 'common.php';
include 'charfunctions.php';

if (isset($_SESSION['usr_id'])) {

if(isset($_POST['submit']))
{	
$pass = $_POST['pass'];
$newpass = $_POST['newpass'];

if("$pass" == "")
{
echo "Change password error. <br><br>Please enter your current password.<br><br><a href='manage.php'>Go Back</a>";
define('ROOT', './');
exit;
} 
else

if ("$newpass" == "") {
    echo "Change password error <br><br>Please enter a new password.<br><br><a href='manage.php'>Go Back</a>";
    define('ROOT', './');
} else {
$thepass = ("SELECT pass FROM wk_players where username='" . $_SESSION['usr_name'] . "'");
}
$result = mysqli_query($con, $thepass);
$wolf = $result->fetch_object()->pass;

$lol2 = sha1($pass);
$lol3 = sha1($newpass);

if("'$lol2'" == "'$wolf'")
    {
	mysqli_query($con, "UPDATE wk_players SET pass='$lol3' where username='".$_SESSION['usr_name']."'"); 
	
        echo 'Your password has been changed.<br><br><a href="manage.php">Go Back</a>';
	exit;
	}
	else 
	{
        echo 'Invalid current password or new password. <br><br><a href="manage.php">Go Back</a>' . '<br>';
        define('ROOT', './');
	exit;
	}
	mysqli_close($con);
	}
include 'header.php';
?>

 	<br />
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
<table>
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
        
<br>
<br>

<div id="character">
    <?php
      
  
    $query = "SELECT * FROM wk_players WHERE username='".$_SESSION['usr_name']."'";
    $stmt = $con->prepare($query);
    @$stmt->bind_param('s', $_SESSION['usr_name']);
    $stmt->execute();
    $res = $stmt->get_result();
?>
<p><?php while($row = $res->fetch_array()):
echo drawCharacter($row['haircolour'],$row['headsprite'],$row['skincolour'],$row['topcolour'],$row['male'],$row['trousercolour']); 
endwhile;
    
        
        ?>
</div>

<?php
} else { ?>
Not logged in.
<?php } 
include 'footer.php';