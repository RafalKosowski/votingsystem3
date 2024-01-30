<?php
// Kod PHP
class MenuView
{


    public function getMenu($userLevel, $ce)
    {
        $data = [];

        switch ($userLevel) {
            case 1:
                $data[] = ['name' => 'Użytkownicy', 'link' => '/View/admin/admin.php'];
            case 2:
                $data[] = ['name' => 'Dodaj głosowanie', 'link' => '/View/vote/addVoteForm.php'];
                $data[] = ['name' => 'Raporty', 'link' => '/View/vote/votesReport.php'];
            case 3:
                $data[] = ['name' => 'Lista głosowań', 'link' => '/View/vote/voteList.php'];
                break;
            default:
                echo "Ups. We have a problem";
        }

        echo $this->buildMenu($data, $ce);
    }

    private function buildMenu($data, $ceId)
    {
        $menu = '<nav class="navbar navbar-expand-lg navbar-light bg-light">';
        $menu .= '<a class="navbar-brand" href="#">System głosowania 3</a>';
        $menu .= '<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">';
        $menu .= '<span class="navbar-toggler-icon"></span>';
        $menu .= '</button>';
        $menu .= '<div class="collapse navbar-collapse" id="navbarNav">';
        $menu .= '<ul class="navbar-nav">';

        foreach ($data as $index => $d) {
            $isCurrent = $index == $ceId;
            $menu .= $this->buildElementMenu($d['name'], $d['link'], $isCurrent);
        }


        $menu .= $this->buildElementMenu("Wyloguj", '/View/loginForm.php?logout=1', false);


        $menu .= '</ul>';
        $menu .= '</div>';
        $menu .= '</nav>';

        return $menu;
    }

    private function buildElementMenu($name, $link, $isCurrent)
    {
        $class = $isCurrent ? 'nav-item active' : 'nav-item';
        $btnClass = $name == 'Wyloguj' ? 'logout-btn' : '';
        return '<li class="' . $class . '"><a class="nav-link ' . $btnClass . '" href="' . $link . '">' . $name . '</a></li>';
    }

}
?>
