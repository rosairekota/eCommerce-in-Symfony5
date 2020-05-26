<?php

namespace App\DataFixtures;

use App\Entity\Post;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class PostFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $faker = \Faker\Factory::create('fr_FR');
        for ($i = 0; $i < 30; $i++) {
            // ON INSERE LES CATEGORIES
            $post = new Post();
            $post->setTitle($faker->words(2, true))
                ->setDescription($faker->paragraph());
            $manager->persist($post);
        }
        $manager->flush();
    }
}
