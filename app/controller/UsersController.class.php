<?php
/**
 * Author: Paweł Wolak 2017
 *
 */
namespace controller;

use model\UsersModel;
use \modules\validator\LoginValidator;
use \modules\validator\SettingValidator;
use \modules\validator\PasswordValidator;

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

    /**
     * Akcja aktualizuje dane
     */
    public function settingAction()
    {
        if (false === empty($_POST)) {
            $oValidator = new SettingValidator;
            if (false === $oValidator->isValid()) {
                $oValidator->saveGlobally();
                return  $this->redirect('/user/setting');
            }

            $userModel = new UsersModel;
            $user = $userModel->updateUser(
                $_SESSION['user']['idUzytkownik'],
                $_POST['imie'],
                $_POST['nazwisko'],
                $_SESSION['user']['typ_konta'],
                $_SESSION['user']['nazwa'],
                $_SESSION['user']['skrot']
            );

            if ($user == true) {
                $_SESSION['user']['imie'] = $_POST['imie'];
                $_SESSION['user']['nazwisko'] = $_POST['nazwisko'];

                $this->setInfo('success', "Profil został zaktualizowany");
                $this->redirect('/user/setting');
            } else {
                $this->setInfo('error', "Profil niezostał zaktualizowany");
                $this->redirect('/user/setting');
            }
        }

        SettingValidator::appendToView($this->getView());

        return $this->getView()
            ->assign('content', 'user/setting.html')
            ->render('layout.html');
    }

    /**
     * Akcja aktualizująca hasło
     */
    public function passwordAction()
    {

        if (false === empty($_POST)) {
            $oValidator = new PasswordValidator;
            if (false === $oValidator->isValid()) {
                $oValidator->saveGlobally();
                return  $this->redirect('/user/setting/password');
            }
            if ($_POST['nowe_haslo'] != $_POST['powtorne_haslo']) {
                $this->setInfo('error', 'Nowe hasła nie są sobie równe!');
                return  $this->redirect('/user/setting/password');
            }


            $userModel = new UsersModel;
            if ($userModel->checkUserPassword($_SESSION['user']['idUzytkownik'], $_POST['stare_haslo']) === false) {
                $this->setInfo('error', 'Podałeś nieprawidłowe hasło!');
                return  $this->redirect('/user/setting/password');
            }

            $userModel = new UsersModel;
            $user = $userModel->updateUserPassword($_SESSION['user']['idUzytkownik'], $_POST['nowe_haslo']);

            if ($user == true) {
                $this->setInfo('error', "Twoje hasło zostało zmienione!");
                $this->redirect('/user/setting');
            } else {
                $this->setInfo('error', "Twoje hasło nie zostało zmienione!");
            }
        }
        PasswordValidator::appendToView($this->getView());
        return $this->getView()
            ->assign('content', 'user/password.html')
            ->render('layout.html');
    }
}