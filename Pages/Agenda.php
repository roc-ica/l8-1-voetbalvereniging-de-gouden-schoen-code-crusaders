<?php
//session_start();
//?>
<!---->
<!--<!DOCTYPE html>-->
<!--<html lang="en">-->
<!---->
<!--<head>-->
<!--    <meta charset="UTF-8">-->
<!--    <meta http-equiv="X-UA-Compatible" content="IE=edge">-->
<!--    <meta name="viewport" content="width=device-width, initial-scale=1.0">-->
<!--    <title>De Gouden Schoen || Agenda</title>-->
<!--    <link rel="stylesheet" href="../Media/CSS/main.css" >-->
<!--    <link rel="stylesheet" href="../Media/CSS/header.css" >-->
<!--    <link rel="stylesheet" href="../Media/CSS/agenda.css" >-->
<!--    <link rel="preconnect" href="https://fonts.googleapis.com">-->
<!--    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>-->
<!--    <link href="https://fonts.googleapis.com/css2?family=Geologica:wght@200&family=Roboto&display=swap" rel="stylesheet">-->
<!--    <link rel="stylesheet" href="../Media/CSS/main.css">-->
<!--    <link rel="stylesheet" href="../Media/CSS/header.css">-->
<!--    <link rel="stylesheet" href="../Media/CSS/home.css">-->
<!--</head>-->
<!---->
<!--<body>-->
<!--    --><?php //include "../Media/Templates/header.php";
//          include "../Media/Templates/DBConnect.php";
//
//
//    $query = ("SELECT task.Task_ID, task.Title, task.StartDate, task.EndDate, user_has_task.Task_ID FROM task INNER JOIN user_has_task ON task.Task_ID = user_has_task.Task_ID WHERE user_has_task.User_ID = ?");
//    $stmt = $conn->prepare($query);
//    $stmt-> bind_param('i', $_SESSION['uid']);
//    $stmt->execute();
//    $data = $stmt->get_result();
//    $projects = array();
//    while ($project =  mysqli_fetch_assoc($data))
//    {
//        $projects[] = $project;
//    }
//    foreach ($projects as $project)
//    {
//?>
<!--    <div class="card">-->
<!--        <p class="title">--><?php //echo $project['Title']; ?><!--</p>-->
<!--        _____________________________-->
<!--        <p> Van: --><?php //echo $project['StartDate']; ?><!--</p>-->
<!--        <p> Tot: --><?php //echo $project['EndDate']; ?><!--</p>-->
<!--    </div>-->
<!--    --><?php
//    }
//    ?>
<!---->
<!---->
<!---->
<!---->
<!---->
<!---->
<!--</body>-->
<!---->
<!--</html>-->