<?php


namespace App\RequestProcessor\Interfaces;


use Symfony\Component\HttpFoundation\Request;

interface UserRequestProcessorInterface
{
    public function register(Request $request);
}