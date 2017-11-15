<?php
/**
 * Author: Paweł Wolak 2016
 *
 */
namespace model;

class LeaderModel extends \core\BaseModel {

    /**
     * Akcja zwraca prowadzących przedmiot
     * @param  integer $idPrzedmiot id przedmiotu
     */
    public function getLeaderBySubject($idPrzedmiot)
    {
        $query = "SELECT *
                  FROM Prowadzacy t1, Uzytkownik t2
                  WHERE idPrzedmiot = :idPrzedmiot
                  AND t1.idUzytkownik = t2.idUzytkownik";
        $stm = $this->db()->prepare($query);
        $stm->bindParam(':idPrzedmiot', $idPrzedmiot, \PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetchAll(\PDO::FETCH_CLASS);
    }

    /**
     * Akcja zwraca wszystkie przedmioty które użytkownik prowadzi
     * @param  integer $idUzytkownik id użytkownika
     */
    public function getLeaderByUser($idUzytkownik)
    {
        $query = "SELECT *
                  FROM Prowadzacy t1, Przedmiot t2
                  WHERE t1.idUzytkownik = :idUzytkownik
                  AND t1.idPrzedmiot = t2.idPrzedmiot";
        $stm = $this->db()->prepare($query);
        $stm->bindParam(':idUzytkownik', $idUzytkownik, \PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetchAll(\PDO::FETCH_CLASS);
    }

    /**
     * Akcja zwraca rekord czli sprawdza czy jest prowadzącym przedmiot
     * @param  integer $idPrzedmiot  id przedmiotu
     * @param  integer $idUzytkownik id użytkownika
     */
    public function getLeaderByPrzedmiotAndUzytkownik($idPrzedmiot, $idUzytkownik)
    {
        $query = "SELECT *
                  FROM Prowadzacy
                  WHERE idPrzedmiot = :idPrzedmiot
                  AND idUzytkownik = :idUzytkownik";
        $stm = $this->db()->prepare($query);
        $stm->bindParam(':idPrzedmiot', $idPrzedmiot, \PDO::PARAM_INT);
        $stm->bindParam(':idUzytkownik', $idUzytkownik, \PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Akcja dodaje nowego prowadzącego do przedmiotu
     * @param integer $idPrzedmiot  id przedmiotu
     * @param integer $idUzytkownik id użytkownika
     */
    public function addNewLeader($idPrzedmiot, $idUzytkownik)
    {
        $query = "INSERT INTO Prowadzacy (idPrzedmiot, idUzytkownik)
                  VALUES (:idPrzedmiot, :idUzytkownik)";
        $stm   = $this->db()->prepare($query);
        $stm->bindParam(':idPrzedmiot', $idPrzedmiot, \PDO::PARAM_INT);
        $stm->bindParam(':idUzytkownik', $idUzytkownik, \PDO::PARAM_INT);
        return $stm->execute();
    }

    /**
     * Akcja kasuje prowodzącego z przedmiotu
     * @param  integer $idPrzedmiot  id przedmiotu
     * @param  integer $idUzytkownik id użytkownika
     */
    public function deleteLeader($idPrzedmiot, $idUzytkownik)
    {
        $query = "DELETE FROM Prowadzacy 
                  WHERE idPrzedmiot = :idPrzedmiot
                  AND idUzytkownik = :idUzytkownik";
        $stm = $this->db()->prepare($query);
        $stm->bindParam(':idPrzedmiot', $idPrzedmiot, \PDO::PARAM_INT);
        $stm->bindParam(':idUzytkownik', $idUzytkownik, \PDO::PARAM_INT);
        return $stm->execute();
    }

    
}