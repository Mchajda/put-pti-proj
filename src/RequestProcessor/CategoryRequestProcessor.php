<?php


namespace App\RequestProcessor;


use App\Entity\Category;
use App\Factory\CategoryFactory;
use App\RequestProcessor\Interfaces\CategoryRequestProcessorInterface;
use Symfony\Component\HttpFoundation\Request;

class CategoryRequestProcessor implements CategoryRequestProcessorInterface
{
    public function create(Request $request): Category
    {
        $name = $request->request->get('name');

        return CategoryFactory::create(
            $name
        );
    }
}