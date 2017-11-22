<?php

namespace modules\validator;

/**
 * Klasa sprawdzająca poprawność wprowadzanych danych w formularzu nowej trasy.
 */
class FileValidator extends \vendor\validator\Validator
{
    public function getRules()
    {
        return array(
            'file' => array(
                'notNull',
            ),
            'nazwa' => array(
                'notNull',
            ),
        );
    }

    public function getOnFailInfo()
    {
        return 'Popraw błędy formularza.';
    }
}
