<?php
include "../Media/Templates/DBConnect.php";
session_start();
if (isset($_POST["Submit"])) {
    $title = $_POST["Task"];
    $capacity = $_POST["Capacity"];
    list($hours, $minutes) = explode(":", $_POST["StartTime"]);
    $startTimestamp = mktime($hours, $minutes);
    list($hours, $minutes) = explode(":", $_POST["EndTime"]);
    $endTimestamp = mktime($hours, $minutes);

    $seconds = $endTimestamp - $startTimestamp;
    $minutes = ($seconds / 60) % 60;
    $hours = floor($seconds / (60 * 60));
    $seconds = $seconds - (60 * $minutes) - (60 * 60 * $hours);
    var_dump($hours, $minutes, $seconds, $_POST["StartTime"], $_POST["EndTime"]);
    $duration = $hours . ":" . $minutes . ":" . $seconds;

    $STMT = $conn->prepare("INSERT INTO `task`(`Title`, `Capacity`, `duration`) VALUES (?,?,?);");
    if ($STMT == false) {
        die("Secured");
    }
    $RESULT = $STMT->bind_param("sis", $title, $capacity, $duration);
    if ($RESULT == false) {
        die("Secured");
    }
    $RESULT = $STMT->execute();
    if ($RESULT == false) {
        die("Secured");
    }
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
    <title>De Gouden Schoen || Task Overview</title>
</head>

<body>
    <?php include "../Media/Templates/header.php" ?>

    <?php
    if (isset($_SESSION["email"])) :
        if ($_SESSION["role"] == 1) :
    ?>
            <button class="liheader" id="NewTask">New Task</button>
            <section class="sectionNewTask" id="sectionNewTask">
                <div class="WrapperNewTask">
                    <h3 class="sectionHeader">New Task</h3>
                    <form action="" method="post" class="NewTaskForm" id="NewTaskForm">
                        <label for="Task">
                            Task:
                            <input id="Task" type="text" name="Task" required>
                        </label>
                        <label for="Catagory">
                            <select id="Catagory" name="Catagory" required>
                                <option value="Catagory 1">Catagory 1</option>
                                <option value="Catagory 2">Catagory 2</option>
                                <option value="Catagory 3">Catagory 3</option>
                                <option value="Catagory 4">Catagory 4</option>
                                <option value="Catagory 5">Catagory 5</option>
                                <option value="Catagory 6">Catagory 6</option>
                            </select>
                        </label>
                        <div class="NewTaskDateTime">
                            <label for="StartTaskDate">
                                Start task date:
                                <input id="StartTaskDate" type="date" name="StartDate" required>
                            </label>
                            <label for="EndTaskDate">
                                End task date:
                                <input id="EndTaskDate" type="date" name="EndDate" required>
                            </label>
                            <label for="StartTaskTIme">
                                Start task time:
                                <input id="StartTaskTime" type="time" name="StartTime" required>
                            </label>
                            <label for="EndTaskTime">
                                End task time:
                                <input id="EndTaskTime" type="time" name="EndTime" required>
                            </label>
                        </div>
                        <label for="TaskCapacity">
                            Number of volunteers:
                            <input id="TaskCapacity" type="number" min="0" name="Capacity" required />
                        </label>
                        <button id="NewTaskFormSubmit" type="submit">Create Task</button>
                        <input id="hiddenSubmit" type="hidden" name="Submit">
                    </form>
                </div>
            </section>
        <?php endif ?>
    <?php endif ?>
</body>

<script>
    var taskForm = document.getElementById("NewTaskForm");
    document.getElementById("NewTask").addEventListener("click", function() {
        document.getElementById("sectionNewTask").style.display = "flex";
    });

    taskForm.addEventListener("submit", function(e) {
        var dateCorrect = false;
        var timeCorrect = false;
        e.preventDefault();
        if (document.getElementById("StartTaskDate").value < document.getElementById("EndTaskDate").value) {
            dateCorrect = true;
        } else {
            dateCorrect = false;
            if (document.getElementById("StartTaskTime").value < document.getElementById("EndTaskTime").value) {
                timeCorrect = true;
            } else {
                timeCorrect = false;
            }
        }
        if (timeCorrect || dateCorrect) {
            taskForm.submit();
        }
    })
</script>

</html>