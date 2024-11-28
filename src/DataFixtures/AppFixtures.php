<?php

namespace App\DataFixtures;

use App\Entity\Wish;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Validator\Constraints\Date;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = \Faker\Factory::create("fr_FR");

        for ($i = 0; $i < 50; $i++){
            $wish = new Wish();
            $wish->setTitle($faker->word());
            $wish->setAuthor($faker->name());
            $wish->setDescription($faker->text());
            $wish->setDateCreated(new \DateTime());
            $wish->setDateUpdated(new \DateTime());
            $manager->persist($wish);
        }

        $manager->flush();
    }
}
