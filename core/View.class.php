<?php
/**
 *
 */

namespace core;

class View {
    /**
     * Przechowuje zmienne wykorzystywane w widoku.
     * @var array
     */
    private $_variables = array();

    /**
     * Kontroller wywołujący ten widok.
     */
    private $_controller = NULL;

    /**
     *
     * @var string
     */
    private $_temp = '';

    private static $_assets = NULL;

    public function __construct(\core\BaseController $controller)
    {
        $this->_controller = $controller;
    }

    /**
     * Ustawia prefix dla ssetów.
     *
     * @param string $name
     */
    static public function setAssets($assets)
    {
        if (NULL === self::$_assets) {
            self::$_assets = $assets;
        }
    }

    /**
     * Renderuje widok.
     *
     * @return void
     */
    public function render($name)
    {
        $this->_temp = $name;
        extract($this->_variables);
        include(__DIR__.'/../app/view/'.$this->_temp.'.php');
    }

    /**
     * Przypisuje zmienną do widoku.
     *
     * @param integer $name
     * @param integer $value
     * @param integer $merge
     *
     * @return object $this
     */
    public function assign($name, $value, $merge=FALSE)
    {
        if (TRUE === $merge
            && TRUE === isset($this->_variables[$name])
            && TRUE === is_array($this->_variables[$name])
        ) {
            $this->_variables[$name] = array_merge($this->_variables[$name], $value);
        } else {
            $this->_variables[$name] = $value;
        }

        return $this;

    }

    /**
     * Zwraca kontroller.
     *
     * @return object
     */
    public function getController()
    {
        return $this->_controller;
    }

    /**
     * Zwraca adres strony.
     *
     * @param string $name Uniwersalna ścieżka.
     *
     * @return string
     */
    private function url($name)
    {
        return URL_PREFIX.$name;

    }

    /**
     * Zwraca ścieżkę do plików css/js/obrazków.
     *
     * @param string $name Ścieżka do zasobu.
     *
     * @return string
     */
    private function assets($name)
    {
        return self::$_assets.$name;

    }

    /**
     * Załącza inne pliki widoków.
     *
     * @param string $name
     */
    private function inc($name)
    {
        $this->_temp = $name;
        extract($this->_variables);
        include(__DIR__.'/../app/view/'.$this->_temp.'.php');
    }

    /**
     * Metoda pomocnicza, zwraca dni tygodnia.
     *
     * @param integer $day Numer dnia.
     *
     * @return string
     */
    private function getDay($day)
    {
        $days = array(1 => 'Poniedziałek', 'Wtorek' , 'Środa', 'Czwartek', 'Piątek', 'Sobota', 'Niedziela');
        return $days[$day];

    }

    /**
     * Zwraca czy użytkownik ma dostęp do danego zasobu.
     *
     * @param string $name nazwa zasobu.
     *
     * @return boolean
     */
    private function hasAccess($name)
    {
        return $this->getController()->getSecurity()->checkPermission($name);
    }

    private function isAdmin(){
        if($this->getController()->getSecurity()->getUser()->typ_konta == 'admin') return true; else return false;
    }

    private function isTeacher(){
        if($this->getController()->getSecurity()->getUser()->typ_konta == 'teacher') return true; else return false;
    }

    private function isStudent(){
        if($this->getController()->getSecurity()->getUser()->typ_konta == 'student') return true; else return false;
    }
}