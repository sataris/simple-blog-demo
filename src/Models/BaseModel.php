<?php

namespace SimpleDemoBlog\Models;

use PDO;

include(__DIR__.'/../../vendor/autoload.php');

/**
 * Class BaseModel
 */
class BaseModel
{

    protected int $id = 0;
    protected string $table;

    protected array $fields;
    protected PDO $pdo;
    private mixed $updated_at;
    private mixed $created_at;

    public function __construct()
    {
        $this->pdo = new PDO("mysql:host=db;dbname=db", 'root', 'simple-blog');
    }

    /**
     * Retrieves a record from the table corresponding to the calling class based on the given ID.
     *
     * @param  int  $id  The ID of the record to retrieve.
     * @return object|null An object of the calling class representing the retrieved record, or null if the record is not found.
     */
    public static function find(int $id): ?object
    {
        $model = new (self::getCallingClass());
        $table = $model->getTable();

        $sql = "SELECT * FROM $table WHERE id = :id";

        $stmt = $model->getDBConnection()->prepare($sql);

        $stmt->bindParam(':id', $id);
        $stmt->execute();

        //        var_dump($stmt->fetch(PDO::FETCH_ASSOC));
        $array = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!empty($array)) {
            foreach ($array as $key => $value) {
                $methodName = 'set'.ucfirst($key);
                $model->$methodName($value);
            }

            return $model;
        }

        return null;


    }

    /**
     * Returns the name of the calling class.
     *
     * @return string The name of the calling class.
     */
    protected static function getCallingClass()
    {
        return get_called_class();
    }

    /**
     * Retrieves the name of the table associated with the current object.
     *
     * @return string The name of the table.
     */
    public function getTable(): string
    {
        return $this->table;
    }

    /**
     * Returns the PDO database connection object.
     *
     * @return \PDO The PDO database connection object.
     */
    protected function getDBConnection(): PDO
    {
        return $this->pdo;
    }


    /**
     * Fetches all records from the table corresponding to the calling class.
     *
     * @return array An array of objects of the calling class, representing the fetched records.
     */
    public static function all(): array
    {
        $model = new (self::getCallingClass());
        $table = $model->getTable();

        $sql = "SELECT * FROM $table order by created_at desc";

        $stmt = $model->getDBConnection()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_CLASS, self::getCallingClass());

    }

    /**
     * Saves the data of the object to the database.
     * If the object has an ID, it updates the corresponding database record.
     * If the object doesn't have an ID, it creates a new database record.
     *
     * @return void
     */
    public function save(): void
    {
        $this->fields = array_merge($this->fields);
        $placeholders = array_map(function ($field) {
            return ':'.$field;
        }, array_merge($this->fields, ['created_at', 'updated_at']));

        if (!empty($this->id)) {
            $update_clauses = array_map(fn($field) => "$field = :" . $field, $this->fields);
            $update_clauses = implode(", ", $update_clauses);


            $stmt = $this->pdo->prepare("UPDATE $this->table SET $update_clauses, updated_at = NOW() WHERE id = :id");
            foreach ($this->fields as $field) {
                $fieldMethod = 'get'.ucfirst($field);
                $stmt->bindValue(':'.$field, $this->$fieldMethod());
            }
            $stmt->bindValue(':id', $this->getId());
            $stmt->execute();

        } else {
            $stmt = $this->pdo->prepare("INSERT INTO $this->table (".implode(',',
                    array_merge($this->fields, ['created_at', 'updated_at'])).") VALUES (".implode(',',
                    $placeholders).")");
            foreach ($this->fields as $field) {
                $fieldMethod = 'get'.ucfirst($field);
                $stmt->bindValue(':'.$field, $this->$fieldMethod());
            }
            $stmt->bindValue(':created_at', date('Y-m-d H:i:s'));
            $stmt->bindValue(':updated_at', date('Y-m-d H:i:s'));

            //        var_dump($stmt->queryString);
            $stmt->execute();
            $this->setId($this->pdo->lastInsertId());
        }


        //        var_dump('the id is ' . $this->id);

    }

    /**
     * Gets the id of the object.
     *
     * @return int The id of the object.
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Sets the ID of the object.
     *
     * @param  int  $id  The ID to set.
     * @return void
     */

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * Get the "created_at" date as a DateTime object.
     *
     * @return \DateTime The "created_at" date as a DateTime object.
     */
    public function getCreated_At(): \DateTime
    {
        return date_create_from_format('Y-m-d H:i:s', '2024-05-11 08:30:40');
    }

    /**
     * Sets the value of the created_at property.
     *
     * @param  string  $created_at  The created_at value to be set.
     * @return void
     */
    public function setCreated_At(string $created_at): void
    {
        $this->created_at = $created_at;
    }

    /**
     * Returns the updated_at property as a DateTime object.
     *
     * @return \DateTime The updated_at property as a DateTime object.
     */
    public function getUpdated_At(): \DateTime
    {
        return date_create_from_format('Y-m-d H:i:s', $this->created_at);
    }

    /**
     * Set the updated_at timestamp for the object.
     *
     * @param  string  $updated_at  The updated_at timestamp value.
     * @return void
     */
    public function setUpdated_At(string $updated_at): void
    {
        $this->updated_at = $updated_at;
    }
}