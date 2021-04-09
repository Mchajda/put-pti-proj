<?php


namespace App\Service\Interfaces;


use App\Entity\Room;

interface RoomServiceInterface
{
    public function create(Room &$room): void;
    public function delete(Room $room): void;
    public function save(): void;
}