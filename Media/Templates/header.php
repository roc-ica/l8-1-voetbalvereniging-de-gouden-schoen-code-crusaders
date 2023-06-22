<head>
    <link rel="stylesheet" href="../css/header.css">
</head>
<header>
    <h1 class="Logo-Header">De <span class="gold">Gouden</span>schoen</h1>
    <ul class="ulheader">
        <li class="liheader"><a class="headerLink" href="../Pages/index.php">Home</a></li>
        <li class="liheader"><a class="headerLink" href="../Pages/Agenda.php">Agenda</a></li>
        <li class="liheader">Contact</li>
    </ul>
    <div class="Login-Header">
        <?php
        if (!isset($_SESSION["email"])) :
        ?>
            <a href="../pages/InlogPage.php">
                <button class="buttonLogin">Inloggen</button>
            </a>
        <?php else : ?>
            <a href="../Media/Templates/Logout.php">
                <button class="buttonLogin">Log-Uit</button>
            </a>
        <?php endif ?>
        <button id="darkModeButton" class="buttonLogin">Donkere Modus</button>
    </div>
    <script src="../Media/JS/darkmode.js"></script>

</header>