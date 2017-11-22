<?php
/**
 * Author: Paweł Wolak 2016
 *
 */
namespace controller;

class UploadFile {

    private $_error;
    private $fileName;
    private $size;
    private $maxFileSize = 52428800; //50MB
    private $path;
    private $xyz;
    private $extension;

    public function __construct(){}


    /**
     * Ustawia ścieżkę do pliku
     * 
     * @param string  $path [description]
     * @param integer $id   [description]
     * @param integer $id2  [description]
     */
    public function setPath($path){
        $this->path = $path;

    }


    /**
     * Zwraca maksymalny rozmiar pliku.
     * 
     * @return integer
     */
    public function getMaxFileSize()
    {
        return $this->maxFileSize;

    }


    /**
     * Przerzuca plik do kataogu z assetami.
     * 
     * @param string $form
     *
     * @return string
     *
     * @throws \Exception Jeśli napotka błędy z uploadem.
     */
    public function uploadAction($form)
    {    
        if ($_FILES[$form]['error'] !== UPLOAD_ERR_OK){
            throw new \Exception('Wystąpił problem z uploadem pliku.');
        }
        
        $this->fileName = md5($_FILES[$form]["name"].time().mt_rand());
        $this->extension = substr($_FILES[$form]["name"],strrpos($_FILES[$form]["name"], ".")+1);
        
        if ($_FILES[$form]['size'] > $this->getMaxFileSize()) {
            throw new \Exception('Plik jest za duży.');
        }
        
        if (!file_exists($this->path)) {
            if(!mkdir($this->path, 0755)){
                throw new \Exception('Wystąpił problem tworzeniem katalogu!');
            }
        }

        $this->path = $this->path.'/'.$this->fileName.'.'.$this->extension;

        if (move_uploaded_file($_FILES[$form]['tmp_name'], $this->path)) {
            return $this->fileName.'.'.$this->extension;
        } else {
            throw new \Exception('Wystąpił problem z kopiowaniem pliku.');
        }

    }

}

