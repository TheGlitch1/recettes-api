<?php

namespace App\DataFixtures;

use Faker;
use Doctrine\Bundle\FixturesBundle\Fixture;

abstract class AbstractFixtures extends Fixture
{
    
    protected Faker\Generator $faker;

    public function __construct()
    {
        $this->faker = Faker\Factory::create('fr_FR');
    }
}
