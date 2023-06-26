<?php
session_start();
include "../../Media/Templates/DBConnect.php";

$DATA = json_decode(file_get_contents('php://input'), true);

$STMT = $conn->prepare("INSERT INTO `category`(`Name`) VALUES (?)");
if ($STMT == false) {
    die("Secured");
}

$RESULT = $STMT->bind_param("s", $DATA["category"]);
if ($RESULT == false) {
    die("Secured");
}

$RESULT = $STMT->execute();
if ($RESULT == false) {
    die("Secured");
}

$STMT = $conn->prepare("SELECT `Category_ID`, `Name` FROM `category` WHERE `Name` = ?");
if ($STMT == false) {
    die("Secured");
}

$RESULT = $STMT->bind_param('s', $DATA['category']);
if ($RESULT == false) {
    die("Secured");
}

$RESULT = $STMT->execute();
if ($RESULT == false) {
    die("Secured");
}

$RESULT = $STMT->get_result();

try {
    $stats = $RESULT->fetch_array();
    $RESULT = array("CategoryId" => $stats["Category_ID"], "Name" => $stats["Name"]);
} catch (Exception $e) {
    $e->getMessage();
}

echo json_encode($RESULT);
