<?php

namespace App\DataFixtures;

use App\Factory\RecipeFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        RecipeFactory::createMany(25);

        UserFactory::createOne([
            'email' => 'doggo@barkbite.com',
            'password' => 'woof',
            'roles' => ['ROLE_ADMIN']
        ]);

        $manager->flush();
    }
}
