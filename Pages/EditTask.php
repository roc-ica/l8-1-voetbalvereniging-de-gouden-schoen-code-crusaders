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
    $taskId = $_POST["TaskId"];

    $startDate = $startDate . " " . $startTime;
    $endDate = $endDate . " " . $endTime;

    $STMT = $conn->prepare("UPDATE `task` SET `Title` = ?, `Capacity` = ?, `StartDate` = ?, `EndDate` = ?, `Category_ID` = ? WHERE `Task_ID` = ?;");
    if ($STMT == false) {
        die("Secured");
    }
    $RESULT = $STMT->bind_param("sissii", $title, $capacity, $startDate, $endDate, $category, $taskId);
    if ($RESULT == false) {
        die("Secured");
    }
    $RESULT = $STMT->execute();
    if ($RESULT == false) {
        die("Secured");
    }
    header("Refresh:0.1; url=TaskOverview.php", true, 303);
}


if (isset($_POST["submitId"])) {
    $STMT = $conn->prepare("SELECT * FROM `task` WHERE `Task_ID` =?");

    $RESULT = $STMT->bind_param("i", $_POST["submitId"]);

    $RESULT = $STMT->execute();

    $RESULT = $STMT->get_result();

    while ($row = $RESULT->fetch_array()) {
        $title = $row['Title'];
        $description = $row["Description"];
        $capacity = $row['Capacity'];
        $category = $row['Category_ID'];
        list($startDate, $startTime) = explode(" ", $row["StartDate"]);
        list($endDate, $endTime) = explode(" ", $row["EndDate"]);
    }
} else {
    header("location: TaskOverview.php");
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
    <link rel="stylesheet" href="../Media/CSS/TaskEdit.css">
    <style>

    </style>
    <title>De Gouden Schoen || Taak verranderen</title>
</head>

<body>
    <?php include "../Media/Templates/header.php" ?>
    <section class="SectionEditTask" id="SectionNewTask">
        <div class="WrapperEditTask">
            <a href="../Pages/TaskOverview.php">
                <button class="CloseButton" id="EditTaskClose">X</button>
            </a>
            <form action="" method="post" class="EditTaskForm" id="EditTaskForm">
                <input type="hidden" name="TaskId" value="<?php echo $_POST["submitId"] ?>" />
                <label for="Task">
                    Taak:
                    <input id="Task" type="text" name="Task" value="<?php echo $title ?>" required>
                </label>
                <label for="Category">
                    <select id="Category" name="Category" required>
                        <?php
                        $STMT2 = $conn->prepare("SELECT `Category_ID`, `Name` FROM `category`");
                        $STMT2->execute();
                        $RESULT2 = $STMT2->get_result();
                        while ($row2 = $RESULT2->fetch_array()) : ?>
                            <?php if ($row2["Category_ID"] != $category) : ?>
                                <option value="<?php echo $row2["Category_ID"] ?>"><?php echo $row2["Name"] ?></option>
                            <?php else : ?>
                                <option value="<?php echo $row2["Category_ID"] ?>" selected><?php echo $row2["Name"] ?></option>
                            <?php endif ?>
                        <?php endwhile ?>
                    </select> <br />
                    <button type="button" class="AddCategoryButton" id="AddCategoryButton">Voeg een categorie toe</button>
                </label>
                <div class="EditTaskDateTime">
                    <label for="StartTaskDate">
                        Begin taak datum:
                        <input id="StartTaskDate" type="date" name="StartDate" value="<?php echo $startDate ?>" required>
                    </label> <br />
                    <label for="EndTaskDate">
                        Eind taak datum:
                        <input id="EndTaskDate" type="date" name="EndDate" value="<?php echo $endDate ?>" required>
                    </label> <br />
                    <label for="StartTaskTIme">
                        Begin taak tijd:
                        <input id="StartTaskTime" type="time" name="StartTime" value="<?php echo $startTime ?>" required>
                    </label> <br />
                    <label for="EndTaskTime">
                        Eind taak tijd:
                        <input id="EndTaskTime" type="time" name="EndTime" value="<?php echo $endTime ?>" required>
                    </label>
                </div>
                <label for="TaskCapacity">
                    Nummer aan vrijwilligers:
                    <input id="TaskCapacity" type="number" min="0" name="Capacity" value="<?php echo $capacity ?>" required />
                </label>
                <button id="EditTaskFormSubmit" type="submit">Edit Task</button>
                <input id="hiddenSubmit" type="hidden" name="Submit">
            </form>
        </div>
    </section>
    <section class="SectionEditCategory" id="SectionEditCategory">
        <div class="WrapperEditCategory">
            <button class="CloseButton" id="EditCategoryClose">X</button>
            <h3 class="SectionHeader">Nieuwe categorie</h3>
            <form class="EditCategoryForm" id="EditCategoryForm">
                <label for="Category">
                    Categorie:
                    <input id="EditCategory" type="text" name="Category" required>
                </label>
                <button type="button" id="EditCategoryFormSubmit" type="submit">Creër categorie</button>
            </form>
        </div>
    </section>
</body>
<script>
    var taskForm = document.getElementById("EditTaskForm");

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

    document.getElementById("AddCategoryButton").addEventListener("click", function() {
        document.getElementById("SectionEditCategory").style.display = "flex";
    })

    document.getElementById("EditCategoryClose").addEventListener("click", function() {
        document.getElementById("SectionEditCategory").style.display = "none";
    });

    document.getElementById("EditCategoryFormSubmit").addEventListener("click", function() {
        CreateCategory();
    });

    function CreateCategory() {
        const value = document.getElementById("EditCategory").value;
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