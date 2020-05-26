<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductSearchType;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProductRepository;
use App\SearchEntity\ProductSearch;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends AbstractController
{

    /**
     * @var ProductSearch
     */
    private $product_search;
    public function __construct(ProductSearch $product_search)
    {

        $this->product_search = $product_search;
    }
    /**
     * @Route("/", name="product_index")
     */
    public function index(PostRepository $repo, PaginatorInterface $paginator, Request $request)
    {
        $product_search = new ProductSearch();
        $form_productSearch = $this->createForm(ProductSearchType::class,  $product_search);
        $form_productSearch->handleRequest($request);



        $query = $repo->findQueryPaginate();
        $products_pagination = $paginator->paginate($query, $request->query->getInt('page', 1), 6);
        return $this->render('product/listview.html.twig', [
            'posts'        => $products_pagination,
            'form'             => $form_productSearch->createView()
        ]);
    }

    /**
     * @Route("/search", name="product_search")
     */
    public function search(ProductRepository $repo, PaginatorInterface $paginator, Request $request)
    {
        $product_search = new ProductSearch();
        $form_productSearch = $this->createForm(ProductSearchType::class,  $product_search);
        $form_productSearch->handleRequest($request);



        $query = $repo->findQuerySearch($product_search);
        $products_pagination = $paginator->paginate($query, $request->query->getInt('page', 1), 6);
        return $this->render('product/search.html.twig', [
            'products'        => $products_pagination,
            'form'             => $form_productSearch->createView()
        ]);
    }









    // /**
    //  * @Route("/produits/search", name="product_search")
    //  */
    // public function search(ProductRepository $repo, PaginatorInterface $paginator, Request $request)
    // {


    //     $query = $repo->findQuerySearch($this->product_search);
    //     $this->products_pagination = $paginator->paginate($query, $request->query->getInt('page', 1), 6);
    //     return $this->render('product/searchProducts.html.twig', [
    //         'products'        => $this->products_pagination,
    //     ]);
    // }
}
