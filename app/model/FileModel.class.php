<?php
/**
 * Author: Paweł Wolak 2016
 *
 */
namespace model;

class FileModel extends \core\BaseModel {

    /**
     * Akcja dodaje plik
     * @param string $nazwa          nazwa pliku
     * @param string $tytul          tytuł pliku
     * @param string $data           data dodania pliku
     * @param integer $idUzytkownik   id użytkownika
     * @param integer $idPodKategoria id pod kategorii
     */
    public function addFile($nazwa, $tytul, $data, $idUzytkownik, $idPodKategoria)
    {
        $query = "INSERT INTO Plik (nazwa, tytul, data, idUzytkownik, idPodKategoria)
                  VALUES (:nazwa, :tytul, :data, :idUzytkownik, :idPodKategoria)";
        $stm   = $this->db()->prepare($query);
        $stm->bindParam(':nazwa', $nazwa, \PDO::PARAM_STR);
        $stm->bindParam(':tytul', $tytul, \PDO::PARAM_STR);
        $stm->bindParam(':data', $data, \PDO::PARAM_STR);
        $stm->bindParam(':idUzytkownik', $idUzytkownik, \PDO::PARAM_INT);
        $stm->bindParam(':idPodKategoria', $idPodKategoria, \PDO::PARAM_INT);
        return $stm->execute();
    }

    /**
     * Akcja kasuje pliku
     * @param  integer $idPlik id pliku
     */
    public function deleteFile($idPlik)
    {
        $query = "DELETE FROM Plik
                  WHERE idPlik = :idPlik";
        $stm = $this->db()->prepare($query);
        $stm->bindParam(':idPlik', $idPlik, \PDO::PARAM_INT);
        return $stm->execute();
    }

    /**
     * Akcja sprawdza czy plik istnieje
     * @param  integer $idPlik id pliku
     */
    public function getFileByid($idPlik)
    {
        $query = "SELECT *
                  FROM Plik
                  WHERE idPlik = :idPlik";
        $stm = $this->db()->prepare($query);
        $stm->bindParam(':idPlik', $idPlik, \PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetch(\PDO::FETCH_OBJ);
    }

}