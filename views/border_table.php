<?php
$default_year = 113;
$border_types = array("住宿生", "無效", "學一OA樓長", "學一OB樓長", "學二OE樓長", "學二OF樓長");
$border_apply_story_manager_states = array("未申請", "已申請");
?>

<!--Border-->
<!--Title-->
<div class="card m-2 px-4 py-3">
  <div class="d-flex justify-content-between">
    <h4 class="mb-0">住宿生資料</h4>
    <button class='btn ms-2 btn-primary btn-sm' data-mdb-toggle='modal' data-mdb-target='#addBorderModal'><i class='fa fa-add me-1'></i>新增</button>
  </div>
</div>

<!-- Table -->
<div class="card m-2">
  <section class="border p-4">
    <div data-mdb-hover="true" class="datatable datatable-hover">
      <div class="datatable-inner table-responsive ps" style="overflow: auto; position: relative;">
        <table class="table datatable-table">
          <thead class="datatable-header">
            <tr>
              <th scope="col">年</th>
              <th scope="col">帳號</th>
              <th scope="col">類別</th>
              <th scope="col">申請樓長</th>
              <th scope="col">宿社</th>
              <th scope="col">房號</th>
              <th scope="col">操作</th>
            </tr>
          </thead>
          <tbody class="datatable-body">
            <?php
              
              $result = border_read_all($conn);

              if (mysqli_num_rows($result) > 0) 
              {
                while ($info = mysqli_fetch_assoc($result)) 
                {
                  $account = $info['account'];
                  $type = $info['type'];
                  $state = $info['apply_story_manager_state'];
                  $year = $info['year'];
                  $room_number = $info['room_number'];
                  $dormitory_id = $info['dormitory_id'];
                  $dormitory_name = $info['dormitory_name'];

                  
                  echo "<tr>" .
                    "<td> " . $year . "</td>".
                    "<td> " . $account . "</td>".
                    "<td> " . $border_types[$type] . "</td>".
                    "<td> " . $border_apply_story_manager_states[$state] . "</td>".
                    "<td> " . $dormitory_name . "</td>".
                    "<td> " . $room_number . "</td>".
                    "<td>
                      <button class='call-btn btn btn-outline-primary btn-floating btn-sm ripple-surface' data-mdb-toggle='modal' data-mdb-target='#updateBorderModal$year-$account'><i class='fa fa-pencil'></i></button>
                      <button class='message-btn btn ms-2 btn-primary btn-floating btn-sm' data-mdb-toggle='modal' data-mdb-target='#deleteBorderModal$year-$account'><i class='fa fa-trash'></i></button>
                    </td>".
                    "</tr>";

                  // Update Modal
                  echo "
                  <div class='modal fade' id='updateBorderModal$year-$account' tabindex='-1' aria-labelledby='updateBorderModalLabel' aria-hidden='true'>
                    <div class='modal-dialog modal-dialog-centered'>
                    <form method='post' action='./controller/border_controller.php'>
                    <div class='modal-content'>
                      <div class='modal-header'>
                        <h5 class='modal-title' id='updateBorderModalLabel'>修改住宿生</h5>
                      </div>
                      <div class='modal-body'>
                        <div class='text-center mb-3'>
                          <div class='form-outline mb-4'>
                            <input value='$account' required readonly type='text' name='account' class='form-control' />
                            <label class='form-label'>住宿生編號</label>
                          </div>
                          <div class='form-outline mb-4'>
                            <input value='$year' required readonly type='text' name='year' class='form-control' />
                            <label class='form-label'>年</label>
                          </div>
                          <select class='form-select mb-4' name='type' required>
                            <option value=''>類別</option>";
                            for($i = 0; $i<6; $i++){
                              echo "<option value=$i"; 
                              if($type == $i) echo " selected"; 
                              echo ">".$border_types[$i]."</option>";
                            }
                          echo "</select>
                          <select class='form-select mb-4' name='apply_story_manager_state' required>
                            <option value=''>狀態</option>";
                            for($i = 0; $i<2; $i++){
                              echo "<option value=$i"; if($state ==$i) echo " selected"; echo ">".$border_apply_story_manager_states[$i]."</option>";
                            }
                          echo "</select>
                          <select class='form-select mb-4' name='dorm_room' required>
                            <option value=''>宿社-房號</option>";
                              $res = room_read_all($conn);
                              if (mysqli_num_rows($res) > 0) {
                                while ($info = mysqli_fetch_assoc($res)){
                                  echo "<option value=".$info['dormitory_id'].'-'.$info['room_number'].">".$info['name'].'-'.$info['room_number'].''."</option>";
                                }
                              }
                          echo "</select>
                        </div>
                      </div>
                      <div class='modal-footer'>
                        <button type='button' class='btn btn-secondary' data-mdb-dismiss='modal'>取消</button>
                        <button type='submit' class='btn btn-primary' name='update' value='update'>確認</button>
                      </div>
                    </div>
                    </form>
                    </div>
                  </div>";
                  

                  // Delete  Modal
                  echo "
                  <div class='modal fade' id='deleteBorderModal$year-$account' tabindex='-1' aria-labelledby='deleteBorderModalLabel' aria-hidden='true'>
                    <div class='modal-dialog modal-dialog-centered'>
                      <form method='post' action='./controller/border_controller.php'>
                        <div class='modal-content'>
                          <div class='modal-header'>
                            <h5 class='modal-title' id='deleteBorderModalLabel'>刪除住宿生</h5>
                          </div>
                          <div class='modal-body'>您確認要刪除此住宿生嗎？</div>
                          <div class='modal-footer'>
                            <input value='$account' required type='hidden' name='account' class='form-control' />
                            <input value='$year' required type='hidden' name='year' class='form-control' />
                            <button type='button' class='btn btn-secondary' data-mdb-dismiss='modal'>取消</button>
                            <button type='submit' class='btn btn-primary' name='delete' value='delete'>確認</button>
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>";
                }
              }
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </section>
</div>

<!-- Add Modal -->
<div class='modal fade' id='addBorderModal' tabindex='-1' aria-labelledby='addBorderModalLabel' aria-hidden='true'>
  <div class='modal-dialog modal-dialog-centered'>
    <div class='modal-content'>
      <div class='modal-header'>
        <h5 class='modal-title' id='addSystemManagerModalLabel'>新增住宿生</h5>
      </div>
      <form method='post' action='./controller/border_controller.php'>
        <div class='modal-body'>
          <div class='text-center mb-3'>
            <select class='form-select mb-4' name='account' required>
              <option value=''>帳號</option>
              <?php
                $res = student_read_all($conn);
                if (mysqli_num_rows($res) > 0) {
                  while ($info = mysqli_fetch_assoc($res)){
                    echo "<option value=".$info['account'].">".$info['account']."</option>";
                  }
                }
              ?>
            </select>
              <input value= '<?php echo $default_year;?>' required type='hidden' name='year'  class='form-control' />
          </div>
        </div>
        <div class='modal-footer'>
          <button type='button' class='btn btn-secondary' data-mdb-dismiss='modal'>取消</button>
          <button type='submit' class='btn btn-primary' name='create' value='create'>確認</button>
        </div>
      </form>
      
    </div>
  </div>
</div>

