<?php

use Business\Domain\Result;
use Business\Services\QuestionService;
use Business\Services\QuizService;
use Business\Services\ResultService;
use Business\Services\UserService;

require_once "../../psr4_autoloader.php";
session_start();

/**
 * Le service utilisé pour les divers opérations sur les quiz
 */
$quizService = new QuizService();

/**
 * Le service utilisé pour les divers opérations sur les questions
 */
$questionService = new QuestionService();

/**
 * Le service utilisé pour les divers opérations sur les utilisateurs
 */
$userService = new UserService();

/**
 * Le service utilisé pour les divers opérations sur les résultats
 */
$resultService = new ResultService();

/**
 * Réponse à la requête ajax
 */
if (isset($_GET['answer'], $_GET['quesId'])) {
    $answer = trim(htmlspecialchars($_GET['answer']));
    $quesId = (int)$_GET['quesId'];
    if (!isset($_SESSION['score'])) {
        $_SESSION['score'] = 0;
    }
    $score = (int)$_SESSION['score'];

    $questionToCheck = $questionService->getQuestionById($quesId);

    if ($questionToCheck->getCorrectAnswer() == htmlspecialchars_decode($answer)) {
        $score++;
        $_SESSION['score'] = $score;
        echo $score;
    } else {
        echo $score;
    }
}

/**
 * Recupère l'id du quiz choisi dans la page de quiz
 */
$quizId = (int)$_SESSION['quizId'];

/**
 * Le quiz à jouer
 */
$quizChosen = $quizService->getQuizById($quizId);

/**
 * La liste des questions associés au quiz
 */
$listQuestions = $questionService->filterQuestionsByQuizId($quizChosen->getId());

/**
 * L'array lui-même qui contient les questions pour une bonne gestion visuelle du code
 */
$questions = $listQuestions->getListQuestions();

/**
 * Le nombre total de questions à passer
 */
$totalQuestions = count($questions);

/**
 * Le compte des questions à passer
 */
$counter = 0;

/**
 * Changement de la question
 */
if (isset($_GET["action"]) && $_GET["action"] === "next") {
    //Le compteur va s'incrémenter
    $counter = (int)$_GET["counter"] + 1;
}

/**
 * Fin du quiz
 * Production du résultat final
 */
if (isset($_GET["action"]) && $_GET["action"] === "end") {

    $scoreFinal = (int)$_SESSION['score'];

    $currentUser = $userService->getUserById((int)$_SESSION['userId']);

    $result = $resultService->createResult(new Result($scoreFinal, $quizChosen, $currentUser));

    $_SESSION['resultId'] = $result->getId();

    unset($_SESSION['score']);

    header("Location: score.php");
    exit();
}

/**
 * Mettre fin au quiz en processus
 */
if (isset($_GET["action"]) && $_GET["action"] === "cancel") {

    header("Location: gamerQuiz.php");
    exit();
}

$question = $questions[$counter];
$answers = array($question->getCorrectAnswer(), $question->getWrongAnswer1(),
    $question->getWrongAnswer2(), $question->getWrongAnswer3());
shuffle($answers);

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
    <div class="game" id="game">
        <div class="quiz">
            <div class="quiz-title">
                <p>
                    <?php echo $quizChosen->getTitle(); ?>
                </p>
            </div>
            <div class="question-text">
                <p>
                    <?php echo $question->getQuestionText() ?>
                </p>
            </div>
            <div class="answers1">
                <strong>A.</strong>&nbsp;
                <a href="" class="ans" id="ans1">
                    <?php echo $answers[0]; ?>
                </a>
            </div>
            <div class="answers2">
                <strong>B.</strong>&nbsp;
                <a href="" class="ans" id="ans2">
                    <?php echo $answers[1]; ?>
                </a>
            </div>
            <div class="answers3">
                <strong>C.</strong>&nbsp;
                <a href="" class="ans" id="ans3">
                    <?php echo $answers[2]; ?>
                </a>
            </div>
            <div class="answers4">
                <strong>D.</strong>&nbsp;
                <a href="" class="ans" id="ans4">
                    <?php echo $answers[3]; ?>
                </a>
            </div>
            <div class="exit">
                <a href="?action=cancel" class="bttn" id="cancelQuiz">
                    Quitter
                </a>
            </div>
            <div class="next">
                <?php if ($counter < $totalQuestions - 1) { ?>
                    <a href="?action=next&counter=<?php echo $counter; ?>" class="bttn" id="next">
                        Suivant
                    </a>
                <?php } elseif ($counter === $totalQuestions - 1) { ?>
                    <a href="?action=end" class="bttn" id="end">
                        Terminer
                    </a>
                <?php } ?>
            </div>
        </div>
        <p id="quesId" style="visibility: hidden;"><?php echo $question->getId(); ?></p>
    </div>
</div>

<script>
    const answers = document.querySelectorAll(".ans");

    const quesId = Number(document.getElementById("quesId").textContent);

    /* Envoi de la reponse a la question par requete ajax */
    answers.forEach(answer => {
        answer.addEventListener('click', function (event) {
            event.preventDefault();
            console.log("Le clic a ete detecte");
            let value = answer.textContent;
            answer.style.textDecoration = "underline";
            console.log(value);
            let xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4) {
                    if (xhr.status === 200) {
                        let reponse = xhr.responseText;
                        console.log(reponse)
                    } else {
                        console.log("Erreur : " + xhr.status + " " + xhr.statusText);
                    }
                }
            }
            xhr.open("GET", "jeuQuiz.php?answer=" + encodeURIComponent(value) + "&quesId=" + encodeURIComponent(quesId), true);
            xhr.send();
        });
    });

</script>
</body>
</html>
