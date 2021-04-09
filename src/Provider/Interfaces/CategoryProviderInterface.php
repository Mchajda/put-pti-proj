<?php


namespace App\Provider\Interfaces;


use App\Entity\Category;

interface CategoryProviderInterface
{
    public function getAll(): array;
    public function getOneById($category_id): Category;
}