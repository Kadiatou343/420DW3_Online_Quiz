<?php
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel - Admin</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Roboto', sans-serif;
        }

        body {
            min-height: 100vh;
        }

        .side-menu{
            position: fixed;
            background: #023459;
            width: 20vw;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .side-menu .brand-name {
            height: 10vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        h1 {
            color: #B2A59F;
        }

        li {
            list-style: none;
        }

        .side-menu li {
            font-size: 24px;
            padding: 10px 40px;
            color: white;
            display: flex;
            align-items: center;
        }

        .side-menu li:hover {
            background: white;
            color: #023459;
        }

        .side-menu ul li span{
            font-size: 0.9em;
        }

        .header-container {
            position: absolute;
            right: 0;
            width: 80vw;
            height: 100vh;
            background: #f1f1f1;
        }

        .header-container .header {
            position: fixed;
            top: 0;
            right: 0;
            width: 80vw;
            height: 10vh;
            background: white;
            display: flex;
            align-items: center;
            justify-content: space-around;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .header p {
            background: #023459;
            color: #B2A59F;
            padding: 5px 10px;
            text-align: center;
        }

        a{
            text-decoration: none;
            color: inherit;
        }
    </style>
</head>
<body>
    <div class="side-menu">
            <div class="brand-name">
                <h1><i>Online&nbsp;Quiz</i></h1>
            </div>
            <ul>
                <li><a href="#"><img src="../images/icons8-quizlet-50 (1).png" alt="">&nbsp; <span>Quiz</span></a></li>
                <li><a href="#"><img src="../images/icons8-user-50.png" alt="">&nbsp; <span>Utilisateurs</span></a></li>
                <li><a href="#"><img src="../images/icons8-test-results-50 (1).png" alt="">&nbsp; <span>Résultats</span></a></li>
            </ul>
    </div>
    <div class="header-container">
        <div class="header">
            <p class="welcome">La base des adminitrateurs</p>
            <p class="username">Bonjour&nbsp;</p>
        </div>
    </div>
</body>
</html>