<?php
/**
 * @package    Modules
 * @subpackage Validator
 * @author     Michał Kutrzeba <kutrzeba.michal@gmail.com>
 * @copyright  Michał Kutrzeba <kutrzeba.michal@gmail.com>
 */

namespace vendor\validator;


/**
 * Klasa przechowująca metody sprawdzające pola.
 */
class Rules
{
    /**
     * Klasa walidatora.
     *
     * @var Validator
     */
    private $_validator;

    final public function setValidatorInstance(Validator $validator)
    {
        $this->_validator = $validator;
        return $this;

    }//end setFields()


    /**
     * Pobiera wartość pola.
     *
     * @param string $name Nazwa pola.
     *
     * @return mixed Wartość pola.
     */
    final protected function getField($name)
    {
        $aFields = $this->_validator->getFields();
        return $aFields[$name];

    }//end getField()


    /**
     * Pobiera wartość pola plikowego.
     *
     * @param string $name Nazwa pola.
     *
     * @return array
     */
    final protected function getFile($name)
    {
        $aFiles = $this->_validator->getFiles();
        return $aFiles[$name];

    }//end getFile()


    /**
     * Wykonuje funkcję anonimową przekazaną w parametrze przez użytkownika.
     *
     * @param  string   $testObject Sprawdzana wartość.
     * @param  function $params[0]  Defonicja funkcji.
     *
     * @return boolean
     */
    final public function _lambda($testObject, $lambdaFunction, $params)
    {
        if (!is_callable($lambdaFunction)) {
            throw new \Exception('Function '.$lambdaFunction.'() is not callable.');
        }

        return $lambdaFunction($testObject, $params);

    }//end _lambda()


    /**
     * Zamienia wartość na wartość float.
     *
     * @param mixed
     *
     * @return float
     **/
    function toFloat($var)
    {
        return (float)str_replace(array(' ', ',',), array('', '.'), $var);

    }//end toFloat()


    /**
     *
     * @param string $testObject Testowana wartość.
     * @param array $params Parametry według których sprawdzana zostanie wartość,
     *                           [0] => integer  minimalna długość,
     *                           [1] => integer  maksymalna długość.
     * @return bool
     */
    public function isLengthBetween($testObject, array $params)
    {
        $iStrlen = strlen($testObject);
        if ($params[0] > $iStrlen || $params[1] < $iStrlen) {
            return FALSE;

        }//end if

        return TRUE;

    }//end isLengthBetween


    /**
     *
     * @param string $testObject Testowana wartość.
     * @param array $params Parametry według których sprawdzana zostanie wartość,
     *                           [0] => integer  minimalna długość,
     *                           [1] => integer  maksymalna długość.
     * @return bool
     */
    public function isBetween($testObject, array $params)
    {
        $testObject = (float) $testObject;
        if ($params[0] > $testObject || $params[1] < $testObject) {
            return false;

        }//end if

        return true;

    }//end isLengthBetween


    /**
     * Sprawdza czy wartość znajduje się w tablicy.
     *
     * @param string $testObject Testowana wartość.
     * @param array $params Parametry według których sprawdzana zostanie wartość,
     *                           [0] => array  tablica wartości, w którym może zawierać się wartość.
     * @return bool
     */
    public function isIn($testObject, array $params)
    {
        if (TRUE === in_array($testObject, $params[0])) {
            return TRUE;

        }//end if

        return FALSE;

    }//end isIn


    /**
     * Sprawdza czy wartość jest typu integer.
     *
     * @param string $testObject Badana wartość.
     *
     * @return bool
     */
    public function isInt($testObject)
    {
        return (bool) preg_match('/^([0-9]+)$/', $testObject);

    }//end isInt()


    /**
     * Sprawdza czy dana wartość jest typu float.
     *
     * @param string $testObject Badana wartość.
     *
     * @return bool
     */
    public function isFloat($testObject)
    {
        return (bool) preg_match('/^([0-9]*)\.{0,1}([0-9]*)$/', $testObject);

    }//end isFloat()


    /**
     * Sprawdza czy to wartość typu boolowskiego.
     *
     * @param string $testObject Badana wartość.
     *
     * @return bool
     */
    public function isBool($testObject)
    {
        return is_bool($testObject);
    }//end isFloat()


    /**
     * Sprawdza czy podany email jest prawidłowy.
     *
     * @param  string $testObject
     * @return bool
     */
    public function isEmail($testObject)
    {
        $testObject = strtolower($testObject);
        // Preg match na podstawie RFC
        $reg = "/^[a-zA-Z0-9.!#$%&'*+\/\=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/";

        if (preg_match($reg, $testObject, $aMatch) === 1) {
            return TRUE;

        } else {
            return FALSE;
        }

    }//end isEmail()


