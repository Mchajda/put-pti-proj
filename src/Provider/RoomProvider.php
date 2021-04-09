<?php


namespace App\Provider;


use App\Entity\Room;
use App\Provider\Interfaces\RoomProviderInterface;
use App\Repository\RoomRepository;

class RoomProvider implements RoomProviderInterface
{
    private $repository;

    public function __construct(RoomRepository $repository){
        $this->repository = $repository;
    }

    public function getAll(): array
    {
        return $this->repository->findAll();
    }

    public function getOneById($room_id): Room
    {
        return $this->repository->findOneBy(['id' => $room_id]);
    }
}