<?php

namespace app\Util;

use app\Model\Auditrail;

class Database {

    private $db_host = DB_HOST;  // Change as required
    private $db_user = DB_USER;  // Change as required
    private $db_pass = DB_PASS;  // Change as required
    public $db_name = DB_NAME; // Change as required
    private $db_driver = DB_DRIVER;
    private $mysql = "";


    /*
     * Extra variables that are required by other function such as boolean con variable
     */
    private $con = false; // Check to see if the connection is active
    private $result = array(); // Any results from a query will be stored here
    public $myQuery = ""; // used for debugging process with SQL return
    private $numResults = ""; // used for returning the number of rows
    // Function to make connection to database
    private static $sqls = '';
    private $createAuditrail = array();
    private $updateAuditrail = array();
    public $insert_log = true;
    
    public function getDb_host() {
        return $this->db_host;
    }

    public function getDb_user() {
        return $this->db_user;
    }

    public function getDb_pass() {
        return $this->db_pass;
    }

    public function getDb_name() {
        return $this->db_name;
    }

    public function getDb_driver() {
        return $this->db_driver;
    }

    public function setDb_host($db_host) {
        $this->db_host = $db_host;
    }

    public function setDb_user($db_user) {
        $this->db_user = $db_user;
    }

    public function setDb_pass($db_pass) {
        $this->db_pass = $db_pass;
    }

    public function setDb_name($db_name) {
        $this->db_name = $db_name;
    }