    /**
     * Sprawdza czy podany numer telefonu jest prawidłowy.
     *
     * @param  string $testObject
     * @return bool
     */
    public function isPhone($testObject)
    {
        return (0 < preg_match('/^[\(\)\-\ \+0-9]{7,17}$/', $testObject)) ? TRUE : FALSE;

    }//end isPhone()


    /**
     * Sprawdza czy dane pole może być nickiem.
     * @param $testObject
     * @return bool
     */
    public function isNick($testObject)
    {
        return (0 < preg_match('/^[A-Za-z0-9\-\.]*$/', $testObject)) ? TRUE : FALSE;

    }//end isNick


    /**
     * Sprawdza czy tekst nie jest mniejszy niż wartość dozwolona.
     *
     * @param  string  $testObject Badany tekst
     * @param  array   $params     Parametry według których sprawdzana jest wartość,
     *                             [0] => integer  minimalna długość.
     *
     * @return void
     */
    public function minLength($testObject, array $params)
    {
        return strlen($testObject) < $params[0] ? FALSE : TRUE;

    }//end minLength


    /**
     * Sprawdza czy poprawna została podana płeć [M, F, N]
     *
     * @param $testObject
     * @return bool
     */
    public function isSex($testObject)
    {
        if ($testObject !== 'M' && $testObject !== 'F' && $testObject !== 'N') {
            return FALSE;

        } else {
            return TRUE;

        }//end if

    }//end isSex()


    /**
     * Sprawdza czy tekst nie jest większy niż wartość dozwolona.
     *
     * @param  string $testObject Badany tekst
     * @param  array $params Parametry według których sprawdzana jest wartość,
     *                       [0] => integer  maksymalna długość.
     *
     * @return bool
     */
    public function maxLength($testObject, array $params)
    {
        return strlen($testObject) > $params[0] ? FALSE : TRUE;//end if

    }//end maxLength()


    /**
     * Sprawdza czy wartość nie jest pusta.
     *
     * @param string $testObject Testowana wartość.
     *
     * @return bool
     */
    public function notNull($testObject)
    {
        return !empty($testObject);

    }//end notNull()


    /**
     * Sprawdza czy wartość znajduje się w danym przedziale.
     *
     * @param  integer $testObject Sprawdzana wartość.
     * @param  array $params Tablica zawierająca dwa elementy, kolejno:
     *                             [0] => integer  wartość minimalna,
     *                             [1] => wartość maksymalna.
     *
     * @return bool
     */
    public function inRange($testObject, array $params)
    {
        if ($params[0] > $testObject || $params[1] < $testObject) {
            return FALSE;

        } else {
            return TRUE;

        }//end if

    }//end inRange()


    /**
     * Sprawdza czy wartość znajduje się w danym przedziale z wykluczeniem podanych wartości.
     *
     * @param  int $testObject Sprawdzana wartość.
     * @param  array $params Tablica zawierająca dwa elementy, kolejno:
     *                             [0] => integer  wartość minimalna,
     *                             [1] => wartość maksymalna.
     *
     * @return bool
     */
    public function inOpenRange($testObject, array $params)
    {
        if ($params[0] >= $testObject || $params[1] <= $testObject) {
            return FALSE;

        } else {
            return TRUE;

        }//end if

    }//end inOpenRange()


    /**
     * Sprawdza czy wartość jest poprawnie wprowadzoną datą.
     *
     * @param string $testObject Testowana wartość.
     * @param array $params     Tablica zawierająca jeden element - format daty.
     *
     * @return bool
     */
    public function isDate($testObject, array $params)
    {
        if (TRUE === empty($params)) {
            $params[0] = 'Y-m-d';
        }//end if

        try {
            $aDate = \DateTime::createFromFormat($params[0], $testObject);
            if (FALSE === $aDate) {
                return FALSE;

            }//end if

        } catch (\Exception $e) {
            return FALSE;

        }//end try

        return TRUE;

    }//end isDate


