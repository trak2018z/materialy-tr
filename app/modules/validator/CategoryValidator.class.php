<?php

namespace modules\validator;

/**
 * Klasa sprawdzająca poprawność wprowadzanych danych w formularzu nowej trasy.
 */
class CategoryValidator extends \vendor\validator\Validator
{
    public function getRules()
    {
        return array(
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
