<?php


namespace App\Provider;


use App\Entity\Category;
use App\Provider\Interfaces\CategoryProviderInterface;
use App\Repository\CategoryRepository;

class CategoryProvider implements CategoryProviderInterface
{
    private $repository;

    public function __construct(CategoryRepository $repository){
        $this->repository = $repository;
    }

    public function getAll(): array
    {
        return $this->repository->findAll();
    }

    public function getOneById($category_id): Category
    {
        return $this->repository->findOneBy(['id' => $category_id]);
    }
}