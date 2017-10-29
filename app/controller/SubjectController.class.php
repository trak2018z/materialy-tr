<?php
/**
 * Author: Paweł Wolak 2017
 *
 */
namespace controller;

use model\SubjectModel;
use model\LeaderModel;
use model\UsersModel;
use \modules\validator\SubjectValidator;

class SubjectController extends \core\BaseController {

    /**
     * Akcja wyświetlająca wszystkie przedmioty
     */
    public function showAction()
    {
        $subjectModel = new SubjectModel;
        if($_SESSION['user']['typ_konta'] == 'teacher'){
            $subjects = $subjectModel->getSubjectsCreateBy($_SESSION['user']['idUzytkownik']);
            $leaderModel = new LeaderModel;
            $leaderSubject = $leaderModel->getLeaderByUser($_SESSION['user']['idUzytkownik']);
        }elseif($_SESSION['user']['typ_konta'] == 'student') {
            $subjects = $subjectModel->getSubjectsForStudent($_SESSION['user']['idUzytkownik']);
            $leaderSubject = array();
        }else{
            $subjects = $subjectModel->getSubjects();
        }

        $this->getView()
            ->assign('subjects', $subjects)
            ->assign('leaderSubject', $leaderSubject)
            ->assign('content', 'subject/show.html')
            ->render('layout.html');
    }

    /**
     * Akcja dodaje przedmiot
     */
    public function addAction()
    {
       if (false === empty($_POST)) {
            $oValidator = new SubjectValidator;
            if (false === $oValidator->isValid()) {
                $oValidator->saveGlobally();
                return  $this->redirect('/subject/add');
            }

            $date = date('Y-m-d H:i:s');
            $subjectModel = new SubjectModel;
            $subject = $subjectModel->addNewSubject(ucfirst($_POST['nazwa']), $_POST['uzytkownik'], $date, $_SESSION['user']['idUzytkownik']);

            if ($subject == true) {
                $this->setInfo('success', "Przedmiot został dodany!");
                $this->redirect('/subject/show');
            } else {
                $this->setInfo('error', "Przedmiot nie został dodany!");
                $this->redirect('/subject/add');
            }
        }

        SubjectValidator::appendToView($this->getView());
        
        $userModel = new UsersModel;
        $users = $userModel->getUsersByType('student');

        $this->getView()
            ->assign('users', $users)
            ->assign('content', 'subject/addSubject.html')
            ->render('layout.html');
    }
}