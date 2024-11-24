<?php

require_once "../../psr4_autoloader.php";

use ProjectUtilities\CookieManager;
use ProjectUtilities\SessionManager;

if (isset($_GET["action"]) && $_GET["action"] == "logout") {
    SessionManager::killUserSession();
    CookieManager::killUserCookie();
    header("Location: index.php");
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
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Parkinsans&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../StyleSheets/homeAdminStyle.css">
    <title>Panel - Gamer</title>
    <style>

        .side-menu ul li span{
            font-size: 0.7em;
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
            <p class="username">Bonjour&nbsp;<?php echo (SessionManager::doesUserSessionExit()) ? $_SESSION["user"] : '';?></p>
            <a class="btn btn-danger" href="?action=logout" style="background: #1E646E; border: #1E646E;"><i class="bi bi-box-arrow-right"></i></a>
        </div>
        <div class="card">

        </div>
        <div class="iframe-container">
            <iframe name="contentFrame" src="./gamerQuiz.php"></iframe>
        </div>
    </div>
</body>
</html>