<?php


namespace App\RequestProcessor\Interfaces;


use App\Entity\Post;
use App\Entity\Room;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;

interface PostRequestProcessorInterface
{
    public function create(Request $request, User $author, Room $room, ?Post $parentPost): Post;
}