<?php


namespace App\Service;


use App\Entity\Category;
use App\Entity\Post;
use App\Service\Interfaces\CategoryServiceInterface;
use App\Service\Interfaces\PostServiceInterface;
use Doctrine\ORM\EntityManagerInterface;

class PostService extends EntityService implements PostServiceInterface
{
    public function __construct(EntityManagerInterface $entity_manager)
    {
        parent::__construct($entity_manager, Post::class);
    }

    public function create(Post &$post): void
    {
        $this->createEntity($post);
    }

    public function delete(Post $post): void
    {
        $this->entity_manager->remove($post);
        $this->entity_manager->flush();
    }

    public function save(): void
    {
        $this->entity_manager->flush();
    }
}