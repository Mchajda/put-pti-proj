<?php


namespace App\RequestProcessor\Interfaces;


use App\Entity\Category;
use Symfony\Component\HttpFoundation\Request;

interface CategoryRequestProcessorInterface
{
    public function create(Request $request): Category;
}