    public function setDb_driver($db_driver) {
        $this->db_driver = $db_driver;
    }

    
    public function connect() {
        if (!$this->con) {
            if ($this->db_driver == "mysql") {
                $myconn = @mysql_connect($this->db_host, $this->db_user, $this->db_pass);  // mysql_connect() with variables defined at the start of Database class
                if ($myconn) {
                    $seldb = @mysql_select_db($this->db_name, $myconn); // Credentials have been pass through mysql_connect() now select the database
                    if ($seldb) {
                        $this->con = true;
                        return true;  // Connection has been made return TRUE
                        $this->log_masuk("CONNECTION DATABASE BERHASIL : ");
                    } else {
                        array_push($this->result, mysql_error());
                        $this->log_masuk("GAGAL CONNECT : " . mysql_error());
                        return false;  // Problem selecting database return FALSE
                    }
                } else {
                    array_push($this->result, mysql_error());
                    $this->log_masuk("GAGAL CONNECT : " . mysql_error());
                    return false; // Problem connecting return FALSE
                }
            } else if ($this->db_driver == "mysqli") {
                $myconn = new \mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);  // mysql_connect() with variables defined at the start of Database class    
                if ($myconn->connect_errno) {
//                    die("ERROR : -> " . $MySQLiconn->connect_error);
                    array_push($this->result, mysql_error());
                    $this->log_masuk("GAGAL CONNECT : " . $myconn->connect_error);
                    return false;
                } else {
                    $this->mysql = $myconn;
                    $this->con = true;
                    return true;
                }
            }
        } else {
            return true; // Connection has already been made return TRUE 
        }
    }

    // Function to disconnect from the database
    public function disconnect() {
        // If there is a connection to the database
        if ($this->db_driver == "mysql") {
            if ($this->con) {
                // We have found a connection, try to close it
                if (@mysql_close()) {
                    // We have successfully closed the connection, set the connection variable to false
                    $this->con = false;
                    // Return true tjat we have closed the connection
                    return true;
                } else {
                    // We could not close the connection, return false
                    return false;
                }
            }
        } else if ($this->db_driver == "mysqli") {
            if ($this->mysql->close()) {
                // We have successfully closed the connection, set the connection variable to false
                $this->con = false;
                // Return true tjat we have closed the connection
                return true;
            } else {
                // We could not close the connection, return false
                return false;
            }
        }
    }

    public function sql($sql) {
//        echo $sql;
        if ($this->db_driver == "mysql") {
            $query = @mysql_query($sql);
            $this->myQuery = $sql; // Pass back the SQL
            if ($query) {
                // If the query returns >= 1 assign the number of rows to numResults
                $this->numResults = mysql_num_rows($query);
                // Loop through the query results by the number of rows returned
                for ($i = 0; $i < $this->numResults; $i++) {
                    $r = mysql_fetch_array($query);
                    $key = array_keys($r);
                    for ($x = 0; $x < count($key); $x++) {
                        // Sanitizes keys so only alphavalues are allowed
                        if (!is_int($key[$x])) {
                            if (mysql_num_rows($query) >= 1) {
                                $this->result[$i][$key[$x]] = $r[$key[$x]];
                                $this->log_masuk("WRITE SQL BERHASIL : " . $sql);
                            } else {
                                $this->result = null;
                                $this->log_masuk("WRITE SQL NULL ");
                            }
                        }
                    }
                }
                return true; // Query was successful
            } else {
                array_push($this->result, mysql_error());
                $this->log_masuk("GAGAL WRITE SQL : " . mysql_error());
                return false; // No rows where returned
            }
        } else if ($this->db_driver == "mysqli") {
            $this->myQuery = $sql;
            $query = $this->mysql->query($sql);
//            print_r($query);
            if ($query) {
                $this->numResults = $query->num_rows;
                // Loop through the query results by the number of rows returned
                for ($i = 0; $i < $this->numResults; $i++) {
                    $r = $query->fetch_array();
                    $key = array_keys($r);
                    for ($x = 0; $x < count($key); $x++) {
                        // Sanitizes keys so only alphavalues are allowed
                        if (!is_int($key[$x])) {
                            if ($query->num_rows >= 1) {
                                $this->result[$i][$key[$x]] = $r[$key[$x]];
                                $this->log_masuk("WRITE SQL BERHASIL : " . $sql);
                            } else {
                                $this->result = null;
                                $this->log_masuk("WRITE SQL NULL ");
                            }
                        }
                    }
                }
                return true; // Query was successful
            } else {
                LOGGER($this->mysql->error);
                array_push($this->result, $this->mysql->error);
                $this->log_masuk("GAGAL WRITE SQL : " . $this->mysql->error);
                return false; // No rows where returned
            }
        }
    }

    public function log_masuk($msg) {
        
    }

    public function selectRelation($table) {
        $this->connect();
        $this->sql('' .
                'select TABLE_NAME,COLUMN_NAME,CONSTRAINT_NAME,REFERENCED_TABLE_NAME,' .
                'REFERENCED_COLUMN_NAME from INFORMATION_SCHEMA.KEY_COLUMN_USAGE' .
                ' where TABLE_SCHEMA = "' . $this->db_name . '" and TABLE_NAME = "' . $table . '"' .
                ' and referenced_column_name is not NULL;');

        $result = $this->getResult();
//        echo $this->getSql();
        return $result;
    }

    public function selectByID($table, $where = null) {
        $this->connect();
        $this->select($table->getEntity(), "*", array(), $where, null);
        $result = $this->getResult();

        return $result;
    }

    /**
     * (PHP 4, PHP 5+)<br/>
     * SELECT TABLE FROM YOUR DATABASE WITH PARAM
     * Licensed by Tripoin Team
     * @link http://www.tripoin.co.id/
     * @param String $table [optional] <p>
     * set your table ex:mst_province
     * </p>
     * @param String $rows [optional] <p>
     * set your rows or select field ex - All = * , and other
     * </p>
     * @param String $where [optional] <p>
     * set where field table ex:code=0
     * </p>
     * @param String $order [optional] <p>
     * set order by table ex: code ASC.
     * </p>
     * @param String $limit [optional] <p>
     * set limit table ex: 0,10.
     * </p>
     * @return Boolean A formatted version of <i>true or false</i><p>
     * if you get array from  this select table, doing $db->getResult();
     * </p>
     * 
     */
    public function select($table, $rows = '*', $join = array(), $where = null, $order = null, $limit = null) {
        // Create query from the variables passed to the function
        $q = 'SELECT ' . $rows . ' FROM ' . $table;
        /* if ($join != null) {
          $q .= ' JOIN ' . $join;
          }
         * */
        if (!empty($join)) {
            if (is_array($join)) {
                foreach ($join as $value) {
                    $q .= ' JOIN ' . $value;
                }
            } else {
                $q .= ' JOIN ' . $value;
            }
        }
        if ($where != null) {
            $q .= ' WHERE ' . $where;
        }
        if ($order != null) {
            $q .= ' ORDER BY ' . $order;
        }
        if ($limit != null) {
            $q .= ' LIMIT ' . $limit;
        }
//        echo $q;
        $this->myQuery = $q; // Pass back the SQL
        // Check to see if the table exists
        if ($this->db_driver == "mysql") {
            if ($this->tableExists($table)) {
                // The table exists, run the query
                $query = @mysql_query($q);
                if ($query) {
                    // If the query returns >= 1 assign the number of rows to numResults
                    $this->numResults = mysql_num_rows($query);
                    // Loop through the query results by the number of rows returned
                    for ($i = 0; $i < $this->numResults; $i++) {
                        $r = mysql_fetch_array($query);
                        $key = array_keys($r);
                        for ($x = 0; $x < count($key); $x++) {
                            // Sanitizes keys so only alphavalues are allowed
                            if (!is_int($key[$x])) {
                                if (mysql_num_rows($query) >= 1) {
                                    $this->result[$i][$key[$x]] = $r[$key[$x]];
//                                    $this->log_masuk('SUKSES SELECT Table : ' . $table);
                                } else {
                                    $this->result = null;
//                                    $this->log_masuk('SELECT DATA NULL');
                                }
                            }
                        }
                    }
                    return true; // Query was successful
                } else {
                    array_push($this->result, mysql_error());
//                    $this->log_masuk("GAGAL SELECT : " . mysql_error());
                    return false; // No rows where returned
                }
            } else {
//                $this->log_masuk("GAGAL SELECT : " . mysql_error());
                return false; // Table does not exist
            }
        } else if ($this->db_driver == "mysqli") {
            if ($this->tableExists($table)) {
                // The table exists, run the query
                $query = $this->mysql->query($q);
//                print_r($query);
                if ($query) {
                    // If the query returns >= 1 assign the number of rows to numResults
                    $this->numResults = $query->num_rows;
                    // Loop through the query results by the number of rows returned
                    for ($i = 0; $i < $this->numResults; $i++) {
                        $r = $query->fetch_array();
//                        print_r($r);
                        $key = array_keys($r);
                        for ($x = 0; $x < count($key); $x++) {
                            // Sanitizes keys so only alphavalues are allowed
                            if (!is_int($key[$x])) {
                                if ($query->num_rows >= 1) {
                                    $this->result[$i][$key[$x]] = $r[$key[$x]];
                                    $this->log_masuk('SUKSES SELECT Table : ' . $table);
                                } else {
                                    $this->result = null;
                                    $this->log_masuk('SELECT DATA NULL');
                                }
                            }
                        }
                    }
                    return true; // Query was successful
                } else {
//                    LOGGER($this->mysql->error);
                    error_get_last()['message'] = $this->mysql->error;
                    array_push($this->result, $this->mysql->error);
                    $this->log_masuk("GAGAL SELECT : " . $this->mysql->error);
                    return false; // No rows where returned
                }
            } else {
                $this->log_masuk("GAGAL SELECT : " . $this->mysql->error);
                return false; // Table does not exist
            }
        }
    }

    // Function to insert into the database
    public function insert($table, $params = array()) {
        // Check to see if the table exists
        //	$attack = array('status'=>'1');
        //	$attack = array();
        if (!empty($this->createAuditrail)) {
            $params = array_merge($params, $this->createAuditrail);
        }
        if ($this->db_driver == "mysql") {
            if ($this->tableExists($table)) {
                $sql = 'INSERT INTO `' . $table . '` (`' . implode('`, `', array_keys($params)) . '`) VALUES ("' . implode('", "', $params) . '")';
//            preg_match_all('/fn_name\((["\'])(.*?)\1\)/', $to, $out);
//            $sql .= addcslashes($sql, "\'\"");
                $this->myQuery = $sql; // Pass back the SQL
                // Make the query to insert to the database
                if ($ins = @mysql_query($sql)) {
                    array_push($this->result, mysql_insert_id());
                    $this->log_masuk('SUKSES INSERT DENGAN ID = ' . mysql_insert_id() . ' dan Table = ' . $table);
                    return true; // The data has been inserted
                } else {

                    array_push($this->result, mysql_error());
                    $this->log_masuk("GAGAL INSERT : " . mysql_error());
                    return false; // The data has not been inserted
                }
            } else {
                $this->log_masuk("GAGAL INSERT : " . mysql_error());
                return false; // Table does not exist
            }
        } else if ($this->db_driver == "mysqli") {
            if ($this->tableExists($table)) {
                $sql_insert = '';
                foreach ($params as $key => $value) {
                    if ($value !== NULL) {
//                        LOGGER($key.'='.$value);
                        if ($value == NULL) {
//                            LOGGER('DATA NULL');
                            $sql_insert .= $key . " = null,";
                        } else {
                            $sql_insert .= $key . " = '" . $this->mysql->real_escape_string($value) . "',";
                        }
                    } else if ($value === NULL) {
//                        LOGGER('DATA NULL');
                        $sql_insert .= $key . " = null,";
                    } else if ($value == NULL) {
//                        LOGGER('DATA NULL');
                        $sql_insert .= $key . " = null,";
                    } else {
                        LOGGER($key . ":" . $value);
                    }
                }
                $sql_insert2 = rtrim($sql_insert, ',');
                $sql = 'INSERT INTO ' . $table . ' SET ' . $sql_insert2;
//            preg_match_all('/fn_name\((["\'])(.*?)\1\)/', $to, $out);
//            $sql .= addcslashes($sql, "\'\"");
                $this->myQuery = $sql; // Pass back the SQL
                // Make the query to insert to the database
                if ($this->mysql->query($sql)) {
                    array_push($this->result, $this->mysql->insert_id);
                    $this->log_masuk('SUKSES INSERT DENGAN ID = ' . $this->mysql->insert_id . ' dan Table = ' . $table);
                    return true; // The data has been inserted
                } else {
                    LOGGER($this->mysql->error);
                    array_push($this->result, $this->mysql->error);
                    $this->log_masuk("GAGAL INSERT : " . $this->mysql->error);
                    return false; // The data has not been inserted
                }
            } else {
                $this->log_masuk("GAGAL INSERT : " . $this->mysql->error);
                return false; // Table does not exist
            }
        }
    }

    //Function to delete table or row(s) from database
    public function delete($table, $where = null) {
        // Check to see if table exists
        if ($this->db_driver == "mysql") {
            if ($this->tableExists($table)) {
                // The table exists check to see if we are deleting rows or table
                if ($where == null) {
                    $delete = 'DELETE ' . $table; // Create query to delete table
                } else {
                    $delete = 'DELETE FROM ' . $table . ' WHERE ' . $where; // Create query to delete rows
                }
                // Submit query to database
                if ($del = @mysql_query($delete)) {
                    array_push($this->result, mysql_affected_rows());
                    $this->myQuery = $delete; // Pass back the SQL
                    $this->log_masuk("DELETE SUKSES Tabel :" . $table);
                    return true; // The query exectued correctly
                } else {
                    array_push($this->result, mysql_error());
                    $this->log_masuk("GAGAL DELETE : " . mysql_error());
                    return false; // The query did not execute correctly
                }
            } else {
                $this->log_masuk(mysql_error());
                $this->log_masuk("GAGAL DELETE : " . mysql_error());
                return false; // The table does not exist
            }
        } else if ($this->db_driver == "mysqli") {
            if ($this->tableExists($table)) {
                // The table exists check to see if we are deleting rows or table
                if ($where == null) {
                    $delete = 'DELETE ' . $table; // Create query to delete table
                } else {
                    $delete = 'DELETE FROM ' . $table . ' WHERE ' . $where; // Create query to delete rows
                }
                // Submit query to database
                if ($this->mysql->query($delete)) {
                    array_push($this->result, $this->mysql->affected_rows);
                    $this->myQuery = $delete; // Pass back the SQL
                    $this->log_masuk("DELETE SUKSES Tabel :" . $table);
                    return true; // The query exectued correctly
                } else {
                    array_push($this->result, $this->mysql->error);
                    $this->log_masuk("GAGAL DELETE : " . $this->mysql->error);
                    return false; // The query did not execute correctly
                }
            } else {
                $this->log_masuk(mysql_error());
                $this->log_masuk("GAGAL DELETE : " . $this->mysql->error);
                return false; // The table does not exist
            }
        }
    }

    // Function to update row in database
    public function update($table, $params = array(), $where) {
        // Check to see if table exists
//        print_r($params);
        if (!empty($this->updateAuditrail)) {
            $params = array_merge($params, $this->updateAuditrail);
        }
        if ($this->db_driver == "mysql") {
            if ($this->tableExists($table)) {
                // Create Array to hold all the columns to update
                $args = array();
                foreach ($params as $field => $value) {
                    // Seperate each column out with it's corresponding value
                    $args[] = $field . '="' . $value . '"';
                }
                // Create the query
                $sql = 'UPDATE ' . $table . ' SET ' . implode(',', $args) . ' WHERE ' . $where;
                // Make query to database
//            echo $sql;
                $this->myQuery = $sql; // Pass back the SQL
                if ($query = @mysql_query($sql)) {
//            	array_push($this->result,mysql_affected_rows());
                    array_push($this->result, 1);
                    $this->log_masuk("UPDATE BERHASIL Table : " . $table);
                    return true; // Update has been successful
                } else {
                    LOGGER(mysql_error());
                    array_push($this->result, mysql_error());
                    $this->log_masuk("GAGAL UPDATE : " . mysql_error());
//                array_push($this->result, 0);
                    return false; // Update has not been successful
                }
            } else {
                $this->log_masuk("GAGAL UPDATE : " . mysql_error());
                return false; // The table does not exist
            }
        } else if ($this->db_driver == "mysqli") {
            if ($this->tableExists($table)) {
                $sql_insert = '';
                foreach ($params as $key => $value) {
                    if ($value !== NULL) {
                        $sql_insert .= $key . " = '" . $this->mysql->real_escape_string($value) . "',";
                    } else if ($value === NULL) {
                        $sql_insert .= $key . " = null,";
                    }
                }
                $sql_insert2 = rtrim($sql_insert, ',');
                $sql = 'UPDATE ' . $table . ' SET ' . $sql_insert2 . ' WHERE ' . $where;
//            preg_match_all('/fn_name\((["\'])(.*?)\1\)/', $to, $out);
//            $sql .= addcslashes($sql, "\'\"");
                $this->myQuery = $sql; // Pass back the SQL
                // Make the query to insert to the database
                if ($this->mysql->query($sql)) {
                    array_push($this->result, 1);
                    $this->log_masuk("UPDATE BERHASIL Table : " . $table);
                    return true; // The data has been inserted
                } else {
                    LOGGER($this->mysql->error);
                    LOGGER($sql);
                    array_push($this->result, $this->mysql->error);
                    $this->log_masuk("GAGAL UPDATE : " . $this->mysql->error);
                    return false; // The data has not been inserted
                }
            } else {
                $this->log_masuk("GAGAL UPDATE : " . $this->mysql->error);
                return false; // Table does not exist
            }
        }
    }

    // Private function to check if table exists for use with queries
    private function tableExists($table) {
        if ($this->db_driver == "mysql") {
            $tablesInDb = @mysql_query('SHOW TABLES FROM ' . $this->db_name . ' LIKE "' . $table . '"');
            if ($tablesInDb) {
                if (mysql_num_rows($tablesInDb) == 1) {
                    return true; // The table exists
                } else {
                    array_push($this->result, $table . " does not exist in this database");
                    $this->log_masuk($table . " does not exist in this database");
                    return false; // The table does not exist
                }
            }
        } else if ($this->db_driver == "mysqli") {
            $tablesInDb = $this->mysql->query('SHOW TABLES FROM ' . $this->db_name . ' LIKE "' . $table . '"');

            if ($tablesInDb) {
                if ($tablesInDb->num_rows == 1) {
                    return true; // The table exists
                } else {
                    array_push($this->result, $table . " does not exist in this database");
                    $this->log_masuk($table . " does not exist in this database");
                    return false; // The table does not exist
                }
            }
        }
    }

    public static function querySql() {
//        self::initialize();
        echo self::$sqls;
    }

    // Public function to return the data to the user
    public function getResult() {
        self::$sqls = $this->myQuery;
        $val = $this->result;
        $this->result = array();
        return $val;
    }

    //Pass the SQL back for debugging
    public function getSql() {
        $val = $this->myQuery;
        $this->myQuery = array();
        return $val;
    }

    //Pass the number of rows back
    public function numRows() {
        $val = $this->numResults;
        $this->numResults = array();
        return $val;
    }

    // Escape your string
    public function escapeString($data) {
        if ($this->db_driver == "mysql") {
            return mysql_real_escape_string($data);
        } else if ($this->db_driver == "mysqli") {
            return $this->mysql->escape_string($data);
        }
    }

    public function createAuditrail() {
        $audit = new Auditrail();
        $result = array(
            $audit->getStatus() => 1,
            $audit->getCreatedByUsername() => $_SESSION[SESSION_USERNAME],
            $audit->getCreatedOn() =>  date(DATE_FORMAT_PHP_DEFAULT),
        );
        $this->createAuditrail = $result;
//        return $result;
    }

    public function updateAuditrail() {
        $audit = new Auditrail();
        $result = array(
            $audit->getStatus() => 1,
            $audit->getModifiedByUsername() => $_SESSION[SESSION_USERNAME],
            $audit->getModifiedOn() =>  date(DATE_FORMAT_PHP_DEFAULT),
        );
        $this->updateAuditrail = $result;
//        return $result;
    }

}
