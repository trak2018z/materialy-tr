<?php
/**
 * Author: Paweł Wolak 2016
 *
 */
namespace model;

class CategoryModel extends \core\BaseModel {

    /**
     * Akcja zwraca wszystkie kategorie przedmiotu
     * @param  integer $idPrzedmiot id przemiotu
     */
    public function getCategoryByidPrzedmiot($idPrzedmiot)
    {
        $query = "SELECT t1.nazwa kat, t2.nazwa pod, t1.idKategoria, t2.idPodkategoria, t3.nazwa nz, t3.tytul, t3.idPlik
                  FROM Kategoria as t1
                  LEFT JOIN Podkategoria as t2 ON t2.idKategoria = t1.idKategoria
                  LEFT JOIN Plik as t3 ON t3.idPodkategoria = t2.idpodkategoria
                  WHERE t1.idPrzedmiot = :idPrzedmiot
                  ORDER BY t1.idKategoria, t2.idPodkategoria";
       
        $stm = $this->db()->prepare($query);
        $stm->bindParam(':idPrzedmiot', $idPrzedmiot, \PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * Akcja sprawdza czy kategoria istnieje
     * @param  integer $idKategoria id kategorii
     */
    public function getCategoryByid($idKategoria)
    {
        $query = "SELECT *
                  FROM Kategoria
                  WHERE idKategoria = :idKategoria";
        $stm = $this->db()->prepare($query);
        $stm->bindParam(':idKategoria', $idKategoria, \PDO::PARAM_INT);
        $stm->execute();
        return $stm->fetch(\PDO::FETCH_OBJ);
    }

    /**
     * Akcja dodająca kategorie
     * @param string $nazwa        nazwa kategorii 
     * @param integer $idPrzedmiot  id przedmiotu
     * @param integer $idUzytkownik id użytkownika
     */
    public function addNewCategory($nazwa, $idPrzedmiot, $idUzytkownik)
    {
        $query = "INSERT INTO Kategoria (nazwa, idPrzedmiot, idUzytkownik)
                  VALUES (:nazwa, :idPrzedmiot, :idUzytkownik)";
        $stm   = $this->db()->prepare($query);
        $stm->bindParam(':nazwa', $nazwa, \PDO::PARAM_STR);
        $stm->bindParam(':idPrzedmiot', $idPrzedmiot, \PDO::PARAM_INT);
        $stm->bindParam(':idUzytkownik', $idUzytkownik, \PDO::PARAM_INT);
        return $stm->execute();
    }

    /**
     * Akcja aktualizująca kategorie
     * @param  string $nazwa       nowa nazwa
     * @param  integer $idKategoria id kategorii
     */
    public function editCategory($nazwa, $idKategoria)
    {
        $query = "UPDATE Kategoria
                  SET nazwa = :nazwa
                  WHERE idKategoria = :idKategoria";
        $stm = $this->db()->prepare($query);
        $stm->bindParam(':idKategoria', $idKategoria, \PDO::PARAM_INT);
        $stm->bindParam(':nazwa', $nazwa, \PDO::PARAM_STR);
        return $stm->execute();
    }

    /**
     * Akcja kasuje kategorie
     * @param  integer $idKategoria id kategorii
     */
    public function deleteCategory($idKategoria)
    {
        $query = "DELETE FROM Kategoria
                  WHERE idKategoria = :idKategoria";
        $stm = $this->db()->prepare($query);
        $stm->bindParam(':idKategoria', $idKategoria, \PDO::PARAM_INT);
        return $stm->execute();
    }

}