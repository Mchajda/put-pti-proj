<?php


namespace App\Provider;


use App\Entity\Post;
use App\Provider\Interfaces\PostProviderInterface;
use App\Repository\PostRepository;

class PostProvider implements PostProviderInterface
{
    private $repository;

    public function __construct(PostRepository $repository){
        $this->repository = $repository;
    }

    public function getAll(): array
    {
        return $this->repository->findAll();
    }

    public function getOneById($post_id): Post
    {
        return $this->repository->findOneBy(['id' => $post_id]);
    }

    public function getAllByRoomId($room_id)
    {
        return $this->repository->findBy(['room_id' => $room_id]);
    }
}