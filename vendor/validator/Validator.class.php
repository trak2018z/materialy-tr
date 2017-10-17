<?php
/**
 * @package    Modules
 * @subpackage Validator
 * @author     Michał Kutrzeba <kutrzeba.michal@gmail.com>
 * @copyright  Michał Kutrzeba <kutrzeba.michal@gmail.com>
 */

namespace vendor\validator;

use vendor\validator\Rules;
use core\Session;

/**
 * Klasa obsługująca walidację pól formularzy.
 *
 * Musi zostać rozszerzona przez klasę obsługującą konkretny formularz.
 */
abstract class Validator
{
    /**
     * Tablica wiadomości walidacji.
     * @var array
     */
    private $_messages = array();

    /**
     * Tablica wiadomości domyślnych.
     * @var array
     */
    private $_defaultMessages = array();

    /**
     *
     */
    private $_rules = array();

    /**
     * Pola, $_POST.
     * @var array
     */
    private $_fields = array();

    /**
     * Pliki, $_FILES.
     * @var array
     */
    private $_files = array();

    /**
     * Identyfikator językowy.
     */
    private $_locale = 'pl-PL';

    /**
     * Rodzaj komunikatów. Skąd brać komunikaty np. default - dla strony web, api dla api.
     */
    private $_type = 'default';

    /**
     * Wiadomości o błędach.
     */
    private $_warnings = array();

    /**
     * Czy formularz ma poprawnie wprowadzone dane.
     */
    private $_validate = NULL;

    /**
     * Dodatkowe dane potrzebne do walidacji, np. id użytkownika.
     */
    private $_additionals = array();

    /**
     * Tablica konfiguracji, np. ile znaków ma określone pole etc.
     * @var array
     */
    private $_config = array();

    /**
     * Obiekt klasy Rules.
     *
     * @var object
     */
    private $_rule;

    const VAL_ARRAY = 1;

    /**
     *
     */
    public function __construct($type='default', $locale='pl-PL')
    {
        // $this->setConfig(__DIR__.'/../../config/validator.json');
        $this->_fields  = $_POST;
        $this->_files   = $_FILES;
        $this->_rule    = new Rules();
        $this->_locale  = $locale;
        $this->_type    = $type;
        $this->_loadMessages();
        $this->init();
        $this->_rule->setValidatorInstance($this);

    }//end __construct()


    /**
     * Zapisuje wynik walidacji w sesji.
     */
    public function saveGlobally()
    {
        $aForm   = array();
        if (FALSE === $this->isValid()) {
            $aForm['fields'] = $this->getFields();
        } else {
            $aForm['fields'] = array();
        }//end if

        $aForm['info'] = $this->getWarnings();
        $_SESSION['form'] = $aForm;
    }//end saveGlobally()


    /**
     * Pobiera wynik walidacji z sesji i zapisuje do widoku.
     *
     * @param object $ui
     *
     * @return void
     */
    static public function appendToView($ui, array $aOverride=array())
    {
        $aForm   = $_SESSION['form'];
        if (TRUE === empty($aForm['fields'])) {
            $aForm['fields'] = $aOverride;
        } else {
            $aForm['fields'] = array_merge($aOverride, $aForm['fields']);
        }//end if

        $ui->assign('form', $aForm);
        unset($_SESSION['form']);
        return $aForm;

    }//end appendToView()


    /**
     * Dorzuca wartości do sprawdzenia.
     * Metoda nadpisuje już istniejące pola.
     *
     * @param string $name  Nazwa pola.
     * @param mixed  $value Wartość pola.
     *
     * @return object $this
     */
    public function appendToFields($name, $value)
    {
        $this->_fields[$name] = $value;
        return $this;

    }//end appendToFields()


    /**
     * Zwraca obiekt Rules
     *
     * @return object
     */
    public function getRule($name = null)
    {
        if (null === $name) {
            return $this->_rule;
        }

        return $this->_rule[$name];

    }//end getRule()


    /**
     * Ustawia zewnętrzny obiekt przechowujący zasady walidacji.
     *
     * @param object $oRule Obiekt przechowujący zasady walidacji.
     *
     * @return void
     */
    protected function setRule($oRule)
    {
        unset($this->_rule);
        $this->_rule = $oRule;
        return $this;

    }//end setRule()


