<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
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
                    <a href="?action=resp&answer=<?php echo $answers[0]?>&questionId=<?php echo $questions[$counter]->getId(); ?>">A.&nbsp;<?php echo $answers[0]; ?></a>
                </div>
                <div class="answer">
                    <a href="?action=resp&answer=<?php echo $answers[1]?>&questionId=<?php echo $questions[$counter]->getId(); ?>">B.&nbsp;<?php echo $answers[1]; ?></a>
                </div>
                <div class="answer">
                    <a href="?action=resp&answer=<?php echo $answers[2]?>&questionId=<?php echo $questions[$counter]->getId(); ?>">C.&nbsp;<?php echo $answers[2]; ?></a>
                </div>
                <div class="answer">
                    <a href="?action=resp&answer=<?php echo $answers[3]?>&questionId=<?php echo $questions[$counter]->getId(); ?>">D.&nbsp;<?php echo $answers[3]; ?></a>
                </div>
                <div class="exit">
                    <a href="?cancel=exit" id="cancelQuiz">Quitter</a>
                </div>
                <div class="next">
                    <?php if (isset($totalQuestions)){ if ($counter < $totalQuestions - 1){ ?>
                    <a href="?action=next&count=<?php echo $counter; ?>">Suivant</a>
                    <?php } elseif ($counter === $totalQuestions - 1) {?>
                    <a href="?action=end&quesId=<?php echo $questions[$counter]->getId(); ?>" id="endQuiz">Terminer</a>
                    <?php } }?>
                </div>
                <?php } ?>
            </div>
        </div>

        
        <div class="result" id="result">
            <div class="score">
                <div class="note">
                    <p><strong>Score</strong>&nbsp;=&nbsp;<?php echo $result->getScore();?></p>
                </div>
                <div class="quiz-note">
                    <p>Quiz&nbsp;:&nbsp;<?php echo $result->getQuiz()->getTitle(); ?></p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>