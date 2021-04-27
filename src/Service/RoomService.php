<?php


namespace App\Service;


use App\Entity\Room;
use App\Service\Interfaces\PostServiceInterface;
use App\Service\Interfaces\RoomServiceInterface;
use Doctrine\ORM\EntityManagerInterface;

class RoomService extends EntityService implements RoomServiceInterface
{
    private $postService;

    public function __construct(EntityManagerInterface $entity_manager, PostServiceInterface $postService)
    {
        parent::__construct($entity_manager, Room::class);

        $this->postService = $postService;
    }

    public function create(Room &$room): void
    {
        $this->createEntity($room);
    }

    public function delete(Room $room): void
    {
        foreach ($room->getPosts() as $post) {
            $this->postService->delete($post);
        }

        $this->entity_manager->remove($room);
        $this->entity_manager->flush();
    }

    public function save(): void
    {
        $this->entity_manager->flush();
    }
}