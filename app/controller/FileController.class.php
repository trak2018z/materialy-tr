<?php
/**
 * Author: Paweł Wolak 2016
 *
 */

namespace controller;

use model\FileModel;

class FileController extends \core\BaseController{

    private $idPlik;
    private $nazwa;
    private $typ;
    private $sciezka;
    private $tytul;
    private $file;

    /**
     * Funkcja sprawdza czy idPlik jest liczbą
     * @param  [type]  $input [description]
     * @return boolean        [description]
     */
    public function isInteger($input){
        return ctype_digit(strval($input));
    }

    /**
     * Konstruktor inicjujący
     * @param integer $idPlik id pliku
     * @param string $nazwa  nazwa pliku
     */
    public function __construct($idPlik, $nazwa){
        $this->idPlik = $idPlik;
        $this->nazwa = $nazwa;
        if(!$this->isInteger($this->idPlik)){
            $this->redirect('/logout');
        }
    }

    /**
     * Funkcja zapisuje informacje o pliku
     */
    public function checkExists(){
        $fileModel = new FileModel;
        $this->file = $fileModel->getFileByid($this->idPlik);
    }

    /**
     * Funkcja ustawia nagłówki i otwiera plik do pobrania
     */
    public function fileDownload(){
        $this->checkExists();
        if (TRUE === empty($this->file)) {
            $this->setInfo('error', "Plik nie istnieje!");
            $this->redirect('/subject/show');
        }
        if(TRUE === empty($_SESSION['user']['idUzytkownik'])){
            $this->setInfo('error', "Musisz być zalogowany, aby pobrać plik!");
            $this->redirect('/subject/show');          
        }

        $this->typ = strstr($this->file->nazwa, '.', false);
        $this->tytul = $this->file->tytul;
        $this->sciezka = 'app/upload/'.$this->nazwa.$this->typ;

        if(!file_exists($this->sciezka)){
            $this->setInfo('error', "Plik nie został odnaleziony!");
            $this->redirect('/subject/show');
        }

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.$this->tytul.$this->typ.'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($this->sciezka));
        readfile($this->sciezka);
        exit;
    }
}

