<?php

namespace App\DataFixtures;

use App\Entity\IngredientGroup;
use App\Repository\UnitRepository;
use App\Entity\RecipeHasIngredient;
use App\Repository\RecipeRepository;
use Doctrine\Persistence\ObjectManager;
use App\Repository\IngredientRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class RecipeHasIngredientFixtures extends AbstractFixtures implements DependentFixtureInterface
{
    public function __construct(protected UnitRepository $unitRepository, protected RecipeRepository $recipeRepository, protected IngredientRepository $ingredientRepository)
    {
        parent::__construct();
    }

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $units = $this->unitRepository->findAll();
        $recipes = $this->recipeRepository->findAll();
        $ingredients = $this->ingredientRepository->findAll();


        $groups = [];
        for ($i = 0; $i < 20; ++$i) {
            // create group ingredients
            $group = new IngredientGroup();
            $name = $this->faker->words(2, true);
            $group->setName($name)->setPriority(1);
            $manager->persist($group);
            $groups[] = $group;
        }

        foreach ($recipes as $recipe) {
            $recipeGroups = [];
            if ($this->faker->boolean(25)) {
                $recipeGroups = $this->faker->randomElements($groups, $this->faker->numberBetween(2, 3));
            }

            for ($i = 0; $i < $this->faker->numberBetween(2, 8); ++$i) {
                $rhi = new RecipeHasIngredient();

                $unit = $this->faker->randomElement($units);
                $ingredient = $this->faker->randomElement($ingredients);
                $rhi
                    ->setQuantity($this->faker->randomFloat(1, 0, 10))
                    ->setOptional($this->faker->boolean(10))
                    ->setUnit($unit)
                    ->setRecipe($recipe)
                    ->setIngredient($ingredient);

                $manager->persist($rhi);
            }
        }


        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            IngredientFixtures::class,
            RecipeFixtures::class,
            UnitFixtures::class,
        ];
    }
}
