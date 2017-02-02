<?php

namespace App\Models;
use PDO;

use Core\Model;

class Album extends Model
{
    /**
     * Table name
     * @var string
     */
    protected static $table = 'disks';

    /**
     * Get all rows
     * @return array
     */
    public static function all()
    {
        try {
            $stmt = self::query('SELECT disks.id, disks.name as album, bands.name as band FROM ' . self::$table . ' LEFT JOIN bands ON disks.band_id = bands.id');
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
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
            $last_id = self::insert('INSERT INTO ' . self::$table . ' (band_id, name) VALUES (?, ?)', [$array['band'], $array['name']]);
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


    /**
     * Get all albums from a band
     * @param  integer $id
     * @return mixed
     */
    public static function getByBandId($id)
    {
        try {
            $stmt = self::query('SELECT * FROM ' . self::$table . ' WHERE band_id = ?', [$id]);
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}
