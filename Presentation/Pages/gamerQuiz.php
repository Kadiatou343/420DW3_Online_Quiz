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
 * Le service de l'utilisateur utilisé pour les divers opérations sur l'utilisateur
 */
$userService = new UserService();

/**
 * Le service du résultat utilisé pour les divers opérations sur les résultats
 */
$resultService = new ResultService();


/**
 * Verification de la reception de la requête d'ajax
 */
if (isset($_GET['answer'], $_GET['quesId'])) {
    $quesId = (int) $_GET['quesId'];
    $answer = (string) $_GET['answer'];
    if (!isset($_SESSION['score'])) {
        $_SESSION['score'] = 0;
    }
    /**
     * Pour enlever le prefix de reponse ex : A. ou B.
     */
    $answer = substr($answer, 3);

    $questionToCheck = $questionService->getQuestionById($quesId);

    /**
     * Attribution du score
     */
    if ($questionToCheck->getCorrectAnswer() === $answer) {
        $_SESSION['score'] = (int)($_SESSION['score']) + 1;
    }
    exit();
}

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
 * Le jeu de quiz commence si l'action play est bien choisie
 */
if (isset($_GET['action']) && $_GET['action'] == "play") {
    /**
     * L'id du quiz choisi
     */
    $quizId = (int) $_GET['quizId'];

    /**
     * Le quiz lui-même
     */
    $quiz = $quizService->getQuizById($quizId);

    /**
     * Les questions du quiz
     */
    $listQuestions = $questionService->filterQuestionsByQuizId($quiz->getId());

    /**
     * Un array qui contient les question pour une bonne gestion visuelle du code
     */
    $questions = $listQuestions->getListQuestions();

    /**
     * Le nombre de questions pour le quiz
     */
    $totalQuestions = count($listQuestions->getListQuestions());
}
/**
 * Le compteur pour un acces global
 */
$counterGlobal = 0;

/**
 * Passer à la prochaine question
 */
if (isset($_GET['action']) && $_GET['action'] == "next") {
    $counter = (int) $_GET['counter'];
    $counterGlobal = $counter + 1;
}

if (isset($_GET['action']) && $_GET['action'] == "end") {
    $userId = (int) $_SESSION['userId'] ?? null;
    $quesId = (int) $_GET['quesId'];

    if ($userId !== null) {
        try {
            throw new Exception("Session Introuvable Erreur du système");
        }catch (Exception $e){
            echo $e->getMessage();
        }
    }

    $user = $userService->getUserById($userId);
    $quizRes = $questionService->getQuestionById($quesId)->getQuiz();
    $score = (int) $_SESSION['score'];

    $result = new Result($score, $quizRes, $user);

    /**
     * Enregistrement du nouveau résultat pour l'utilisateur
     */
    $resultService->createResult($result);

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
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($listQuizzes->getListQuizzes())){
                        foreach ($listQuizzes->getListQuizzes() as $quiz) { ?>
                    <tr>
                        <td><?php echo $quiz->getTitle(); ?></td>
                        <td><?php echo $quiz->getDescription(); ?></td>
                        <td>
                            <a href="?action=play&quizId=<?php echo $quiz->getId(); ?>" id="play" class="play"><i class="bi bi-play-fill"></i></a>
                        </td>
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
        <div class="game" id="game">
            <div class="quiz">
                <div class="title">
                    <p>
                        <?php echo isset($quiz) ? $quiz->getTitle() : ''; ?>
                    </p>
                </div>
                <?php if (isset($questions)) {
                    $counter = $counterGlobal;
                    $answers = array($questions[$counter]->getCorrectAnswer(), $questions[$counter]->getWrongAnswer1(),
                        $questions[$counter]->getWrongAnswer2(), $questions[$counter]->getWrongAnswer3());
                    shuffle($answers);
                    ?>
                <div class="question-text">
                    <p>
                        <?php echo $questions[$counter]->getQuestionText(); ?>
                    </p>
                </div>
                <div class="answer">
                    <a href="questionId=<?php echo $questions[$counter]->getId(); ?>" class="ans">A.&nbsp;<?php echo $answers[0]; ?></a>
                </div>
                <div class="answer">
                    <a href="questionId=<?php echo $questions[$counter]->getId(); ?>" class="ans">B.&nbsp;<?php echo $answers[1]; ?></a>
                </div>
                <div class="answer">
                    <a href="questionId=<?php echo $questions[$counter]->getId(); ?>" class="ans">C.&nbsp;<?php echo $answers[2]; ?></a>
                </div>
                <div class="answer">
                    <a href="questionId=<?php echo $questions[$counter]->getId(); ?>" class="ans">D.&nbsp;<?php echo $answers[3]; ?></a>
                </div>
                <div class="exit">
                    <a href="" id="cancelQuiz">Quitter</a>
                </div>
                <div class="next">
                    <?php if (isset($totalQuestions)){ if ($counter < $totalQuestions - 1){ ?>
                    <a href="?action=next&count=<?php echo $counter; ?>">Suivant</a>
                    <?php } elseif ($counter === $totalQuestions - 1) {?>
                    <a href="?action=end&quesId=<?php echo $questions[$counter]->getId(); ?>" id="endQuiz">Terminer</a>
                    <?php } }?>
                    <p id="quesId" style="visibility:hidden;" class="quesId"><?php echo $questions[$counter]->getId(); ?></p>
                </div>
                <?php } ?>
            </div>
        </div>
        <div class="result" id="result">
            <div class="score">
                <?php if (isset($result)) { ?>
                <div class="note">
                    <p><strong>Score</strong>&nbsp;=&nbsp;<?php echo $result->getScore();?></p>
                </div>
                <div class="quiz-note">
                    <p>Quiz&nbsp;:&nbsp;<?php echo $result->getQuiz()->getTitle(); ?></p>
                </div>
                <?php } ?>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="./test.js">

    </script>
</body>
</html>
