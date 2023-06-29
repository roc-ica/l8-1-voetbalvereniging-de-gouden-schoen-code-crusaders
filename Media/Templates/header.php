<head>
    <link rel="stylesheet" href="../css/header.css">
</head>
<header>
    <h1 class="Logo-Header">De <span class="gold">Gouden</span> schoen</h1>
    <ul class="ulheader">
        <li class="liheader"><a class="headerLink" href="../Pages/index.php">Startpagina</a></li>
        <li class="liheader"><a class="headerLink" href="../Pages/mytasks.php">Agenda</a></li>
        <li class="liheader"><a class="headerLink" href="../Pages/TaskSignup.php">Taak aanmelden</a></li>
        <?php
        if (isset($_SESSION["email"])) :
            if ($_SESSION["role"] == 2) :
        ?>
                <li class="liheader"><a class="headerLink" href="../Pages/TaskOverview.php">Taken bekijken</a></li>
            <?php endif ?>
        <?php endif ?>
    </ul>
    <div class="Login-Header">
        <?php
        if (!isset($_SESSION["role"])) :
        ?>
            <a href="../pages/InlogPage.php">
                <button class="buttonLogin">Inloggen</button>
            </a>
            <?php else : if ($_SESSION["role"] == 2) : ?>
                <div class="AdminDropdown">
                    <button class="buttonLogin DropdownButton">Gebruikersinstellingen</button>
                    <div class="AdminDropdownContent">
                        <a class="DropdownContent" href="../Pages/UserOverview.php">Gebruikers</a>
                        <a class="DropdownContent" href="../Media/Templates/Logout.php">Uitloggen</a>
                    </div>
                </div>
            <?php else : ?>
                <a href="../Media/Templates/Logout.php">
                    <button class="buttonLogin">Log-Uit</button>
                </a>
            <?php endif ?>
        <?php endif ?>
        <button id="darkModeButton" class="buttonLogin">Donkere Modus</button>
    </div>
    <script src="../Media/JS/darkmode.js"></script>

</header>