<?php
session_start();

include '../Media/Templates/DBConnect.php';

$user_ID = $_GET['wijzigid'];
$sql = "SELECT * FROM `user` WHERE user_ID = $user_ID";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$FirstName = $row['FirstName'];
$LastName = $row['LastName'];

if (isset($_POST['submit'])) {
    $FirstName = htmlspecialchars($_POST['FirstName']);
    $LastName = htmlspecialchars($_POST['LastName']);

    $sql = "UPDATE `user` SET user_id =  $user_ID, FirstName = '$FirstName', LastName = '$LastName' WHERE user_ID = $user_ID";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        header('Location: UserOverview.php');
    } else {
        die(mysqli_error($conn));
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Aanpassen</title>
</head>

<body>
    <form action="" method="POST">
        <div class="FirstName">
            <input type="text" class="FirstName" id="FirstName" name="FirstName" placeholder="FirstName" value=<?php echo $FirstName; ?>>
        </div>
        <br>
        <div class="LastName">
            <input type="text" class="LastName" id="LastName" name="LastName" placeholder="LastName" value=<?php echo $LastName; ?>>
        </div>
        <button type="sumbit" name="submit">Opslaan</button>
    </form>
</body>

</html>