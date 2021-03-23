<?php


namespace App\Service\Interfaces;


use App\Entity\User;

interface UserServiceInterface
{
    /**
     * @param User $user
     */
    public function create(User &$user): void;

    /**
     * @param User $user
     */
    public function delete(User $user): void;

    public function save(): void;
}