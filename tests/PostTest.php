<?php

namespace SimpleDemoBlog\Tests;

include __DIR__ . '/../vendor/autoload.php';

use SimpleDemoBlog\Models\Comment;
use SimpleDemoBlog\Models\User;
use SimpleDemoBlog\Tests\TestCase;
use SimpleDemoBlog\Models\Post;
use Faker\Factory as FakerFactory;

class PostTest extends TestCase {

    /**
     *@covers \SimpleDemoBlog\Models\User::setUser_name
     * @covers \SimpleDemoBlog\Models\User::setEmail
     * @covers \SimpleDemoBlog\Models\User::setPassword
     * @covers \SimpleDemoBlog\Models\Post::setTitle
     * @covers \SimpleDemoBlog\Models\Post::setBody
     * @covers \SimpleDemoBlog\Models\Post::setUser_id
     * @covers \SimpleDemoBlog\Models\Comment::setComment
     * @covers \SimpleDemoBlog\Models\Comment::setPostId
     * @covers \SimpleDemoBlog\Models\Comment::setUserName
     */
    public function testCreatePost() {

       $user = new User;

        $user->setUser_name($this->faker->userName);
        $user->setEmail($this->faker->email);
        $user->setPassword($this->faker->password);
        $user->save();

        $post = new Post;

        $postTitle = $this->faker->word;
        $postContent = $this->faker->text;

        $post->setTitle($postTitle);
        $post->setBody($postContent);
        $post->setUser_id($user->getId());

        $post->save();

        $this->assertEquals($postTitle,$post->getTitle());
        $this->assertEquals($postContent,$post->getBody());

        for ($x=0;$x <= $this->faker->numberBetween(3,6); $x++) {
            $comment = new Comment();
            $comment->setComment($this->faker->text);
            $comment->setPostId($post->getId());
            $comment->setUserName($this->faker->userName);
            $comment->save();
        }

    }
}
