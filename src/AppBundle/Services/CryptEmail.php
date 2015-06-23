<?php

namespace AppBundle\Services;

class CryptEmail extends \Twig_Extension 
{
    public function getFunctions() {
        return array(
            'cryptEmail' => new \Twig_Function_Method($this, 'cryptEmail')
        );
    }

    public function getName() {
        return 'CryptEmail';
    }

    public function cryptEmail($email, $mailto = false) {

        $key = sha1(uniqid(mt_rand(), true));

        $tab_key = array();
        $tab_val = array();
        while (substr($email, 0, 1) != '') {
            $md5 = '_' . md5(sha1(uniqid(mt_rand(), true)));
            $tab_val[$md5] = substr($email, 0, 1);
            $tab_key[] = $md5;
            $email = substr($email, 1);
        }

        $tab_order = $tab_key;
        shuffle($tab_key);

        $result = '
            <span id="email_no_spam_'.$key.'">Activez le javascript pour voir l\'email.</span>
            <script type="text/javascript">var email_no_spam = $("#email_no_spam_'.$key.'");'; 
        foreach ($tab_key as $key) {
            $result .= 'var '.$key.' = "'.$tab_val[$key].'";';
        }

        $result .= 'email_no_spam.html(';

        if ($mailto)
            $result .= '\'<a href="mailto:\'+';

        $mail = '';
        foreach ($tab_order as $key) {
            $mail .= ''.$key.'+';
        }
        $mail = substr($mail, 0, -1);
        $result .= $mail;

        if ($mailto)
            $result .= '+\'">\'+'.$mail.'+\'</a>\'';



        $result .= ');
            </script>
        ';

        return $result;
    }
}