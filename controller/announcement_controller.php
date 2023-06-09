<?php
    session_start();
    
    require_once('../service/require_all.php');

    echo $_POST['account'].' ';
    echo $_POST['title'].' ';
    echo $_POST['content'].' ';

    if(isset($_POST['create'])){
        announcement_create($conn, $_POST['account'], $_POST['title'], $_POST['content'], true);
    } else if(isset($_POST['delete'])){
        announcement_delete($conn, $_POST['announcement_id']);
    } else if(isset($_POST['update'])){
        announcement_update($conn, $_POST['announcement_id'], $_POST['title'], $_POST['content']);
    }

    header("Location: ../main.php?status=success#pills-announcement");
?>