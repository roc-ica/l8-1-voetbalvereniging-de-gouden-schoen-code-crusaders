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
        <button class="buttonLogin" onclick="tologin()" >Inloggen</button>
        <button id="darkModeButton" class="buttonLogin">Donkere Modus</button>
    </div>
</header>

<script>
        function tologin() {
            window.location.replace("../Pages/InlogPage.php")
        }
    </script>
