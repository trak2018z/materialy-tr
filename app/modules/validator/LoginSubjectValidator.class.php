<?php

namespace modules\validator;

/**
 * Klasa sprawdzająca poprawność wprowadzanych danych w formularzu nowej trasy.
 */
class LoginSubjectValidator extends \vendor\validator\Validator
{
    public function getRules()
    {
        return array(
            'login' => array(
                'notNull',
            ),
            'haslo' => array(
                'notNull',
            ),
        );
    }

    public function getOnFailInfo()
    {
        return 'Popraw błędy formularza.';
    }
}
