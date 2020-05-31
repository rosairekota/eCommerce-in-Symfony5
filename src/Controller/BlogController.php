<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/blog")
 */
class BlogController extends AbstractController
{
    /**
     * @Route("/", name="blog_index", methods={"GET"})
     */
    public function index(PostRepository $postRepository, Request $request, PaginatorInterface $paginator): Response
    {
        $query = $postRepository->findQueryPaginate();
        $posts = $paginator->paginate($query, $request->query->getInt('page', 1), 4);
        return $this->render('blog/index.html.twig', [
            'posts' => $posts,
        ]);
    }


    /**
     * @Route("/{id}", name="blog_show", methods={"GET"})
     */
    public function show(Post $post): Response
    {
        return $this->render('blog/show.html.twig', [
            'post' => $post,
        ]);
    }
}
