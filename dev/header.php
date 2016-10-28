<!DOCTYPE html>
<html>
<head>
	<title>Wolf Kingdom</title>
	<meta content="width=device-width, initial-scale=1.0" name="viewport" >
	<link rel="stylesheet" href="css/bootstrap.css" type="text/css" />
        
</head>
<body>
<script src="js/jquery-1.10.2.js"></script>
<script src="js/bootstrap.js"></script>

<nav class="navbar navbar-default" role="navigation">
	<div class="container-fluid">
		<div class="navbar-header">
			<a class="navbar-brand" href="index.php">Wolf Kingdom</a>
		</div>
		<div class="collapse navbar-collapse" id="navbar1">
			<ul class="nav navbar-nav navbar-right">
				<?php if (isset($_SESSION['usr_id'])) { ?>
				<li><p class="navbar-text">You are logged in as <a href="manage.php"><b><?php echo $_SESSION['usr_name']; ?></b>.</a></p></li>
                                <li><a href="manage.php">Manage Player</a></li>
				<li><a href="logout.php">Log Out</a></li>
				<?php } else { ?>
				<li><a href="login.php">Login</a></li>
				<li><a href="register.php">Register</a></li>
				<?php } ?>
			</ul>
		</div>
	</div>
</nav>