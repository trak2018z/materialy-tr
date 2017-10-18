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

    /**
     * Akcja edytuje użytkownika
     * @param  string $idUzytkownik id użytkownika 
     * @param  string $imie         imie użytkownika
     * @param  string $nazwisko     nazwisko użytkownika
     * @param  string $typ_konta    typ konta użytkownika
     * @param  string $nazwa        nazwa użytkownika
     * @param  string $skrot        skrót użytkownika
     */
    public function updateUser($idUzytkownik, $imie, $nazwisko, $typ_konta, $nazwa, $skrot)
    {
        $query = "UPDATE Uzytkownik
                  SET imie = :imie,
                      nazwisko = :nazwisko,
                      typ_konta = :typ_konta,
                      nazwa = :nazwa,
                      skrot = :skrot
                  WHERE idUzytkownik = :idUzytkownik";
        $stm = $this->db()->prepare($query);
        $stm->bindParam(':idUzytkownik', $idUzytkownik, \PDO::PARAM_INT);
        $stm->bindParam(':imie', $imie, \PDO::PARAM_STR);
        $stm->bindParam(':nazwisko', $nazwisko, \PDO::PARAM_STR);
        $stm->bindParam(':typ_konta', $typ_konta, \PDO::PARAM_STR);
        $stm->bindParam(':nazwa', $nazwa, \PDO::PARAM_STR);
        $stm->bindParam(':skrot', $skrot, \PDO::PARAM_STR);
        return $stm->execute();
    }

    /**
     * Akcja edytuje użytkownika
     * @param  string $idUzytkownik id użytkownika 
     * @param  string $imie         imie użytkownika
     * @param  string $nazwisko     nazwisko użytkownika
     * @param  string $typ_konta    typ konta użytkownika
     * @param  string $nazwa        nazwa użytkownika
     * @param  string $skrot        skrót użytkownika
     * @param  string $haslo        hasło użytkownika
     */
    public function updateUserAndPassword($idUzytkownik, $imie, $nazwisko, $typ_konta, $nazwa, $skrot, $haslo)
    {
        $query = "UPDATE Uzytkownik
                  SET imie = :imie,
                      nazwisko = :nazwisko,
                      typ_konta = :typ_konta,
                      nazwa = :nazwa,
                      skrot = :skrot,
                      haslo = :haslo
                  WHERE idUzytkownik = :idUzytkownik";
        $stm = $this->db()->prepare($query);
        $stm->bindParam(':idUzytkownik', $idUzytkownik, \PDO::PARAM_INT);
        $stm->bindParam(':imie', $imie, \PDO::PARAM_STR);
        $stm->bindParam(':nazwisko', $nazwisko, \PDO::PARAM_STR);
        $stm->bindParam(':typ_konta', $typ_konta, \PDO::PARAM_STR);
        $stm->bindParam(':nazwa', $nazwa, \PDO::PARAM_STR);
        $stm->bindParam(':skrot', $skrot, \PDO::PARAM_STR);
        $stm->bindParam(':haslo', $haslo, \PDO::PARAM_STR);
        return $stm->execute();
    }

    /**
     * Akcja sprawdza hasła przesłane z użytkownkiem z bazy
     * @param  integer $idUzytkownik id użytkownika
     * @param  string $haslo        hasło przesłane
     * @return bool               false gdy są różne
     */
    public function checkUserPassword($idUzytkownik, $haslo)
    {
        $usersModel = new UsersModel;
        $pass = $usersModel->getUserById($idUzytkownik);

        if($this->_hash($haslo) != $pass->haslo)
        {
            return  false;
        }

        return true;
    }

    /**
     * updateUserPassword Aktualizacja hasła użytkownika
     * @param  integer $idUzytkownik Numer użytkownika
     * @param  string $haslo        Hasło użytkownika
     * @return bool               Poprawność wykonania
     */
    public function updateUserPassword($idUzytkownik, $haslo)
    {
        $query = "UPDATE Uzytkownik
                  SET haslo = :haslo
                  WHERE idUzytkownik = :idUzytkownik";
        $stm = $this->db()->prepare($query);
        $stm->bindParam(':idUzytkownik', $idUzytkownik, \PDO::PARAM_INT);
        $stm->bindParam(':haslo', $this->_hash($haslo), \PDO::PARAM_STR);
        return $stm->execute();
    }

}