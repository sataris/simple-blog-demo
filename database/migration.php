<?php

namespace SimpleDemoBlog\Migrations;

use PDO;

class migration
{
    const CHARSET = 'utf8mb4';
    private $host;
    private $db;
    private $user;
    private $pass;
    private $charset;
    private PDO $conn;

    public function __construct($charset = self::CHARSET)
    {
        $this->charset = $charset;
        $this->establishConnection();
        $this->truncateAllTables();
    }

    /**
     * Run a database query.
     *
     * @param  string  $query  The SQL query to be executed.
     * @param  string  $name  The name of the query (optional, default is 'Query').
     *
     * @return void
     * @throws \Exception If the query execution fails.
     */
    private function runQuery(string $query, string $name = 'Query'): void
    {
       try {
    $this->getConn()->exec($query);
    echo "Ran ".$name.' successfully'.PHP_EOL;
} catch (PDOException $e) {
    throw new Exception($e->getMessage());
}
    }

    /**
     * Run database migration to create table posts.
     * In a real application, I would use a migration package or similar to allow us to rollback db changes
     */
    public function migrate()
    {
        if (empty($this->getConn())) {
            try {
                $this->establishConnection();
            } catch (\Exception $e) {
                die($e->getMessage());
            }
        }

        $usersTableCommand = "CREATE TABLE users (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            user_name VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
            email VARCHAR(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL UNIQUE,
            password VARCHAR(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                   updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";

        $this->runQuery($usersTableCommand, 'Create Users Table');

        $postsTableCommand = "CREATE TABLE posts (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT(6) UNSIGNED NOT NULL,
    title VARCHAR(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    body TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FULLTEXT(body),
    INDEX(title)
    ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";

        $this->runQuery($postsTableCommand, 'Create Posts Table');

        $alterPostsTableCommand = "ALTER TABLE posts
            ADD FOREIGN KEY (user_id) REFERENCES users(id)";
        $this->runQuery($alterPostsTableCommand, 'Link Posts & Users Table');

        $commentsTableCommand = "CREATE TABLE comments (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    post_id INT(6) UNSIGNED NOT NULL,
    username VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    comment TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    captcha VARCHAR(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci";

        $this->runQuery($commentsTableCommand, 'Create Comments Table');

        $alterCommentsTableCommand1 = "ALTER TABLE comments
    ADD FOREIGN KEY (post_id) REFERENCES posts(id)";

        $this->runQuery($alterCommentsTableCommand1, 'Link Posts & Comments Table');
    }

    /**
     * Establishes a connection to the database.
     *
     * @throws \Exception If the connection fails
     */
    function establishConnection(): void
    {

        try {
            $this->conn = new PDO("mysql:host=db;dbname=db", 'root', 'simple-blog');
            // Set the PDO error mode to exception
            $this->getConn()->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            throw new Exception("Connection failed: ".$e->getMessage());
        }
    }

    public function getConn() {
        return $this->conn;
    }
    function truncateAllTables(): void
{
    try {
        // Fetch all the table names in the database
        $tablesQuery = $this->getConn()->query('SHOW TABLES');
        $this->getConn()->exec('SET FOREIGN_KEY_CHECKS=0;');
        while ($table = $tablesQuery->fetch(PDO::FETCH_NUM)) {
            // Truncate each one
            $this->getConn()->exec('TRUNCATE TABLE ' . $table[0]);
        }
        $this->getConn()->exec('SET FOREIGN_KEY_CHECKS=1;');
        echo "All tables truncated successfully" . PHP_EOL;
    } catch (PDOException $e) {
        $this->getConn()->rollBack();
        throw new Exception($e->getMessage());
    }
}
}
// To keep thing stupid simple, let's just run this class when it runs this file.
$migration = new migration();

$migration->migrate();