    /**
     * Zwraca czy pola są wprowadzone prawidłowo.
     *
     * @return boolean
     */
    public function isValid()
    {
        if (NULL === $this->_validate) {
            $this->checkRules(); // Sprawdzanie zasad getRules()
            $this->_validate = $this->isWarning();
        }//end if

        return $this->_validate;

    }//end isValid()


    /**
     * Sprawdza zasady walidacji wpisane w funkcji getRules()
     *
     * @return void
     */
    public function checkRules()
    {
        $aRules = $this->getRules();
        if (TRUE === empty($aRules)) {
            return FALSE;

        }//end if

        $aFields = $this->getFields();
        $aFiles  = $this->getFiles();
        foreach ($aRules as $var => $val) {

            foreach ($val as $varRule => $valRule) {
                $placeholders = array();
                if (TRUE === is_array($valRule)) {
                    $functionName = $valRule[0];
                    $placeholders = $valRule;
                    unset($placeholders[0]);
                    $placeholders = array_values($placeholders);
                } else {
                    $functionName = $valRule;
                    $placeholders = array();
                }//end if

                $aTree = $this->fieldNameBuilder($var);
                if (1 < count($aTree)) {
                    $this->iterateFields($aTree, $aFields, $var, $functionName, $placeholders, array());
                    continue;
                }//end if

                if ('notNull' !== $functionName && TRUE === empty($aFields[$var]) && TRUE === empty($aFiles[$var])) {
                    continue;
                }//end if

                if (FALSE === is_callable($functionName) && FALSE === method_exists($this->getRule(), $functionName)) {
                    throw new \Exception('Method \''.$functionName.'\' doesn\'t exists.');
                }//end if

                if (TRUE === empty($aFields[$var])) {
                    $this->checkRule($var, $functionName, $aFiles[$var], $placeholders);
                } else {
                    $this->checkRule($var, $functionName, $aFields[$var], $placeholders);
                }//end if

            }//end foreach
        }//end foreach

    }//end checkRules()


    /**
     * Metoda rekurencyjna, walidująca kolejne poziomy tablicy.
     *
     * @param  array  $aTree        Drzewo
     * @param  array  $aFields      Pola
     * @param  string $fieldName    Nazwa pola do walidacji.
     * @param  string $functionName Nazwa funkcji walidującej.
     * @param  array  $placeholders
     *
     * @return void
     */
    private function iterateFields($aTree, $aFields, $fieldName, $functionName, $placeholders, $aTreeAsc)
    {
        $temp    = $aTree;
        foreach ($temp as $val) {
            if (NULL != $val) {
                $aFields = $aFields[$val];
                array_push($aTreeAsc, $val);
                array_shift($temp);
            } else {
                array_push($aTreeAsc, 0);
                array_shift($temp);
                for ($i = 0, $ii = count($aFields); $i < $ii; $i++) {
                    $aTreeAsc[count($aTreeAsc)-1] = $i;
                    $this->iterateFields($temp, $aFields[$i], $fieldName, $functionName, $placeholders, $aTreeAsc);

                }//end for

                return;

            }//end if

        }//end foreach

        if ('notNull' !== $functionName && TRUE === empty($aFields)) {
            return;
        }//end if

        if (FALSE === method_exists($this->getRule(), $functionName)) {
            throw new \Exception('Method \''.$functionName.'\' doesn\'t exists.');
        }//end if

        if (TRUE === empty($aFields)) {
            $this->checkRule($aTreeAsc, $functionName, $aFiles, $placeholders);
        } else {
            $this->checkRule($aTreeAsc, $functionName, $aFields, $placeholders);
        }//end if

    }//end iterateFields()


    /**
     * Rozbija zapis typu pos[][MILLED] na tablicę kolejnych pól tj.
     * array('pos', NULL, 'MILLED'), która póżniej może być iterowana,
     * w miejscu NULL typ integer np. $aFields['pos'][$i]['MILLED']
     * i sprawdzane jej zasady.
     *
     * @param string $fieldName Nazwa pola.
     *
     * @return array
     */
    public function fieldNameBuilder($fieldName)
    {
        $sRegex   = "/([a-zA-Z0-9_-]*)((\[([a-zA-Z0-9_-]*)\])*)/";
        $aMatches = array();
        if (0 < preg_match($sRegex, $fieldName, $aMatches)) {
            if (TRUE === empty($aMatches[2])) {
                return $aMatches[0];

            } else {
                $sNextFields = substr($aMatches[2], 1, -1);
                $aFields     = array_merge(array($aMatches[1]), explode('][', $sNextFields));
                return $aFields;

            }//end if

        }//end if

    }//end fieldNameBuilder()


