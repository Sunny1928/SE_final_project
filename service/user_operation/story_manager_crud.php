<?php
    /*
    type    
        -2 學一 OA樓長 
        -3 學一 OB樓長 
        -4 學二 OE樓長 
        -5 學二 OF樓長
    */
    // 將學生變成樓長 
    function story_manager_create($conn , $account , $year , $type){

        $sql = "UPDATE border SET type = ? WHERE account = ? AND year = ?";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param('isi' , $type , $account ,  $year);
        return $stmt->execute();
    }

    // 檢查一個border是否為樓長
    function story_manager_check($conn , $account , $year){

        $rel = story_manager_read_account_year($conn , $account , $year);

        if($rel->num_rows == 0)
            return False;

        return $rel->fetch_assoc()["type"] > 1;
    }
    
    // 用帳號及年份查詢樓長
    function story_manager_read_account_year($conn , $account , $year){

        $sql = "SELECT * FROM user 
                JOIN student ON user.account = student.account 
                JOIN border ON user.account = border.account 
                WHERE user.account = ? AND border.year = ? AND border.type > 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('si', $account , $year);
        $stmt->execute();
        return $stmt->get_result();
    }
    
    // 查詢特定年分宿舍的樓長
    function story_manager_read_dorm_year($conn , $type , $year){

        $sql = "SELECT * FROM user 
                JOIN student ON user.account = student.account 
                JOIN border ON user.account = border.account 
                WHERE border.type = ? AND border.year = ? ";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ii', $type , $year);
        $stmt->execute();
        return $stmt->get_result();
    }

    // 樓長創建點名資料
    function story_manager_create_roll_call($conn , $type , $year){

        $type -=2;
        $rel = border_read_year_dorm($conn ,$year, $type);

        if($rel->num_rows > 0){
            while ($border = $rel->fetch_assoc()) {
                roll_call_create($conn , $border['account'], $year, 0);
            }
        }
        return;
    }
?>