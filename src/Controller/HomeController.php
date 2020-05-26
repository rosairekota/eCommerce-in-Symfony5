<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/about", name="home")
     */

    public function index(ProductRepository $repo, PaginatorInterface $paginator, Request $request)
    {
        return $this->render('pages/toto.html.twig');
    }
}
