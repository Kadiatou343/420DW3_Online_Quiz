<?php
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../StyleSheets/homeAdminStyle.css">
    <title>Panel - Gamer</title>
    <style>

        .side-menu ul li span{
            font-size: 0.8em;
        }

    </style>
</head>
<body>
    <div class="side-menu">
            <div class="brand-name">
                <h1><i>Quizzy&nbsp;Dev</i></h1>
            </div>
            <ul>
                <li><a href="./gamerQuiz.php" target="contentFrame"><img src="../images/icons8-quizlet-50 (1).png" alt="">&nbsp; <span>Quiz</span></a></li>
                <li><a href="./changePassword.php" target="contentFrame"><img src="../images/icons8-user-50.png" alt="">&nbsp; <span>Mon&nbsp;compte</span></a></li>
                <li><a href="./gamerResults.php" target="contentFrame"><img src="../images/icons8-test-results-50 (1).png" alt="">&nbsp; <span>Résultats</span></a></li>
            </ul>
    </div>
    <div class="container">
        <div class="header">
            <img src="../images/quizzy_dev_logo.png" alt="logo" width="70" height="60">
            <p class="username">Bonjour&nbsp;</p>
        </div>
        <div class="card">

        </div>
        <div class="iframe-container">
            <iframe name="contentFrame" src="./gamerQuiz.php"></iframe>
        </div>
    </div>
</body>
</html>