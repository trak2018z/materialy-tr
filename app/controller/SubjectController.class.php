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
use \modules\validator\DeleteSubjectValidator;
use \modules\validator\LeaderValidator;

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

    /**
     * Akcja wyświetla wszystkie informacje o przedmiocie
     * @param  integer $id idPrzedmiotu
     */
    public function viewAction($id)
    {
        $subjectModel = new SubjectModel;
        $subject = $subjectModel->getSubjectById($id);
      
        if (TRUE === empty($subject)) {
            $this->setInfo('error', "Przedmiot nie został odnaleziony");
            $this->redirect('/subject/show');
        }

        $leaderModel = new LeaderModel;
        $leader = $leaderModel->getLeaderByPrzedmiotAndUzytkownik($id, $_SESSION['user']['idUzytkownik']);

        if (TRUE === empty($leader)) {
            if($subject->idUzytkownik != $_SESSION['user']['idUzytkownik']){
                if($subject->uzytkownik != $_SESSION['user']['idUzytkownik']){
                    if($_SESSION['user']['typ_konta'] != 'admin'){
                        $this->setInfo('error', "Nie możesz przeglądać tego przedmiotu!");
                        $this->redirect('/subject/show');
                    }
                }
            }
        }
           
        $userModel = new UsersModel;
        $usr = $userModel->getUserById($subject->uzytkownik);

        $leaderModel = new LeaderModel;
        $leaders = $leaderModel->getLeaderBySubject($id);

        $this->getView()
            ->assign('leaders', $leaders)
            ->assign('usr', $usr)
            ->assign('id', $id)
            ->assign('subject', $subject)
            ->assign('content', 'subject/view.html')
            ->render('layout.html');
    }

    /**
     * Akcja kasuje przedmiot 
     * @param  integer $id id kasowanego przedmiotu
     * @return [type]     [description]
     */
    public function deleteAction($id)
    {
        $subjectModel = new SubjectModel;
        $subject = $subjectModel->getSubjectById($id);

        if (TRUE === empty($subject)) {
            $this->setInfo('error', "Przedmiot nie został odnaleziony!");
            $this->redirect('/subject/show');
        }

        if($subject->idUzytkownik != $_SESSION['user']['idUzytkownik']){
            $this->setInfo('error', "Nie posiadasz praw do kasowania przedmiotu!");
            $this->redirect('/subject/'.$id.'/view');
        }

        if (FALSE === empty($_POST)) {
            $oValidator = new DeleteSubjectValidator;
            if (false === $oValidator->isValid()) {
                $oValidator->saveGlobally();
                return $this->redirect('/subject/'.$id.'/view');
            }

            $subjectModel = new SubjectModel;
            $subject = $subjectModel->removeSubject($id);

            if($subject == true) {
                $this->setInfo('success', "Przedmiot został skasowany!");
                $this->redirect('/subject/show');
            } else {
                $this->setInfo('error', "Przedmiot nie został skasowany!");
                $this->redirect('/subject/'.$id.'/view');
            }
        }
    }

    /**
     * Potwierdzenie usunięcia przedmiotu
     * @param  integer $id id kasowanego przedmiotu
     * @return [type]     [description]
     */
    public function confirmAction($id)
    {
        $subjectModel = new SubjectModel;
        $subject = $subjectModel->getSubjectById($id);

        if (TRUE === empty($subject)) {
            $this->setInfo('error', "Przedmiot nie został odnaleziony!");
            $this->redirect('/subject/show');
        }

        if($subject->idUzytkownik != $_SESSION['user']['idUzytkownik']){
            $this->setInfo('error', "Nie posiadasz praw do kasowania przedmiotu!");
            $this->redirect('/subject/'.$id.'/view');
        }

        $this->getView()
            ->assign('subject', $subject)
            ->assign('id', $id)
            ->assign('content', 'subject/confirmDelete.html')
            ->render('layout.html');
    }

    /**
     * Akcja dodaje nowego prowadzacego do przedmiotu
     * @param integer $id id przedmiotu
     */
    public function addLeaderAction($id)
    {
        $subjectModel = new SubjectModel;
        $subject = $subjectModel->getSubjectById($id);

        if (TRUE === empty($subject)) {
            $this->setInfo('error', "Przedmiot nie został odnaleziony!");
            $this->redirect('/subject/show');
        }

        if($subject->idUzytkownik != $_SESSION['user']['idUzytkownik']){
            $this->setInfo('error', "Nie posiadasz praw do dodawania prowadzących!");
            $this->redirect('/subject/'.$id.'/view');
        }

        if (false === empty($_POST)) {
            $oValidator = new LeaderValidator;
            if (false === $oValidator->isValid()) {
                $oValidator->saveGlobally();
                return  $this->redirect('/subject/add');
            }

            $userModel = new UsersModel;
            $user = $userModel->getUserById($_POST['nauczyciel']);

            if (TRUE === empty($user)) {
                $this->setInfo('error', "Taki nauczyciel nie istnieje!");
                $this->redirect('/subject/'.$id.'/view');
            }

            $checkleaderModel = new LeaderModel;
            $check = $checkleaderModel->getLeaderByPrzedmiotAndUzytkownik($id, $_POST['nauczyciel']);

            if($check == true){
                $this->setInfo('error', "Ten nauczyciel już prowadzi ten przedmiot!");
                $this->redirect('/subject/'.$id.'/view');
            }

            $leaderModel = new LeaderModel;
            $leader = $leaderModel->addNewLeader($id, $_POST['nauczyciel']);

            if ($leader == true) {
                $this->setInfo('success', "Nauczyciel został dodany do przedmiotu jako prowadzący!");
                $this->redirect('/subject/'.$id.'/view');
            } else {
                $this->setInfo('error', "Nauczyciel nie został dodany do przedmiotu!");
                $this->redirect('/subject/'.$id.'/leader/add');
            }
        }

        LeaderValidator::appendToView($this->getView());
        
        $userModel = new UsersModel;
        $users = $userModel->getUsersByType('teacher');

        $this->getView()
            ->assign('users', $users)
            ->assign('id', $id)
            ->assign('content', 'subject/addLeader.html')
            ->render('layout.html');
    }

    /**
     * Akcja kasuje lidera z przedmiotu
     * @param  integer $id  id przedmiotu
     * @param  integer $id2 id prowadzącego
     */
    public function deleteLeaderAction($id, $id2)
    {
        $subjectModel = new SubjectModel;
        $subject = $subjectModel->getSubjectById($id);

        if (TRUE === empty($subject)) {
            $this->setInfo('error', "Przedmiot nie został odnaleziony!");
            $this->redirect('/subject/show');
        }

        $leaderModel = new LeaderModel;
        $leader = $leaderModel->getLeaderByPrzedmiotAndUzytkownik($id, $id2);

        if (TRUE === empty($leader)) {
            $this->setInfo('error', "Ten nauczyciel nie prowadzi tego przedmiotu");
            $this->redirect('/subject/'.$id.'/view');
        }

        if($subject->idUzytkownik != $_SESSION['user']['idUzytkownik']){
            $this->setInfo('error', "Nie posiadasz praw do kasowania prowadzących!");
            $this->redirect('/subject/'.$id.'/view');
        }

        if (false === empty($_POST)) {

            $leaderModel = new LeaderModel;
            $leader = $leaderModel->deleteLeader($id, $id2);

            if ($leader == true) {
                $this->setInfo('success', "Nauczyciel został usunięty z przedmiotu!");
                $this->redirect('/subject/'.$id.'/view');
            } else {
                $this->setInfo('error', "Nauczyciel nie został usunięty z przedmiotu!");
                $this->redirect('/subject/'.$id.'/view');
            }
        }
        
        $userModel = new UsersModel;
        $users = $userModel->getUserById($id2);

        $this->getView()
            ->assign('usr', $users)
            ->assign('id', $id)
            ->assign('id2', $id2)
            ->assign('content', 'subject/deleteLeader.html')
            ->render('layout.html');
    }
}