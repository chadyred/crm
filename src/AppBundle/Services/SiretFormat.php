<?php

namespace AppBundle\Services;

class SiretFormat extends \Twig_Extension
{
    public function getFunctions() {
        return array(
            'siretFormat' => new \Twig_Function_Method($this, 'siretFormat')
        );
    }

    public function getName() {
        return 'siretFormat';
    }

    public function siretFormat($siret) {
        $format = substr($siret, 0, 3).' ';
        $format .= substr($siret, 3, 3).' ';
        $format .= substr($siret, 6, 3).' ';
        $format .= substr($siret, 9, 5).' ';

        return $format;
    }
}