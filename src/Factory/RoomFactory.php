<?php


namespace App\Factory;


use App\Entity\Room;

class RoomFactory
{
    public static function create(
        $name,
        $category,
        $parent
    ){
        $room = new Room();

        $room->setName($name);
        $room->setCategory($category);
        $room->setParent($parent);

        return $room;
    }
}