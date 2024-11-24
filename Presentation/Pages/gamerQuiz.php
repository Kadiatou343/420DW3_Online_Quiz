<?php

use Business\Domain\Result;
use Business\Services\QuestionService;
use Business\Services\QuizService;
use Business\Services\ResultService;
use Business\Services\UserService;

require_once "../../psr4_autoloader.php";
session_start();

/**
 * Le service du quiz utilisé pour les divers opérations sur les quiz
 */
$quizService = new QuizService();

/**
 * Le service de la question utilisé pour les divers opérations sur les questions
 */
$questionService = new QuestionService();

/**
 * Le nombre total de quiz dispo dans la base de données
 */
$totalQuizzes = $quizService->getQuizzesCount();

/**
 * Le nombre de quiz à chercher dans la base de données
 */
$limit = 4;

/**
 * Pour obtenir le nombre de pagination possible
 */
$totalPages = ceil($totalQuizzes / $limit);

/**
 * Pour avoir le numéro de page sur laquelle se trouve l'utilisateur avec les liens de paginations, 1 par defaut
 */
$page = $_GET['page'] ?? 1;

/**
 * Le delimiteur dans la base de données
 */
$offset = (int) (($page - 1) * $limit);

/**
 * Les quiz correspondant avec la limite et le delimiteur
 */
$listQuizzes = $quizService->getQuizzesByLimitAndOffset($limit, $offset);

/**
 * Faire passer passer les informations du quiz choisi à travers la session pour que la page de jeu puisse y acceder
 * Redirection vers la page de jeu
 */
if (isset($_GET["action"]) && $_GET["action"] == "play") {
    $_SESSION['quizId'] = (int) $_GET["quizId"];
    header("Location: jeuQuiz.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Parkinsans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../StyleSheets/gamerStyles.css">
    <title>Jeu - Quiz</title>
</head>
<body>
    <div class="main-container">
        <div class="data" id="data">
            <div class="table-title">
                <h3>Selectionnez le quiz que vous voulez</h3>
                <a href="./gamerResults.php" target="contentFrame" class="bttn">Mes résultats</a>
            </div>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">Titre du quiz</th>
                        <th scope="col">Description du quiz</th>
                        <th scope="col">Disponibilité</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($listQuizzes->getListQuizzes())){
                        foreach ($listQuizzes->getListQuizzes() as $quiz) { ?>
                    <tr>
                        <td><?php echo $quiz->getTitle(); ?></td>
                        <td><?php echo $quiz->getDescription(); ?></td>
                        <?php if (count($questionService->filterQuestionsByQuizId($quiz->getId())->getListQuestions()) > 3) { ?>
                        <td>Disponible</td>
                        <td>
                            <a href="?action=play&quizId=<?php echo $quiz->getId(); ?>" id="play" class="play"><i class="bi bi-play-fill"></i></a>
                        </td>
                        <?php } else {?>
                        <td>Indisponible</td>
                        <td>No&nbsp;action</td>
                                <?php } ?>
                    </tr>
                    <?php } } ?>
                </tbody>
            </table>
            <div class="table-footer">
                <?php if ($page > 1) { ?>
                <a href="?page=<?php echo $page - 1 ?>" class="bttn">Précédant</a>
                <?php } else { ?>
                <div><span class="disabled">Précédant</span></div>
                <?php } if ($page < $totalPages) { ?>
                <a href="?page=<?php echo $page + 1 ?>" class="bttn">Suivant</a>
                <?php } else { ?>
                <div><span class="disabled">Suivant</span></div>
                <?php } ?>
            </div>
        </div>
</body>
</html>
