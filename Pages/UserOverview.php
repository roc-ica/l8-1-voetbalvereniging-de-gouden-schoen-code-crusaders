<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Geologica:wght@200&family=Roboto&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/5622272db3.js" crossorigin="anonymous"></script>
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
            $sql = "SELECT * FROM `user`";
            $result = $conn->query($sql);

            if ($result) {
                while ($row = $result->fetch_object()) {
                    $user_ID = $row->user_ID;
                    $FirstName = $row->FirstName;
                    $Email = $row->Email;
                    $Role = $row->Role;

                    echo '<tr class="actief">
                    <th scope="row">' . $user_ID . '</th>
                    <td data-label="Naam: ">' . $FirstName . '</td>
                    <td data-label="Email: ">' . $Email . '</td>
                    <td data-label="Rol: ">' . $Role . '</td>
            
                    <td>
                    <button id="del" class="del"><a href="wis.php? wisid=' . $user_ID . '"><i class="fa-solid fa-trash" id="del"></i></a></button>
                    <button id="wijzig" class="wijzig"><a href="wijzig.php? wijzigid=' . $user_ID . '"><i class="fa-solid fa-pen-to-square" id="chang"></i></a></button>

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