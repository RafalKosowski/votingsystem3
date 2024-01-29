<?php
    use Controller\UserController;
    require_once("../../Controller/UserController.php");
    require_once("VoteView.php");

    $userController = new UserController();
    $voteView = new VoteView();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List of Votes</title>
</head>
<body>
<style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        button {
            display: block;
            margin: 20px auto;
            text-align: center;
        }

        a {
            text-decoration: none;
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border-radius: 4px;
        }

        a:hover {
            background-color: #45a049;
        }
    </style>
<button>
    <a href="addVoteForm.php"> Dodaj Głosowanie </a>
</button>
<?php
if($userController->checkUserAccess(2)){
    $voteView->buildVoteListForSecretary();
}elseif ($userController->checkUserAccess(3)){
    $voteView->buildVoteListForUser();
}
?>

</body>
</html>
