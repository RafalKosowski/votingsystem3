<?php

class MenuView
{


    public function getMenu($userLevel,$ce)
    {

        $data = [];



        switch ($userLevel) {

            case 1:
                $data[] = ['name' => 'Użytkownicy', 'link' => '/votingsystem3/View/admin/admin.php'];
            case 2:
                $data[] = ['name' => 'Dodaj głosowanie', 'link' => '/votingsystem3/View/vote/addVoteForm.php'];
                $data[] = ['name' => 'Raporty', 'link' => '/votingsystem3/View/vote/votesReport.php'];
            case 3:
                $data[] = ['name' => 'Lista głosowań', 'link' => '/votingsystem3/View/vote/voteList.php'];



                break;

            default:
                echo "Ups. We have a problem";
//                header('Location: /votingsystem3/View/loginForm.php');

        }

        echo $this->buildMenu($data,$ce);
        echo '<div class="logout">'.$this->buildElementMenu("Wyloguj",'/votingsystem3/View/loginForm.php?logout=1', false).'</div>';


    }

    private function buildMenu($data,$ceId)
    {
        $menu = '<ul>';

        foreach ( $data as $index => $d) {
            $c = $index==$ceId;
            $menu.=$this->buildElementMenu($d['name'],$d['link'],$c);
        }
        $menu.='</ul>';


        return $menu;
    }

    private function buildElementMenu($name, $link, $isCurrent){
        $cl= $isCurrent ? 'class="current"' :'';
        return '<li '.$cl.' ><a href="'.$link.'">'.$name.'</a></li>';
    }
}