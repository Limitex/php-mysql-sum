<?php
require( $_SERVER['DOCUMENT_ROOT'] . '/_mysql.php');
class MySQL_Manage {

    public const SELECT_TYPE_ALL = 0;
    public const SELECT_TYPE_LATEST = 1;
    public const SELECT_TYPE_COUNT = 2;

    public const TABLE_NAME1  = 'user_list';
    public const TABLE_NAME2 = 'list';
    public const TABLE_NAME3 = 'setting';

    private const HOSTNAME = 'localhost';
    private const USERNAME = 'root';
    private const PASSWORD = '0000';
    private const DATABASE = 'test_database';

    private const TABLE_INIT1 = array('UserName' => 'varchar(255)', 'PasswordHash' => 'varchar(511)', 'Position' => 'varchar(255)');
    private const TABLE_INIT2 = array('UserName' => 'varchar(255)', 'CreatorIP' => 'varchar(15)', 'CreatedTime' => 'datetime', 'Description' => 'text(511)');
    private const TABLE_INIT3 = array('Item' => 'varchar(255)', 'Value' => 'varchar(511)');

    private $mysql;
    
    function __construct() {
        $this->mysql = new MySQL(MySQL_Manage::HOSTNAME, MySQL_Manage::USERNAME, MySQL_Manage::PASSWORD, MySQL_Manage::DATABASE);
        $this->mysql->table_initialize(MySQL_Manage::TABLE_NAME1, MySQL_Manage::TABLE_INIT1);
        $this->mysql->table_initialize(MySQL_Manage::TABLE_NAME2, MySQL_Manage::TABLE_INIT2);
        $this->mysql->table_initialize(MySQL_Manage::TABLE_NAME3, MySQL_Manage::TABLE_INIT3);

        $this->drop(MySQL_Manage::TABLE_NAME1);
        $this->drop(MySQL_Manage::TABLE_NAME2);
        $this->drop(MySQL_Manage::TABLE_NAME3);

        $this->mysql->CREATE();
    }

    function show (){
        $this->mysql->show_sqls();
    }

    function select($table, $type, $count = 1){
        if($type == MySQL_Manage::SELECT_TYPE_ALL)
            return $this->mysql->SELECT($table, MySQL::SELECT_TYPE_LIST, MySQL::SELECT_TYPE_ALL);
        if($type == MySQL_Manage::SELECT_TYPE_LATEST)
            return $this->mysql->SELECT($table, MySQL::SELECT_TYPE_LIST, MySQL::SELECT_TYPE_LATEST, $count);
        if($type == MySQL_Manage::SELECT_TYPE_COUNT)
            return $this->mysql->SELECT($table, MySQL::SELECT_TYPE_COUNT);
    }

    function insert ($table, $data){
        $this->mysql->INSERT($table, $data);
    }

    function update ($table, $id, $array){
        $this->mysql->UPDATE($table, $id, $array);
    }

    function delete ($table, $id){     
        $this->mysql->DELETE($table, $id);
    }

    private function drop ($table){
        $this->mysql->DROP($table);
    }
}
?>