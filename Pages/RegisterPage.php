<?php

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
                    <h2>Account maken</h2>
                    <br>
                    <br>
                    <form action="" class="form">
                        <div class="form__veld">
                            <label for="firstname">Voornaam</label><br>
                            <input type="text" class="input_veld" name="firstname" id="firstname">
                        </div>
                        <br>
                        <div class="form__veld">
                            <label for="lastname">Achternaam</label><br>
                            <input type="text" class="input_veld" name="lastname" id="lastname" />
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
                            <button name="submit" class="submit">Registreren</button>
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

</html>