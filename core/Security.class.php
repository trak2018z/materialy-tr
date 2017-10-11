<?php
/**
 * Klasa odpowiedzialna za zarządzanie sesją urzytkownika.
 */
namespace core;

class Security
{

    private $_routing = array();

    /**
     * Zapisuje obiekt routingu.
     *
     * @param object $routing Obiekt klasy Routing.
     */
    public function setRoute(\core\Routing $routing)
    {
        $this->_routing = $routing;
    }

    /**
     * Sprawdza czy użytkownik ma dostęp do zasobów.
     */
    public function checkPermission($route = null)
    {
        if (null === $this->_routing) {
            throw new \Exception('Cannot check access without routing.');
        }

        if (null === $route) {
            $aCRoute = $this->getRoute()->getCurrentRoute();
        } else {
            $aCRoute = $this->getRoute()->getRouting($route);
        }

        if (false === isset($aCRoute['secured']) || false === $aCRoute['secured']) {
            return true;
        }

        if (true === in_array($this->getUser()->typ_konta, $aCRoute['roles'])) {
            return true;
        } else {
            return false;
        }

    }

    /**
     * Zwraca tablicę zalogowanego użytkownika.
     */
    final public function getUser($field = null)
    {
        if (null !== $field && true === isset($_SESSION['user'][$field])) {
            return $_SESSION['user'][$field];
        }

        return (object) $_SESSION['user'];

    }

    /**
     * Zwraca obiekt routingu.
     *
     * @return object
     */
    public function getRoute()
    {
        return $this->_routing;

    }
}
