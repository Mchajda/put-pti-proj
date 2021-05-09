<?php


namespace App\Provider\Interfaces;


use App\Entity\Post;

interface PostProviderInterface
{
    public function getAll(): array;
    public function getOneById($post_id): Post;
    public function getAllCommentsByPostId($post_id): ?array;
    public function getAllByRoomId($room_id);
    public function getLast3ByUserId($user_id);
}