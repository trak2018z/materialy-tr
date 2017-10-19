<?php

namespace modules\validator;

/**
 * Klasa sprawdzająca poprawność wprowadzanych danych w formularzu nowej trasy.
 */
class ManagerValidator extends \vendor\validator\Validator
{
    public function getRules()
    {
        return array(
            'typ_konta' => array(
                'notNull',
                array('isIn', array('admin', 'teacher', 'student')),
            ),
        );
    }

    public function getOnFailInfo()
    {
        return 'Popraw błędy formularza.';
    }
}
