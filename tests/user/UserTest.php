<?php

namespace App\Tests\user;

use App\RequestProcessor\UserRequestProcessor;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class UserTest extends TestCase
{
    private $userRequestProcessor;

    public function setUp(): void
    {
        $this->userRequestProcessor = new UserRequestProcessor();
    }

    public function testSomething(): void
    {
        $request = Request::create('/', 'POST', [
            'email' => 'email@gmail.com',
            'password' => 'pass',
            'nickname' => 'nick',
            'roles' => ['ROLE_USER'],
        ]);

        $user = $this->userRequestProcessor->register($request);

        $this->assertTrue($user->getNickname() == "nick");
    }
}
