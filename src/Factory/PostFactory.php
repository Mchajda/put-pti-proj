<?php


namespace App\Factory;


use App\Entity\Post;

class PostFactory
{
    public static function create(
        $text,
        $author,
        $room,
        $parentPostId
    ){
        $post = new Post();

        $post->setText($text);
        $post->setAuthor($author);
        $post->setRoom($room);
        $post->setParentId($parentPostId);
        $post->setCreatedAt(new \DateTime());

        return $post;
    }
}