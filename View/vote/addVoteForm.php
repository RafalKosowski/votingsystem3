
<?php
//error_reporting(0);
//ini_set('display_errors', 0);
require_once("../../Controller/VoteController.php");
require_once("../../Controller/UserController.php");
require_once("../../Model/User.php");
require_once("../../Database/Database.php");
require_once('../MenuView.php');
require_once("../../Controller/VoteTypeController.php");
require_once("../../Controller/MajorityController.php");
require_once("../../Controller/AnswerController.php");
require_once("../../Controller/QuorumController.php");
require_once("../../Model/User.php");
require_once("../../Database/Database.php");
use Controller\MajorityController;
use Controller\QuorumController;

use Controller\VoteTypeController;
use Model\Majority;
use Model\Quorum;
use Model\VoteType;

use Controller\VoteController;
use Controller\UserController;


require_once("../../Controller/UserController.php");

$userController = new UserController();

if(!$userController->checkUserAccess(2)){
    header("Location: ../error/nopermission.php");
}






// Assume $voteController is an instance of your VoteController
// Assume $_GET['id'] contains the vote ID from the URL parameter




$voteTypeController = new VoteTypeController();
$majorityController = new MajorityController();
$quorumController = new QuorumController();

$quorumList = $quorumController->getAll();
$voteTypeList = $voteTypeController->getAll();
$majorityList= $majorityController->getAll();




?>
<!doctype html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../style.css">
    <title>Document</title>
</head>
<body>
    <?php include "../elements/menu.php";?>

<section>
<form action="../../Controller/submit_vote.php" method="post">
    <label for="name">Name:</label><br>
    <input type="text" id="name" name="name" maxlength="64" required><br>
    <label for="startdate">Start Date:</label><br>
    <input type="datetime-local" id="startdate" name="startdate" required><br>
    <label for="enddate">End Date:</label><br>
    <input type="datetime-local" id="enddate" name="enddate" required><br>
    <label for="question">Question:</label><br>
    <input type="text" id="question" name="question" maxlength="256" required><br>

    <label for="vote_type_id">Vote Type ID:</label><br>
    <select id="vote_type_id" name="vote_type_id">
        <option>  </option>
        <?php
        foreach ($voteTypeList as $vl ){
            echo '<option value="'.$vl["id"].'">'.$vl["name"] .' </option>';
        }
        ?>
    </select><br>
    <!--Jeżeli zostanie wybrana opcja tak nie, to nie wtświetlamy opcji pól do wprowadznia pytania-->
<!--    <label for="answers">Answers ID:</label><br>-->

        <!--To będzie dostępne po wybraniu  własne opcje w vote type -->
        <!-- 2 pola typu text oraz przycisk który pozwala dodać kolejne pola (może być mak 5 pól ) Oraz ostatnie pole wstrzymuję się (wyłączone) -->


    <div id="answersSection" style="display:none;">
        <label for="answers">Answers:</label><br>
        <div id="answersContainer">
            <!-- Początkowe pola odpowiedzi -->
            <input type="text" id="answer1" name="answers[]" maxlength="64" placeholder="Answer 1"><br>
            <input type="text" id="answer2" name="answers[]" maxlength="64" placeholder="Answer 2"><br>
            <!-- Dodatkowe pola będą dodawane dynamicznie -->

        </div>
        <input type="text" id="abstain" name="abstain" value="Wstrzymuję się" readonly><br>

        <button type="button" id="addAnswer">Add Answer</button>
        <button type="button" id="removeAnswer">Remove Answer</button>

    </div>

    <div id="majoritySection" style="display:none;">
        <label for="majority_id">Majority ID:</label><br>
        <select id="majority_id" name="majority_id">
            <option>  </option>
            <?php
            foreach ($majorityList as $ml ){
                echo '<option value="'.$ml["id"].'">'.$ml["name"] .' </option>';
            }
            ?>
        </select><br>
    </div>

    <label for="quorum_id">Quorum ID:</label><br>
    <select id="quorum_id" name="quorum_id">
        <option>  </option>
        <?php
        foreach ($quorumList as $ql ){
            echo '<option value="'.$ql["id"].'">'.$ql["name"] .' </option>';
        }
        ?>
    </select><br>



    <input type="submit" value="Submit">
</form>
</section>
<script>
    var voteTypeSelect = document.getElementById('vote_type_id');
    var answersSection = document.getElementById('answersSection');
    var answersSelect = document.getElementById('answers');
    var majoritySection = document.getElementById('majoritySection');

    voteTypeSelect.addEventListener('change', function () {
        var selectedValue = this.value;

        // Jeżeli wybrano odpowiedni typ głosowania, pokaż sekcje
        if (selectedValue == 1) {
            answersSection.style.display = 'none';
            majoritySection.style.display = 'block';
        } else if(selectedValue == 2){
            answersSection.style.display = 'block';
            majoritySection.style.display = 'none';
        }else{
            answersSection.style.display = 'none';
            majoritySection.style.display = 'none';
        }
    });

    var answerCounter = 2; // Zaczynamy od dwóch pól odpowiedzi

    document.getElementById('addAnswer').addEventListener('click', function () {
        if (answerCounter < 5) { // Maksymalnie 5 pól odpowiedzi
            var newInput = document.createElement('input');
            newInput.type = 'text';
            newInput.name = 'answers[]';
            newInput.id = 'answer' + (answerCounter + 1);
            newInput.maxLength = 64;
            newInput.placeholder = 'Answer ' + (answerCounter + 1);
            answersContainer.appendChild(newInput);
            answersContainer.appendChild(document.createElement('br'));
            answerCounter++;
        }
    });

    document.getElementById('removeAnswer').addEventListener('click', function () {
        if (answerCounter > 2) { // Musi pozostać przynajmniej 2 pola
            var lastInput = document.getElementById('answer' + answerCounter);
            answersContainer.removeChild(lastInput);
            answersContainer.removeChild(answersContainer.lastElementChild); // Usuń ostatni <br>
            answerCounter--;
        }
    });
</script>
<footer>
    // tu bedzie stopka
</footer>
</body>
</html>