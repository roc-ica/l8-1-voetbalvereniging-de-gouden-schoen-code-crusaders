<?php
session_start();
include "../../Media/Templates/DBConnect.php";

$DATA = json_decode(file_get_contents('php://input'), true);

$STMT = $conn->prepare("DELETE FROM `task` WHERE `task_ID` = ?");

$RESULT = $STMT->bind_param("i", $DATA['task_ID']);

$RESULT = $STMT->execute();
if ($RESULT == true) {
    $RESULT = array("status" => true);
} else {
    $RESULT = array("status" => false);
}
echo json_encode($RESULT);