    /**
     * Sprawdza pojedyncze pole.
     *
     * @param  string $fieldName    Nazwa pola.
     * @param  string $functionName Nazwa funkcji.
     * @param  mixed  $fieldValue   Wartość pola.
     * @param  array  $placeholders Parametry.
     *
     * @return void
     */
    public function checkRule($fieldName, $functionName, $fieldValue, $placeholders)
    {
        if (is_callable($functionName)) {
            $return = $this->getRule()->_lambda($fieldValue, $functionName, $placeholders);
            $functionName = $placeholders[0];
            array_shift($placeholders);
        } else {
            $return = $this->getRule()->$functionName($fieldValue, $placeholders);
        }//end if

        if (FALSE === $return) {
            $this->setWarning($fieldName, $functionName, $placeholders);
        } else if (TRUE === is_string($return)) {
            $this->setWarning($fieldName, $return);
        }//end if

        return $this;

    }//end checkRule()


    /**
     * Ustawia błąd na polu.
     *
     * @param  string $fieldName    Nazwa pola.
     * @param  string $message      Identyfikator wiadomości, lub wiadomość.
     * @param  string $placeholders Opcjonalne wartości, które można przekazać do wiadomości.
     * @return void
     */
    protected function setWarning($fieldName, $message, $placeholders=array())
    {
        $this->_validate = FALSE;
        if (TRUE === is_array($fieldName)) {
            $aTemp = array();
            $aTemp = &$this->_warnings[$fieldName[0]];
            array_shift($fieldName);
            foreach ($fieldName as $val) {
                $aTemp = &$aTemp[$val];
            }//end foreach

            $aTemp = $this->getMessage($message, $fieldName, $placeholders);
        } else {
            $this->_warnings[$fieldName] = $this->getMessage($message, $fieldName, $placeholders);
        }//end if

    }//end setWarning();


    /**
     * Sprawdza czy do danego pola pojawia się błąd.
     *
     * @param  string  $name Nazwa pola.
     * @return boolean
     */
    protected function isWarning($name=NULL)
    {
        if ($name === NULL) {
            if (TRUE === empty($this->_warnings)) {
                return TRUE;

            } else {
                return FALSE;

            }//end if

        }//end if

        if (TRUE === isset($this->_warnings[$fieldName])) {
            return TRUE;

        }//end if

        return FALSE;

    }//end isWarning();


    /**
     * Zwraca komunikaty błędów przypisane do pól.
     * @param  boolean $withAdditionals Flaga oznaczająca czy mają zostać zwrócone pola
     *                                  dodatkowe takie jak '_success'.
     * @return array
     */
    public function getWarnings($withAdditionals=TRUE)
    {
        $aTemp = array();
        if (TRUE === $this->isValid()) {
            $aTemp['_success'] = TRUE;
            $aTemp['_html']    = $this->getOnSuccessInfo();
        } else {
            $aTemp['_success'] = FALSE;
            $aTemp['_html']    = $this->getOnFailInfo();
        }//end if

        if (TRUE === $withAdditionals) {
            $aTemp = array_merge($aTemp, $this->_warnings);
        } else {
            $aTemp = $this->_warnings;
        }//end if

        return $aTemp;

    }//end getWarnings()


    /**
     * Zwraca wartość pola po nazwie
     *
     * @return array
     */
    public function getFields()
    {
        return $this->_fields;

    }//end getField


    /**
     * Zwraca wartość pola po nazwie
     *
     * @return array
     */
    public function getField($key)
    {
        return $this->_fields[$key];

    }//end getField


    /**
     * Zwraca wartość tablicy z plikami.
     *
     * @return array
     */
    public function getFiles()
    {
        return $this->_files;

    }//end getFiles()


    /**
     * Ustawia pola do walidacji.
     *
     * @param array $aFields Pola do walidacji.
     *
     * @return object
     */
    public function setFields($aFields)
    {
        $this->_fields = $aFields;
        return $this;

    }//end setFields()


