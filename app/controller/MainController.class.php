<?php
/**
 * Author: Paweł Wolak 2017
 *
 */
namespace controller;

class MainController extends \core\BaseController {

    /**
     * Akcja wyświetlająca stronę główną.
     */
    public function indexAction()
    {

        $this->getView()
            ->assign('content', 'main/index.html')
            ->render('layout.html');
    }

    /**
     * Akcja wyświetlająca stronę kontaktu.
     */
    public function contactAction()
    {
        $this->getView()
            ->assign('name', 'test')
            ->assign('content', 'main/contact.html')
            ->render('layout.html');
    }

}