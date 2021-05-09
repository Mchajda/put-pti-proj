<?php


namespace App\RequestProcessor;


use App\Entity\Post;
use App\Entity\Room;
use App\Entity\User;
use App\Factory\PostFactory;
use App\RequestProcessor\Interfaces\PostRequestProcessorInterface;
use Symfony\Component\HttpFoundation\Request;

class PostRequestProcessor implements PostRequestProcessorInterface
{
    public function create(Request $request, User $author, Room $room, $parentPostId): Post
    {
        $text = $request->request->get('text');

        return PostFactory::create(
            $text,
            $author,
            $room,
            $parentPostId
        );
    }
}