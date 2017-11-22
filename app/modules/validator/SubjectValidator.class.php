<?php

namespace modules\validator;

/**
 * Klasa sprawdzająca poprawność wprowadzanych danych w formularzu nowej trasy.
 */
class SubjectValidator extends \vendor\validator\Validator
{
    public function getRules()
    {
        return array(
            'nazwa' => array(
                'notNull',
            ),
            'uzytkownik' => array(
                'notNull',
                'isInt',
            ),
        );
    }

    public function getOnFailInfo()
    {
        return 'Popraw błędy formularza.';
    }
}
