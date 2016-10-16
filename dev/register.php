<?php
session_start();

if(isset($_SESSION['usr_id'])) {
	header("Location: index.php");
}

include_once 'common.php';

//set validation error flag as false
$error = false;

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

//check if form is submitted
if (isset($_POST['signup'])) {
	$username = mysqli_real_escape_string($con, $_POST['username']);
	$password = mysqli_real_escape_string($con, $_POST['password']);
	$cpassword = mysqli_real_escape_string($con, $_POST['cpassword']);
	$remote_addr = $_SERVER['REMOTE_ADDR'];
	$usernameHash = usernameToHash($username);
	if($usernameHash < 0) {
			$errors[] = 'Invalid username.';
	}
	$hello = $db->query("SELECT * FROM wk_players WHERE creation_ip='$remote_addr'");
	$q = "SELECT * FROM wk_players WHERE creation_ip='$remote_addr'";
	$result = mysql_query($q);
	$noob=mysql_numrows($result);
	if($noob >= 9999999999999999999999999996){
		$error = true;
		$password_error = "Password must be minimum of 6 characters";
	}
	if (!preg_match("/^[a-zA-Z ]+$/",$username)) { //username can contain only alpha characters and space
		$error = true;
		$name_error = "Username must contain only alphabets and space";
	}
	if(strlen($password) < 6) {
		$error = true;
		$password_error = "Password must be minimum of 6 characters";
	}
	if($password != $cpassword) {
		$error = true;
		$cpassword_error = "Password and Confirm Password doesn't match";
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
?>

<!DOCTYPE html>
<html>
<head>
	<title>Player Registration</title>
	<meta content="width=device-width, initial-scale=1.0" name="viewport" >
	<link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" />
</head>
<body>

<nav class="navbar navbar-default" role="navigation">
	<div class="container-fluid">
		<!-- add header -->
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar1">
				<span class="sr-only"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="index.php">Wolf Kingdom</a>
		</div>
		<!-- menu items -->
		<div class="collapse navbar-collapse" id="navbar1">
			<ul class="nav navbar-nav navbar-right">
				<li><a href="login.php">Login</a></li>
				<li class="active"><a href="register.php">Register</a></li>
			</ul>
		</div>
	</div>
</nav>

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
<script src="js/jquery-1.10.2.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>



