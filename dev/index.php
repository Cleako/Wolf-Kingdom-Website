<?php
session_start();
include_once 'common.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>Wolf Kingdom</title>
	<meta content="width=device-width, initial-scale=1.0" name="viewport" >
	<link rel="stylesheet" href="css/bootstrap.min.css" type="text/css" />
</head>
<body>

<nav class="navbar navbar-default" role="navigation">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar1">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="index.php">Wolf Kingdom</a>
		</div>
		<div class="collapse navbar-collapse" id="navbar1">
			<ul class="nav navbar-nav navbar-right">
				<?php if (isset($_SESSION['usr_id'])) { ?>
				<li><p class="navbar-text">You are logged in as '<?php echo $_SESSION['usr_name']; ?>'.</p></li>
				<li><a href="logout.php">Log Out</a></li>
				<?php } else { ?>
				<li><a href="login.php">Login</a></li>
				<li><a href="register.php">Register</a></li>
				<?php } ?>
			</ul>
		</div>
	</div>
</nav>
    
<?php if (isset($_SESSION['usr_id'])) { ?>
    Logged in.
<?php 
include_once 'changepass.php';
?>
<?php } else { ?>
    Not logged in.
<?php } ?>

<script src="js/jquery-1.10.2.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>

