<?php
session_start();

include "../Media/Templates/header.php";

if (!(isset($_SESSION['sessionid']) || $_SESSION['sessionid'] == session_id() || $_SESSION['role'] == 2)) {
    header("location: index.php");
}


include '../Media/Templates/DBConnect.php';


if (isset($_GET['wijzigid'])) {
    $user_ID = $_GET['wijzigid'];

    $sql = "SELECT * FROM `user` WHERE user_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $user_ID);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_array()) {
        $FirstName = $row['FirstName'];
        $LastName = $row['LastName'];
        $Email = $row['Email'];
        $Role = $row['Role'];
    }
}

if (isset($_POST['submit'])) {
    $FirstName = htmlspecialchars($_POST['FirstName']);
    $LastName = htmlspecialchars($_POST['LastName']);
    $Email = htmlspecialchars($_POST['Email']);
    $Role = htmlspecialchars($_POST['rol']);
    $user_ID = htmlspecialchars($_POST['uid']);

    $sql = "UPDATE `user` SET FirstName = ?, LastName = ?, Email = ?, `Role` = ? WHERE user_ID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sssss', $FirstName, $LastName, $Email, $Role, $user_ID);
    $stmt->execute();
    header('Location: UserOverview.php');
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gebruiker Aanpassen</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geologica:wght@200&family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../Media/CSS/main.css">
    <link rel="stylesheet" href="../Media/CSS/header.css">
    <link rel="stylesheet" href="../Media/CSS/home.css">
    <link rel="stylesheet" href="../Media/CSS/wijzig.css">

</head>

<body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <div class="FirstName">
            <input type="text" class="FirstName" id="FirstName" name="FirstName" placeholder="FirstName" value="<?php echo $FirstName; ?>">
        </div>
        <br>
        <div class="LastName">
            <input type="text" class="LastName" id="LastName" name="LastName" placeholder="LastName" value="<?php echo $LastName ?>">
        </div>
        <br>
        <div class="Email">
            <input type="text" class="Email" id="Email" name="Email" placeholder="Email" value="<?php echo $Email; ?>">
        </div>
        <br>
        <div class="Rol">
            <select name="rol" id="rol">
                <option <?php if ($Role == '0') {
                            echo ("selected");
                        } ?> value="0">Inactief</option>
                <option <?php if ($Role == '1') {
                            echo ("selected");
                        } ?> value="1">Gebruiker</option>
                <option <?php if ($Role == '2') {
                            echo ("selected");
                        } ?> value="2">Admin</option>
            </select>
        </div>
        <input type="hidden" name="uid" value=<?php echo $user_ID; ?>>
        <input class="opslaan" type="submit" name="submit" value="opslaan">
    </form>
</body>

</html>