    /**
     * Zwraca wiadomość według klucza
     *
     * @param  string $name         Nazwa wiadomości.
     * @param  string $field        Nazwa pola.
     * @param  string $placeholders Opcjonalne wartości, które można przekazać do wiadomości.
     * @return string
     */
    protected function getMessage($name, $field=NULL, $placeholders=array())
    {
        if (TRUE === isset($this->_messages[$this->_locale][$field][$name])) {
            return preg_replace(array('/\$1/', '/\$2/'), $placeholders, $this->_messages[$this->_locale][$field][$name]);
        } else if (TRUE === isset($this->_defaultMessages[$this->_locale][$name])) {
            return preg_replace(array('/\$1/', '/\$2/'), $placeholders, $this->_defaultMessages[$this->_locale][$name]);
        }//end if

        return preg_replace(array('/\$1/', '/\$2/'), $placeholders, $name);

    }//end getMessage()


    /**
     * Dodatkowe dane potrzebne do walidacji.
     *
     * @deprecated Powinno zostać usunięta w przyszłości.
     *
     * @param string $name Nazwa pod jaką zapisać dane.
     * @param mixed  $data Dane wprowadzane.
     *
     * @return object
     */
    public function setAdditionalData($name, &$data)
    {
        $this->_additionals[$name] = $data;
        return $this;

    }//end additionalData()


    /**
     * Zwraca dodatkowe dane przesłane do walidacji.
     *
     * @deprecated Powinna zostać usunięta w przyszłości.
     *
     * @param  string    $name Nazwa pod jaką dane zostały zapisane.
     * @param  string    $type Typ danych.
     *
     * @throws Exception Kiedy nie zgadza się typ z oczekiwanym.
     *
     * @return mixed
     */
    protected function getAdditionalData($name, $type=NULL)
    {
        if ($type === self::VAL_ARRAY && FALSE === is_array($this->_additionals[$name])) {
            throw new \Exception('Niezgodny typ plików.');
        } else {
            return $this->_additionals[$name];
        }//end if

    }//end getAdditionalData()


    /**
     * Zamienia wartość floatową z przecinku na kropkę.
     *
     * @param  string
     * @return float
     */
    protected function parseFloat($val)
    {
        return (float) str_replace(array(' ', ','), array('', '.'), $val);

    }//end toDot()


    /**
     * Pobiera określoną wartość z konfiguracji.
     *
     * @param  string $name  Nazwa konfiguracji.
     * @param  string $field Nazwa pola do którego chcemy wziąć konfigurację.
     * @return mixed         Różnego typu wartości.
     */
    public function getConfig($field, $name)
    {
        return $this->_config[$this->getName()][$field][$name];

    }//end getConfig()


    /**
     * Ustawia konfiguracje dla walidatora.
     *
     * @todo Przenieść konfigurację do pliku, w tym miejscu ją tylko zaczytywać i wrzucać do zmiennej _config.
     *
     * @param  string $configFile Adres do pliku konfiguracyjnego.
     * @return void
     */
    private function setConfig($configFile)
    {
        if (TRUE === file_exists($configFile)) {
            $configContent = file_get_contents($configFile);
            $_config       = json_decode($configContent, TRUE);
            if (TRUE === is_array($_config)) {
                $this->_config = $_config;
            } else {
                throw new \Exception('JSON syntax error!');
            }//end if

        }//end if

    }//end setConfig()


