<?php
session_start();

if(isset($_SESSION['usr_id'])) {
	header("Location: index.php");
}

include_once 'common.php';

//set validation error flag as false
$error = false;

//check if form is submitted
if (isset($_POST['signup'])) {
	$banlist = ARRAY (
                "insert", "select", "update", "delete", "distinct", "having", "truncate", "replace",
                "handler", "like", " as ", "or ", "procedure", "limit", "order by", "group by", "asc", "desc"
        );
        $username = TRIM ( STR_REPLACE ( $banlist, '', STRTOLOWER ( mysqli_real_escape_string($con, $_POST['username']) ) ) );
	$password = TRIM ( STR_REPLACE ( $banlist, '', STRTOLOWER ( mysqli_real_escape_string($con, $_POST['password']) ) ) );
	$cpassword = TRIM ( STR_REPLACE ( $banlist, '', STRTOLOWER ( mysqli_real_escape_string($con, $_POST['cpassword']) ) ) );
	$remote_addr = $_SERVER['REMOTE_ADDR'];
	$usernameHash = usernameToHash($username);
	if($usernameHash < 0) {
			$errors[] = 'Invalid username.';
	}
	$hello = $db->query("SELECT * FROM wk_players WHERE creation_ip='$remote_addr'");
	$q = "SELECT * FROM wk_players WHERE creation_ip='$remote_addr'";
	$result = mysqli_query($con, $q);
	$noob=mysqli_num_rows($result);
	if($noob >= 999999999999999){
		$error = true;
		$password_error = "You have created too many players already.";
	}
	if(strlen($username) > 12) {
		$error = true;
		$password_error = "Username may not be longer than 12 characters";
	}
	if (!preg_match("/^[a-zA-Z0-9]+([ ][a-zA-Z0-9]+)?$/",$username)) {
		$error = true;
		$name_error = "Username may contain only letters, numbers, and a space.";
	}
	if(strlen($password) < 4) {
		$error = true;
		$password_error = "Password must be at least 4 characters or more.";
	}
	if($password != $cpassword) {
		$error = true;
		$cpassword_error = "Password and confirm password didn't match.";
	}
	if (!$error) {
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
		$successmsg = 'User \''.htmlspecialchars($username).'\' has been created. <a href="login.php">Click here to Login</a>';
		$db->close();
	}
}
include 'header.php';
?>
<div class="container">
	<div class="row">
		<div class="col-md-4 col-md-offset-4 well">
			<form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="signupform">
				<fieldset>
					<legend>Register</legend>

					<div class="form-group">
						<label for="name">Username</label>
						<input type="text" name="username" placeholder="Username" required value="<?php if($error) echo $username; ?>" class="form-control" />
						<span class="text-danger"><?php if (isset($name_error)) echo $name_error; ?></span>
					</div>
					
					<div class="form-group">
						<label for="name">Password</label>
						<input type="password" name="password" placeholder="Password" required class="form-control" />
						<span class="text-danger"><?php if (isset($password_error)) echo $password_error; ?></span>
					</div>

					<div class="form-group">
						<label for="name">Confirm Password</label>
						<input type="password" name="cpassword" placeholder="Confirm Password" required class="form-control" />
						<span class="text-danger"><?php if (isset($cpassword_error)) echo $cpassword_error; ?></span>
					</div>

					<div class="form-group">
						<input type="submit" name="signup" value="Sign Up" class="btn btn-primary" />
					</div>
				</fieldset>
			</form>
			<span class="text-success"><?php if (isset($successmsg)) { echo $successmsg; } ?></span>
			<span class="text-danger"><?php if (isset($errormsg)) { echo $errormsg; } ?></span>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4 col-md-offset-4 text-center">	
		Already Registered? <a href="login.php">Login Here</a>
		</div>
	</div>
</div>
<?php
include 'footer.php';
?>