<?php
namespace Enigmatic\CRMBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;


class SiretValidator extends ConstraintValidator
{

    public function validate($value, Constraint $constraint)
    {
        if (null !== $value) {
            $siret = $value;

            $total = 0;

            if (strlen($siret) == 14){

                for ($i = 0; $i < 14; $i++){

                    $key = substr($siret, $i, 1);

                    $mult = 1;
                    if ($i % 2 == 0)
                        $mult = 2;

                    $res = $key * $mult;

                    if ($res > 10)
                        $res -= 9;

                    $total += $res;
                }
                if ($total % 10 != 0)
                    $this->context->addViolation($constraint->message_invalid);
            }
            else {
                $this->context->addViolation($constraint->message_format);
            }
        }
    }
}