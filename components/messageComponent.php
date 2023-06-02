<!-- Message Component -->
<div class="tab-pane fade h-100" id="pills-message" role="tabpanel" aria-labelledby="tab-message">

<!--Title-->
<div class="card m-2 px-4 py-3">
    <div class="d-flex justify-content-between">
    <h4 class="mb-0">留言板</h4>
    </div>
</div>

<div class="m-2 h-70" style="background-color: #eee;">
    <div class="card h-70" id="chat2">
    <div class="card-body h-70" style="position: relative; height: 660px; overflow: scroll;">

        <?php
        $result = message_read_all($conn);
        
        while($info=mysqli_fetch_array($result)){
            
            $id = $info["message_id"];
            $content = $info['content'];
            $account = $info['account'];
            // $datetime = $info['datetime'];
            $date = mb_split(" ",$info['datetime'])[1];
            $time = mb_split(":",$date);
            
            # 判斷是不是本人和身分是否為學生 , 都符合的人不能編輯其他使用者的留言
            if($account != $_SESSION["account"] ){
                if ($_SESSION["permission"]=="student"){
                echo "
                <div class='d-flex flex-row justify-content-start'>
                    <img src='./image/user.png' alt='avatar' class='rounded-circle' style='width: 45px; height: 100%;'>
                    <div>
                    <p class='small p-2 ms-3 mb-1 rounded-3' style='background-color: #f5f6f7; max-width:950px;'>$content</p>
                    <p class='small ms-3 mb-2 rounded-3 text-muted'>$time[0]:$time[1]</p>
                    </div>
                </div>
                ";
                }
                else {
                echo "
                <div class='d-flex flex-row justify-content-start'>
                    <img src='./image/user.png' alt='avatar' class='rounded-circle' style='width: 45px; height: 100%;'>
                    <div>
                    <p class='small p-2 ms-3 mb-1 rounded-3' style='background-color: #f5f6f7; max-width:950px;'>$content</p>
                    <div class='small mb-2 text-muted d-flex'>
                        <p class='ms-1 rounded-3 text-muted'>$time[0]:$time[1]</p>
                        <p class='ms-1 rounded-3' style='width: fit-content;' data-mdb-ripple-color='light' data-mdb-toggle='modal' data-mdb-target='#updateMessageModal$id'>編輯</p>
                        <p class='ms-1 rounded-3' style='width: fit-content;' data-mdb-ripple-color='light' data-mdb-toggle='modal' data-mdb-target='#deleteMessageModal$id'>刪除</p>
                    </div>
                    </div>
                </div>
                ";
                }
            } 
            else {
            # 本人可以對自己傳的訊息操作
            echo "
                <div class='d-flex flex-row justify-content-end pt-1'>
                <div>
                    <div class='align-item-end d-flex flex-row-reverse'>
                    <p class='small p-2 me-3 mb-1 text-white rounded-3 bg-primary' style='max-width:950px;'>$content</p>
                    </div>
                    <div class='align-item-end d-flex flex-row-reverse'>
                    <div class='small mb-2 text-muted d-flex'>
                        <p class='me-1  rounded-3  d-flex justify-content-end'>$time[0]:$time[1]</p>
                        <p class='ms-1 rounded-3' style='width: fit-content;' data-mdb-ripple-color='light' data-mdb-toggle='modal' data-mdb-target='#updateMessageModal$id'>編輯</p>
                        <p class='ms-1 rounded-3' style='width: fit-content;' data-mdb-ripple-color='light' data-mdb-toggle='modal' data-mdb-target='#deleteMessageModal$id'>刪除</p>
                    </div>
                    </div>
                </div>

                <img src='";echo $_SESSION['icon']; echo"'alt='avatar' class='rounded-circle' style='width: 45px; height: 100%;'>
                </div>
                ";
            }

            // Update Message Modal
            echo "
            <div class='modal fade' id='updateMessageModal$id' tabindex='-1' aria-labelledby='updateMessageModalLabel' aria-hidden='true'>
            <div class='modal-dialog modal-dialog-centered'>
                <div class='modal-content'>

                <form method='post' action='./service/comment_update.php'>
                <div class='modal-header'>
                    <h5 class='modal-title' id='updateMessageModalLabel'>修改留言</h5>
                </div>
                <div class='modal-body'>
                    <div class='form-outline'>
                    <textarea name='content' class='form-control border' id='textAreaExample' rows='4' required>$content</textarea>
                    <!-- <label class='form-label' for='textAreaExample'>内容</label> -->
                    <input type='hidden' name='account' value='$account'>
                    <input type='hidden' name='comment_id' value='$id'>
                    </div>
                </div>
                <div class='modal-footer'>
                    <button type='button' class='btn btn-secondary' data-mdb-dismiss='modal'>取消</button>
                    <button type='submit' class='btn btn-primary'>確認</button>
                </div>
                </form>

                </div>
            </div>
            </div>";

        
        // Delete Message Modal
        echo "
        <div class='modal fade' id='deleteMessageModal$id' tabindex='-1' aria-labelledby='deleteMessageModalLabel' aria-hidden='true'>
            <div class='modal-dialog modal-dialog-centered'>
            <div class='modal-content'>
                <div class='modal-header'>
                <h5 class='modal-title' id='deleteMessageModalLabel'>刪除留言</h5>
                </div>
                <div class='modal-body'>您確認要刪除留言嗎？</div>
                <div class='modal-footer'>
                <button type='button' class='btn btn-secondary' data-mdb-dismiss='modal'>取消</button>
                <button type='button' class='btn btn-primary'>確認</button>
                </div>
            </div>
            </div>
        </div>";
        }
        ?>

        <!-- time 
        <div class="divider d-flex align-items-center mb-4">
        <p class="text-center mx-3 mb-0" style="color: #a2aab7;">Today</p>
        </div>
        -->
    </div>

    <!-- Add -->
    <form method="post" id="add_message" action="./service/comment_add.php">
        <div class="card-footer text-muted d-flex justify-content-start align-items-center p-3">
        <img src=<?php echo $_SESSION['icon'];?> alt="avatar 3" style="width: 40px; height: 100%; border-radius: 100%;">
        <input name="content" required type="text" class="form-control form-control-lg"
            id="exampleFormControlInput1" placeholder="Type message">
        <a class="ms-3" onclick="document.getElementById('add_message').submit();"><i
            class="fas fa-paper-plane"></i></a>
        </div>
    </form>
    </div>
</div>
</div>