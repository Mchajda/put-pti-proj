<?php


namespace App\RequestProcessor;


use App\Entity\User;
use App\Factory\UserFactory;
use App\RequestProcessor\Interfaces\UserRequestProcessorInterface;
use Symfony\Component\HttpFoundation\Request;

class UserRequestProcessor implements UserRequestProcessorInterface
{
    public function register(Request $request){
        $email = $request->request->get('email');
        $password = $request->request->get('password');
        $nickname = $request->request->get('nickname');
        $roles = ['ROLE_USER'];

        return UserFactory::create($email, $password, $nickname, $roles);
    }

    public function edit(Request $request, User &$user) {
        if ($request->request->get('password') == $request->request->get('passwordCheck')) {
            $user->setPassword(password_hash($request->request->get('password'), PASSWORD_DEFAULT));
            $user->setUpdatedAt(new \DateTime());
        }
    }
}