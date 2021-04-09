<?php


namespace App\Service\Interfaces;


use App\Entity\Category;

interface CategoryServiceInterface
{
    public function create(Category &$category): void;
    public function delete(Category $category): void;
    public function save(): void;
}