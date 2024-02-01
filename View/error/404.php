
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>404</title>
    <link rel="stylesheet" href="../style.css"/>
</head>
<body>
<?php

    include "../elements/menu.php";
    echo "<div class='error'>Nie znaleziono zasobu</div>";

    include "../elements/footer.php";
    error_reporting(0);
    ini_set('display_errors', 0);
?>
</body>
</html>

