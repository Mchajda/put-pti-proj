<?php


namespace App\RequestProcessor\Interfaces;


use App\Entity\Post;
use Symfony\Component\HttpFoundation\Request;

interface PostRequestProcessorInterface
{
    public function create(Request $request, $author, $room): Post;
}