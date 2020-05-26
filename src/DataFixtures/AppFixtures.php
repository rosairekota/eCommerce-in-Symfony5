<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Product;
use App\Entity\Category;
use App\Entity\Customer;
use App\Entity\Seller;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
       
        $faker=\Faker\Factory::create('fr_FR');
        for ($i=0; $i < 2; $i++) { 
            // ON INSERE LES CATEGORIES
            $category=new Category();
            $category->setTitle($faker->words(2,true))
                     ->setDesciption($faker->paragraph());
            $manager->persist($category);

             // ON INSERE LES CLIENTS

             $customer=new Customer();
             $customer->setName($faker->name)
                      ->setEmail($faker->email)
                      ->setTelephone('+243'.$faker->numberBetween(2000000000,9000000000))
                      ->setCountry($faker->country)
                      ->setCity($faker->city)
                      ->setPostalCode('+243')
                      ->setPassword($faker->numberBetween(1000000000,9007020800))
                      ->setAdress($faker->address);
            $manager->persist($customer);
            for ($j=1; $j<4; $j++) { 

                $product = new Product();
                $product->setTitle($faker->words(3,true))
                        ->setPrice($faker->numberBetween(10,200))
                        ->setDescription($faker->paragraph())
                        ->setImage($faker->imageUrl())
                        ->setCategory($category)
                        ->addCustomer($customer);
                        
                 $manager->persist($product);
            }
            for ($k=1; $k<4; $k++) { 

                $seller = new Seller();
                $seller->setName($faker->name)
                        ->setEmail($faker->email)
                        ->setTelephone('+243'.$faker->numberBetween(2000000000,9000000000))
                        ->setContry($faker->country)
                        ->setCity($faker->city)
                        ->setPostalCode('+243')
                        ->setAddress($faker->address)
                        ->setExperience($faker->numberBetween(1,100).' ans')
                        ->setDescription($faker->paragraph())
                        ->addProduct($product);
                        
                 $manager->persist($seller);
            }
        
        }

        $manager->flush();
    }
}
