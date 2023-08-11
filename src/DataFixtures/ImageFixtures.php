<?php

namespace App\DataFixtures;

use Doctrine\Persistence\ObjectManager;

class ImageFixtures extends AbstractFixtures
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
