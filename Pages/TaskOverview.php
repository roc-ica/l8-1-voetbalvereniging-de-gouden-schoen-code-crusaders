<?php
session_start();
if ((!isset($_SESSION['sessionid']) || $_SESSION['sessionid'] == session_id()) && !$_SESSION['role'] == 2) {
    header("location: index.php");
}
include "../Media/Templates/DBConnect.php";

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
    <title>De Gouden Schoen || Taken Overzicht</title>
</head>

<body>
    <?php include "../Media/Templates/header.php" ?>
    <section class="TaskSection">
        <?php
        if (isset($_SESSION["role"])) :
            if ($_SESSION["role"] == 2) :
        ?>
                <button class="buttonLogin NewTaskButton" id="NewTask">Nieuwe Taak</button>
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
                        <h4>Omschrijving:</h4>
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
                    <form method="post" action="EditTask.php">
                        <button class="buttonLogin DeleteButton" type="button" value="<?php echo $row["Task_ID"] ?>">Verwijder taak</button>
                        <button class="buttonLogin" type="submit" name="submitId" value="<?php echo $row["Task_ID"] ?>">Verander taak</button>
                    </form>
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
                        <form action="" method="post" class="NewTaskForm" id="NewTaskForm">
                            <label for="Task">
                                Taak:
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
                                </select> <br />
                                <button type="button" class="AddCategoryButton" id="AddCategoryButton">Nieuwe Categorie</button>
                            </label>
                            <div class="NewTaskDateTime">
                                <label for="StartTaskDate">
                                    Startdag taag:
                                    <input id="StartTaskDate" type="date" name="StartDate" required>
                                </label> <br />
                                <label for="EndTaskDate">
                                    Einddag taak:
                                    <input id="EndTaskDate" type="date" name="EndDate" required>
                                </label> <br />
                                <label for="StartTaskTIme">
                                    Starttijd taak:
                                    <input id="StartTaskTime" type="time" name="StartTime" required>
                                </label> <br />
                                <label for="EndTaskTime">
                                    Eindtijd taak:
                                    <input id="EndTaskTime" type="time" name="EndTime" required>
                                </label>
                            </div>
                            <label for="TaskCapacity">
                                Hoeveelheid vrijwilligers:
                                <input id="TaskCapacity" type="number" min="0" name="Capacity" required />
                            </label>
                            <button id="NewTaskFormSubmit" type="submit">Taak aanmaken</button>
                            <input id="hiddenSubmit" type="hidden" name="Submit">
                        </form>
                    </div>
                </section>
                <section class="SectionNewCategory" id="SectionNewCategory">
                    <div class="WrapperNewCategory">
                        <button class="CloseButton" id="NewCategoryClose">X</button>
                        <h3 class="SectionHeader">Nieuwe categorie</h3>
                        <form class="NewCategoryForm" id="NewCategoryForm">
                            <label for="Category">
                                Categorie:
                                <input id="NewCategory" type="text" name="Category" required>
                            </label>
                            <button type="button" id="NewCategoryFormSubmit" type="submit">Categorie aanmaken</button>
                        </form>
                    </div>
                </section>
            <?php endif ?>
        <?php endif ?>
    </section>
</body>

<script>
    var taskForm = document.getElementById("NewTaskForm");
    var deleteButtons = document.getElementsByClassName("DeleteButton");

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
        CreateCategory();
    });

    document.getElementById("AddCategoryButton").addEventListener("click", function() {
        document.getElementById("SectionNewCategory").style.display = "flex";
    })

    size_check();

    document.getElementsByTagName("BODY")[0].onresize = function() {
        size_check();
    };


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

    function CreateCategory() {
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
                    category.selected = true;
                    document.getElementById("Category").appendChild(category);
                    document.getElementById("SectionNewCategory").style.display = "none";
                    document.getElementById("NewCategory").value = "";
                })
                .catch((error) => {});
        }
    }
</script>

</html>