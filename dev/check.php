<?php
include_once 'common.php';

if (isset($_POST["username"])) {
                $username = mysqli_real_escape_string($con, $_POST["username"]);
                $sql = "select username from wk_players where username='$username'";
                $result = mysqli_query($con, $sql);
                echo mysqli_num_rows($result);
        }