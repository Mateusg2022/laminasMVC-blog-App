<?php

namespace Album\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

use Album\Model\AlbumTable;

use Album\Form\AlbumForm;
use Album\Model\Album;


class AlbumController extends AbstractActionController
{

    private $table;

    public function __construct(AlbumTable $table)
    {
        $this->table = $table;
    }
    public function indexAction()
    {
        return new ViewModel([
            'albums' => $this->table->fetchAll(),
        ]);
    }

    public function addAction()
    {
        //We instantiate AlbumForm and set the label on the submit button to "Add"
        $form = new AlbumForm();
        $form->get('submit')->setValue('Add');

        //Esse método é herdado da classe AbstractActionController. Retorna um objeto da classe Laminas\Stdlib\RequestInterface (normalmente uma instância de Laminas\Http\Request)
        $request = $this->getRequest();

        if (! $request->isPost()) {
            return ['form' => $form];
        }

        $album = new Album();
        $form->setInputFilter($album->getInputFilter());
        $form->setData($request->getPost());

        //If form validation fails, we want to redisplay the form. At this point, the form contains information about what fields failed validation, and why, and this information will be communicated to the view layer.
        if(! $form->isValid()){
            return ['form' => $form];
        }

        $album->exchangeArray($form->getData());
        $this->table->saveAlbum($album);

        //we redirect back to the list of albums
        return $this->redirect()->toRoute('album');
    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);

        if ($id === 0) {
            return $this->redirect()->toRoute('album', ['action' => 'add']);
        }

        //retrice the album with the specidied id. doing so raises an exception if the album is not found,
        //witch should result in redirectiong to the landing page
        try {
            $album = $this->table->getAlbum($id);
        }catch (\Exception $e) {
            return $this->redirect()->toRoute('album', ['action' => 'index']);
        }

        $form = new AlbumForm();
        $form->bind($album);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        $viewData = ['id' => $id, 'form' => $form];

        if (! $request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter($album->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return $viewData;
        }

        try {
            $this->table->saveAlbum($album);
        }catch (\Exception $e) {
        }

        //redirect to album list
        return $this->redirect()->toRoute('album', ['action'=> 'index']);
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if(! $id) {
            return $this->redirect()->toRoute('album');
        }

        $request = $this->getRequest();

        if($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->table->deleteAlbum($id);
            }

            //redirect to list of albums
            return $this->redirect()->toRoute('album');
        }

        return [
            'id' => $id,
            'album' => $this->table->getAlbum($id),
        ];
    }
}

/**
 * Como o Laminas sabe contruir um AlbumController? ELe usa o ServiceManager, um sistema de injeção de dependencia que cria o objeto com as dependencias que ele precisa.
 * Agora que o AlbumController precisa de um AlbumTable, precisamos explicar isso ao ServiceManager.
 * 1- Podemos criar uma AlbumControllerFactory, onde pega o AlbumTable do container e retorna o controller. Mas existem outras soluções
 * 2- (+rapida e sem criar arquivos extras) ReflectionBasedAbstractFactory -> fabrica automatica que usa reflexao (ie, examina o codigo em tempo de execução)
 * pra ver quais dependencias o contrutor do controller precisa e se elas ja estao no ServiceManager.
 * Se encontrar tudo, ele cria o objeto com as dependencias corretas automaticamente, sem precisar escrever um factory manual em outro arquivo AlbumControllerFactory.php
 */