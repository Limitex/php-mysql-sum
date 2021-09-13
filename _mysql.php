<?php
class MySQL {
    
    private $MySQL_PDO, $SQL;

    function __construct($hostname, $username, $password, $database) {
        try {
            $this->MySQL_PDO = new PDO ("mysql:host=$hostname;dbname=$database;charset=utf8", $username, $password);
        } catch (PDOException $e) {
            echo $e->getMessage;
            exit;
        }
        $this->SQL = array(
            'TABLES' => array(),
            'COLUMN' => array(),
            'CREATE' => array(),
            'UPDATE' => array(),
            'SELECT' => array(),
            'INSERT' => array(),
            'DELETE' => array(), 
            'DROP' => array()
        );
    }

    function __destruct() {
        $this->MySQL_PDO = NULL;
        $this->SQL = NULL;
    }
    
    function send_sql($SQL, $parms = NULL) {
        $stmt = $this->MySQL_PDO->prepare($SQL);
        if($stmt->execute($parms)) return array( true, $stmt->fetchAll() );
        else return array( false, 'SQL could not be executed for some reason.' );
    }

    function table_initialize($table, $array) {
        if(in_array($table, $this->SQL['TABLES'])) return array( false, 'The table is already defined.');
        $array = array('ID' => "int AUTO_INCREMENT NOT NULL PRIMARY KEY") + $array;
        $create = ''; $insert = array('', ''); $column = array(); $update = '';
        foreach($array as $key => $value){
            $create = $create.$key.' '.$value.', ';
            if($key != 'ID'){
                $insert[0] = $insert[0].$key.', ';
                $insert[1] = $insert[1].':'.$key.', ';
                $column += array(count($column) => $key);
                $update = $update.$key.'=:'.$key.', ';
            }
        }
        // $this->SQL['CREATE'][$table] = "CREATE TABLE IF NOT EXISTS `$table` ".'('.rtrim($create, ', ').');';
        $this->SQL['TABLES'][count($this->SQL['TABLES'])] = $table;
        $this->SQL['COLUMN'][$table] = $column;
        $this->SQL['CREATE'][$table] = "CREATE TABLE `$table` ".'('.rtrim($create, ', ').');';
        $this->SQL['UPDATE'][$table] = "UPDATE `$table` SET ".rtrim($update, ', ')." where ID = :ID;";
        $this->SQL['SELECT'][$table] = "SELECT * from (SELECT * from `$table`) as A order by ID;";
        $this->SQL['INSERT'][$table] = "INSERT INTO `$table` ".'('.rtrim($insert[0], ', ').') VALUES ('.rtrim($insert[1], ', ').');';
        $this->SQL['DELETE'][$table] = "DELETE FROM `$table` WHERE ID = :ID; SET @i := 0; UPDATE `$table` SET ID = (@i := @i + 1);";
        $this->SQL['DROP'][$table] = "DROP TABLE `$table`;";
        return array( true, '' );
    }

    function show_sqls() {
        foreach($this->SQL as $key1 => $array){
            foreach($array as $key => $value){
                if(!is_array($value)){
                    echo '['.$key1.']['.$key.'] = "'.$value.'"<br>';
                }else{
                    foreach($value as $k => $a){
                        echo '['.$key1.']['.$key.']['.$k.'] = "'.$a.'"<br>';
                    }
                }
                
            }
            echo "<br>";
        }
    }

    function CREATE($table = NULL) {
        if(empty($table)){
            $count = 0;
            foreach ($this->SQL['CREATE'] as $sql){
                $result = $this->send_sql($sql);
                if(!$result[0]) $count++;
            }
            return array( $count == 0, $count, $count.' failures' );
        }else{
            foreach ($this->SQL['CREATE'] as $key => $sql){
                if($table == $key){
                    $result = $this->send_sql($sql);
                    if(!$result[0]) return array( false, 1, '1 failures' );
                    return array( true, 0, '0 failures' );
                }
            }
            return array( false, -1, 'The specified table is not defined.');
        }
    }

    function SELECT($table){
        return $this->send_sql($this->SQL['SELECT'][$table]);
    }

    function INSERT($table, $array) {
        $sql_columns = $this->SQL['COLUMN'][$table];
        $insert_columns = array_keys($array);
        $params = $this->params($sql_columns, $insert_columns, $array);
        $this->send_sql($this->SQL['INSERT'][$table], $params);
    }

    function UPDATE($table, $where, $array){
        $array = array('ID' => $where) + $array;
        $sql_columns = $this->SQL['COLUMN'][$table]; array_unshift($sql_columns, 'ID');
        $insert_columns = array_keys($array);
        $params = $this->params($sql_columns, $insert_columns, $array);
        $this->send_sql($this->SQL['UPDATE'][$table], $params);
    }

    function DELETE($table, $id) {
        $this->send_sql($this->SQL['DELETE'][$table], array(':ID' => $id));
    }

    function DROP($table) {
        $this->send_sql($this->SQL['DROP'][$table]);
        unset($this->SQL['DROP'][$table]);
    }

    private function params($sql_columns, $insert_columns, $array){
        $params = array(); 
        foreach($sql_columns as $sc){
            foreach($insert_columns as $ic){
                if($sc == $ic){
                    $params += array(':'.$sc => $array[$ic]);
                }
            }
        }
        return $params;
    }
}
?>