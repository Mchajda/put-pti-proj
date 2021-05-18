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

    public function getAll(): ?array
    {
        return $this->repository->findAll();
    }

    public function getOneById($room_id): ?Room
    {
        return $this->repository->findOneBy(['id' => $room_id]);
    }

    public function getOneByName($name): ?Room
    {
        return $this->repository->findOneBy(['name' => $name]);
    }

    public function getOneBySlug($slug): ?Room
    {
        return $this->repository->findOneBy(['slug' => $slug]);
    }

    public function getRoomsUserDoesNotBelongTo($rooms_user_belongs, $all_rooms)
    {
        $rooms_user_does_not_belong = [];

        foreach($all_rooms as $room) {
            $belongs = false;
            foreach($rooms_user_belongs as $user_room) {
                if ($user_room == $room) {
                    $belongs = true;
                    break;
                }
            }
            if($belongs == false){
                array_push($rooms_user_does_not_belong, $room);
            }
        }

        return $rooms_user_does_not_belong;
    }

    public function getMostActiveRooms()
    {
        $rooms = $this->getAll();
        $rooms_segregated = [];

        foreach ($rooms as $key => $room) {
            $rooms_segregated[$key] = ["participants" => $room->getMember()->count(), "posts" => $room->getPosts()->count()];
        }

        foreach ($rooms_segregated as $key => $room) {
            for ($i=0; $i<sizeof($rooms_segregated)-1; $i++) {
                if ($rooms_segregated[$i]['posts'] < $rooms_segregated[$i+1]['posts']) {
                    $temp = $rooms_segregated[$i];
                    $rooms_segregated[$i] = $rooms_segregated[$i+1];
                    $rooms_segregated[$i+1] = $temp;
                }
            }
        }

        return $rooms_segregated;
    }
}