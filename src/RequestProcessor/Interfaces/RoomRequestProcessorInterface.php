<?php


namespace App\RequestProcessor\Interfaces;


use App\Entity\Room;
use Symfony\Component\HttpFoundation\Request;

interface RoomRequestProcessorInterface
{
    public function create(Request $request): Room;
}