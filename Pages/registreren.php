<?php

include "../Media/Templates/header.php";
include "../Media/Templates/DBConnect.php";

if (isset($_POST['submit'])) {
    $voornaam = $_POST['voornaam'];
    $achternaam = $_POST['achternaam'];
    $email = $_POST['email'];
    $wachtwoord = $_POST['password'];

    $hashed_password = password_hash($wachtwoord, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO user (FirstName, LastName, Email, Password) VALUES (?,?,?,?)");
    $stmt->bind_param("ssss", $voornaam, $achternaam, $email, $hashed_password);
    $stmt->execute();
}

?>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/5622272db3.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Geologica:wght@200&family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../Media/CSS/inlog.css">
    <title>De Goeden Schoen || Register</title>
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
                    <h2>Registreer</h2>
                    <br>
                    <br>
                    <form class="form" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="form__veld">
                            <label for="email">voornaam</label><br>
                            <input type="text" class="input_veld" name="voornaam" id="voornaam">
                        </div>
                        <br>
                        <div class="form__veld">
                            <label for="email">achternaam</label><br>
                            <input type="text" class="input_veld" name="achternaam" id="achternaam">
                        </div>
                        <br>
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
                            <button type="submit" class="submit" name="submit">Inloggen</button>
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