    /**
     * Ładuje komunikaty z setMessages, dorzuca domyślne.
     *
     * Jeżeli jest potrzeba ładować z pliku lub bazy danych to w tym miejscu.
     *
     * @return void
     */
    protected function _loadMessages()
    {
        $aLocalMessages     = $this->getMessages($this->_locale, $this->_type);
        $aDefaultMessagesPL = array(
                               // Ogólne.
                               'notNull'              => 'To pole nie może być puste.',
                               'isEmail'              => 'To nie jest poprawny adres email.',
                               'isPhone'              => 'To nie jest prawidłowy numer telefonu.',
                               'minLength'            => 'Wartość jest za krótka (min. $1 znaków).',
                               'maxLength'            => 'Wartość jest za długa (max. $1 znaków).',
                               'isLt'                 => 'Wartość powinna być mniejsza niż $i.',
                               'isGt'                 => 'Wartość powinna być większa od $1.',
                               'isLe'                 => 'Wartość powinna być mniejsza lub równa niż $1.',
                               'isGe'                 => 'Wartość powinna być większa lub równa od $1.',
                               'isSex'                => 'Niewłaściwa płeć.',
                               'isPostCode'           => 'Niepoprawny kod pocztowy.',
                               'isLengthBetween'      => 'Długość powinna zawierać się pomiędzy $1 i $2 znaków.',
                               'isIn'                 => 'Nieprawidłowa wartość.',
                               'isInt'                => 'Wartość powinna zawierać liczby całkowite.',
                               'isFloat'              => 'Wartość powinna zawierać liczby rzeczywiste.',
                               'isBool'               => 'Wartość powinna zawierać wartość logiczną.',
                               'isNick'               => 'Niepoprawny nick.',
                               'inRange'              => 'Wartość powinna zawierać się w przedziale $1 i $2.',
                               'isDate'               => 'To nie jest poprawny format daty.',
                               'isNotFutureDate'      => 'Data zawiera się w nieprawidłowym zakresie.',
                               'isProperFileSize'     => 'Podany plik jest zbyt duży, maks. $2MB.',
                               'isProperFileSizeApi'  => 'Podany plik jest zbyt duży, maks. $1MB.',
                               'inOpenRange'          => 'Wartość powinna zawierać się w przedziale $1 i $2.',
                               'isFileType'           => 'Niepoprawny format pliku ($1).',
                               'csrf'                 => 'Token jest nieprawidłowy lub wygasł.',
                               'isBetween'            => 'Wartość powinna być pomiędzy $1 a $2.'
                              );
        $aDefaultMessagesEN = array(
                               // Ogólne.
                               'notNull'              => 'This field cannot be blank.',
                               'isEmail'              => 'This is not a valid e-mail address.',
                               'isPhone'              => 'This is not a valid phone number.',
                               'minLength'            => 'This value is too short (min. $1 characters).',
                               'maxLength'            => 'This value is too long (max. $1 characters).',
                               'isLt'                 => 'This value should be less than $i.',
                               'isGt'                 => 'This value should be greater than $1.',
                               'isLe'                 => 'This value should be less than or equal to $1.',
                               'isGe'                 => 'This value should be greater than or equal to $1.',
                               'isSex'                => 'Choose a valid gender.',
                               'isPostCode'           => 'This value is not a valid post-code.',
                               'isLengthBetween'      => 'This value should be between $1 and $2 characters.',
                               'isIn'                 => 'The value you selected is not a valid choice.',
                               'isInt'                => 'This value should be of type integer.',
                               'isFloat'              => 'This value should be of type float.',
                               'isBool'               => 'This value should be of type boolean.',
                               'isNick'               => 'Incorrect nick name.',
                               'inRange'              => 'Value should be between $1 and $2.',
                               'isDate'               => 'This value is not a valid date.',
                               'isNotFutureDate'      => 'Date is in illegal range.',
                               'isProperFileSize'     => 'File is too big, max. $2MB.',
                               'isProperFileSizeApi'  => 'File is too big, max. $1MB.',
                               'inOpenRange'          => 'Value should be between $1 and $2.',
                               'isFileType'           => 'This value should be of type $1.',
                               'csrf'                 => 'The token is invalid or expired.',
                              );
        $this->_defaultMessages['pl-PL'] = $aDefaultMessagesPL;
        $this->_defaultMessages['en-US'] = $aDefaultMessagesEN;
        $this->_defaultMessages['en-GB'] = $aDefaultMessagesEN;
        $this->_messages[$this->_locale] = $aLocalMessages;
    }//end _loadMessages()


    /**
     * Komunikat wyświetlający się w przypadku powodzenia.
     *
     * @return string
     */
    public function getOnSuccessInfo()
    {
        return 'Formularz został wysłany.';

    }//end getOnSuccessInfo()


    /**
     * Komunikat wyświetlający się w przypadku niepowodzenia.
     *
     * @return string
     */
    public function getOnFailInfo()
    {
        return 'Formularz nie został wysłany.';

    }//end getOnFailInfo()


    /**
     * Ustawia tablicę z zasadami walidacji.
     *
     * @return void
     */
    abstract protected function getRules();


    /**
     * Instrukcje wykonywane podczas tworzenia obiektu.
     */
    protected function init()
    {
        //
    }//end init()


    /**
     * Zwraca nazwę walidatora.
     *
     * @return string
     */
    public function getName()
    {
        //
    }


    /**
     * Ustawia komunikaty.
     *
     * Metoda może być rozszerzona w kolejnych klasach.
     *
     * @return array
     */
    public function getMessages($locale, $source='default') {
        $aMessages['pl-PL']['default'] = array();
        $aMessages['pl-PL']['api']     = array();

        return $aMessages[$locale][$source];

    }//end getMessages()

}