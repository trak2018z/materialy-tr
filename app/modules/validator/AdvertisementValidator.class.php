<?php

namespace modules\validator;

/**
 * Klasa sprawdzająca poprawność wprowadzanych danych w formularzu nowej trasy.
 */
class AdvertisementValidator extends \vendor\validator\Validator
{
    public function getRules()
    {
        return array(
            'tytul' => array(
                'notNull',
            ),'tresc' => array(
                'notNull',
            ),
        );
    }

    public function getOnFailInfo()
    {
        return 'Popraw błędy formularza.';
    }
}
