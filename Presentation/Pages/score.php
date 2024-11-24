<?php

use Business\Services\ResultService;

require_once "../../psr4_autoloader.php";
session_start();

$resultService = new ResultService();

$result = $resultService->getResultById((int)$_SESSION['resultId']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Parkinsans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../StyleSheets/gamerStyles.css">
    <title>Document</title>
</head>
<body>
    <div class="main-container">
            <div class="result" id="result">
                <div class="score">
                    <div class="note">
                        <p><strong>Score</strong>&nbsp;=&nbsp;<?php echo $result->getScore();?></p>
                    </div>
                    <div class="quiz-note">
                        <p>Quiz&nbsp;:&nbsp;<?php echo $result->getQuiz()->getTitle(); ?></p>
                    </div>
                </div>
                <div class="back">
                    <a href="./gamerQuiz.php" class="bttn">Retour aux quiz</a>
                </div>
            </div>
    </div>
</body>
</html>