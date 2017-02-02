<?php

namespace App\Models;
use PDO;

use Core\Model;

class Band extends Model
{
    /**
     * Table name
     * @var string
     */
    protected static $table = 'bands';

    /**
     * Get all rows
     * @return array
     */
    public static function all()
    {
        try {
            $stmt = self::query('SELECT * FROM ' . self::$table);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Get one row
     * @param  integer $id
     * @return object
     */
    public static function get($id)
    {
        try {
            $stmt = self::query('SELECT * FROM ' . self::$table . ' WHERE id = ?', [$id]);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data[0];
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Save a new row
     * @param  array $array
     * @return integer
     */
    public static function save($array)
    {
        try {
            $last_id = self::insert('INSERT INTO ' . self::$table . ' (name) VALUES (?)', [$array['name']]);
            return $last_id;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Delete a row
     * @param  integer $id
     * @return integer
     */
    public static function delete($id)
    {
        $stmt = self::query('DELETE FROM ' . self::$table . ' WHERE id = ?', [$id]);
        return $id;
    }
}
