<?php
/**
 * @package    Modules
 * @subpackage Validator
 * @author     Michał Kutrzeba <kutrzeba.michal@gmail.com>
 * @copyright  Michał Kutrzeba <kutrzeba.michal@gmail.com>
 */

namespace vendor\validator;

/**
 * Klasa uniwersalna bez konieczności tworzenia nowej instacji
 */
final class Universal extends Validator
{
    /**
     * Nazwa walidatora według którego później wczytywany jest konfig.
     *
     * @var string
     */
    private $_name = 'universal';

    /**
     * Zwraca nazwę walidatora.
     *
     * @return string
     */
    public function getName()
    {
        return $this->_name;

    }//end getName


    /**
     * Ustawia nazwę walidatora.
     *
     * @param string $name
     */
    public function setName($name)
    {
        if ('universal' === $this->_name) {
            $this->_name = $name;
        }//end if

        return $this;

    }//end setName()


    public function getRules()
    {
        return array();

    }//end getRules()
}