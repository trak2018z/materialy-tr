<?php
/**
 * Author: Paweł Wolak 2016
 *
 */
namespace model;

class SubCategoryModel extends \core\BaseModel {

    /**
     * Akcja zwraca sub kategorie w zależności od przedmiotu
     * @param  integer $idPrzedmiot id przedmiotu
     */
    public function getCategoryByidPrzedmiot($idPrzedmiot)
    {
        $query = "SELECT t1.nazwa kat, t2.nazwa pod, t1.idKategoria, t2.idPodkategoria
                  FROM kategoria as t1
                  RIGHT JOIN podkategoria as t2 ON t2.idKategoria = t1.idKategoria
                  WHERE t1.idPrzedmiot = :idPrzedmiot";
        $stm = $this->db()->prepare($query);
        $stm->bindParam(':idPrzedmiot', $idPrzedmiot, \PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * Akcja zwraca subkategorie po jej id
     * @param  integer $idPodKategoria id sub kategorii
     */
    public function getSubCategoryByid($idPodKategoria)
    {
        $query = "SELECT *
                  FROM Podkategoria
                  WHERE idPodKategoria = :idPodKategoria";
        $stm = $this->db()->prepare($query);
        $stm->bindParam(':idPodKategoria', $idPodKategoria, \PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetch(\PDO::FETCH_OBJ);
    }

    /**
     * Akcja dodaje sub kategorie
     * @param string $nazwa        nazwa subkategorii 
     * @param integer $idKategoria  id kategorii
     * @param integer $idUzytkownik id użytkownika dodającego
     */
    public function addNewSubCategory($nazwa, $idKategoria, $idUzytkownik)
    {
        $query = "INSERT INTO Podkategoria (nazwa, idKategoria, idUzytkownik)
                  VALUES (:nazwa, :idKategoria, :idUzytkownik)";
        $stm   = $this->db()->prepare($query);
        $stm->bindParam(':nazwa', $nazwa, \PDO::PARAM_STR);
        $stm->bindParam(':idKategoria', $idKategoria, \PDO::PARAM_INT);
        $stm->bindParam(':idUzytkownik', $idUzytkownik, \PDO::PARAM_INT);
        return $stm->execute();
    }

    /**
     * Akcja aktualizuje subkategorie
     * @param  string $nazwa          nowa nazwa sub kategorii
     * @param  integer $idPodKategoria id subkategorii
     */
    public function editSubCategory($nazwa, $idPodKategoria)
    {
        $query = "UPDATE Podkategoria
                  SET nazwa = :nazwa
                  WHERE idPodKategoria = :idPodKategoria";
        $stm = $this->db()->prepare($query);
        $stm->bindParam(':idPodKategoria', $idPodKategoria, \PDO::PARAM_INT);
        $stm->bindParam(':nazwa', $nazwa, \PDO::PARAM_STR);
        return $stm->execute();
    }

    /**
     * Akcja kasuje subkategorie
     * @param  integer $idPodKategoria id subkategorii
     */
    public function deleteSubCategory($idPodKategoria)
    {
        $query = "DELETE FROM Podkategoria
                  WHERE idPodKategoria = :idPodKategoria";
        $stm = $this->db()->prepare($query);
        $stm->bindParam(':idPodKategoria', $idPodKategoria, \PDO::PARAM_INT);
        return $stm->execute();
    }

}