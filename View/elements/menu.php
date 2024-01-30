<?php
error_reporting(0);
ini_set('display_errors', 0);
?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">System głosowania</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <?php
                require_once("../../Controller/UserController.php");
                require_once("../../Model/User.php");
                require_once("../../Database/Database.php");
                require_once('../MenuView.php');

                use Controller\UserController;



                $uc = new UserController();
                $user = $uc->getLoggedUser();
                $menu = new MenuView();
                $menu->getMenu($user->permission_id, 1);
                ?>

            </ul>
        </div>
    </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

