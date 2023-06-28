<?php
session_start();

include "../Media/Templates/header.php";
include "../Media/Templates/DBConnect.php";

if (isset($_POST['submit'])) {
    $voornaam = htmlspecialchars($_POST['voornaam']);
    $achternaam = htmlspecialchars($_POST['achternaam']);
    $email = htmlspecialchars($_POST['email']);
    $PASSWORD = htmlspecialchars($_POST['password']);

    $hashed_password = password_hash($PASSWORD, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO user (FirstName, LastName, Email, Password, `Role`) VALUES (?,?,?,?,0)");
    $stmt->bind_param("ssss", $voornaam, $achternaam, $email, $hashed_password);
    $stmt->execute();

    $sql = "SELECT user_ID, email, `PASSWORD`, `Role` FROM user WHERE email =?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();


    try {
        while ($row = $result->fetch_array()) {
            //result is in row
            $passwordreturn = password_verify($PASSWORD, $row['PASSWORD']);
            // var_dump($passwordreturn); die;
            $role = $row['Role'];

            if ($passwordreturn) {
                $_SESSION['email'] = $email;
                $_SESSION['role'] = $role;
                $_SESSION['uid'] = $row['user_ID'];
                $_SESSION['sessionid'] = session_id();
                header("Refresh:0.1; url=TaskOverview.php", true, 303);
            }
        }
    } catch (Exception $e) {
        $e->getMessage();
    }
}

?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/5622272db3.js" crossorigin="anonymous"></script>
    <link href="https://fonts.googleapis.com/css2?family=Geologica:wght@200&family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../Media/CSS/inlog.css">
    <title>De Goeden Schoen || Registreren</title>
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
                            <label for="email">Voornaam</label><br>
                            <input type="text" class="input_veld" name="voornaam" id="voornaam">
                        </div>
                        <br>
                        <div class="form__veld">
                            <label for="email">Achternaam</label><br>
                            <input type="text" class="input_veld" name="achternaam" id="achternaam">
                        </div>
                        <br>
                        <div class="form__veld">
                            <label for="email">Email</label><br>
                            <input type="email" class="input_veld" name="email" id="email">
                        </div>
                        <br>
                        <div class="form__veld">
                            <label for="password">Wachtwoord</label><br>
                            <input type="password" class="input_veld" name="password" id="password" />
                            <i class="fa-solid fa-eye-slash" onclick="myEye()"></i>
                        </div>

                        <br>
                        <div class="submit_button">
                            <button type="submit" class="submit" name="submit">Registreren</button>
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