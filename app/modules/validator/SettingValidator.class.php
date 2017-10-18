<?php

namespace modules\validator;

/**
 * Klasa sprawdzająca poprawność wprowadzanych danych w formularzu nowej trasy.
 */
class SettingValidator extends \vendor\validator\Validator
{
    public function getRules()
    {
        return array(
            'imie' => array(
                'notNull',
            ),
            'nazwisko' => array(
                'notNull',
            ),
        );
    }

    public function getOnFailInfo()
    {
        return 'Popraw błędy formularza.';
    }
}
