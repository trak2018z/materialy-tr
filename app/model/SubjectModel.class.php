<?php
/**
 * Author: Paweł Wolak 2017
 *
 */
namespace model;

class SubjectModel extends \core\BaseModel {

    /**
     * Akcja wyświetla wszystkie przedmioty
     * @param  integer $page    [description]
     * @param  integer $results [description]
     * @return [type]           [description]
     */
    public function getSubjects($page=0, $results=25)
    {
        $start = $page*$results;
        $query = "SELECT *
                  FROM Przedmiot
                  LIMIT :start, :results";
        $stm = $this->db()->prepare($query);
        $stm->bindParam(':start', $start, \PDO::PARAM_INT);
        $stm->bindParam(':results', $results, \PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetchAll(\PDO::FETCH_CLASS);
    }

    /**
     * Akcja zwraca przedmiot po id
     * @param  integer $idPrzedmiot id przedmiotu
     */
    public function getSubjectById($idPrzedmiot)
    {
        $query = "SELECT *, t1.nazwa nz
                  FROM Przedmiot t1, Uzytkownik t2
                  WHERE idPrzedmiot = :idPrzedmiot
                  AND t1.idUzytkownik = t2.idUzytkownik";
        $stm = $this->db()->prepare($query);
        $stm->bindParam(':idPrzedmiot', $idPrzedmiot, \PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetch(\PDO::FETCH_OBJ);
    }

    /**
     * Akcja zwraca przedmioty dla którego są przeznaczone przedmioty 
     * @param  integer $uzytkownik id użytkownika
     */
    public function getSubjectsForStudent($uzytkownik)
    {
        $query = "SELECT *
                  FROM Przedmiot
                  WHERE uzytkownik = :uzytkownik";
        $stm = $this->db()->prepare($query);
        $stm->bindParam(':uzytkownik', $uzytkownik, \PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetchAll(\PDO::FETCH_CLASS);
    }

    /**
     * Akcja zwraca przedmiot który stworzył użytkownik
     * @param  integer $idUzytkownik id uzytkownika
     */
    public function getSubjectsCreateBy($idUzytkownik)
    {
        $query = "SELECT *
                  FROM Przedmiot
                  WHERE idUzytkownik = :idUzytkownik";
        $stm = $this->db()->prepare($query);
        $stm->bindParam(':idUzytkownik', $idUzytkownik, \PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetchAll(\PDO::FETCH_CLASS);
    }

    /**
     * Akcja kasuję przedmiot
     * @param  integer $idPrzedmiot id przedmiotu
     */
    public function removeSubject($idPrzedmiot)
    {
        $query = "DELETE FROM Przedmiot 
                  WHERE idPrzedmiot = :idPrzedmiot";
        $stm = $this->db()->prepare($query);
        $stm->bindParam(':idPrzedmiot', $idPrzedmiot, \PDO::PARAM_INT);
        return $stm->execute();
    }
    
    /**
     * Akcja dodaje przedmiot
     * @param string $nazwa        nazwa przedmiotu
     * @param integer $uzytkownik   id uzytkownika dla kogo jest przeznaczony
     * @param string $data         data utworzenia
     * @param integer $idUzytkownik id użytkownika tworzącego
     */
    public function addNewSubject($nazwa, $uzytkownik, $data, $idUzytkownik)
    {
        $query = "INSERT INTO Przedmiot (nazwa, uzytkownik, aktualizacja, idUzytkownik)
                  VALUES (:nazwa, :uzytkownik, :data, :idUzytkownik)";
        $stm   = $this->db()->prepare($query);
        $stm->bindParam(':nazwa', $nazwa, \PDO::PARAM_STR);
        $stm->bindParam(':uzytkownik', $uzytkownik, \PDO::PARAM_INT);
        $stm->bindParam(':data', $data, \PDO::PARAM_STR);
        $stm->bindParam(':idUzytkownik', $idUzytkownik, \PDO::PARAM_INT);
        return $stm->execute();
    }

    /**
     * Akcja aktualizująca datę przedmiotu
     * @param  integer $idPrzedmiot id przedmiotu
     * @param  string $data        data przedmiotu
     */
    public function updateDateSubject($idPrzedmiot, $data)
    {
        $query = "UPDATE Przedmiot
                  SET aktualizacja = :data
                  WHERE idPrzedmiot = :idPrzedmiot";
        $stm = $this->db()->prepare($query);
        $stm->bindParam(':idPrzedmiot', $idPrzedmiot, \PDO::PARAM_INT);
        $stm->bindParam(':data', $data, \PDO::PARAM_STR);
        return $stm->execute();
    }

    /**
     * Akcja aktualizująca przedmiot
     * @param  string $nazwa       nazwa przedmiotu
     * @param  integer $idPrzedmiot id przedmiotu
     */
    public function updateSubject($nazwa, $idPrzedmiot)
    {
        $query = "UPDATE Przedmiot
                  SET nazwa = :nazwa
                  WHERE idPrzedmiot = :idPrzedmiot";
        $stm = $this->db()->prepare($query);
        $stm->bindParam(':idPrzedmiot', $idPrzedmiot, \PDO::PARAM_INT);
        $stm->bindParam(':nazwa', $nazwa, \PDO::PARAM_STR);
        return $stm->execute();
    }

}