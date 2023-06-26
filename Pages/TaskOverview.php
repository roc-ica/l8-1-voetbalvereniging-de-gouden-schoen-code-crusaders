<?php
include "../Media/Templates/DBConnect.php";
session_start();
if (isset($_POST["Submit"])) {
    $title = $_POST["Task"];
    $capacity = $_POST["Capacity"];
    $category = $_POST["Category"];
    $startDate = $_POST["StartDate"];
    $startTime = $_POST["StartTime"];
    $endDate = $_POST["EndDate"];
    $endTime = $_POST["EndTime"];

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
    header("Refresh:0.1; url=TaskOverview.php", true, 303);
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
    <title>De Gouden Schoen || Task Overview</title>
</head>

<body>
    <?php include "../Media/Templates/header.php" ?>
    <section class="TaskSection">
        <?php
        if (isset($_SESSION["email"])) :
            if ($_SESSION["role"] == 2) :
        ?>
                <button class="buttonLogin" id="NewTask">New Task</button>
            <?php endif ?>
        <?php endif ?>
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

            while ($row = $RESULT->fetch_array()) : ?>

                <div class="Tasks" id="<?php echo $row["Task_ID"] ?>">
                    <h3><?php echo $row["Title"] ?></h3>
                    <?php if ($row["Description"] != null) : ?>
                        <h4>Description</h4>
                        <p><?php echo $row["Description"] ?></p>
                    <?php endif ?>
                    <h4>Capacity:</h4>
                    <p><?php echo $row["Capacity"] ?></p>
                    <h4>Category:</h4>
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
                        <h4>Time</h4>
                        <div>
                            <h5>Start date</h5>
                            <div>
                                <?php
                                $datetime = explode(" ", $row["StartDate"]);
                                for ($i = 0; $i < count($datetime); $i++) : ?>
                                    <p>
                                        <?php echo $datetime[$i] ?>
                                    </p>
                                <?php endfor ?>
                            </div>
                            <h5>End date</h5>
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
                    <button class="buttonLogin DeleteButton" value="<?php echo $row["Task_ID"] ?>">Delete task</button>
                    <button class="buttonLogin EditButton" value="<?php echo $row["Task_ID"] ?>">Edit task</button>
                </div>

            <?php endwhile ?>
        </div>
        <?php
        if (isset($_SESSION["email"])) :
            if ($_SESSION["role"] == 2) :
        ?>
                <section class="SectionNewTask" id="SectionNewTask">
                    <div class="WrapperNewTask">
                        <button class="CloseButton" id="NewTaskClose">X</button>
                        <h3 class="SectionHeader">New Task</h3>
                        <form action="" method="post" class="NewTaskForm" id="NewTaskForm">
                            <label for="Task">
                                Task:
                                <input id="Task" type="text" name="Task" required>
                            </label>
                            <label for="Category">
                                <select id="Category" name="Category" required>
                                    <?php
                                    $STMT = $conn->prepare("SELECT `Category_ID`, `Name` FROM `category`");
                                    $STMT->execute();
                                    $RESULT = $STMT->get_result();
                                    while ($row = $RESULT->fetch_array()) : ?>
                                        <option value="<?php echo $row["Category_ID"] ?>"><?php echo $row["Name"] ?></option>
                                    <?php endwhile ?>
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
    </section>
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
    size_check();

    document.getElementsByTagName("BODY")[0].onresize = function() {
        size_check();
    };

    var deleteButtons = document.getElementsByClassName("DeleteButton");
    var deleteButtons = document.getElementsByClassName("EditButton");

    for (let index = 0; index < deleteButtons.length; index++) {
        deleteButtons[index].addEventListener("click", function() {
            DeleteTask(this.value);
        })
    };


    function size_check() {
        var r = document.querySelector(':root');
        var rect = document.getElementsByTagName("header")[0].getBoundingClientRect()

        var headerSize = Math.ceil(rect.height);
        r.style.setProperty('--Header-Height', headerSize + 'px');
    }

    function DeleteTask(taskId) {
        const data = {
            task_ID: taskId
        };
        fetch("../Media/Fetch/DeleteTask.php", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify(data),
            })
            .then((response) => response.json())
            .then((data) => {
                if (data["status"] == true) {
                    document.getElementsByClassName("TaskContainer")[0].removeChild(document.getElementById(taskId));
                }
            })
            .catch((error) => {});
    }

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
                    document.getElementById("Category").appendChild(category);
                })
                .catch((error) => {});
        }
    }
</script>

</html>