<?php
//Par Félix-Antoine Lavoie

namespace App;

class FilAriane
{
    private static $instance = null;
    private $arrPages = array('accueil');

    public function __construct()
    {
    }

    public function getFil($newPage, $special = 'vide') {
        if($newPage != 'accueil'){
            $this->arrPages = App::getInstance()->getSession()->getItem('filArianne');
        }
        else {
            $this->arrPages = array('accueil');
        }
        
        if(Validation::validerStr($newPage, '#^[A-Za-z]{3,12}?#')) {
                if(array_search($newPage,$this->arrPages) !== false) {
                    $index = array_search($newPage, $this->arrPages);

                    array_splice($this->arrPages, $index+1);
                }
                else {
                    array_push($this->arrPages, $newPage);
                }

            App::getInstance()->getSession()->setItem('filArianne', $this->arrPages);
            return $this->write($special);
        }

        else {
            return "Erreur 404";
        }
    }

    private function write($special = 'vide') {

        $liens = array(
            'division' => ' > ',
            'accueil' => '<a href="index.php">Acceuil</a>',
            'livres' => '<a href="index.php?controleur=livre&action=index">Livres</a>',
            'special' => ''
        );

        //            Seul les pages de même niveau mais différentes envoi un 2e argument (ex: fiche et les étapes de transaction)
        if($special != 'vide') {
            $liens['special'] = $special;
        }

        $fil = '';
        for($i = 0; $i<count($this->arrPages); $i++) {
            if($i != 0) {
                $fil .= $liens['division'];
            }

            $fil .= $liens[$this->arrPages[$i]];
        }

        return $fil;
    }
}
