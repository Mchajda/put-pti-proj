<?php


namespace App\RequestProcessor;


use App\Entity\Post;
use App\Factory\PostFactory;
use App\RequestProcessor\Interfaces\PostRequestProcessorInterface;
use Symfony\Component\HttpFoundation\Request;

class PostRequestProcessor implements PostRequestProcessorInterface
{
    public function create(Request $request, $author, $room): Post
    {
        $text = $request->request->get('text');

        return PostFactory::create(
            $text,
            $author,
            $room
        );
    }
}