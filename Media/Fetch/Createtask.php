<?php

$DATA = json_decode(file_get_contents('php://input'), true);

$title = $DATA["title"];
$capacity = $DATA["capacity"];
$category = $DATA["category"];
$startDate = $DATA["startDate"];
$startTime = $DATA["startTime"];
$endDate = $DATA["endDate"];
$endTime = $DATA["endTime"];

$startDate = $startDate . " " . $startTime;
$endDate = $endDate . " " . $endTime;

$STMT = $conn->prepare("INSERT INTO `task`(`Title`, `Capacity`, `StartDate`, `EndDate`, `Category_ID`) VALUES (?,?,?,?,?);");
if ($STMT == false) {
    die("Secured");
}
$RESULT = $STMT->bind_param("sissi", $title, $capacity, $startDate, $endDate, $category);
if ($RESULT == false) {
    die("Secured");
}
$RESULT = $STMT->execute();
if ($RESULT == false) {
    die("Secured");
}
