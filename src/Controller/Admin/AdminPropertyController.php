<?php

namespace App\Controller\Admin;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use\Symfony\Component\HttpFoundation\Request;
use App\Repository\PropertyRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Property ;
use App\Form\PropertyType;



class AdminPropertyController extends AbstractController
{
    /**
     * @var Repository
     */
    private $repository;

    
    /**
     * @var ObjectManager
     */
    private $manager;
    public function __construct(PropertyRepository $repository,EntityManagerInterface $manager){
        $this->repository=$repository;
        $this->manager=$manager;
    }

/**
 * @Route("/admin", name="admin_property_index")
 */
  public function index(){
      $properties=$this->repository->findAll();
    return $this->render('admin/property/index.html.twig',compact('properties'));
  }
  /**
   * @Route("/admin/property/new", name="admin_property_new")
   */
  public function new(Request $request){ 
    $property= new Property();
    $route_name='new';
    return $this->managerForm($property,$request,$route_name);
   
  }

  /**
 * @Route("/admin/property/{id}/edit", name="admin_property_edit", methods="GET|POST")
 */
public function edit(Property $property, Request $request){
   
 $route_name='edit';
 return $this->managerForm($property,$request,$route_name);
 
}
  /**
 * @Route("/admin/property/{id}", name="admin_property_delete", methods="DELETE")
 * @param Property
 */
public function delete(Property $property,Request $request){

  /**
   * Vérification de la validité du token
   */
  if ($this->isCsrfTokenValid('delete'.$property->getId(),$request->get('_token'))) {
    $this->manager->remove($property);
    $this->addFlash('success','Le bien :<<'.$property->getTitle().'>> a été supprimé avec succès!');
    $this->manager->flush();
    
  }
  return $this->redirectToRoute('admin_property_index');
 

  
}

/*--------------------------------------------LES METHODES  PRIVEES-----------------------------------------*/

/**
 * Cette Methode prive sert a creer le formulaire, persister le donne du formulaire et a gerener une vue
 * @method Form
 */
private function managerForm(Property $property, Request $request,string $route_name){

    $from=$this->createForm(PropertyType::class,$property);
    $from->handleRequest($request);
   if ($from->isSubmitted()&& $from->isValid()) {
      
    if ($route_name=='new') {
        $this->manager->persist($property);
        $this->addFlash('success','bien ajouter avec succes');
      }
      else{
        $this->addFlash('success','bien modifié avec succes');
      }
        
        $this->manager->flush();
       return $this->redirectToRoute('admin_property_index');
   }
   return $this->render('admin/property/'.$route_name.'.html.twig',[
    'formProperty'    => $from->createView(),
    'property'        =>$property
]);
}
}