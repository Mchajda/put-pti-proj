<?php


namespace App\Service\Interfaces;


use App\Entity\User;

interface UserServiceInterface
{
    public function create(User &$user): void;
    public function delete(User $user): void;
    public function save(): void;
}