<?php

namespace modules\validator;

/**
 * Klasa sprawdzająca poprawność wprowadzanych danych w formularzu nowej trasy.
 */
class RegisterStudentValidator extends \vendor\validator\Validator
{
    public function getRules()
    {
        return array(
            'kierunek' => array(
                'notNull',
            ),
            'skrot' => array(
                'notNull',
            ),
            'haslo' => array(
                'notNull',
            ),
            'login' => array(
                'notNull',
            ),
        );
    }

    public function getOnFailInfo()
    {
        return 'Popraw błędy formularza.';
    }
}
