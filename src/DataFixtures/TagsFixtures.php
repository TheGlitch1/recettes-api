<?php

namespace App\DataFixtures;

use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use App\Entity\Tag;

class TagsFixtures extends AbstractFixtures
{
    public function load(ObjectManager $manager): void
    {

        // Delete child records first
        $tags = $manager->getRepository(Tag::class)->findAll();
        foreach ($tags as $tag) {
            if ($tag->getParent() !== null) {
                $tag->setParent(null);
                $manager->persist($tag);
            }
        }
        $manager->flush();

        // Delete parent records
        $tags = $manager->getRepository(Tag::class)->findAll();
        foreach ($tags as $tag) {
            if ($tag->getParent() === null) {
                $manager->remove($tag);
            }
        }
        $manager->flush();
        
        $tags = [];
        for ($i = 0; $i < 200; ++$i) {
            $tag = new Tag();
            /** @var Tag $parent */
            $parent = $this->faker->optional(weight: 0.125)->randomElement($tags);
            $tag
                ->setName($this->faker->name())
                ->setDescription($this->faker->text(250))
                ->setMenu($this->faker->boolean(30))
                ->setParent($parent)
            ;
            $tags[] = $tag;
            $manager->persist($tag);
        }

        $manager->flush();
    }
}
