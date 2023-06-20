<?php
session_start();

include "../Media/Templates/DBConnect.php";

if (isset($_POST['submit'])) {
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    $sql = "SELECT id, email, password, role FROM user WHERE email = ? AND status = 'TRUE'";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    try {
        while ($row = $result->fetch_array()) {
            $passwordreturn = password_verify($password, $row['password']);
            $role = $row['rol'];

            if ($passwordreturn) {
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['email'] = $email;
                $_SESSION['role'] = $row['role'];
                $_SESSION['sessionid'] = session_id();
                //alert('Je bent ingelogd');
    
            }
        }
    } catch (Exception $e) {
        $e->getMessage();
    }
 
    if($_SESSION['role'] == 'admin') {
        header('Location: UserOverview.php');
    } else {
        header("Refresh:0.1; url=TaskOverview.php", true, 303);
    }

}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/5622272db3.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Geologica:wght@200&family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../Media/CSS/inlog.css">
    <title>De gouden Schoen || Inlog</title>
</head>

<body>
    <div class="blok1"></div>
    <div class="blok2"></div>
 
    <div id="content">
        <div class="blok">
            <div class="veld">
                <img src="../Media/img/schoen.jpg">

                <div class="inlog">
                    <br>
                    <h2>Inloggen</h2>
                    <br>
                    <br>
                    <form action="" class="form">
                        <div class="form__veld">
                            <label for="email">Email</label><br>
                            <input type="text" class="input_veld" name="email" id="email">
                        </div>
                        <br>
                        <div class="form__veld">
                            <label for="password">Wachtwoord</label><br>
                            <input type="password" class="input_veld" name="password" id="password" />
                            <i class="fa-solid fa-eye-slash" onclick="myEye()"></i>
                        </div>
                        
                        <br>
                        <div class="submit_button">
                            <button name="submit" class="submit">Inloggen</button>
                        </div>
                    </form>
                    <br>    
                    <br>
                    <div class="copy">
                        <p>© De gouden schoen. All rights reserved | Design by Code Crusaders</p>
                    </div>
                </div>

            </div>


        </div>
    </div>
   
</body>

<script>
    function myEye() {
        let x = document.getElementById('password');

        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }
</script>
</html>