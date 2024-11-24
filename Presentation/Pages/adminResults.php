<?php

use Business\Services\ResultService;

require_once "../../psr4_autoloader.php";

/**
 * Le service utilisé pour les divers opérations sur les résultats
 */
$resultService = new ResultService();

/**
 * Liste des résultats
 */
$results = $resultService->getAllResults();

/**
 * Filtrage par utilisateur
 */
if (isset($_GET["filterByUser"])){
    $userId = (int) $_GET["filterByUser"];
    $results = $resultService->filterResultsByUserId($userId);
}

/**
 * Filtrage par quiz
 */
if (isset($_GET["filterByQuiz"])){
    $quizId = (int) $_GET["filterByQuiz"];
    $results = $resultService->filterResultsByQuizId($quizId);
}

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
                    <a class="bttn" id="byQuiz">Filtrer par Quiz</a>
                    <a class="bttn" id="byUser">Filtrer par Utilisateur</a>
                </div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Id-joueur</th>
                            <th scope="col">Email&nbsp;Joueur</th>
                            <th scope="col">Id-quiz</th>
                            <th scope="col">Titre&nbsp;Quiz</th>
                            <th scope="col">Score</th>
                            <th scope="col">Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($results->getListResults() as $result) { ?>
                        <tr>
                            <td><?php echo $result->getUser()->getId(); ?></td>
                            <td><?php echo $result->getUser()->getEmail(); ?></td>
                            <td><?php echo $result->getQuiz()->getId();?></td>
                            <td><?php echo $result->getQuiz()->getTitle();?></td>
                            <td><?php echo $result->getScore();?></td>
                            <td><?php echo $result->getDateCreated()->format('Y-m-d H:i:s')?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="details">
                <p>Pour plus de détails des quiz , <a href="./adminQuiz.php"><span>c'est ici</span></a></p>
                <p>Pour plus de détails des joueurs , <a href="./adminUsers.php"><span>c'est ici</span></a></p>
            </div>
        </div>
    </div>
    <script>
        const input = document.getElementById('filter');
        const link = document.getElementById('byUser');
        const link2 = document.getElementById('byQuiz');

        // Mise à jour de l'attribut href du lien en fonction de l'entrée
        input.addEventListener('input', () => {
            link.href = `?filterByUser=${encodeURIComponent(input.value)}`;
            link2.href = `?filterByQuiz=${encodeURIComponent(input.value)}`;
        });
    </script>
</body>
</html>
