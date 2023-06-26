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
        if ($_SESSION["role"] == 2) :
    ?>
            <button class="liheader" id="NewTask">New Task</button>
            <section class="SectionNewTask" id="SectionNewTask">
                <div class="WrapperNewTask">
                    <button class="CloseButton" id="NewTaskClose">X</button>
                    <h3 class="SectionHeader">New Task</h3>
                    <form action="" method="post" class="NewTaskForm" id="NewTaskForm">
                        <label for="Task">
                            Task:
                            <input id="Task" type="text" name="Task" required>
                        </label>
                        <label for="Catagory">
                            <select id="Catagory" name="Catagory" required>
                                <?php
                                $STMT = $conn->prepare("SELECT `Category_ID`, `Name` FROM `category`");
                                $STMT->execute();
                                $RESULT = $STMT->get_result();
                                while ($row = $RESULT->fetch_array()) :?>
                                    <option value="Catagory 1">Category 1</option>
                                <?php endwhile ?>
                                <option value="Catagory 2">Category 2</option>
                                <option value="Catagory 3">Category 3</option>
                                <option value="Catagory 4">Category 4</option>
                                <option value="Catagory 5">Category 5</option>
                                <option value="Catagory 6">Category 6</option>
                            </select>
                            <button type="button" class="AddCategoryButton" id="AddCategoryButton">Add Category</button>
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
            <section class="SectionNewCategory" id="SectionNewCategory">
                <div class="WrapperNewCategory">
                    <button class="CloseButton" id="NewCategoryClose">X</button>
                    <h3 class="SectionHeader">New Category</h3>
                    <form class="NewCategoryForm" id="NewCategoryForm">
                        <label for="Category">
                            Category:
                            <input id="NewCategory" type="text" name="Category" required>
                        </label>
                        <button type="button" id="NewCategoryFormSubmit" type="submit">Create Category</button>
                    </form>
                </div>
            </section>
        <?php endif ?>
    <?php endif ?>
</body>

<script>
    var taskForm = document.getElementById("NewTaskForm");
    document.getElementById("NewTask").addEventListener("click", function() {
        document.getElementById("SectionNewTask").style.display = "flex";
    });
    document.getElementById("NewTaskClose").addEventListener("click", function() {
        document.getElementById("SectionNewTask").style.display = "none";
    });
    document.getElementById("NewCategoryClose").addEventListener("click", function() {
        document.getElementById("SectionNewCategory").style.display = "none";
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
    document.getElementById("NewCategoryFormSubmit").addEventListener("click", function() {
        FetchQuestion();
    });
    document.getElementById("AddCategoryButton").addEventListener("click", function() {
        document.getElementById("SectionNewCategory").style.display = "flex";

    })

    function FetchQuestion() {
        const value = document.getElementById("NewCategory").value;
        const data = {
            category: value
        };
        if (value != "") {
            fetch("../Media/Fetch/CreateCategory.php", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                    },
                    body: JSON.stringify(data),
                })
                .then((response) => response.json())
                .then((data) => {
                    var category = document.createElement("option");
                    category.value = data["CategoryId"];
                    category.text = data["Name"];
                    document.getElementById("Catagory").appendChild(category);
                })
                .catch((error) => {
                    console.error("Error HUISs:", error);
                });
        }
    }
</script>

</html>