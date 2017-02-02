<?php

namespace Core;

use PDO;
use App\Config;

abstract class Model
{
    private static $db = null;
    private static $query;
	private static $error = false;
	private static $results;
	private static $count = 0;

    /**
     * Check if there's an open conection, and use that,
     * otherwise, open a new one.
     *
     * @return resource
     */
    protected static function connect()
    {
        if (self::$db === null) {
            $connection = 'mysql:host=' . Config::DB_HOST . ';dbname=' . Config::DB_NAME . ';charset=utf8';

            try {
                self::$db = new PDO($connection, Config::DB_USER, Config::DB_PASSWORD);
            } catch (Exception $e) {
                throw new \ErrorException($e->getMessage());
            }

            self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
    }

    /**
     * Get the actual instance
     * @return resource
     */
    public static function getInstance()
    {
        if (self::$db === null) {
            self::connect();
        }
        return self::$db;
    }

    /**
     * Prepare query for excecution
     * @param  string $sql
     * @param  array $params
     * @return null
     */
    private static function prepareQuery($sql, $params)
    {
        $conn = self::getInstance();
        if (self::$query = $conn->prepare($sql)) {
			$i = 1;
			if (count($params)) {
				foreach ($params as $param) {
					self::$query->bindValue($i, $param);
					$i++;
				}
			}
			if (self::$query->execute()) {
				self::$count = self::$query->rowCount();
			} else {
				self::$results = null;
				self::$error = true;
				self::$error_info = $conn->errorInfo();
			}
		} else {
			self::$error = true;
			self::$error_info = $conn->errorInfo();
		}
    }

    /**
     * Method for querying
     * @param  PDD $conn
     * @param  string $sql
     * @param  array  $params
     * @return mixed
     */
    public static function query($sql, $params = array()) {
        self::prepareQuery($sql, $params);
        return self::$query;
	}

    /**
     * Method for insert
     * @param  PDD $conn
     * @param  string $sql
     * @param  array  $params
     * @return mixed
     */
    public static function insert($sql, $params = array()) {
		self::prepareQuery($sql, $params);
        return self::$db->lastInsertId();
	}
}
