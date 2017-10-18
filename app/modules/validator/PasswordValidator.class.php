<?php

namespace modules\validator;

/**
 * Klasa sprawdzająca poprawność wprowadzanych danych w formularzu nowej trasy.
 */
class PasswordValidator extends \vendor\validator\Validator
{
    public function getRules()
    {
        return array(
            'stare_haslo' => array(
                'notNull',
            ),
            'nowe_haslo' => array(
                'notNull',
            ),
            'powtorne_haslo' => array(
                'notNull',
            ),
        );
    }

    public function getOnFailInfo()
    {
        return 'Popraw błędy formularza.';
    }
}
