<?php


namespace App\Provider;


use App\Provider\Interfaces\UserProviderInterface;
use App\Repository\UserRepository;

class UserProvider implements UserProviderInterface
{
    private $repository;

    public function __construct(UserRepository $repository){
        $this->repository = $repository;
    }

    public function getAll(){
        return $this->repository->findAll();
    }

    public function getOneById($user_id){
        return $this->repository->findOneBy(['id' => $user_id]);
    }

    public function getOneByNick($nickname){
        return $this->repository->findOneBy(['nickname' => $nickname]);
    }

    public function getOneByEmail($email){
        return $this->repository->findOneBy(['email' => $email]);
    }

    public function getOneByNickname($nickname){
        return $this->repository->findOneBy(['nickname' => $nickname]);
    }

    public function getUsersForAdmin(){
        return $this->repository->findBy(['roles' => 'ROLE_USER']);
    }
}