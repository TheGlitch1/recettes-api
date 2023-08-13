<?php

namespace App\DataFixtures;

use App\Entity\Source;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SourceFixtures extends AbstractFixtures
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);

        for ($i = 0; $i < 75; ++$i) {
            $source = new Source();
            $source
                ->setName($this->faker->name())
                ->setDescription($this->faker->text(123))
                ->setUrl($this->faker->url());

            $manager->persist($source);
        }

        $manager->flush();
    }
}