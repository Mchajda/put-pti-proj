<?php


namespace App\Provider\Interfaces;


use App\Entity\Room;

interface RoomProviderInterface
{
    public function getAll(): ?array;
    public function getOneById($room_id): ?Room;
    public function getOneByName($name): ?Room;
    public function getRoomsUserDoesNotBelongTo($rooms_user_belongs, $all_rooms);
}