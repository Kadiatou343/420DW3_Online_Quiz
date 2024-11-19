<?php

use Business\Domain\Question;
use Business\Domain\Quiz;
use Business\Services\QuestionService;
use Business\Services\QuizService;
use ProjectUtilities\ArgumentOutOfRangeException;
use ProjectUtilities\FileManager;

require_once "../../psr4_autoloader.php";

/**
 * Le service de Quiz utilisé pour effectuer les divers opérations sur les quiz
 */
$quizService = new QuizService();
/**
 * Le service de Question utilisé pour effectuer les divers opérations sur les questions
 */
$questionService = new QuestionService();
/**
 * La liste qui va contenir tous les enregistrements de Quiz pour l'affichage
 */
$listQuizzes = $quizService->getAllQuizzes();

/**
 * L'envoi du formulaire par post
 */
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //Verification pour determiner si c'est le bouton pour ajouter un quiz
    if (isset($_POST["quiz"])) {
        $title = htmlspecialchars($_POST["title"]);
        $description = htmlspecialchars($_POST["description"]);

        try {
            $quiz = new Quiz('', '');
            $quiz->setTitle($title);
            $quiz->setDescription($description);
        } catch (ArgumentOutOfRangeException $e) {
            $error = $e->getMessage();
        }
    }

    //Verification si c'est le bouton pour ajouter une question a un quiz
    if (isset($_POST["question"])) {
        try {
            $questionText = htmlspecialchars($_POST["questionText"]);
            $correctAnswer = htmlspecialchars($_POST["correctAns"]);
            $wrongAnswer1 = htmlspecialchars($_POST["wrongAns1"]);
            $wrongAnswer2 = htmlspecialchars($_POST["wrongAns2"]);
            $wrongAnswer3 = htmlspecialchars($_POST["wrongAns3"]);
            $quizId = (int)$_POST["quizId"] ?? null;
            $tempPath = $_FILES["imageUrl"]["tmp_name"];
            $fileName = basename($_FILES["imageUrl"]["name"]);
            $fileSize = (int)filesize($_FILES["imageUrl"]["size"]);

            /**
             * Validation du fichier en tant qu'image permise
             */
            if (!FileManager::IsFileTypeAllowed($tempPath)) {
                throw new InvalidArgumentException("Le type de fichier n'est pas autorisé !");
            }

            /**
             * Validation de la taille de l'image
             */
            if (!FileManager::verifyImageSize($fileSize)) {
                throw new ArgumentOutOfRangeException("L'image depasse la taille mmaximale!");
            }

            /**
             * Verification de la nullabilite de l'id du quiz
             */
            if ($quizId === null) {
                throw new InvalidArgumentException("Le quiz auquel la question doit appartenir n'arrive pas à être resolu!");
            }

            /**
             * Obtention du quiz auquel la question doit être lier par son id
             */
            $quiz = $questionService->getQuestionDAO()->getQuizDAO()->getById($quizId)
                ?? throw new InvalidArgumentException("Le quiz auquel est lié cette question n'existe pas !");

            /**
             * Creation de l'objet Question qui va contenir toutes les informations
             */
            $question = new Question('', '', '',
                '', '', $quiz);

            $question->setQuestionText($questionText);
            $question->setCorrectAnswer($correctAnswer);
            $question->setWrongAnswer1($wrongAnswer1);
            $question->setWrongAnswer2($wrongAnswer2);
            $question->setWrongAnswer3($wrongAnswer3);
            $question->setImageUrl(FileManager::TARGET_DIR . $fileName);

            /**
             * Ajout dans la base de données
             */
            $newQuestion = $questionService->createQuestion($question);

            /**
             * Ajout de l'image en local si elle n'existe pas déjà
             */
            if (!FileManager::VerifyIfFileExists($fileName)) {
                FileManager::moveFileToLocal($tempPath, $fileName);
            } else {
                $warningFile = "L'image existe deja !";
            }

        } catch (InvalidArgumentException|ArgumentOutOfRangeException $e) {
            $error = $e->getMessage();
        }
    }

}

/**
 * Verifier si une action a été choisie pour un quiz
 */
