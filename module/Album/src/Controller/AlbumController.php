<?php

namespace Album\Controller;

use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

use Album\Model\AlbumTable;


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
    {}

    public function editAction()
    {}

    public function deleteAction()
    {}
}

/**
 * Como o Laminas sabe contruir um AlbumController? ELe usa o ServiceManager, um sistema de injeção de dependencia que cria o objeto com as dependencias que ele precisa.
 * Agora que o AlbumController precisa de um AlbumTable, precisamos explicar isso ao ServiceManager.
 * 1- Podemos criar uma AlbumControllerFactory, onde pega o AlbumTable do container e retorna o controller. Mas existem outras soluções
 * 2- (+rapida e sem criar arquivos extras) ReflectionBasedAbstractFactory -> fabrica automatica que usa reflexao (ie, examina o codigo em tempo de execução)
 * pra ver quais dependencias o contrutor do controller precisa e se elas ja estao no ServiceManager.
 * Se encontrar tudo, ele cria o objeto com as dependencias corretas automaticamente, sem precisar escrever um factory manual em outro arquivo AlbumControllerFactory.php
 */