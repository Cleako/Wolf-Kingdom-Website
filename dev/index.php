<?php
session_start();

include_once 'common.php';
include 'header.php';

if (isset($_SESSION['usr_id'])) { ?>
Logged in.
<?php 
} else { ?>
Not logged in.
<?php } 
include 'footer.php';

