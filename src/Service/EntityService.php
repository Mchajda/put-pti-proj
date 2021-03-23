<?php


namespace App\Service;


use App\Service\Interfaces\EntityServiceInterface;
use Doctrine\ORM\EntityManagerInterface;

class EntityService implements EntityServiceInterface
{
    protected $entity_manager;
    protected $entity_class;

    public function __construct(EntityManagerInterface $entity_manager, $entity_class)
    {
        $this->entity_manager = $entity_manager;
        $this->entity_class = $entity_class;
    }

    public function createEntity($entity): void
    {
        $this->entity_manager->persist($entity);
        $this->entity_manager->flush();
    }

    public function save(): void
    {
        $this->entity_manager->flush();
    }
}