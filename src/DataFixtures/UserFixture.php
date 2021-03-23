<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class UserFixture extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $password = password_hash("maciek1", PASSWORD_DEFAULT);
        $product = new User();
        $product->setEmail('maciej.chajda@gmail.com');
        $product->setPassword($password);
        //$product->setRoles('ROLE_USER');
        $manager->persist($product);

        // add more products

        $manager->flush();
    }
}
