<?php

namespace App\DataFixtures;

use App\Entity\Annonce;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 4; $i++) {
            $annonce = new Annonce();
            $annonce->setTitle('annonce ' .$i);
            $annonce->setPrice(mt_rand(10, 100));
            $annonce->setDescription('ceci est une description' .$i);

            
            $manager->persist($annonce);    
        }
        $manager->flush();
    }
}