if (isset($_GET['action'])) {
    /**
     * Cas ou l'action look est choisie
     */
    if ($_GET['action'] == 'look' && isset($_GET['quizId'])) {
        $quizId = (int)$_GET['quizId'];
        $listQuestions = $questionService->filterQuestionsByQuizId($quizId);
    }

    /**
     * Cas ou l'action edit est choisie
     */
    if ($_GET['action'] == 'edit' && isset($_GET['quizId'])) {
        $quizId = (int)$_GET['quizId'];
        $quizToUpdate = $questionService->getQuestionDAO()->getById($quizId);
    }
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
    <link rel="stylesheet" href="../StyleSheets/adminStyles.css">
    <title>Panel - Quiz</title>
</head>
<body>
<div class="main-container">
    <div class="list-quiz">
        <div class="filter">
            <input type="text" name="filter" id="filter" placeholder="Recherche de quiz">
            <button name="search" class="bttn">Recherche</button>
        </div>
        <div class="table-content">
            <div class="table-title">
                <h3>Liste des quiz</h3>
                <a href="#" class="bttn">Ajouter Quiz</a>
            </div>
            <table class="table table-stripped">
                <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Titre</th>
                    <th scope="col">Description</th>
                    <th scope="col">Date&nbsp;création</th>
                    <th scope="col">Action</th>
                </tr>
                </thead>
                <tbody>
                <?php if (!empty($listQuizzes->getListQuizzes())) {
                    foreach ($listQuizzes->getListQuizzes() as $quiz): ?>
                        <tr>
                            <th scope="row"> <?php echo $quiz->getId(); ?> </th>
                            <td> <?php echo $quiz->getTitle(); ?> </td>
                            <td> <?php echo $quiz->getDescription(); ?> </td>
                            <td> <?php echo $quiz->getDateCreated()->format('Y-m-d'); ?> </td>
                            <td>
                                <a href="?action=remove&quizId=<?php echo $quiz->getId(); ?>"><i
                                            class="bi bi-trash"></i></a>&nbsp;
                                <a href="?action=edit&quizId=<?php echo $quiz->getId(); ?>"><i class="bi bi-pencil"></i></a>
                                <a href="?action=look&quizId=<?php echo $quiz->getId(); ?>"><i
                                            class="bi bi-eye"></i></a>
                            </td>
                        </tr>
                    <?php endforeach;
                } else { ?>
                    <tr>
                        <th scope="row">No data</th>
                        <td>No data</td>
                        <td>No data</td>
                        <td>No data</td>
                        <td>
                            <a href="#"><i class="bi bi-trash"></i></a>&nbsp;
                            <a href="#"><i class="bi bi-pencil"></i></a>
                            <a href="#"><i class="bi bi-eye"></i></a>
                        </td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="table-content">
        <div class="table-title">
            <h3>Questions du quiz N°</h3>
            <h3>Titre du quiz</h3>
        </div>
        <table class="table table-stripped">
            <thead>
            <tr>
                <th scope="col">Id</th>
                <th scope="col">Question</th>
                <th scope="col">Bonne rep.</th>
                <th scope="col">Mauvaise rep.</th>
                <th scope="col">Mauvaise rep.</th>
                <th scope="col">Mauvaise rep.</th>
                <th scope="col">Image</th>
                <th scope="col">Action</th>
            </tr>
            </thead>
            <tbody>
            <?php if (isset($listQuestions)) {
                foreach ($listQuestions->getListQuestions() as $question): ?>
                    <tr>
                        <th scope="row"> <?php echo $question->getId(); ?> </th>
                        <td> <?php echo $question->getQuestionText(); ?> </td>
                        <td> <?php echo $question->getCorrectAnswer(); ?> </td>
                        <td> <?php echo $question->getWrongAnswer1(); ?> </td>
                        <td> <?php echo $question->getWrongAnswer2(); ?> </td>
                        <td> <?php echo $question->getWrongAnswer3(); ?> </td>
                        <td><img src="<?php echo $question->getImageUrl(); ?>" alt="err" width="50" height="50"></td>
                        <td>
                            <a href="?action=qRemove&quesId=<?php echo $question->getId(); ?>"><i
                                        class="bi bi-trash"></i></a>&nbsp;
                            <a href="?action=qEdit&quesId=<?php echo $question->getId(); ?>"><i
                                        class="bi bi-pencil"></i></a>
                        </td>
                    </tr>
                <?php endforeach;
            } ?>
            </tbody>
        </table>
    </div>
    <div class="add-quiz">
        <div class="quiz">
            <form action="#" method="post">
                <div class="form-gr">
                    <div class="input-gr">
                        <label for="quizId">Id</label>
                        <input type="text" name="id" id="quizId" readonly>
                    </div>

                    <div class="input-gr">
                        <label for="title">Titre</label>
                        <input type="text" name="title" id="title" required>
                    </div>

                    <div class="input-gr">
                        <label for="description">Description</label>
                        <input type="text" name="description" id="description" required>
                    </div>

                    <div class="input-gr">
                        <label for="date">Date&nbsp;création</label>
                        <input type="text" name="date" id="date" readonly>
                    </div>

                    <button type="submit" name="quiz" class="bttn">Créer</button>
                </div>
            </form>
        </div>
        <div class="question">
            <form action="#" method="post">
                <div>
                    <div class="input-gr">
                        <label for="questionId">Id</label>
                        <input type="text" name="questionId" id="questionId" readonly>
                    </div>

                    <div class="input-gr">
                        <label for="questionText">Question?</label>
                        <input type="text" name="questionText" id="questionText" required>
                    </div>

                    <div class="input-gr">
                        <label for="correctAnsw">Bonne&nbsp;rep.</label>
                        <input type="text" name="correctAnsw" id="correctAnsw" required>
                    </div>

                    <div class="input-gr">
                        <label for="wrongAnsw1">Bonne&nbsp;rep.</label>
                        <input type="text" name="wrongAnsw1" id="wrongAnsw1" required>
                    </div>

                    <div class="input-gr">
                        <label for="wrongAnsw2">Bonne&nbsp;rep.</label>
                        <input type="text" name="wrongAnsw2" id="wrongAnsw2" required>
                    </div>

                    <div class="input-gr">
                        <label for="wrongAnsw3">Bonne&nbsp;rep.</label>
                        <input type="text" name="wrongAnsw3" id="wrongAnsw3" required>
                    </div>

                    <div class="input-gr">
                        <label for="imageUrl">Televerser image</label>
                        <input type="file" name="imageUrl" id="imageUrl" required>
                    </div>

                    <button type="submit" name="question" class="bttn">Ajouter au quiz</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>