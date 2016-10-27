<?php
session_start();

include_once 'common.php';

if (isset($_SESSION['usr_id'])) {
include_once 'changepass.php';
} else { ?>
Not logged in.
<?php } 
include 'footer.php';
?>