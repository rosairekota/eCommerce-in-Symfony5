<?php

namespace App\Controller\Admin;

use App\Entity\Seller;
use App\Form\SellerType;
use App\Repository\SellerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/admin/seller")
 */
class AdminSellerController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    /**
     * @Route("/", name="seller_index")
     */
    public function index(SellerRepository $repo)
    {
        return $this->render('admin/seller/index.html.twig', [
            'sellers'    => $repo->findAll(),
        ]);
    }

    /**
     * @Route("/create", name="seller_create")
     */
    public function create(Request $request)
    {
        $seller = new Seller();
        $form = $this->createForm(SellerType::class, $seller);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($seller);
            $this->em->flush();
            $this->addFlash('success', 'Félicitation vous etes enregistré !');
            return $this->redirectToRoute('seller_index');
        }

        return $this->render('admin/seller/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/edit", name="seller_edit")
     */
    public function update(Seller $seller, Request $request)
    {
        $form = $this->createForm(SellerType::class, $seller);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success', 'La modification a réussi !');
            return $this->redirectToRoute('seller_index');
        }
        return $this->render('admin/seller/edit.html.twig', [
            'form'  => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}/delete", name="seller_delete", methods="DELETE")
     */
    public function delete(Seller $seller, Request $request)
    {
        if ($this->isCsrfTokenValid('delete' . $seller->getId(), $request->get('_token'))) {
            $this->em->remove($seller);
            $this->em->flush();
            $this->addFlash('success', 'la suppression a reussi');
        }
        return $this->redirectToRoute('seller_index');
    }
}
