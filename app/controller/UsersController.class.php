<?php
/**
 * Author: Paweł Wolak 2017
 *
 */
namespace controller;

use model\UsersModel;
use \modules\validator\LoginValidator;

class UsersController extends \core\BaseController
{
    /**
     *
     */
    public function init()
    {
        parent::init();
    }


    /**
     * Akcja wyświetlająca i obsługująca formularz logowania.
     */
    public function loginAction()
    {
        if (!empty($_SESSION['user']['idUzytkownik'])) {
            return $this->redirect('/home');

        }

        if (false === empty($_POST)) {
            $oValidator = new LoginValidator;
            if (false === $oValidator->isValid()) {
                $oValidator->saveGlobally();
                return $this->redirect('/login');
            }
            $usersModel = new UsersModel;
            $user = $usersModel->checkUser($_POST['login'], $_POST['haslo']);
            if (false != $user) {
                if($user['typ_konta'] == 'teacher' || $user['typ_konta'] == 'admin'){
                    $_SESSION['user']['imie'] = $user['imie'];
                    $_SESSION['user']['nazwisko'] = $user['nazwisko'];
                }else{
                    $_SESSION['user']['skrot'] = $user['skrot'];
                    $_SESSION['user']['nazwa'] = $user['nazwa'];
                }
                $_SESSION['user']['idUzytkownik'] = $user['idUzytkownik'];
                $_SESSION['user']['typ_konta'] = $user['typ_konta'];
                $_SESSION['user']['login'] = $user['login'];
                return $this->redirect('/home');
            } else {
                $this->setInfo('error', 'Wpisałeś nieprawidłowe dane.');
                return $this->redirect('/login');
            }
        }
        
        LoginValidator::appendToView($this->getView());
        return $this->getView()
           ->assign('content', 'user/login.html')
           ->render('layout.html');

    }

    /**
     * Wykonuje akcje wylogowywania.
     */
    public function logoutAction()
    {
        unset($_SESSION['user']);
        return $this->redirect('/home');

    }
}