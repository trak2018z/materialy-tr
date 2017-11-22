<?php

namespace modules\validator;

/**
 * Klasa sprawdzająca poprawność wprowadzanych danych w formularzu nowej trasy.
 */
class LeaderValidator extends \vendor\validator\Validator
{
    public function getRules()
    {
        return array(
            'nauczyciel' => array(
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
