<?php


namespace App\Factory;


use App\Entity\User;

class UserFactory
{
    public static function create(
        $email,
        $password,
        $nickname,
        $roles
    ){
        $user = new User();

        $user->setEmail($email);
        $user->setPassword(password_hash($password, PASSWORD_DEFAULT));
        $user->setNickname($nickname);
        $user->setRoles($roles);

        $user->setCreatedAt(new \DateTime());
        $user->setUpdatedAt(new \DateTime());

        return $user;
    }
}