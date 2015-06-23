<?php

namespace AppBundle\Services;

class CloneVar extends \Twig_Extension
{
    public function getFunctions() {
        return array(
            'cloneVar' => new \Twig_Function_Method($this, 'cloneVar')
        );
    }

    public function getName() {
        return 'cloneVar';
    }

    public function cloneVar($var) {
        return clone($var);
    }
}