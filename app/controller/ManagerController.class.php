<?php
/**
 * Author: Paweł Wolak 2017
 *
 */
namespace controller;

use model\UsersModel;
use \modules\validator\ManagerValidator;

class ManagerController extends \core\BaseController {

    /**
     * Akcja wyświetlająca wszystkich użytkoników
     */
    public function viewAction()
    {
        
        $usersModel = new UsersModel;
        $users = $usersModel->getUsers();

        $this->getView()
            ->assign('users', $users)
            ->assign('content', 'manager/view.html')
            ->render('layout.html');
    }

    /**
     * Akcja pozwalająca edytować użytkownika
     * @param  integer $id idUzytkownika
     */
    public function editAction($id)
    {
        if (FALSE === empty($_POST)) {
            $oValidator = new ManagerValidator;
            if (false === $oValidator->isValid()) {
                $oValidator->saveGlobally();
                return $this->redirect('/manager/'.$id.'/edit');
            }

            $userModel = new UsersModel;

            if($_POST['haslo'] != '')
                $user = $userModel->updateUserAndPassword($id, $_POST['imie'], $_POST['nazwisko'], $_POST['typ_konta'], 
                                           $_POST['nazwa'], $_POST['skrot'], $_POST['haslo']);
            else
                $user = $userModel->updateUser($id, $_POST['imie'], $_POST['nazwisko'], $_POST['typ_konta'], 
                                           $_POST['nazwa'], $_POST['skrot']);

            if($user == true) {
                $this->setInfo('success', "Użytkownik został zaktualizowany");
                $this->redirect('/manager/'.$id.'/edit');
            } else {
                $this->setInfo('error', "Użytkownik niezostał zaktualizowany");
                $this->redirect('/manager/'.$id.'/edit');
            }
        }

        $userModel = new UsersModel;
        $user = $userModel->getUserById($id);

        if(!is_numeric($id) || $user < 1){
            $this->setInfo('error', "Użytownik niezostał odnaleziony");
            $this->redirect('/manager/view');
        }

        ManagerValidator::appendToView($this->getView());

        return $this->getView()
            ->assign('usr', $user)
            ->assign('content', 'manager/edit.html')
            ->render('layout.html');
    }

}