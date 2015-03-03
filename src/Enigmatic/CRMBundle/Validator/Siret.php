<?php
namespace Enigmatic\CRMBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
* @Annotation
*/
class Siret extends Constraint
{
    public $message_format = 'Le format est invalide (minimum 14 chiffres).';
    public $message_invalid = 'Veuillez saisir un numéro Siret existant.';
}