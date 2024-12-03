<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\User;
use App\Entity\Wish;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Validator\Constraints\Date;

class AppFixtures extends Fixture
{

    private ObjectManager $manager;
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $this->manager = $manager;
        $this->loadUsers();
        $this->loadCategories();
        $this->loadWishes();
    }

    public function loadWishes(){
        $faker = \Faker\Factory::create("fr_FR");

        for ($i = 0; $i < 50; $i++){
            $wish = new Wish();
            $wish->setTitle($faker->word());
            $wish->setAuthor($faker->name());
            $wish->setDescription($faker->text());
            $wish->setDateCreated(new \DateTime());
            $wish->setDateUpdated(new \DateTime());
            $wish->setCategory($this->getReference("category-" . $faker->randomElement([0,1,2,3,4])));
            $wish->setUser($this->getReference($faker->randomElement(['user', 'admin'])));
            $this->manager->persist($wish);
        }

        $this->manager->flush();
    }

    public function loadCategories(){
        $categories = ['Travel & Adventure', 'Sport', 'Entertainment', 'Human Relations', 'Others'];

        for ($i = 0; $i < count($categories); $i++){
            $category = new Category();
            $category->setName($categories[$i]);
            $this->setReference("category-$i", $category);
            $this->manager->persist($category);
        }

        $this->manager->flush();
    }

    public function loadUsers(){
        $admin = new User();
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setEmail('admin@gmail.com');
        $admin->setUsername("admin");
        $admin->setPassword($this->hasher->hashPassword($admin, 'Pa$$w0rd'));
        $this->setReference('admin', $admin);

        $user = new User();
        $user->setRoles(['ROLE_USER']);
        $user->setEmail('user@gmail.com');
        $user->setUsername("user");
        $user->setPassword($this->hasher->hashPassword($user, 'Pa$$w0rd'));
        $this->setReference('user', $user);

        $this->manager->persist($admin);
        $this->manager->persist($user);
        $this->manager->flush();
    }
}
