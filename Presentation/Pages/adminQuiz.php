<?php
require_once "../../psr4_autoloader.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
                        <tbody>
                            <tr>
                                <th scope="row">1</th>
                                <td>John Doe</td>
                                <td>John Doe</td>
                                <td>John Doe</td>
                                <td>
                                    <a href="#"><i class="bi bi-trash"></i></a>&nbsp;
                                    <a href="#"><i class="bi bi-pencil"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">1</th>
                                <td>John Doe</td>
                                <td>John Doe</td>
                                <td>John Doe</td>
                                <td>
                                    <a href="#"><i class="bi bi-trash"></i></a>&nbsp;
                                    <a href="#"><i class="bi bi-pencil"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">1</th>
                                <td>John Doe</td>
                                <td>John Doe</td>
                                <td>John Doe</td>
                                <td>
                                    <a href="#"><i class="bi bi-trash"></i></a>&nbsp;
                                    <a href="#"><i class="bi bi-pencil"></i></a>
                                </td>
                            </tr>
                            <tr>
                                <th scope="row">1</th>
                                <td>John Doe</td>
                                <td>John Doe</td>
                                <td>John Doe</td>
                                <td>
                                    <a href="#"><i class="bi bi-trash"></i></a>&nbsp;
                                    <a href="#"><i class="bi bi-pencil"></i></a>
                                </td>
                            </tr>
                        </tbody>
                    </thead>
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
                    <tr>
                        <th scope="row">1</th>
                        <td>Jhon Doe</td>
                        <td>Jhon Doe</td>
                        <td>Jhon Doe</td>
                        <td>Jhon Doe</td>
                        <td>Jhon Doe</td>
                        <td>Jhon Doe</td>
                        <td>
                            <a href="#"><i class="bi bi-trash"></i></a>&nbsp;
                            <a href="#"><i class="bi bi-pencil"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">1</th>
                        <td>Jhon Doe</td>
                        <td>Jhon Doe</td>
                        <td>Jhon Doe</td>
                        <td>Jhon Doe</td>
                        <td>Jhon Doe</td>
                        <td>Jhon Doe</td>
                        <td>
                            <a href="#"><i class="bi bi-trash"></i></a>&nbsp;
                            <a href="#"><i class="bi bi-pencil"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">1</th>
                        <td>Jhon Doe</td>
                        <td>Jhon Doe</td>
                        <td>Jhon Doe</td>
                        <td>Jhon Doe</td>
                        <td>Jhon Doe</td>
                        <td>Jhon Doe</td>
                        <td>
                            <a href="#"><i class="bi bi-trash"></i></a>&nbsp;
                            <a href="#"><i class="bi bi-pencil"></i></a>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">1</th>
                        <td>Jhon Doe</td>
                        <td>Jhon Doe</td>
                        <td>Jhon Doe</td>
                        <td>Jhon Doe</td>
                        <td>Jhon Doe</td>
                        <td>Jhon Doe</td>
                        <td>
                            <a href="#"><i class="bi bi-trash"></i></a>&nbsp;
                            <a href="#"><i class="bi bi-pencil"></i></a>
                        </td>
                    </tr>
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