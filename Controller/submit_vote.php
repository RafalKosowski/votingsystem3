<?php

use Controller\AnswerController;
use Controller\VoteController;

require_once("../Controller/VoteController.php");
require_once("../Controller/AnswerController.php");
require_once("../Database/Database.php");
// submit_vote.php

// ... (inne fragmenty kodu) ...

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = [
        'name' => $_POST['name'],
        'startdate' => $_POST['startdate'],
        'enddate' => $_POST['enddate'],
        'question' => $_POST['question'],
        'quorum_id' => $_POST['quorum_id'],
        'vote_type_id' => $_POST['vote_type_id'],
        'majority_id' => $_POST['majority_id'],
    ];

    // Obsługa odpowiedzi
    if ($_POST['vote_type_id'] == 1) {
        // Jeśli to są opcje tak/nie, użyj stałego id=1
        $data['answers_id'] = 1;
    } else {
        // Jeśli to są własne opcje, dodaj nowe odpowiedzi do bazy danych

        // Przykładowa implementacja
        $answerController = new AnswerController();
        $answers = $_POST['answers'];
        $abstain = $_POST['abstain'];


        //  try {
        // Dodaj nowe odpowiedzi do bazy danych
        $newAnswerId = $answerController->create([
            'option1' => isset($answers[0]) ? $answers[0] : null,
            'option2' => isset($answers[1]) ? $answers[1] : null,
            'option3' => isset($answers[2]) ? $answers[2] : null,
            'option4' => isset($answers[3]) ? $answers[3] : null,
            'option5' => isset($answers[4]) ? $answers[4] : null,
            'option6' => isset($abstain) ? $abstain : 'Wstrzymuję się',
        ]);

        // Ustaw odpowiednie id w $data['answers_id']
        $data['answers_id'] = $newAnswerId;
        //   } catch (\PDOException $e) {
        // Obsługa błędów dodawania odpowiedzi do bazy danych
        // Logowanie, wyświetlanie komunikatów, itp.
        //      echo "An error occurred while adding answers to the database. Please try again later.";
        //    exit; // Zakończ przetwarzanie skryptu w przypadku błędu.
        //  }
    }

    $voteController = new VoteController();

    try {
        // Tworzenie głosowania
        $voteController->create($data);
        echo '<script> alert("Vote created successfully!");</script>';
        header('Location: /');

    } catch (PDOException $e) {
        // Obsługa błędów tworzenia głosowania
        echo "An error occurred ";
    }
}