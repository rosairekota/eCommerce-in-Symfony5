<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
//use  Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Service\Cart\CartService;
use Symfony\Component\HttpFoundation\Session\Session;

class CartController extends AbstractController
{
    /**
     * @var CartServcice
     */
    private $cartService;
    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }
    /**
     * @Route("/produits/panier", name="cart_index")
     */

    public function index()
    {

        return $this->render('product/cart/index.html.twig', [
            'customer'  => $this->cartService->getCustomer_inSession(),
            'items'     => $this->cartService->getFullCart(),
            'total'     => number_format($this->cartService->getTotal(), 0, '', ' '),
        ]);
    }



    /**
     * @Route("/produits/panier/ajouter/{slug}-{id}", name="cart_add", requirements={"slug":"[a-z0-9\-]*"})
     */
    public function add(int $id, string $slug, Product $product, Session $session)
    {
        //$session->start();
        // $customer = $session->get('customer_session', []);
        // $session->set('customer_session', $customer);
        // \session_destroy();

        if ($this->cartService->add($id)) {

            $this->addFlash('success', 'ajout du produit dans le panier');
            return $this->redirectToRoute('cart_index');
        } else {
            return $this->redirectToRoute('customer_login');
        }
    }

    /**
     * @Route("/produits/panier/suprimer/{id}", name="cart_remove")
     */
    public function remove(int $id)
    {

        $this->cartService->remove($id);
        $this->addFlash('success', ' Vous avez supprimé le produit dans le panier!');
        return $this->redirectToRoute('cart_index');
    }

    /**
     * @Route("produits/panier/{id}",name="cart_show")
     */
    public function show()
    {


        return $this->render('produt/cart/show.html.twig', []);
    }
}
