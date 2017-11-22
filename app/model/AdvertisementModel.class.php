<?php
/**
 * Author: Paweł Wolak 2016
 *
 */
namespace model;

class AdvertisementModel extends \core\BaseModel {

    /**
     * [getAdvertisementsByIdPrzedmiot description]
     * @param  integer $idPrzedmiot id przedmiotu
     */
    public function getAdvertisementsByIdPrzedmiot($idPrzedmiot)
    {
        $query = "SELECT *
                  FROM Ogloszenia
                  WHERE idPrzedmiot = :idPrzedmiot
                  ORDER BY data DESC";
        $stm = $this->db()->prepare($query);
        $stm->bindParam(':idPrzedmiot', $idPrzedmiot, \PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetchAll(\PDO::FETCH_CLASS);
    }

    /**
     * Akcja sprawdza czy ogłoszenia istnieje
     * @param  integer $idOgloszenia id ogłoszenia
     */
    public function getAdvertisementsById($idOgloszenia)
    {
        $query = "SELECT *
                  FROM Ogloszenia
                  WHERE idOgloszenia = :idOgloszenia";
        $stm = $this->db()->prepare($query);
        $stm->bindParam(':idOgloszenia', $idOgloszenia, \PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Akcja dodaje ogłoszenie
     * @param string $tytul        tytuł ogłoszenia
     * @param string $tresc        treść ogłoszenia
     * @param string $data         data dodania ogłoszenia
     * @param integer $idPrzedmiot  id przedmiotu
     * @param integer $idUzytkownik id użytkownika dodającego
     */
    public function addNewAdvertisement($tytul, $tresc, $data, $idPrzedmiot, $idUzytkownik)
    {
        $query = "INSERT INTO Ogloszenia (tytul, tresc, data, idPrzedmiot, idUzytkownik)
                  VALUES (:tytul, :tresc, :data, :idPrzedmiot, :idUzytkownik)";
        $stm = $this->db()->prepare($query);
        $stm->bindParam(':tytul', $tytul, \PDO::PARAM_STR);
        $stm->bindParam(':tresc', $tresc, \PDO::PARAM_STR);
        $stm->bindParam(':data', $data, \PDO::PARAM_STR);
        $stm->bindParam(':idPrzedmiot', $idPrzedmiot, \PDO::PARAM_INT);
        $stm->bindParam(':idUzytkownik', $idUzytkownik, \PDO::PARAM_INT);
        return $stm->execute();
    }

    /**
     * Akcja kasuje ogłoszenia
     * @param  integer $idOgloszenia id ogłoszenia
     */
    public function deleteAdvertisement($idOgloszenia)
    {
        $query = "DELETE FROM Ogloszenia 
                  WHERE idOgloszenia = :idOgloszenia";
        $stm = $this->db()->prepare($query);
        $stm->bindParam(':idOgloszenia', $idOgloszenia, \PDO::PARAM_INT);
        return $stm->execute();
    }

}