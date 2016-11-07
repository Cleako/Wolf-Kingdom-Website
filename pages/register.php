<?php

include_once './inc/common.php';

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
        
        $arf = ("SELECT username FROM wk_players where username='" . $username . "'");
        $dog = mysqli_query($con, $arf);
        @$wolfie = $dog->fetch_object()->username;
        if("'$username'" == "'$wolfie'")  {
                $error = true;
		$name_error = "Username already registered.";
        }
	if($noob >= 999999999999999){
		$error = true;
		$password_error = "You have created too many players.";
	}
	if(strlen($username) > 12) {
		$error = true;
		$password_error = "May not be longer than 12 characters.";
	}
	if (!preg_match("/^[a-zA-Z0-9]+([ ][a-zA-Z0-9]+)?$/",$username)) {
		$error = true;
		$name_error = "May contain only letters, numbers, and a space.";
	}
        if (!preg_match("/^[a-zA-Z0-9\-_]{0,40}$/",$password)) {
		$error = true;
		$password_error = "May contain only letters and numbers.";
	}
	if(strlen($password) < 4) {
		$error = true;
		$password_error = "Must be at least 4 characters long.";
	}
        if(strlen($password) > 20) {
		$error = true;
		$password_error = "May not be longer than 12 characters.";
	}
	if($password != $cpassword) {
		$error = true;
		$cpassword_error = "Passwords did not match.";
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
		$successmsg = 'User \''.htmlspecialchars($username).'\' has been created.</a>';
		$db->close();
	}
} ?>

<div class="main">
	<div class="content">
		<article>
                        <div id="data">
                            <h4>Register Player</h4><p>
                                <b><?php if (isset($successmsg)) { echo $successmsg; } ?>
                                <?php if (isset($errormsg)) { echo $errormsg; } ?></b>

                                <form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="signupform">
                                <label for="loginname">Username: </label><input type="text" class="name" id="username" name="username"/>
                                        <?php if (isset($name_error)) echo $name_error; ?>

                                <label for="loginpass">Password: </label><input type="password" class="password" id="password" name="password"/>
                                        <?php if (isset($password_error)) echo $password_error; ?>

                                <label for="loginpass">Confirm Password: </label><input type="password" class="password" id="cpassword" name="cpassword"/>
                                        <?php if (isset($cpassword_error)) echo $cpassword_error; ?>

                                <input type="submit" name="signup" value="Submit" class="submit" />
                                </form> 

                                <script src="./js/pwstrength-bootstrap.js" type="text/javascript"></script>
                                <script type="text/javascript">
                                    $(document).ready(function () {
                                        "use strict";
                                        var options = {};
                                        options.ui = {
                                            container: "#container",
                                            showVerdictsInsideProgressBar: true,
                                            viewports: {
                                                progress: ".progress_meter"
                                            }
                                        };
                                        $('#password').pwstrength(options);
                                    });
                                </script>
                                <script type="text/javascript">
                                    $(document).ready(function() {
                                    $("#username").blur(function(e) {
                                        var uname = $(this).val();
                                        if (uname == "")
                                        {
                                            $("#msg").html("");
                                            $("#submit").attr("disabled", true);
                                        }
                                        else
                                        {
                                            $("#msg").html("");
                                            $.ajax({
                                                url: "check.php",
                                                data: {username: uname},
                                                type: "POST",
                                                success: function(data) {
                                                    if(data > '0') {
                                                        $("#msg").html('<span class="text-danger">Username has already been taken!</span>');
                                                        $("#submit").attr("disabled", true);
                                                    } else {
                                                        $("#msg").html('<span class="text-success">Username is available!</span>');
                                                        $("#submit").attr("disabled", false);
                                                    }
                                                }
                                            });
                                        }
                                    });
                                    });
                                </script>
                        </div>
                </article>
	</div>
</div>

<?php
include 'footer.php';