<?php

include_once './inc/common.php';
include './inc/charfunctions2.php';

if(isset($_POST['submit'])) {	
        $username = $_POST['username'];
        $pass = $_POST['curpass'];
        $newpass = $_POST['newpass'];
        
        if("$pass" == "") {
                echo "Change password error. <br><br>Please enter your current password.<br><br><a href='changepass.php'>Go Back</a>";
                define('ROOT', './');
                exit;
        } 
        else if ("$newpass" == "") {
                echo "Change password error <br><br>Please enter a new password.<br><br><a href='changepass.php'>Go Back</a>";
                define('ROOT', './');
        } 
        else {
                $thepass = ("SELECT pass FROM wk_players where username='".$username."'");
        }
        
        $result = mysqli_query($con, $thepass);
        $wolf = $result->fetch_object()->pass;
        $lol2 = sha1($pass);
        $lol3 = sha1($newpass);

        if("'$lol2'" == "'$wolf'") {
                mysqli_query($con, "UPDATE wk_players SET pass='$lol3' where username='".$username."'"); 
                $successmsg = 'Password for \''.htmlspecialchars($username).'\' has been changed.</a>';
        }
        else {
                $errormsg = 'Invalid current password or new password.';
                //define('ROOT', './');
        }
        mysqli_close($con);
} ?>

<div class="main">
	<div class="content">
		<article>
                        <div id="data">
                            <h4>Change Password</h4><p>
                                <b><?php if (isset($successmsg)) { echo $successmsg; } ?>
                                <?php if (isset($errormsg)) { echo $errormsg; } ?></b>
                                <form role="form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="signupform">
                                    <label for="loginname">Username: </label><input type="text" class="name" id="username" name="username"/>
                                        <?php if (isset($name_error)) echo $name_error; ?>
                                    
                                    <label for="loginpass">Password: </label><input type="password" class="password" name="curpass" id="curpass" name="password"/>
                                        <?php if (isset($password_error)) echo $password_error; ?>
                                    
                                    <label for="loginpass">New Password: </label><input type="password" class="password" name="newpass" id="newpass" name="password"/>
                                        <?php if (isset($cpassword_error)) echo $cpassword_error; ?>
                                    
                                    <input type="submit" name="submit" value="Submit" class="submit" />

                                </form>
                                <div id="character">
                                        <?php
                                        /*$query = "SELECT * FROM wk_players WHERE username='".$username."'";
                                        $stmt = $con->prepare($query);
                                        @$stmt->bind_param('s', $username);
                                        $stmt->execute();
                                        $res = $stmt->get_result();
                                        while($row = $res->fetch_array()):
                                        echo drawCharacter($row['haircolour'],$row['headsprite'],$row['skincolour'],$row['topcolour'],$row['male'],$row['trousercolour']); 
                                        endwhile;*/
                                        ?>
                                </div>
                </article>
	</div>
</div>

<?php 
include 'footer.php';