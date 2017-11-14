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
}