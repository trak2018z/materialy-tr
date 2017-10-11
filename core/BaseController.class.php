<?php
namespace core;

use \core\View;
use \core\Security;

class BaseController {
    /**
     * Obiekt widoku.
     * @var object
     */
    private $_view = NULL;

    /**
     * Obiekt odpowiedzialny za ochronę zasobów.
     * @var object
     */
    private $_security = NULL;

    /**
     * Tablica aktualnego routingu.
     * @var object
     */
    private $_routing = NULL;

    public function __construct()
    {
        session_start();
        $this->_view = new View($this);
        $this->_user = (object) $_SESSION['user'];
        $this->init();
    }


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
     * Zapisuje obiekt odpowiedzialny za ochronę zasobów.
     */
    public function setSecurity(\core\Security $security)
    {
        $this->_security = $security;
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

    /**
     * Zwraca obiekt widoku.
     *
     * @return object
     */
    final protected function getView()
    {
        return $this->_view;

    }

    /**
     * Zwraca obiekt odpowiedzialny z ochronę zasobów.
     *
     * @return object
     */
    public function getSecurity()
    {
        return $this->_security;

    }

    /**
     * Skrót do danych o użytkowniku.
     *
     * @return object
     */
    final public function getUser($field = null)
    {
        return $this->getSecurity()->getUser($field);

    }


    /**
     * Wykonuje przekierowanie na inną stronę.
     */
    final protected function redirect($name)
    {
        header('Location: '.URL_PREFIX.$name);
        die();
    }

    /**
     * Wyświetla stronę z błędem 404.
     *
     * @return void
     */
    public function error($code)
    {
        $this->getView()
            ->assign('content', '_errors/'.$code.'.html')
            ->render('layout.html');
    }

    /**
     * Metoda wywoływana przy starcie.
     *
     * @return void
     */
    public function init()
    {
        $this->getView()->assign('error', $this->getInfo('error'));
        $this->getView()->assign('success', $this->getInfo('success'));
        $this->getView()->assign('form', $this->getInfo('form'));
        $this->getView()->assign('user', $_SESSION['user']);

    }

    /**
     * Zapisuje informację jednokrotnego użytku w sesji.
     *
     * @return object
     */
    public function setInfo($key, $value)
    {
        $_SESSION['info'][$key] = $value;
        return $this;

    }

    /**
     * Pobiera informację jednokrotnego użytku z sesji.
     *
     * @return array
     */
    public function getInfo($key)
    {
        $temp = $_SESSION['info'][$key];
        unset($_SESSION['info'][$key]);
        return $temp;

    }
}