<?php

namespace SimpleDemoBlog\Models;

use PDO;

include __DIR__.'/../../vendor/autoload.php';

class Comment extends BaseModel
{

    protected string $table = 'comments';

    protected array $fields = ['post_id', 'username', 'comment'];
    private int $post_id;
    private string $comment;
    private mixed $created_at;
    private mixed $updated_at;
    private string $username;
    private $captcha;

    public static function byPostId(int $postId)
    {
        /** @var Comment $model */
        $model = new(self::getCallingClass());
        $stmt = $model->getDBConnection()->prepare("SELECT * FROM ".$model->getTable()." WHERE post_id = :post_id");
        $stmt->bindValue(':post_id', $postId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, self::getCallingClass());
    }

    public function getComment()
    {
        return $this->comment;
    }

    public function setComment(string $comment)
    {
        $this->comment = $comment;
    }

    public function getPost_Id(): int
    {
        return $this->post_id;
    }

    public function setPostId(int $postId)
    {
        $this->post_id = $postId;
    }

    /**
     * @return mixed
     */
    public function getUserName(): mixed
    {
        return $this->username;
    }

    public function setUserName(string $username): void
    {
        $this->username = $username;
    }
    
    public function setCaptcha($captcha): void {
        $this->captcha = $captcha;
    }

    public function getCaptcha(): string {
        return $this->captcha;
    }
}