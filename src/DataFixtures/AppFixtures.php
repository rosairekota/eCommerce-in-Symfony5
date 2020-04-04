<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Property;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker=\Faker\Factory::create();
        for ($i=1; $i < 30; $i++) { 
            $property=new Property();
            $property->setTitle($faker->sentence())
                    ->setPrice(2000)
                    ->setRooms(4+$i)
                    ->setBedrooms(3+$i)
                    ->setDescription($faker->paragraph())
                    ->setSurface(60+$i)
                    ->setFloor(4+$i)
                    ->setHeat(1)
                    ->setCity($faker->city)
                    ->setAdress($faker->name)
                    ->setPostalCode(32058);
            $manager->persist($property);
        }

        $manager->flush();
    }
}
