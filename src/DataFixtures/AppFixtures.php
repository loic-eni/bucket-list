<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Wish;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Validator\Constraints\Date;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $this->loadCategories($manager);
        $this->loadWishes($manager);
    }

    public function loadWishes(ObjectManager $manager){
        $faker = \Faker\Factory::create("fr_FR");

        for ($i = 0; $i < 50; $i++){
            $wish = new Wish();
            $wish->setTitle($faker->word());
            $wish->setAuthor($faker->name());
            $wish->setDescription($faker->text());
            $wish->setDateCreated(new \DateTime());
            $wish->setDateUpdated(new \DateTime());
            $wish->setCategory($this->getReference("category-" . $faker->randomElement([0,1,2,3,4])));
            $manager->persist($wish);
        }

        $manager->flush();
    }

    public function loadCategories(ObjectManager $manager){
        $categories = ['Travel & Adventure', 'Sport', 'Entertainment', 'Human Relations', 'Others'];

        for ($i = 0; $i < count($categories); $i++){
            $category = new Category();
            $category->setName($categories[$i]);
            $this->setReference("category-$i", $category);
            $manager->persist($category);
        }

        $manager->flush();
    }
}
