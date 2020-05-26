<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use  Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use  Doctrine\ORM\EntityManagerInterface;
use App\Service\Cart\CartService;
use App\Entity\Customer;
use App\Form\CustomerType;
use App\Form\LoginCustomerType;
//classe permettantde gerer les hashage
//use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Repository\CustomerRepository;



class CustomerController extends AbstractController{


     /**
     * @var CartServcice
     */
    private $cartService;

      /**
     * @var SessionInterface
     */
    protected $session;
    public function __construct(CartService $cartService, SessionInterface $session)
    {
        $this->cartService=$cartService;
        $this->session=$session;
    }

    /**
     * @Route("/customer", name="customer_index")
     */
    public function index(){

    }

    /**
     * @Route("/customer/register", name="customer_registration")
     */
    public function create(Request $request,EntityManagerInterface $em){
        $customer=new Customer();
        $this->addFlash('success','Veuillez vous enregistrer svp!');
        

        $form=$this->createForm(CustomerType::class,$customer);
        $form->handleRequest($request);
        //dd($form);
        if ($form->isSubmitted() && $form->isValid()) {

            
            // on Crypte le mot de passe du client
            $hash=sha1($customer->getPassword());
            $customer->setPassword($hash);

            $em->persist($customer);
            $em->flush();
           
            

            return $this->redirectToRoute('customer_login');
            
        }
        return $this->render("customer/create.html.twig",[
            'form'      =>$form->createView(),
        ]);
    }


    /**
    * @Route("/customer/login", name="customer_login")
    */
   public function login(Request $request, CustomerRepository $customerRepository){
      
       $customer=new Customer();
      // $this->addFlash('success','Veuillez vous connecter svp pour remplir votre panier!');
       

       $form=$this->createForm(LoginCustomerType::class,$customer);
       $form->handleRequest($request);
       //dd($form);
       if ($form->isSubmitted() && $form->isValid()) {
           // TRAITEMENT SERIEUX
            $password_submit=$customer->getPassword();
            // on Crypte le mot de passe du client
            $password_submitHashing=sha1($customer->getPassword());
            $email_submit=$customer->getEmail();
            $data=['password'=>$password_submitHashing,'email' =>$email_submit];
            $repo=$customerRepository->findBy($data);
            
            if (!empty($repo)) {
              
                //dd('votre Mot de passe est :'.$password_submitHashing);
              
                // on cree une ssession pour un client
            $customer_session=$this->session->get('customer_session',[]);
            $customer_session['id']= $password_submitHashing;
            $this->session->set('customer_session',$customer_session);
            
           return $this->redirectToRoute('product_index');
            }
            else{
                $this->addFlash('warning','Oups! vous n\'etes pas trouvé dans notre système. Veuillez recommencer.');
            }
            
           
       }
       return $this->render("customer/login.html.twig",[
           'formlogin'      =>$form->createView(),
       ]);
           
   }

    /**
     * @Route("/customer/logout", name="customer_logout")
     */
    public function logout(){
        session_start();
        // $response=$this->cartService->distroyAllSessions();
        // if ($response) {

        //     return $this->redirectToRoute('product_index');
        // } 
        session_destroy();
        $_SESSION=[];
    }

}