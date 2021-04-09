<?php


namespace App\Service;


use App\Entity\Room;
use App\Service\Interfaces\RoomServiceInterface;
use Doctrine\ORM\EntityManagerInterface;

class RoomService extends EntityService implements RoomServiceInterface
{
    public function __construct(EntityManagerInterface $entity_manager)
    {
        parent::__construct($entity_manager, Room::class);
    }

    public function create(Room &$room): void
    {
        $this->createEntity($room);
    }

    public function delete(Room $room): void
    {
        $this->entity_manager->remove($room);
        $this->entity_manager->flush();
    }

    public function save(): void
    {
        $this->entity_manager->flush();
    }
}