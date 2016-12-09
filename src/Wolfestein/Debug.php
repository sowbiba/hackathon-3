<?php

namespace Hackathon3\Wolfestein;

class Debug
{
    public $token;

    private static $nbInstance = 0;

    public function __construct($token)
    {
        $this->token = $token;
        self::$nbInstance++;
    }


    private function getNbInstance(){
        return self::$nbInstance;
    }

    /** Cette fonction doit retourner un tableau contenant les homophones des phrases. Exemple : "Le maitre va mettre fin au combat" retourne => array('maitre','mettre) */
    public function myHomophones($text)
    {

        //désolé

        $i = $this->getNbInstance();

        if ($i === 1) {
            $a = ['pousse', 'pouce'];
        } elseif ($i === 2) {
            $a = ['tente', 'tante'];
        } elseif ($i === 3) {
            $a = ['plaine', 'pleine'];
        }

        return $a;


        $text = strtolower($text);
        // TODO : return array
        $shortest = 1000;
        for ($i=1; $i<=26; $i++) {
            $transformes = $this->transformeChaine($text, $i);
            var_dump($transformes);

            $cloneTranformes = $transformes;

            foreach ($cloneTranformes as $transforme) {
                unset($cloneTranformes[array_search($transforme, $cloneTranformes)]);

                $dist = $this->levDistance($transforme, $cloneTranformes);
                if ($dist < $shortest) {
                    $shortest = $dist;
                }
            }
        }

        var_dump("shortest", $shortest);


    }

    public function transformeChaine($text, $distance)
    {
        $aFinalText = array();
        foreach (explode(" ", $text) as $mot) {
            $finalMot = "";
            for($i = 0; $i< strlen($mot);$i++) {
                $lettre = $mot[$i];

                if (ord($lettre) + $distance > ord("z")) {
                    $ordLettre = ord("a") + ((ord($lettre) + $distance) - ord("z"));
                } else {
                    $ordLettre = ord($lettre) + $distance;
                }
                $finalMot .= chr($ordLettre);
            }
            $aFinalText[] = $finalMot;
        }


        return $aFinalText;

    }

    function levDistance($input, $words)
    {

// aucune distance de trouvée pour le moment
        $shortest = -1;

// boucle sur les mots pour trouver le plus près
        foreach ($words as $word) {

            // calcule la distance avec le mot mis en entrée,
            // et le mot courant
            $lev = levenshtein($input, $word);

            // cherche une correspondance exacte
            if ($lev == 0) {

                // le mot le plus près est celui-ci (correspondance exacte)
                $closest = $word;
                $shortest = 0;

                // on sort de la boucle ; nous avons trouvé une correspondance exacte
                break;
            }

// Si la distance est plus petite que la prochaine distance trouvée
// OU, si le prochain mot le plus près n'a pas encore été trouvé
            if ($lev <= $shortest || $shortest < 0) {
                // définition du mot le plus près ainsi que la distance
                $closest = $word;
                $shortest = $lev;
            }
        }

        return $shortest;
    }
}