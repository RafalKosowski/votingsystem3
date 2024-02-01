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
    <p> Witaj w systemie głosowania</p>


    <?php
        if(isset($_GET["submited"]))
            echo '<p class="info">Oddałeś głos</p>';

        if(isset($_GET["updated"]))
            echo '<p class="info">Głos został zaktualizowany</p>';

        if(isset($_GET["err"]))
            echo '<p class="loginError">Nie udało się oddać głosu</p>';





    ?>
</section>
<?php include_once "../elements/footer.php"; ?>
</body>
</html>

