<?php
class Database
{
    private static $_instance;
    private $_pdo,
        $_query,
        $_error = FALSE,
        $_result,
        $_count = 0;

    private function __construct()
    {
        try {
            $this->_pdo = new PDO('mysql:host=localhost;dbname=mess', 'root', '');
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    public static function getInstance() {
        if(!isset(self::$_instance)) {
            self::$_instance = new Database();
        }
        return self::$_instance;
    }

    public function query($sql, $params = array()) {
        $this->_error = false;
        if($this->_query = $this->_pdo->prepare($sql)) {
            $x = 1;
            if(count($params)) {
                foreach($params as $param) {
                    $this->_query->bindValue($x, $param);
                    $x++;
                }
            }

            if($this->_query->execute()) {
                $this->_result = $this->_query->fetchAll(PDO::FETCH_OBJ);
                $this->_count = $this->_query->rowCount();
            } else {
                $this->_error = TRUE;
            }
        }
        return $this;
    }

    public function action($action, $table, $where = array()) {
        if(count($where) === 3) {
            $operators = array('=', '<', '>', '>=', '<=');

            $field      = $where[0];
            $operator   = $where[1];
            $value      = $where[2];

            if(in_array($operator, $operators)) {
                $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";

                if(!$this->query($sql, array($value))->error()) {
                    return $this;
                }
            }
        }
        return FALSE;
    }

    public function get($table, $where) {
        return $this->action('SELECT *', $table, $where);
    }

    public function delete($table, $where) {
        return $this->action('DELETE', $table, $where);
    }

    public function error() {
        return $this->_error;
    }

    public function count() {
        return $this->_count;
    }

    public function result() {
        return $this->_result;
    }

    public function date() {
        date_default_timezone_set('Asia/Dhaka');
        $date = date('Y-m-d h:i:s');
        return $date;
    }

}