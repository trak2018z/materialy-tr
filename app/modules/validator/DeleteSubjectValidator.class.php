<?php

namespace modules\validator;

/**
 * Klasa sprawdzająca poprawność wprowadzanych danych w formularzu nowej trasy.
 */
class DeleteSubjectValidator extends \vendor\validator\Validator
{
    public function getRules()
    {
        return array(
            'potwierdz' => array(
                'notNull',
            ),
        );
    }

    public function getOnFailInfo()
    {
        return 'Popraw błędy formularza.';
    }
}