    /**
     * Sprawdza czy data jest w normalnym przedziale (nie jest z przyszłości).
     *
     * @param string $testObject Testowana wartość.
     * @param array $params     Tablica zawierająca jeden element - format daty.
     *
     * @return bool
     */
    public function isNotFutureDate($testObject, array $params)
    {
        if (TRUE === empty($params)) {
            $params[0] = 'Y-m-d';
        }//end if

        try {
            $oDate  = \DateTime::createFromFormat($params[0], $testObject);
            if (TRUE === isset($params[1])) {
                $oDate->add(new \DateInterval($params[1]));
            }//end if

            $oToday = new \DateTime();
            $oToday->format($params[0]);
            if (FALSE === $oDate) {
                return FALSE;

            } else if ($oDate > $oToday) {
                return FALSE;

            }//end if

        } catch (\Exception $e) {
            return FALSE;

        }//end try

        return TRUE;

    }//end if


    /**
     * Sprawdza czy plik nie jest za duży, informacje o pliku z tablicy $_POST.
     *
     * @param  string  $testObject Ścieżka do pliku.
     * @param  integer $params     [0] Maksymalny dopuszczalny rozmiar pliku w MB.
     *
     * @return bool
     */
    public function isProperFileSize($testObject, array $params)
    {
        //var_dump($testObject, $params);
        foreach ($testObject[$params[0]] AS $var => $val) {
            $fFileSize = filesize(__DIR__ . '/../..' . AssetsModel::TMP_PATH . $val['Path']);
            if ($params[1] * 1024 * 1024 < $fFileSize) {
                return FALSE;

            }//end if

            return TRUE;

        }//end foreach

    }//end


    /**
     * Sprawdza czy plik nie jest za duży, informacje o pliku z tablicy $_FILES.
     *
     * @param  string  $testObject Ścieżka do pliku.
     * @param  integer $params     [0] Maksymalny dopuszczalny rozmiar pliku w MB.
     *
     * @return bool
     */
    public function isProperFileSizeApi($testObject, array $params)
    {
        if ($params[0] * 1024 * 1024 < $testObject['size']) {
            return FALSE;

        }//end if

        return TRUE;

    }//end isProperFileSizeApi()


    /**
     * Sprawdza czy tekst jest kodem pocztowym.
     *
     * @param string $testObject Kod pocztowy.
     *
     * @return bool
     */
    public function isPostCode($testObject)
    {
        $bIsMatch = preg_match('/^[0-9]{2}-[0-9]{3}$/', $testObject);
        if (TRUE === empty($bIsMatch)) {
            return FALSE;

        }//end if

        return TRUE;

    }//end isPostCode()


    /**
     * Odpowiednik funkcji mniejsze-równe.
     *
     * @param string $testObject Sprawdzana wartość.
     * @param array  $params integer [0] Porównywalna wartość.
     *
     * @return bool
     */
    public function isLt($testObject, array $params)
    {
        $testObject = $this->toFloat($testObject);
        if ($testObject < $params[0]) {
            return TRUE;

        }//end if

        return FALSE;

    }//end isLt()


    /**
     * Odpowiednik funkcji mniejsze-równe.
     *
     * @param string $testObject Sprawdzana wartość.
     * @param array $params (integer) $params[0] Porównywalna wartość.
     *
     * @return bool
     */
    public function isGt($testObject, array $params)
    {
        $testObject = $this->toFloat($testObject);
        if ($testObject > $params[0]) {
            return TRUE;

        }//end if

        return FALSE;

    }//end isGt()


    /**
     * Odpowiednik funkcji mniejsze-równe.
     *
     * @param string $testObject Sprawdzana wartość.
     * @param array $params, (integer) $params[0] Porównywalna wartość.
     *
     * @return bool
     */
    public function isGe($testObject, array $params)
    {
        $testObject = $this->toFloat($testObject);
        if ($testObject >= $params[0]) {
            return TRUE;

        }//end if

        return FALSE;

    }//end isGe()


    /**
     * Odpowiednik funkcji mniejsze-równe.
     *
     * @param string $testObject Sprawdzana wartość.
     * @param  array $params, (integer) $params[0] Porównywalna wartość.
     *
     * @return bool
     */
    public function isLe($testObject, array $params)
    {
        $testObject = $this->toFloat($testObject);
        if ($testObject <= $params[0]) {
            return TRUE;

        }//end if

        return FALSE;

    }//end isLe()


    /**
     * Sprawdza czy token csrf jest poprawny.
     *
     * @param string  $testObject Sprawdzana wartość.
     * @param integer [0] Nazwa tokenu.
     *
     * @return boolean
     */
    public function csrf($csrfToken, array $params)
    {
        $name    = $params[0];
        $session = Session::getInstance();

        $tokens = $session->getData('csrfTokens');
        if ($csrfToken === $tokens[$name]) {
            unset($tokens[$name]);
            $session->setData('csrfTokens', $tokens);
            return TRUE;

        } else {
            return FALSE;

        }//end if

    }//end csrf()
}