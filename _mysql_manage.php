<?php
require( $_SERVER['DOCUMENT_ROOT'] . '/_mysql.php');
class MySQL_Manage {
    private $hostname = 'localhost';
    private $username = 'root';
    private $password = '0000';
    private $database = 'test_database';

    private $table_name1 = 'user_list';
    private $table_name2 = 'list';
    private $table_name3 = 'setting';

    private $table_init1 = array('UserName' => 'varchar(255)', 'PasswordHash' => 'varchar(511)', 'Position' => 'varchar(255)');
    private $table_init2 = array('UserName' => 'varchar(255)', 'CreatorIP' => 'varchar(15)', 'CreatedTime' => 'datetime', 'Description' => 'text(511)');
    private $table_init3 = array('Item' => 'varchar(255)', 'Value' => 'varchar(511)');

    private $mysql;
    
    function __construct() {
        $this->mysql = new MySQL($this->hostname, $this->username, $this->password, $this->database);
        $this->mysql->table_initialize($this->table_name1, $this->table_init1);
        $this->mysql->table_initialize($this->table_name2, $this->table_init2);
        $this->mysql->table_initialize($this->table_name3, $this->table_init3);

        $this->drop();

        $this->mysql->CREATE();
    }

    function show (){
        $this->mysql->show_sqls();
    }

    function select(){       
        $this->mysql->print_a($this->mysql->SELECT($this->table_name1, MySQL::SELECT_TYPE_COUNT), 'SELECT TYPE COUNT');
        $this->mysql->print_a($this->mysql->SELECT($this->table_name1, MySQL::SELECT_TYPE_LIST, MySQL::SELECT_TYPE_ALL), 'SELECT TYPE LIST ALL');
        $this->mysql->print_a($this->mysql->SELECT($this->table_name1, MySQL::SELECT_TYPE_LIST, MySQL::SELECT_TYPE_LATEST, 5), 'SELECT TYPE LIST LATEST');     
    }

    function insert (){
        for($i = 0; $i < 10; $i++){
            $this->mysql->INSERT($this->table_name1, array('UserName' => "val_username$i", 'PasswordHash' => 'val_passwordhash', 'Position' => 'val_position'));
            $this->mysql->INSERT($this->table_name2, array('UserName' => "val_username$i", 'CreatorIP' => 'val_creatorIp', 'CreatedTime' => 'val_createdtime', 'Description' => 'val_description'));
            $this->mysql->INSERT($this->table_name3, array('Item' => "val_item$i", 'Value' => 'val_value'));
        }
    }

    function update (){
        $this->mysql->UPDATE($this->table_name1, 2, array('UserName' => 'rrwr', 'PasswordHash' => 'val_2', 'Position' => 'val_3'));
        $this->mysql->UPDATE($this->table_name1, 5, array('UserName' => 'rrar', 'PasswordHash' => 'val_2', 'Position' => 'val_3'));
    }

    function delete (){     
        $this->mysql->DELETE($this->table_name1, 2);
        $this->mysql->DELETE($this->table_name2, 2);
        $this->mysql->DELETE($this->table_name3, 2);
    }

    private function drop (){
        $this->mysql->DROP($this->table_name1);
        $this->mysql->DROP($this->table_name2);
        $this->mysql->DROP($this->table_name3);
    }
}
?>