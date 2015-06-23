<?php

namespace AppBundle\Services;

class PhoneFormat extends \Twig_Extension 
{
    public function getFunctions() {
        return array(
            'phoneFormat' => new \Twig_Function_Method($this, 'phoneFormat')
        );
    }

    public function getName() {
        return 'PhoneFormat';
    }

    public function phoneFormat($tel) {
        if (substr($tel, 0, 1) == '+') {
            $return_tel = substr($tel, 0, 3);
            $return_tel .= ' '.substr($tel, 3, 1);
            $return_tel .= ' '.substr($tel, 4, 2);
            $return_tel .= ' '.substr($tel, 6, 2);
            $return_tel .= ' '.substr($tel, 8, 2);
            $return_tel .= ' '.substr($tel, 10, 2);
            return $return_tel;
        }
        else
            return chunk_split($tel, 2, ' ');
    }
}