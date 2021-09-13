<?php
    require( $_SERVER['DOCUMENT_ROOT'] . '/_mysql.php');

    $hostname = 'localhost';
    $username = 'root';
    $password = '0402';
    $database = 'test_database';

    $table_name1 = 'user_list';
    $table_name2 = 'list';
    $table_name3 = 'setting';

    $table_init1 = array('UserName' => 'varchar(255)', 'PasswordHash' => 'varchar(511)', 'Position' => 'varchar(255)');
    $table_init2 = array('UserName' => 'varchar(255)', 'CreatorIP' => 'varchar(15)', 'CreatedTime' => 'datetime', 'Description' => 'text(511)');
    $table_init3 = array('Item' => 'varchar(255)', 'Value' => 'varchar(511)');

    $mysql = new MySQL($hostname,$username,$password,$database);
    
    $mysql->table_initialize($table_name1, $table_init1);
    $mysql->table_initialize($table_name2, $table_init2);
    $mysql->table_initialize($table_name3, $table_init3);

    $mysql->show_sqls();

    $mysql->CREATE();

    $mysql->UPDATE($table_name1, 2, array('UserName' => 'rrr', 'PasswordHash' => 'val_p2', 'Position' => 'val3'));
    // $mysql->INSERT($table_name1, array('UserName' => 'val_username', 'PasswordHash' => 'val_passwordhash', 'Position' => 'val_position'));
    // $mysql->INSERT($table_name2, array('UserName' => 'val_username', 'CreatorIP' => 'val_creatorIp', 'CreatedTime' => 'val_createdtime', 'Description' => 'val_description'));
    // $mysql->INSERT($table_name3, array('Item' => 'val_item', 'Value' => 'val_value'));

    // $mysql->DELETE($table_name1, 2);
    // $mysql->DELETE($table_name2, 2);
    // $mysql->DELETE($table_name3, 2);

    // $mysql->DROP($table_name1);
    // $mysql->DROP($table_name2);
    // $mysql->DROP($table_name3);
?>