<?php


namespace App\Provider\Interfaces;


interface UserProviderInterface
{
    public function getAll();
    public function getOneById($user_id);
    public function getOneByEmail($email);
    public function getOneByNickname($nickname);
}