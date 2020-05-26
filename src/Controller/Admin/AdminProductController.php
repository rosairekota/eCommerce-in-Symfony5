<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProductRepository;
use App\Entity\Product;
use App\Form\ProductType;
use Doctrine\ORM\EntityManagerInterface;
use  Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use  Symfony\Component\Filesystem\Filesystem;

class AdminProductController extends AbstractController
{
    /**
     * @var EntityInterfaceManager
     */
    private $manager;
    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @Route("/admin", name="admin_index")
     */

    public function index(ProductRepository $productRepository, Filesystem $file)
    {

        return $this->render('admin/index.html.twig', [
            'products' => $productRepository->findAll(),
            'navbar'    => 'admin',
        ]);
    }

    /**
     * @Route("/admin/creation", name="admin_create", methods="GET|POST")
     */
    public function create(EntityManagerInterface $em, Request $request)
    {
        $product = new Product();
        $route_name = 'create';

        return $this->managerForm($product, $request, $route_name);
    }

    /**
     * @Route("/admin/{id}/modification", name="admin_edit", methods="GET|POST")
     */
    public function edit(Product $product, Request $request)
    {

        $route_name = 'edit';
        return $this->managerForm($product, $request, $route_name);
    }

    /**
     * @Route("/admin/{id}/delete", name="admin_delete", methods="DELETE")
     */
    public function delete(Product $product, Request $request)
    {

        if ($this->isCsrfTokenValid('delete' . $product->getId(), $request->get('_token'))) {
            $this->manager->remove($product);
            $this->manager->flush();
            $this->addFlash('success', 'la suppression a reussi');
        }

        return $this->redirectToRoute('admin_index');
    }






    /**
     * Cette Methode prive sert a creer le formulaire, persister le donne du formulaire et a gerener une vue
     * @method Form
     */
    private function managerForm(Product $product, Request $request, string $route_name)
    {

        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //Traitement de l'amge
            // $fileImage = $product->getImage();
            // $fileNameImage = $product->getTitle() . '.' . $fileImage->guessExtension();

            // //dd($fileNameImage);
            // $fileImage->move($this->getParameter('upload_directory'), $fileNameImage);
            // $product->setImage($fileNameImage);

            if ($route_name == 'create') {
                $this->manager->persist($product);
                $this->addFlash('success', 'produit ajouter avec succes');
            } else {
                $this->addFlash('success', 'produit modifié avec succes');
            }

            $this->manager->flush();
            return $this->redirectToRoute('admin_index');
        }
        return $this->render('admin/' . $route_name . '.html.twig', [
            'formPruducts'    => $form->createView(),
            'product'        => $product,
            'navbar'    => 'admin',
        ]);
    }
}
