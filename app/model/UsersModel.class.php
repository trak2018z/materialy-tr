<?php
/**
 * Author: Paweł Wolak 2017
 *
 */
namespace model;

class UsersModel extends \core\BaseModel {

    /**
     * $SALT Sól potrzebna do stworzenia hasła
     * @var string
     */
    static public $SALT = '';
    
    /**
     * getUsers Pobiera wszystkich użytkowników z bazy
     * @param  integer $page    Numer strony
     * @param  integer $results Ilość elementów na stronie
     */
    public function getUsers($page=0, $results=25)
    {
        $start = $page*$results;
        $query = "SELECT *
                  FROM Uzytkownik 
                  ORDER BY typ_konta";
        $stm = $this->db()->prepare($query);
        $stm->bindParam(':start', $start, \PDO::PARAM_INT);
        $stm->bindParam(':results', $results, \PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetchAll(\PDO::FETCH_CLASS);
    }

    /**
     * Akcja sprawdza użytkownika czy istnieje w bazie
     * @param  string $login login uzytkownika
     * @param  string $pass  haslo uzytkownika
     */
    public function checkUser($login, $pass)
    {
        $query = "SELECT *
                  FROM Uzytkownik
                  WHERE login = :login and haslo = :haslo";
        $stm = $this->db()->prepare($query);
        $stm->bindParam(':login', $login, \PDO::PARAM_STR);
        $stm->bindParam(':haslo', $this->_hash($pass), \PDO::PARAM_STR); 
        $stm->execute();
        return $stm->fetch(\PDO::FETCH_ASSOC);

    }

    /**
     * Akcja zwraca uzytkowników po typie
     * @param  string $typ typ konta
     */
    public function getUsersByType($typ)
    {
        $query = "SELECT *
                  FROM Uzytkownik
                  WHERE typ_konta = :typ_konta";
        $stm = $this->db()->prepare($query);
        $stm->bindParam(':typ_konta', $typ, \PDO::PARAM_STR);
        $stm->execute();
        return $stm->fetchAll(\PDO::FETCH_CLASS);
    }

    /**
     * Akcja zwraca użytkownika po loginie
     * @param  string $login login użytkownika
     */
    public function getUserByLogin($login)
    {
        $query = "SELECT *
                  FROM Uzytkownik
                  WHERE login = :login";
        $stm = $this->db()->prepare($query);
        $stm->bindParam(':login', $login, \PDO::PARAM_STR);
        $stm->execute();
        $stm->fetch(\PDO::FETCH_OBJ);
    }

    /**
     * getUserById Zwraca objekt użytkownika po idUżytkownika
     * @param  integer $id idUżytkownika szukanego
     * @return object     pojedynczy rekord w postaci obiektu
     */
    public function getUserById($id)
    {
        $query = "SELECT *
                  FROM Uzytkownik
                  WHERE idUzytkownik = :idUzytkownik";
        $stm = $this->db()->prepare($query);
        $stm->bindParam(':idUzytkownik', $id, \PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetch(\PDO::FETCH_OBJ);
    }

    /**
     * _hash Tworzymy hash z hasła
     * @param  string $plain Do hasowania
     * @return string        Po shasowaniu
     */
    private function _hash($plain)
    {
        return md5($plain.self::$SALT);
    }
}