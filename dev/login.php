<?php
session_start();

if(isset($_SESSION['usr_id'])!="") {
	header("Location: index.php");
}

include_once 'inc/common.php';

//check if form is submitted
if (isset($_POST['login'])) {
        $banlist = ARRAY (
                "insert", "select", "update", "delete", "distinct", "having", "truncate", "replace",
                "handler", "like", " as ", "or ", "procedure", "limit", "order by", "group by", "asc", "desc"
        );
	$username = TRIM ( STR_REPLACE ( $banlist, '', STRTOLOWER ( mysqli_real_escape_string($con, $_POST['username']) ) ) );
	$password = TRIM ( STR_REPLACE ( $banlist, '', STRTOLOWER ( mysqli_real_escape_string($con, $_POST['password']) ) ) );
	$result = mysqli_query($con, "SELECT * FROM wk_players WHERE username = '" . $username. "' and pass = '" . sha1($password) . "'");

	if ($row = mysqli_fetch_array($result)) {
		$_SESSION['usr_id'] = $row['id'];
		$_SESSION['usr_name'] = $row['username'];
		header("Location: index.php");
	} else {
		$errormsg = "Incorrect username or password.";
	}
}
include 'header.php';
?>
<div class="container">
	<div class="row">
		<div class="col-md-4 col-md-offset-4 well">
			<form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="loginform">
				<fieldset>
					<legend>Login</legend>
					
					<div class="form-group">
						<label for="name">Username</label>
						<input type="text" name="username" placeholder="Your username" required class="form-control" />
					</div>

					<div class="form-group">
						<label for="name">Password</label>
						<input type="password" name="password" placeholder="Your Password" required class="form-control" />
					</div>

					<div class="form-group">
						<input type="submit" name="login" value="Login" class="btn btn-primary" />
					</div>
				</fieldset>
			</form>
			<span class="text-danger"><?php if (isset($errormsg)) { echo $errormsg; } ?></span>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4 col-md-offset-4 text-center">	
		New User? <a href="register.php">Register</a>
		</div>
	</div>
</div>

<?php
include 'footer.php';