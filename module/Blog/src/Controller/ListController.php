<?php

namespace Blog\Controller;

use Blog\Model\PostRepositoryInterface;
use Laminas\Mvc\Controller\AbstractActionController;

use Laminas\View\Model\ViewModel; //viewmodel instances allow you to provide variables to render within your template,
use InvalidArgumentException;

class ListController extends AbstractActionController
{
    /**
     * @var PostRepositoryInterface
     */
    private $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    // Add the following method:
    public function indexAction()
    {
        return new ViewModel([
            'posts' => $this->postRepository->findAllPosts(),
        ]);
    }

    public function detailAction()
    {
        //our ListController should be prepared to do something whenever an InvalidArgumentException is thrown by the PostService.
        $id = $this->params()->fromRoute('id');

        try {
            $post = $this->postRepository->findPost($id);
        } catch (\InvalidArgumentException $ex) {
            return $this->redirect()->toRoute('blog');
        }

        return new ViewModel([
            'post' => $post,
        ]);
        }
}