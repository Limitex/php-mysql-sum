<?php
    require( $_SERVER['DOCUMENT_ROOT'] . '/_mysql.php');

    $hostname = 'localhost';
    $username = 'root';
    $password = '0000';
    $database = 'test_database';

    $table_name1 = 'user_list';
    $table_name2 = 'list';
    $table_name3 = 'setting';

    $table_init1 = array('UserName' => 'varchar(255)', 'PasswordHash' => 'varchar(511)', 'Position' => 'varchar(255)');
    $table_init2 = array('UserName' => 'varchar(255)', 'CreatorIP' => 'varchar(15)', 'CreatedTime' => 'datetime', 'Description' => 'text(511)');
    $table_init3 = array('Item' => 'varchar(255)', 'Value' => 'varchar(511)');


    $mysql = new MySQL($hostname, $username, $password, $database);
    
    $mysql->table_initialize($table_name1, $table_init1);
    $mysql->table_initialize($table_name2, $table_init2);
    $mysql->table_initialize($table_name3, $table_init3);

    $mysql->show_sqls(1);
    
    $mysql->DROP($table_name1);
    $mysql->DROP($table_name2);
    $mysql->DROP($table_name3);

    $mysql->CREATE();

    for($i = 0; $i < 10; $i++){
        $mysql->INSERT($table_name1, array('UserName' => "val_username$i", 'PasswordHash' => 'val_passwordhash', 'Position' => 'val_position'));
        $mysql->INSERT($table_name2, array('UserName' => "val_username$i", 'CreatorIP' => 'val_creatorIp', 'CreatedTime' => 'val_createdtime', 'Description' => 'val_description'));
        $mysql->INSERT($table_name3, array('Item' => "val_item$i", 'Value' => 'val_value'));
    }

    $mysql->UPDATE($table_name1, 2, array('UserName' => 'rrwr', 'PasswordHash' => 'val_2', 'Position' => 'val_3'));
    $mysql->UPDATE($table_name1, 5, array('UserName' => 'rrar', 'PasswordHash' => 'val_2', 'Position' => 'val_3'));

    $mysql->DELETE($table_name1, 2);
    $mysql->DELETE($table_name2, 2);
    $mysql->DELETE($table_name3, 2);

    $mysql->print_a($mysql->SELECT($table_name1, 'count'));
    $mysql->print_a($mysql->SELECT($table_name1, 'list', 'all'));
    $mysql->print_a($mysql->SELECT($table_name1, 'list', 'latest', 5));
    
    // $mysql->DROP($table_name1);
    // $mysql->DROP($table_name2);
    // $mysql->DROP($table_name3);
?>