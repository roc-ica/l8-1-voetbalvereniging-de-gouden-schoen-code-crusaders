<?php
session_start();
include '../Media/Templates/DBConnect.php';
include '../Media/Templates/header.php';

if (!(isset($_SESSION['sessionid']) || $_SESSION['sessionid'] == session_id() || $_SESSION['role'] == 2)) {
    header("location: index.php");
}

// var_dump($_SESSION) ;

if (isset($_GET['wisid'])) {
    $id = $_GET['wisid'];

    echo '<script type="text/javascript">
        if (confirm("Weet je zeker dat je deze gebruiker wilt verwijderen?")) {
            window.location.href = "wis.php?wisid=' . $user_ID . '";
        } else {
            window.location.href = "UserOverview.php";
        }
        </script>';
}
if (isset($_POST['Submit'])) {
    $voornaam = htmlspecialchars($_POST['FirstName']);
    $achternaam = htmlspecialchars($_POST['LastName']);
    $email = htmlspecialchars($_POST['Email']);
    $PASSWORD = htmlspecialchars($_POST['password']);
    $Role = htmlspecialchars($_POST['Role']);

    $hashed_password = password_hash($PASSWORD, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO user (FirstName, LastName, Email, Password, `Role`) VALUES (?,?,?,?,?)");
    $stmt->bind_param("ssssi", $voornaam, $achternaam, $email, $hashed_password, $Role);
    $RESULT = $stmt->execute();
    if ($RESULT == true) {
        header("location: UserOverview.php");
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Geologica:wght@200&family=Roboto&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/5622272db3.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../Media/CSS/UserOverview.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Geologica:wght@200&family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../Media/CSS/main.css">
    <link rel="stylesheet" href="../Media/CSS/header.css">
    <link rel="stylesheet" href="../Media/CSS/home.css">
    <link rel="stylesheet" href="../Media/CSS/UserOverview.css">
    <title>De Gouden Schoen || User Overview</title>
</head>

<body>
    <div id="background">
        <div class="container">
            <?php
            if (isset($_SESSION["role"])) :
                if ($_SESSION["role"] == 2) :
            ?>
                    <button class="buttonLogin NewUserButton" id="NewUser">Nieuwe gebruiker</button>
                <?php endif ?>
            <?php endif ?>
            <table class="table_crud">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Voornaam</th>
                        <th scope="col">Achternaam</th>
                        <th scope="col">Email</th>
                        <th scope="col">Rol</th>
                        <th scope="col">Actie</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    include "../Media/Templates/DBConnect.php";
                    $sql = "SELECT * FROM `user`";
                    $result = $conn->query($sql);

                    if ($result) {
                        while ($row = $result->fetch_object()) {
                            $user_ID = $row->user_ID;
                            $FirstName = $row->FirstName;
                            $LastName = $row->LastName;
                            $Email = $row->Email;
                            $Role = $row->Role;
                            if ($Role == 0) {
                                $Role = "inactief";
                            } else if ($Role == 1) {
                                $Role = "gebruiker";
                            } else if ($Role == 2) {
                                $Role = "admin";
                            }

                            echo '<tr class="actief">
                    <th scope="row">' . $user_ID . '</th>
                    <td data-label="Voornaam: ">' . $FirstName . '</td>
                    <td data-label="Achternaam: ">' . $LastName . '</td>
                    <td data-label="Email: ">' . $Email . '</td>
                    <td data-label="Rol: ">' . $Role . '</td>
            
                    <td>
                    <button id="del" onclick="confirmDelete(' . $user_ID . ')" class="del"><a href="wis.php? wisid=' . $user_ID . '"><i class="fa-solid fa-trash" id="del"></i></a></button>
                    <button id="wijzig" class="wijzig"><a href="wijzig.php? wijzigid=' . $user_ID . '"><i class="fa-solid fa-pen-to-square" id="chang"></i></a></button>

                    </td>
                
                    </tr>';
                        }
                    }

                    ?>
                </tbody>
            </table>
        </div>
        <?php
        if (isset($_SESSION["email"])) :
            if ($_SESSION["role"] == 2) :
        ?>
                <section class="SectionNewUser" id="SectionNewUser">
                    <div class="WrapperNewUser">
                        <button class="CloseButton" id="NewUserClose">X</button>
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="NewUserForm" id="NewUserForm">
                            <label for="FirstName">
                                Voornaam:
                                <input id="FirstName" type="text" name="FirstName" required>
                            </label>
                            <label for="LastName">
                                Achternaam:
                                <input id="LastName" type="text" name="LastName" required>
                            </label>
                            <label for="Email">
                                E-mail:
                                <input id="Email" type="email" name="Email" required>
                            </label>
                            <label for="Role">
                                Rol:
                                <select name="Role" id="Role">
                                    <option value="0">Inactief</option>
                                    <option value="1">Gebruiker</option>
                                    <option value="2">Admin</option>
                                </select>
                            </label>
                            <label for="password">
                                Wachtwoord:
                                <input type="password" class="input_veld" name="password" id="password" />
                            </label>
                            <button id="NewUserFormSubmit" type="submit">Gebruiker toevoegen</button>
                            <input id="hiddenSubmit" type="hidden" name="Submit">
                        </form>
                    </div>
                </section>
            <?php endif ?>
        <?php endif ?>
    </div>
</body>
<script type="text/javascript">
    function confirmDelete(user_ID) {
        if (confirm("Weet je zeker dat je deze gebruiker wilt verwijderen?")) {
            window.location.href = "wis.php?wisid=" + user_ID;
        }
    }
    var taskForm = document.getElementById("NewUserForm");
    var deleteButtons = document.getElementsByClassName("DeleteButton");

    document.getElementById("NewUser").addEventListener("click", function() {
        document.getElementById("SectionNewUser").style.display = "flex";
    });

    document.getElementById("NewUserClose").addEventListener("click", function() {
        document.getElementById("SectionNewUser").style.display = "none";
    });

    size_check();

    document.getElementsByTagName("BODY")[0].onresize = function() {
        size_check();
    };


    for (let index = 0; index < deleteButtons.length; index++) {
        deleteButtons[index].addEventListener("click", function() {
            DeleteTask(this.value);
        })
    };

    function size_check() {
        var r = document.querySelector(':root');
        var rect = document.getElementsByTagName("header")[0].getBoundingClientRect()

        var headerSize = Math.ceil(rect.height);
        r.style.setProperty('--Header-Height', headerSize + 'px');
    }
</script>

</html>