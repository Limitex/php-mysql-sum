<?php
    require( $_SERVER['DOCUMENT_ROOT'] . '/_mysql_manage.php');

    $mysql = new MySQL_Manage();
    $mysql->show();
    $mysql->insert();
    $mysql->update();
    $mysql->delete();
    $mysql->select();
?>