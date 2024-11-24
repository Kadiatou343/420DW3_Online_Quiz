<?php
require_once "../../psr4_autoloader.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Parkinsans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../StyleSheets/adminStyles.css">
    <title>Panel - Result</title>
</head>
<body>
    <div class="main-container">
        <div class="list-result">
            <div class="filter">
                <label for="filter">Quiz id ou joueur id</label>
                <input type="number" width="30" height="30" step="1" name="filter" id="filter" min="1">
            </div>
            <div class="table-content">
                <div class="table-title">
                    <h3>Resultats</h3>
                    <button class="bttn">Filtrer par Quiz</button>
                    <button class="bttn">Filtrer par Utilisateur</button>
                </div>
                <table class="table table-stripped"> 
                    <thead>
                        <tr>
                            <th scope="col">Id-joueur</th>
                            <th scope="col">Email&nbsp;Utilisateur</th>
                            <th scope="col">Id-quiz</th>
                            <th scope="col">Titre&nbsp;Quiz</th>
                            <th scope="col">Score</th>
                            <th scope="col">Nombre&nbsp;question</th>
                            <th scope="col">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>wree@gn.com</td>
                            <td>1</td>
                            <td>YYYYYY</td>
                            <td>10</td>
                            <td>20</td>
                            <td>2024-01-01</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>wree@gn.com</td>
                            <td>1</td>
                            <td>YYYYYY</td>
                            <td>10</td>
                            <td>20</td>
                            <td>2024-01-01</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>wree@gn.com</td>
                            <td>1</td>
                            <td>YYYYYY</td>
                            <td>10</td>
                            <td>20</td>
                            <td>2024-01-01</td>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>wree@gn.com</td>
                            <td>1</td>
                            <td>YYYYYY</td>
                            <td>10</td>
                            <td>20</td>
                            <td>2024-01-01</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="details">
                <p>Pour plus de details des quiz , <a href="./adminQuiz.php" target="contentFrame"><span>c'est ici</span></a></p>
                <p>Pour plus de details des joueurs , <a href="./adminUsers.php" target="contentFrame"><span>c'est ici</span></a></p>
            </div>
        </div>
    </div>
    
</body>
</html>
