<?php
namespace core;

class Routing {
    /**
     * Aktualna ścieżka.
     * @var string
     */
    private $_route = '';

    /**
     * Ścieżka do tablicy routingu.
     */
    private $_routingArrayPath = '';

    /**
     * Tablica routingu.
     * @var array
     */
    private $_routeArray = array();

    /**
     * Tablica parametrów wczytanego routingu.
     * @var array
     */
    private $_currentRoute = array();

    /**
     *
     */
    public function __construct($routingArrayPath)
    {
        $this->_routingArrayPath = $routingArrayPath;
        $this->_routeArray = include($routingArrayPath);
    }


    /**
     * Zwraca tablicę routingu.
     *
     * @return array
     */
    public function getRouting($name=NULL)
    {
        if (NULL === $name) {
            return $this->_routeArray;
        } else if (true === isset($this->_routeArray[$name])) {
            return $this->_routeArray[$name];
        } else {
            throw new \Exception('Cannot find route '.$name.'!');
        }

    }


    /**
     * Zwraca parametry wczytanego routingu.
     *
     * @return array
     */
    public function getCurrentRoute()
    {
        return $this->_currentRoute;

    }


    /**
     *
     */
    public function load()
    {
        $aRouting = $this->getRouting();
        $sSite    = $this->getRoute();
        $getStart = strpos($sSite, '?');
        if ($getStart) {
            $sSite = substr($sSite, 0, $getStart);
        }

        foreach ($aRouting as $var => $val) {
            $pattern = preg_replace(array('/{([a-zA-Z0-9]+)}/', '/\//'), array('([a-zA-Z0-9]+)', '\/'), $val['pattern']);
            $match   = preg_match('/^(\/|^)'.$pattern.'(\/|$)$/', $sSite, $matches);
            //echo '<pre>'; var_dump($pattern, $sSite, $match); echo '</pre>';
            array_shift($matches);
            array_shift($matches);
            array_pop($matches);

            if (1 <= $match) {
                $this->_currentRoute = $val;
                $aModule     = explode('::', $val['controller']);
                $sAction     = $aModule[1].'Action';
                $oSecurity   = new Security();
                $oSecurity->setRoute($this);

                $oController = new $aModule[0];
                $oController->setRoute($this);
                $oController->setSecurity($oSecurity);
                if (TRUE === $oController->getSecurity()->checkPermission()) {
                    call_user_func_array(array($oController, $sAction), $matches);
                } else {
                    $oController->error('403');
                }

                return TRUE;

            }
        }// 403
        $oSecurity   = new Security();
        $oSecurity->setRoute($this);

        $oController = new BaseController;
        $oController->setSecurity($oSecurity);
        $oController->error('404');
        return FALSE;

    }


    /**
     * Ustawia aktualna ścieżkę.
     *
     * @return object $this
     */
    public function setRoute($route)
    {
        $this->_route = $route;
        return $this;

    }


    /**
     *Pobiera aktualną ścieżkę.
     *
     * @return string
     */
    public function getRoute()
    {
        return $this->_route;

    }
}