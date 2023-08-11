<?php

namespace App\DataFixtures;

use App\Entity\Recipe;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class RecipeFixtures extends AbstractFixtures
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        for ($i = 0; $i < 120; ++$i) {
            $recipe = new Recipe();

            $name = $this->faker->words(3, true);
            $recipe
            ->setName($name)
            ->setDescription($this->faker->realText(120))
            ->setDraft($this->faker->boolean(0.1))
            ->setBreak($this->faker->optional(0.01)->numberBetween(0, 600))
            ->setPreparation($this->faker->optional(0.99)->numberBetween(5, 120))
            ->setCooking($this->faker->optional(0.75)->numberBetween(0, 120));

            $recipeTags= $this->faker->randomElements();
            
        }
        $manager->flush();
    }
}
