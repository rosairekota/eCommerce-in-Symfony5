<?php
namespace App\Service\Cart;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Repository\ProductRepository;
use App\Repository\CustomerRepository;


class CartService {
    /**
     * @var SessionInterface
     */
    protected $session;

    /**
     * @var ProductRepository
     */
    protected $productRepository;

    /**
     * @var CustomerRepository
     */
    protected $customerRepository;

    /**
     * @var pannier
     */
    private $panier;

    public function __construct(SessionInterface $session,ProductRepository $productRepository,CustomerRepository $customerRepository){
            $this->session=$session;
            $this->productRepository=$productRepository;
            $this->customerRepository=$customerRepository;
    }

    public function add(int $id){
          // on verifie s'il quelque un panier dans la session
          $this->panier=$this->session->get('panier',[]);
          $client_session=$this->session->get('customer_session',[]);
          if (!empty($client_session)) {
             
              if (!empty($this->panier[$id])) {
                  $this->panier[$id]++;
              } else {
                  $this->panier[$id]=1;
              }
              
              
              $this->session->set('panier',$this->panier);
              return true;
          }
         
         
    }
    public function remove(int $id){
         $this->panier=$this->session->get('panier',[]);
            if (!empty($this->panier[$id])) {
               unset($this->panier[$id]);
            }
            $this->session->set('panier',$this->panier);
    }
    public function getFullCart(): ?array
    {
        $this->panier=$this->session->get('panier',[]);
        $panierWithData=[];
        
            # code...
            foreach ($this->panier as $id => $quanity) {
                $panierWithData[]=[
                    'product'   => $this->productRepository->find($id),
                    'quanity'   => $quanity,
                    // 'customer'  => $this->getCustomer()
                ];
    
            }
        
        
        return $panierWithData;
    }
    public function distroyAllSessions(){
       

        $this->panier=$this->session->get('panier',[]);
        if (!empty($this->panier)) {
           unset($this->panier);
           //session_write_close();
           return true;
        }
        $this->session->set('panier',$this->panier);
        
    }
    public function getCustomer_inSession(){

        $client_session=$this->session->get('customer_session',[]);
        $customerRepository=null;
        if (empty($customerRepository)) {
            $customerRepository = $this->customerRepository->findOneByPassword($client_session['id']);
        }
        return $customerRepository;
    }
    public function getTotal(): ?float
    {
        $total=0;
        foreach ($this->getFullCart() as $item) {
            $total+=$item['product']->getPrice()*$item['quanity'];;
        }
        return $total;
    }
}