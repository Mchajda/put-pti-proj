<?php


namespace App\Factory;


use App\Entity\Room;

class RoomFactory
{
    public static function create(
        $name,
        $user
    ){
        $room = new Room();

        $room->setName($name);
        $room->setCreator($user);

        $room->setCreatedAt(new \DateTime());
        $room->setUpdatedAt(new \DateTime());

        return $room;
    }
}