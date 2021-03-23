<?php


namespace App\Service;


use App\Entity\User;
use App\Service\Interfaces\UserServiceInterface;
use Doctrine\ORM\EntityManagerInterface;

class UserService extends EntityService implements UserServiceInterface
{
    public function __construct(EntityManagerInterface $entity_manager)
    {
        parent::__construct($entity_manager, User::class);
    }

    public function create(User &$user): void
    {
        $this->createEntity($user);
    }

    public function delete(User $user): void
    {
        $this->entity_manager->remove($user);
        $this->entity_manager->flush();
    }

    public function save(): void
    {
        $this->entity_manager->flush();
    }
}