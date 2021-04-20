<?php


namespace App\Service\Interfaces;


use App\Entity\Post;

interface PostServiceInterface
{
    public function create(Post &$post): void;
    public function delete(Post $post): void;
    public function save(): void;
}