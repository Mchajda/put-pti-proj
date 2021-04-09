<?php


namespace App\Service;


use App\Entity\Category;
use App\Service\Interfaces\CategoryServiceInterface;
use Doctrine\ORM\EntityManagerInterface;

class CategoryService extends EntityService implements CategoryServiceInterface
{
    public function __construct(EntityManagerInterface $entity_manager)
    {
        parent::__construct($entity_manager, Category::class);
    }

    public function create(Category &$category): void
    {
        $this->createEntity($category);
    }

    public function delete(Category $category): void
    {
        $this->entity_manager->remove($category);
        $this->entity_manager->flush();
    }

    public function save(): void
    {
        $this->entity_manager->flush();
    }
}