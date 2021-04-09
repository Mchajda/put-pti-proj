<?php


namespace App\RequestProcessor;


use App\Entity\Room;
use App\Factory\RoomFactory;
use App\RequestProcessor\Interfaces\RoomRequestProcessorInterface;
use Symfony\Component\HttpFoundation\Request;

class RoomRequestProcessor implements RoomRequestProcessorInterface
{
    public function create(Request $request): Room
    {
        $name = $request->request->get('name');
        $category = $request->request->get('category');
        $parent = $request->request->get('parent');

        return RoomFactory::create(
            $name,
            $category,
            $parent
        );
    }
}