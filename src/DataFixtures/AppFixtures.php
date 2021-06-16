<?php

namespace App\DataFixtures;

use App\Entity\Argonaute;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

        $argonaute = new Argonaute();
        $argonaute->setName('Eleftheria');
        $manager->persist($argonaute);

        $argonaute = new Argonaute();
        $argonaute->setName('Gennadios');
        $manager->persist($argonaute);

        $argonaute = new Argonaute();
        $argonaute->setName('Lysimachos');
        $manager->persist($argonaute);

        $manager->flush();
    }
}
