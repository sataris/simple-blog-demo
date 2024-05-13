<?php

namespace SimpleDemoBlog\Models;

use PDO;

include (__DIR__ . '/../../vendor/autoload.php');
class Post extends BaseModel {

    public string $table = 'posts';

    public array $fields = ['title','body','user_id'];
    private string $title;
    private string $content;
    private User $author;
    private int $user_id;
    private $body;

        private mixed $updated_at;
    private mixed $created_at;

    public function getTitle() {
        return $this->title;
    }

    public function getBody() {
        return $this->body;
    }

    public function getUser() {
        return $this->author;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function setBody($body): void
    {
        $this->body = $body;
    }

    public function author() {
        return User::find($this->user_id);
    }
    public function setAuthor(User $author) {
        $this->user_id = $author->getId();
        $this->author = $author;
    }

    public function getUser_id() {
        return $this->user_id;
    }

    public function setUser_id($user_id) {
        $this->user_id = $user_id;
    }

    public function comments() {
        return Comment::byPostId($this->id);
    }

    public static function search($string)
    {
        $model = new Post();
        $searchTerm = '%'.$string.'%';
        $stmt = $model->getDBConnection()->prepare("SELECT * FROM ".$model->getTable()." WHERE title LIKE :searchTerm OR body LIKE :searchTerm");
        $stmt->bindParam(':searchTerm', $searchTerm);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, self::getCallingClass());
    }
    public static function pagination(int $start, int $end) {
        $model = new Post();
        $stmt = $model->getDBConnection()->prepare("SELECT * FROM ".$model->getTable()." ORDER BY id desc LIMIT :start, :end");
        $stmt->bindParam(':start', $start, PDO::PARAM_INT);
        $stmt->bindParam(':end', $end, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, self::getCallingClass());
    }
}