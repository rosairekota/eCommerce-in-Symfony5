<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PropertyRepository;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Property;

class PropertyController extends AbstractController
{
    /**
     * @var PropertyRepository
     */

    private $repo;

    
    public function __construct(PropertyRepository $repo){
        $this->repo=$repo;
     
    }
    
    /**
     * @Route("/biens", name="property_index")
     */
    public function index( ObjectManager $em)
    {
        $property=$this->repo->findAllVisible();
       // $this->em->flush();
        return $this->render('pages/property/index.html.twig',[
            'current_menu' =>'property_index',
            'property'    =>$property,
        ]);
    }

    /**
     * @Route("/biens/{slug}-{id}", name="property_show", requirements={"slug":"[a-z0-9\-]*"})
     */
    public function show(Property $property, string $slug){
     // on fait une verification du slug
     if ($property->getSlug()!=$slug) {
         return $this->redirectToRoute('property_show',[
             'id'   =>$property->getId(),
             'slug' =>$property->getSlug()
         ],301);
     }
        return $this->render('pages/property/show.html.twig',[
            'current_menu' =>'property_index',
            'property'    =>$property,
        ]);
    }
}
