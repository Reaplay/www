<?php
    /**
     * Created by PhpStorm.
     * User: Reaplay
     * Date: 28.04.2016
     * Time: 22:38
     */
    
    class REL_DB_MySQLi {
        public $query, $conntection;
    
        function __construct($mysqli_host, $mysqli_user, $mysqli_pass,$mysqli_db,$mysqli_charset) {
            $this->connection = @mysqli_connect($mysqli_host, $mysqli_user, $mysqli_pass);
            if (!$this->connection)
                die("[" . mysqli_connect_errno() . "] dbconn: mysqli_connect: " . mysqli_connect_errno());
            mysqli_select_db($this->connection,$mysqli_db)
            or die("dbconn: mysqli_select_db: " + mysqli_connect_errno());
    
            $this->my_set_charset($this->connection,$mysqli_charset);
            $this->query = array();
            register_shutdown_function("mysqli_close", $this->connection);
           // mysqli_close($this->connection);
            //$this->query[0] = array("seconds" => 0, "query" => 'TOTAL');
        }
    
        /**
         * Sets charset to database connection.
         * @param string $charset Charset to be set
         * @return void
         */
        function my_set_charset($link,$charset) {
            if (!function_exists("mysqli_set_charset") || !mysqli_set_charset($link,$charset)) mysqli_query("SET NAMES $charset");
            return;
        }
    
        /**
         * Preforms a sql query and writes query and time to statistics
         * @param string $query Query to be performed
         * @return resource Mysql resource
         */
        function query($query) {
    
            $query_start_time = microtime(true); // Start time
            $result = mysqli_query($this->connection,$query);
            $query_end_time = microtime(true); // End time
            $query_time = ($query_end_time - $query_start_time);
            //$query_time = substr($query_time, 0, 8);
            $this->query[] = array("seconds" => $query_time, "query" => $query);
            return $result;
        }
    
    }