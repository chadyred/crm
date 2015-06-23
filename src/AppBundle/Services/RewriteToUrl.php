<?php

namespace AppBundle\Services;

class RewriteToUrl extends \Twig_Extension
{
    public function getName()
    {
        return 'rewriteToUrl';
    }

    public function getFunctions()
    {
        return array(
            'rewriteToUrl' => new \Twig_Function_Method($this, 'rewriteToUrl')
        );
    }

    public function rewriteToUrl($texte)
    {
        $caracteres = array("¥" => "Y", "µ" => "u", "À" => "A", "Á" => "A", "Â" => "A", "Ã" => "A",
            "Ä" => "A", "Å" => "A", "Æ" => "A", "Ç" => "C", "È" => "E", "É" => "E", "Ê"=> "E", "Ë" => "E",
            "Ì" => "I", "Í" => "I", "Î" => "I", "Ï" => "I", "Ð" => "D", "Ñ" => "N", "Ò" => "O", "Ó" => "O",
            "Ö" => "O", "Ø" => "O", "Ù" => "U", "Ú" => "U", "Û" => "U", "Ü" => "U", "Ý" => "Y", "ß" => "s",
            "à" => "a", "á" => "a", "â" => "a", "ã" => "a", "ä" => "a", "å"=> "a", "æ" => "a", "ç"=> "c",
            "è" => "e", "é" => "e", "ê" => "e", "ë" => "e", "ì" => "i", "í" => "i", "î" => "i", "ï"=> "i",
            "ð"=> "o", "ñ"=> "n", "ò" => "o", "ó" => "o", "ô" => "o", "õ" => "o", "ö" => "o", "ø" => "o",
            "ù" => "u", "ú" => "u", "û" => "u", "ü" => "u", "ý" => "y", "ÿ" => "y", "Ô" => "O", "Õ" => "O");

        $texte = strtr($texte , $caracteres);
        $texte=strtolower($texte);
        $len = strlen($texte);
        $retour = '';

        for($a=0; $a<$len; $a++){
            $p = ord($texte[$a]);
            if ( ($p > 96 && $p < 123) or ($p > 47 && $p < 58) ) {
                $retour .= $texte[$a];
            } else {
                $retour .= "-";
            }
        }

        while(strpos($retour,"--")!==FALSE) {
            $retour=str_replace("--","-",$retour);
        }
        $retour=trim($retour,"-");

        return $retour;
    }
}