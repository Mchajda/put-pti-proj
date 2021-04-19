<?php


namespace App\RequestProcessor;


use App\Entity\Room;
use App\Factory\RoomFactory;
use App\RequestProcessor\Interfaces\RoomRequestProcessorInterface;
use Symfony\Component\HttpFoundation\Request;

class RoomRequestProcessor implements RoomRequestProcessorInterface
{
    public function create(Request $request, $user): Room
    {
        $name = $request->request->get('name');

        return RoomFactory::create(
            $name,
            $user
        );
    }
}