<?php

use Business\Services\QuestionService;
use Business\Services\ResultService;
use ProjectUtilities\SessionManager;

require_once "../../psr4_autoloader.php";

/**
 * Le service du résult
 */
$resultService = new ResultService();
/**
 * Le service de la question
 */
$questionService = new QuestionService();

if (SessionManager::doesUserSessionExit()) {
    $userId = (int)$_SESSION["userId"];
}

$results = $resultService->filterResultsByUserId($userId ?? 0);

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
    <title>Result-gamer</title>
    <style>
        .table-content {
            margin: 30px;
        }
    </style>
</head>
<body>
<div class="main-container">
    <div class="table-content">
        <div class="table-title">
            <h3>Resultats</h3>
            <h3>Nombre de participation&nbsp;:&nbsp;<?php echo count($results->getListResults()); ?></h3>
        </div>
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">Titre&nbsp;Quiz</th>
                <th scope="col">Nombre&nbsp;de&nbsp;questions</th>
                <th scope="col">Score</th>
                <th scope="col">Date</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($results->getListResults() as $result) { ?>
                <tr>
                    <td><?php echo $result->getQuiz()->getTitle(); ?></td>
                    <td><?php echo count($questionService->filterQuestionsByQuizId($result->getQuiz()->getId())->getListQuestions()); ?></td>
                    <td><?php echo $result->getScore(); ?></td>
                    <td><?php echo $result->getDateCreated()->format('Y-m-d H:i:s'); ?></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
