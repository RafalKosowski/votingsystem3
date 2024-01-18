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
<button>
    <a href="addVoteForm.php"> Dodaj Głosowanie </a>
</button>
<?php
if($userController->checkUserAccess(2)){
    $voteView->buildVoteListForSecretary();
}elseif ($userController->checkUserAccess(3)){
    $voteView->buildVoteListforUser();
}
?>

</body>
</html>
