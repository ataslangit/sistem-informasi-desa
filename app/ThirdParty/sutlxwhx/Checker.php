<?php

/**
 * @author https://gist.github.com/sutlxwhx
 *
 * @version 0.2
 *
 * @license Apache License 2.0
 *
 * @see https://gist.github.com/sutlxwhx/db21a12a15ac00b1346ef7cb502a9a1b
 *
 */

namespace sutlxwhx;

class Checker
{
    /**
     * @var string Result of the checking process
     */
    public $result;

    /**
     * @var \mysqli
     */
    private $mysqli;

    /**
     * Use magic method __construct to connect to mysqli, invoke validation and process functions
     */
    public function __construct($db_host, $db_user, $db_password, $db_name)
    {
        @$this->mysqli = new \mysqli($db_host, $db_user, $db_password);
        if (mysqli_connect_errno($this->mysqli)) {
            return $this->result = "Can't connect to MySQL / MariaDB. Check if your credentials are right.";
        }
        if ($this->validate() == true) {
            return $this->result = $this->process($db_name);
        } else {
            return $this->result = "Can't connect to MySQL / MariaDB. Check if you have php7.0-mysql or database installed.";
        }
    }

    /**
     * Check if the required module exists in this PHP installation
     *
     * @return bool Status of the validation process
     */
    private function validate()
    {
        if (extension_loaded('mysqli')) {
            return true;
        } else {
            return false;
        }

        return true;
    }

    /**
     * Get the response from MySQL / MariaDB
     *
     * @param $db_name Name of the database to check
     * @return bool Status of existence of this database
     */
    private function process($db_name)
    {
        $check_connection = mysqli_fetch_row($this->mysqli->query("SELECT SQL_NO_CACHE IF(EXISTS (SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = '$db_name'), 'Yes','No');"));
        if ($check_connection[0] === "Yes") {
            return true;
        } elseif ($check_connection[0] === "No") {
            return false;
        }
    }

    /**
     * Use magic method __destruct() to close the connection to the MySQL / MariaDB instance
     */
    public function __destruct()
    {
        @mysqli_close($this->mysqli);
    }
}

/**
 * Initialise Checker class and set the necessary parameters
 * Dump the result element of an object
 */
/* $mysql_checker = new Checker('127.0.0.1', 'admin', 'aA12345%', 'example.com'); */
/* var_dump($mysql_checker->result); */
