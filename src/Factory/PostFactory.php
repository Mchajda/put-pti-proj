<?php


namespace App\Factory;


use App\Entity\Post;

class PostFactory
{
    public static function create(
        $text,
        $author,
        $room
    ){
        $post = new Post();

        $post->setText($text);
        $post->setAuthor($author);
        $post->setRoom($room);
        $post->setCreatedAt(new \DateTime());

        return $post;
    }
}