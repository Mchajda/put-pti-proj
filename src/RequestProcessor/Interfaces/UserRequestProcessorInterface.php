<?php


namespace App\RequestProcessor\Interfaces;


use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;

interface UserRequestProcessorInterface
{
    public function register(Request $request);
    public function edit(Request $request, User &$user);
}