<?php

namespace AppBundle\Services;

class TokenGenerator extends \Twig_Extension
{
    public function getName()
    {
        return 'generateToken';
    }

    public function getFunctions()
    {
        return array(
            'generateToken' => new \Twig_Function_Method($this, 'generateToken')
        );
    }

    public function generateToken($length = 8)
    {
        $token = "";
        $suit = "12346789abcdfghjkmnpqrtvwxyzABCDFGHJKLMNPQRTVWXYZ";

        for ($i = 0; $i < $length; $i++)
            $token .= substr($suit, mt_rand(0, strlen($suit)-1), 1);

        return $token;
    }
}