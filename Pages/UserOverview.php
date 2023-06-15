<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Geologica:wght@200&family=Roboto&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../Media/CSS/UserOverview.css">
    <title>De Gouden Schoen || User Overview</title>
</head>

<body>
    <div id="background">
        <div class="container">
            <table class="table_crud">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Naam</th>
                        <th scope="col">Email</th>
                        <th scope="col">Rol</th>
                        <th scope="col">Actie</th>
                    </tr>
                </thead>
                <tbody>
                <?php
            include "../Media/Templates/DBConnect.php";
            $sql = "SELECT * FROM `users_elearn`";
            $result = $conn->query($sql);

            if ($result) {
                while ($row = $result->fetch_object()) {
                    $id = $row->id;
                    $username = $row->username;
                    $email = $row->email;
                    $rol = $row->rol;

                    echo '<tr class="actief">
                    <th scope="row">' . $id . '</th>
                    <td data-label="Naam: ">' . $username . '</td>
                    <td data-label="Email: ">' . $email . '</td>
                    <td data-label="Rol: ">' . $rol . '</td>
            
                    <td>
                    <button class="trash"><a href="wis.php? wisid=' . $id . '">Wis</a></button>
                    <button class="trash"><a href="wijzig.php? wijzigid=' . $id . '">Wijzig</a></button>
                    
                    </td>
                
                    </tr>';
                }
            }

            ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>