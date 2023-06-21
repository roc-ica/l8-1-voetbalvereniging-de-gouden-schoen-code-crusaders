<?php
include '../Media/Templates/DBConnect.php';

if (isset($_GET['wisid'])) {
    $user_ID = $_GET['wisid'];

    $sql = "DELETE FROM `user` WHERE user_ID = $user_ID";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        header('Location: UserOverview.php');
    } else {
        die (mysqli_error($conn));
    }
}
?>