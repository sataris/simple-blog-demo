<?php

namespace SimpleDemoBlog\Models;


use PDO;

include (__DIR__ . '/../../vendor/autoload.php');

/**
 * @property string $password
 */
class User extends BaseModel {

    protected string $table = 'users';

    protected array $fields = ['user_name', 'email', 'password'];
    private string $password;
    private string $user_name;
    private string $email;
    protected int $id;

    private mixed $updated_at;
    private mixed $created_at;

    public function setPassword(string $password) {
        $this->password = password_hash($password,PASSWORD_BCRYPT);
    }

    public function setUser_name(string $username) {
        $this->user_name = $username;
    }

    public function setEmail(string $email) {
        $this->email = $email;
    }

    public function getUser_name() {
        return $this->user_name;
    }

    public function getPassword() {
        return $this->password;
    }

    public function getEmail() {
        return $this->email;
    }

    public static function searchByEmail(string $email) {
       $model = new User();
        $stmt = $model->getDBConnection()->prepare("SELECT * FROM ".$model->getTable()." WHERE email = :searchTerm");
        $stmt->bindParam(':searchTerm', $email);
        $stmt->execute();
//        return $stmt->fetchAll(PDO::FETCH_CLASS, self::getCallingClass());
        $user = $stmt->fetchObject(self::getCallingClass());
        return $user ?: null;
    }

    /**
     *
     */
    public function validatePassword(string $password) {
        if (password_verify($password, $this->password)) {
            return true;
        }
        return false;
    }
}