<?php


namespace App\Factory;


use App\Entity\Category;

class CategoryFactory
{
    public static function create(
        $name
    ){
        $category = new Category();

        $category->setName($name);

        return $category;
    }
}