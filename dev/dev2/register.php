<?php
	
	FUNCTION anti_injection( $username, $password ) {
           // We'll first get rid of any special characters using a simple regex statement.
           // After that, we'll get rid of any SQL command words using a string replacment.
            $banlist = ARRAY (
                    "insert", "select", "update", "delete", "distinct", "having", "truncate", "replace",
                    "handler", "like", " as ", "or ", "procedure", "limit", "order by", "group by", "asc", "desc"
            );
            // ---------------------------------------------
            IF ( EREGI ( "[a-zA-Z0-9]+", $user ) ) {
                    $username = TRIM ( STR_REPLACE ( $banlist, '', STRTOLOWER ( $username ) ) );
            } ELSE {
                    $username = NULL;
            }
            // ---------------------------------------------
            // Now to make sure the given password is an alphanumerical string
            // devoid of any special characters. strtolower() is being used
            // because unfortunately, str_ireplace() only works with PHP5.
            IF ( EREGI ( "[a-zA-Z0-9]+", $password ) ) {
                    $password = TRIM ( STR_REPLACE ( $banlist, '', STRTOLOWER ( $password ) ) );
            } ELSE {
                    $password = NULL;
            }
            // ---------------------------------------------
            // Now to make an array so we can dump these variables into the SQL query.
            // If either user or pass is NULL (because of inclusion of illegal characters),
            // the whole script will stop dead in its tracks.
            $array = ARRAY ( 'username' => $username, 'password' => $password );
            // ---------------------------------------------
            IF ( IN_ARRAY ( NULL, $array ) ) {
                    DIE ( 'Invalid use of login and/or password. Please use a normal method.' );
            } ELSE {
                    RETURN $array;
            }
    }
	
	define('ROOT', './');
	include 'common.php';
	//include('mainheader.php');
 
	if(isset($_POST['submit'])) {
		$errors = array();
		
		$username = trim($_POST['username']);
		$password = trim($_POST['password1']);
		$remote_addr = $_SERVER['REMOTE_ADDR'];
		if(trim($_POST['password2']) != $password) {
			$errors[] = 'The passwords provided do not match.<br><br><a href="/index.php">Go Back</a>';
		}
		
		$usernameHash = usernameToHash($username);
		if($usernameHash < 0) {
			$errors[] = 'Invalid username.';
		}

		$hello = $db->query("SELECT * FROM wk_players WHERE creation_ip='$remote_addr'");
		$q = "SELECT * FROM wk_players WHERE creation_ip='$remote_addr'";
		$result = mysql_query($q);
		$noob=mysql_numrows($result);

		if($noob >= 9999999999999999999999999996){
			$errors[] = 'Only 5 accounts permitted per IP.<br><br><a href="register.php">Go Back</a>';
		}

		if(strlen($username) > 12){
			$errors[] = 'Username can not be over 12 characters.<br><br><a href="register.php">Go Back</a>';
		}
 
		if(strlen($username) < 4){
			$errors[] = 'Username must be 4 characters long or more.<br><br><a href="register.php">Go Back</a>';
		}
		if(strlen($password) < 4){
			$errors[] = 'Password must be 4 characters long or more.<br><br><a href="register.php">Go Back</a>';
		}
 
		$result = $db->query('SELECT `username` FROM `wk_players` WHERE `username` LIKE \''.$username.'\'');
		if($db->num_rows($result)) {
			$errors[] = 'That username is already taken.<br><br><a href="register.php">Go Back</a>';
		}
 
		if(!empty($errors)) {
			print_r($errors);
			exit;
		}

		$time = time();
		$gamepass = sha1($password);
		$gamename = explode('.', encode_username($username));
		$db->query('INSERT INTO `wk_players`(`user`, `username`, `pass`, `creation_date`, `creation_ip`) VALUES (\''.$gamename[0].'\', \''.$username.'\', \''.$gamepass.'\', \''.$time.'\', \''.$remote_addr.'\')');
		$db->query('INSERT INTO `wk_invitems`(`user`, `id`, `amount`, `wielded`, `slot`) VALUES (\''.$gamename[0].'\', 77, 1, 1, 1)');
		$db->query('INSERT INTO `wk_invitems`(`user`, `id`, `amount`, `wielded`, `slot`) VALUES (\''.$gamename[0].'\', 1263, 1, 0, 2)');
		$db->query('INSERT INTO `wk_invitems`(`user`, `id`, `amount`, `wielded`, `slot`) VALUES (\''.$gamename[0].'\', 81, 1, 0, 3)');
		$db->query('INSERT INTO `wk_invitems`(`user`, `id`, `amount`, `wielded`, `slot`) VALUES (\''.$gamename[0].'\', 10, 5000, 0, 4)');
		$db->query('INSERT INTO `wk_experience`(`user`) VALUES (\''.$gamename[0].'\')');
		$db->query('INSERT INTO `wk_curstats`(`user`) VALUES (\''.$gamename[0].'\')');
		echo 'User \''.htmlspecialchars($username).'\' has been created. You may now use this username and password to log into Open RSCD v4.<br><br><a href="register.php">Go Back</a>';
		$db->close();
		exit;
  
      }
		
?>
<fieldset class="menu main">
	<legend>Register</legend>
	<p><em>By registering you are agreeing to abide by our rules. Please make sure you've read them first.</em></p><br />
	<form action="register.php" method="POST">
		<table>
			<tr>
				<td>Username:</td>
				<td><input type="text" class="inputMedium" name="username" value="" /></td>
			</tr>
			<tr>
				<td>Password:</td>
				<td><input type="text"  class="inputMedium" name="password1" value="" /></td>
			</tr>
			<tr>
				<td>Confirm Password:</td>
				<td><input type="text"  class="inputMedium" name="password2" value="" /></td>
			</tr>
			<tr>
				<td colspan="2"><input type="submit" class="button" name="submit" value="Register" /></td>
			</tr>
		</table>
	</form>
</fieldset>
