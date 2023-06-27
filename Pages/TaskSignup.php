<?php
session_start();
if (!(isset($_SESSION['sessionid']) || $_SESSION['sessionid'] == session_id() || ($_SESSION['role'] == 2 || $_SESSION['role'] == 1))) {
    header("location: index.php");
}

?>
