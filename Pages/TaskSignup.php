<?php
session_start();
if (!(isset($_SESSION['sessionid']) || $_SESSION['sessionid'] == session_id() || ($_SESSION['role'] == 2 || $_SESSION['role'] == 1))) {
    header("location: index.php");
}
include "../Media/Templates/DBConnect.php";

if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $stmt = $conn->prepare("INSERT INTO user_has_task (User_ID, Task_ID) VALUES (?,?)");
    $stmt->bind_param("ss", $_SESSION['uid'], $id);
    $stmt->execute();
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Media/CSS/main.css">
    <link rel="stylesheet" href="../Media/CSS/header.css">
    <link rel="stylesheet" href="../Media/CSS/home.css">
    <link rel="stylesheet" href="../Media/CSS/TaskOverview.css">
    <style>

    </style>
    <title>De Gouden Schoen || Taak Aanmelden</title>
</head>

<body>
    <?php include "../Media/Templates/header.php" ?>
    <section class="TaskSection">
        <div class="TaskContainer">
            <?php

            $STMT = $conn->prepare("SELECT * FROM `task`;");
            if ($STMT == false) {
                die("Secured");
            }
            $RESULT = $STMT->execute();
            if ($RESULT == false) {
                die("Secured");
            }

            $RESULT = $STMT->get_result();

            while ($row = $RESULT->fetch_array()) :
                $sql2 = "SELECT * FROM user_has_task WHERE Task_ID =? AND `User_ID` = ?";
                $stmt2 = $conn->prepare($sql2);
                $stmt2->bind_param('si', $row['Task_ID'], $_SESSION["uid"]);
                $stmt2->execute();
                $result2 = $stmt2->get_result();
                if ($result2->num_rows == 0) {
                    $sql3 = "SELECT * FROM user_has_task WHERE Task_ID =?";
                    $stmt3 = $conn->prepare($sql3);
                    $stmt3->bind_param('s', $row['Task_ID']);
                    $stmt3->execute();
                    $result3 = $stmt3->get_result();
                    if ($row["Capacity"] > mysqli_num_rows($result3) && new DateTime() < new DateTime($row['StartDate'])) {

            ?>

                        <div class="Tasks" id="<?php echo $row["Task_ID"] ?>">
                            <h3><?php echo $row["Title"] ?></h3>
                            <?php if ($row["Description"] != null) : ?>
                                <h4>Beschrijving</h4>
                                <p><?php echo $row["Description"] ?></p>
                            <?php endif ?>
                            <h4>Hoeveelheid vrijwilligers:</h4>
                            <p><?php echo $row["Capacity"] ?></p>
                            <h4>Categorie:</h4>
                            <p>
                                <?php
                                $STMT = $conn->prepare("SELECT `Category_ID`, `Name` FROM `category` WHERE `Category_ID` = ?");
                                if ($STMT == false) {
                                    die("Secured");
                                }

                                $RESULT2 = $STMT->bind_param('s', $row["Category_ID"]);
                                if ($RESULT2 == false) {
                                    die("Secured");
                                }

                                $RESULT2 = $STMT->execute();
                                if ($RESULT2 == false) {
                                    die("Secured");
                                }

                                $RESULT2 = $STMT->get_result();

                                while ($row2 = $RESULT2->fetch_array()) {
                                    echo $row2["Name"];
                                }
                                ?>
                            </p>
                            <div>
                                <h4>Tijd</h4>
                                <div>
                                    <h5>Startdatum</h5>
                                    <div>
                                        <?php
                                        $datetime = explode(" ", $row["StartDate"]);
                                        for ($i = 0; $i < count($datetime); $i++) : ?>
                                            <p>
                                                <?php echo $datetime[$i] ?>
                                            </p>
                                        <?php endfor ?>
                                    </div>
                                    <h5>Einddatum</h5>
                                    <div>
                                        <?php
                                        $datetime = explode(" ", $row["EndDate"]);
                                        for ($i = 0; $i < count($datetime); $i++) : ?>
                                            <p>
                                                <?php echo $datetime[$i] ?>
                                            </p>
                                        <?php endfor ?>
                                    </div>
                                </div>
                            </div>
                            <form action="" method="post">
                                <input type="hidden" name="id" value=<?php echo $row['Task_ID'] ?>></input>

                                <button class="buttonLogin DeleteButton" type="submit" name="submit">Aanmelden voor deze taak</button>
                            </form>
                        </div>
            <?php }
                }
            endwhile ?>
        </div>
    </section>
</body>

</html>