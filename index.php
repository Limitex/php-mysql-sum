<?php
    require( $_SERVER['DOCUMENT_ROOT'] . '/_mysql_manage.php');

    $mysql = new MySQL_Manage();
    $mysql->show();
    
    for($i = 0; $i < 10; $i++){
        $mysql->insert(MySQL_Manage::TABLE_NAME1, array('UserName' => "val_username$i", 'PasswordHash' => 'val_passwordhash', 'Position' => 'val_position'));
        $mysql->insert(MySQL_Manage::TABLE_NAME2, array('UserName' => "val_username$i", 'CreatorIP' => 'val_creatorIp', 'CreatedTime' => 'val_createdtime', 'Description' => 'val_description'));
        $mysql->insert(MySQL_Manage::TABLE_NAME3, array('Item' => "val_item$i", 'Value' => 'val_value'));
    }

    $mysql->update(MySQL_Manage::TABLE_NAME1, 3, array('UserName' => 'rrar', 'PasswordHash' => 'val_2', 'Position' => 'val_3'));
    $mysql->update(MySQL_Manage::TABLE_NAME1, 5, array('UserName' => 'rrar', 'PasswordHash' => 'val_2', 'Position' => 'val_3'));

    $mysql->delete(MySQL_Manage::TABLE_NAME1, 2);
    $mysql->delete(MySQL_Manage::TABLE_NAME2, 2);
    $mysql->delete(MySQL_Manage::TABLE_NAME3, 2);

    print_a($mysql->select(MySQL_Manage::TABLE_NAME1, MySQL_Manage::SELECT_TYPE_COUNT), 'COUNT');
    print_a($mysql->select(MySQL_Manage::TABLE_NAME1, MySQL_Manage::SELECT_TYPE_LATEST), 'LATEST');
    print_a($mysql->select(MySQL_Manage::TABLE_NAME1, MySQL_Manage::SELECT_TYPE_LATEST, 2), 'LATEST=2');
    print_a($mysql->select(MySQL_Manage::TABLE_NAME1, MySQL_Manage::SELECT_TYPE_ALL), 'ALL'); 
?>