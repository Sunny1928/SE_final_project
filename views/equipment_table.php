<!-- Equipment -->
<!--Title-->
<div class="card m-2 px-4 py-3">
  <div class="d-flex justify-content-between">
    <h4 class="mb-0">宿舍設備資料</h4>
    <div class="d-flex">
      <select type="text" id="applyFixStateFilter" onchange="table_filter('applyFixStateFilter','equipmentTable',4)" class='form-select-sm'  required>
        <option value=''>報修紀錄</option>
        <?php
        for($i = 0; $i<count($apply_fix_states); $i++){
          echo "<option value=".$apply_fix_states[$i].">".$apply_fix_states[$i]."</option>";
        }?>
      </select>
      <?php 
        if( $_SESSION["permission"] == 0){
            echo "<button class='btn ms-2 btn-primary btn-sm' data-mdb-toggle='modal' data-mdb-target='#addEquipmentModal'><i class='fa fa-add me-1'></i>新增</button>";
        }
      ?>
    </div>
  
  </div>
</div>

<!-- Table -->
<div class="card m-2">
  <section class="border p-4">
    <div id="datatable-custom" data-mdb-hover="true" class="datatable datatable-hover">
      <div class="datatable-inner table-responsive ps" style="overflow: auto; position: relative;">
        <table id='equipmentTable' class="table datatable-table">
          <thead class="datatable-header">
            <tr>
              <th scope="col">宿舍</th> 
              <th scope="col">房號</th>
              <th scope="col">編號</th>
              <th scope="col">名稱</th>
              <th scope="col">報修紀錄</th>
              <th scope="col">年限</th>
              <th scope="col">購買日期</th>
              <?php
              if($_SESSION["permission"] != 2)
                echo "<th scope='col'>操作</th>";
              ?>
            </tr>
          </thead>
          <tbody class="datatable-body">
            <?php
              if($_SESSION["permission"] == 0 || $_SESSION["permission"] == 1){
                $result = equipment_read_all($conn);
              }else{ // parents
                $result = equipment_read_dormid_roomnum($conn , $_SESSION['dormitory_id'], $_SESSION['room_number']);
              }

              if (mysqli_num_rows($result) > 0) 
              {
                while ($info = mysqli_fetch_assoc($result)) 
                {
                  $id = $info['equipment_id'];
                  $name = $info['name'];
                  $expired_year = $info['expired_year'];
                  $datetime = $info['datetime'];
                  $apply_fix_state = $info['apply_fix_state'];
                  $dormitory_id = $info['dormitory_id'];
                  $dormitory_name = $info['dormitory_name'];
                  $room_number = $info['room_number'];
                  
                  echo "<tr>" .
                    "<td>" . $dormitory_name . "</td>".
                    "<td>" . $room_number . "</td>".
                    "<td>" . $id . "</td>".
                    "<td>" . $name . "</td>".
                    "<td class='".$state_classes_defaults[$apply_fix_state]."' >" . $apply_fix_states[$apply_fix_state] . "</td>".
                    "<td>" . $expired_year . "</td>".
                    "<td>" . $datetime . "</td>";


                  if($_SESSION["permission"] == 0 || $_SESSION["permission"] == 1)
                    echo  "<td>
                        <button onclick=\"put_equipment('$id','$dormitory_id-$room_number','$name','$apply_fix_state','$expired_year')\" class='call-btn btn btn-outline-primary btn-floating btn-sm ripple-surface' data-mdb-toggle='modal' data-mdb-target='#updateEquipmentModal'><i class='fa fa-pencil'></i></button>
                        <button onclick=\"put_equipment('$id','$dormitory_id-$room_number','$name','$apply_fix_state','$expired_year')\" class='message-btn btn ms-2 btn-primary btn-floating btn-sm' data-mdb-toggle='modal' data-mdb-target='#deleteEquipmentModal'><i class='fa fa-trash'></i></button>
                      </td>";
                  else if($_SESSION["permission"] != 2){
                    echo "<td> <button "; if($apply_fix_state != 0) echo " disabled ";
                    echo  "onclick=\"put_equipment('$id','$dormitory_id-$room_number','$name','1','$expired_year')\" class='message-btn btn ms-2 btn-outline-primary btn-floating btn-sm' data-mdb-toggle='modal' data-mdb-target='#confirmEquipmentModal'><i class='fa fa-circle-info'></i></button></td>";
                  }
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
<?php 
if( $_SESSION["permission"] == 0 || $_SESSION["permission"] == 1){
echo "<div class='modal fade' id='addEquipmentModal' tabindex='-1' aria-labelledby='addEquipmentModalLabel' aria-hidden='true'>
  <div class='modal-dialog modal-dialog-centered'>
    <div class='modal-content'>
      <div class='modal-header'>
        <h5 class='modal-title' id='addSystemManagerModalLabel'>新增宿舍設備</h5>
      </div>
      <form method='post' action='./controller/equipment_controller.php'>
        <div class='modal-body'>
          <div class='text-center mb-3'>
            <div class='form-outline mb-4'>
              <input required type='text' name='dormitory_id' id='dormitoryId' class='form-control' />
              <label class='form-label' for='dormitoryId'>宿舍大樓編號</label>
            </div>
            <div class='form-outline mb-4'>
              <input required type='text' name='room_number' id='roomNumber' class='form-control' />
              <label class='form-label' for='roomNumber'>房號</label>
            </div>
            <div class='form-outline mb-4'>
              <input required type='text' name='name' id='name' class='form-control' />
              <label class='form-label' for='name'>名稱</label>
            </div>
            <div class='form-outline mb-4'>
              <input required type='text' name='expired_year' id='expiredYear' class='form-control' />
              <label class='form-label' for='expiredYear'>過期年限</label>
            </div>
          </div>
        </div>
        
        <div class='modal-footer'>
          <button type='button' class='btn btn-secondary' data-mdb-dismiss='modal'>取消</button>
          <button type='submit' class='btn btn-primary' name='create' value='create'>確認</button>
        </div>
      </form>
      
    </div>
  </div>
</div>";
}

// Update Modal
echo "
<div class='modal fade' id='updateEquipmentModal' tabindex='-1' aria-labelledby='updateEquipmentModalLabel' aria-hidden='true'>
  <div class='modal-dialog modal-dialog-centered'>
  <div class='modal-content'>
  <form method='post' action='./controller/equipment_controller.php'>
    <div class='modal-header'>
      <h5 class='modal-title' id='updateEquipmentModalLabel'>修改宿舍設備</h5>
    </div>
    <div class='modal-body'>
      <div class='text-center mb-3'>
        <div class='form-outline mb-4'> 
          <input id='id' readonly required type='text' name='equipment_id' class='form-control' />
          <label class='form-label'>設備編號</label>
        </div>
        <select id='dormitory_room'  class='form-select mb-4' name='dormitory_room' autocomplete='on' required>
          <option value=''>房間</option>";
          $res = room_read_all($conn);
          if (mysqli_num_rows($res) > 0) {
            while ($info = mysqli_fetch_assoc($res)){
              echo "<option value=".$info['dormitory_id'].'-'.$info['room_number'];
              if($dormitory_id ==$info['dormitory_id'] && $room_number ==$info['room_number']) echo " selected";
              echo " >".$info['dormitory_id'].'-'.$info['room_number'].''."</option>";
            }
          }
        echo "</select>
        <div class='form-outline mb-4'>
          <input id='name' required type='text' name='name' class='form-control' />
          <label class='form-label'>名稱</label>
        </div>
        <select id='apply_fix_state' class='form-select mb-4' name='apply_fix_state' autocomplete='on' required>
          <option value=''>報修紀錄</option>";
          for($i = 0; $i<4; $i++){
            echo "<option value=$i"; if($apply_fix_state ==$i) echo " selected"; echo ">".$apply_fix_states[$i]."</option>";
          }
        echo "</select>
        <div class='form-outline mb-4'>
          <input id='expired_year' required type='text' name='expired_year' class='form-control' />
          <label class='form-label'>過期年限</label>
        </div>
      </div>
    </div>
    <div class='modal-footer'>
      <button type='button' class='btn btn-secondary' data-mdb-dismiss='modal'>取消</button>
      <button type='submit' class='btn btn-primary' name='update' value='update'>確認</button>
    </div>
  </form>
  </div>
  </div>
</div>";

?>

<!--Delete  Modal -->
<div class='modal fade' id='deleteEquipmentModal' tabindex='-1' aria-labelledby='deleteEquipmentModalLabel' aria-hidden='true'>
  <div class='modal-dialog modal-dialog-centered'>
    <div class='modal-content'>
      <form method='post' action='./controller/equipment_controller.php'>
        <div class='modal-header'>
          <h5 class='modal-title' id='deleteEquipmentModalLabel'>刪除宿舍設備</h5>
        </div>
        <div class='modal-body'>您確認要刪除此宿舍設備嗎？</div>
        <div class='modal-footer'>
          <input id='id' required type='hidden' name='equipment_id' class='form-control' />
          <button type='button' class='btn btn-secondary' data-mdb-dismiss='modal'>取消</button>
          <button type='submit' class='btn btn-primary' name='delete' value='delete'>確認</button>
        </div>
      </form>
    </div>
  </div>
</div>


<div class='modal fade' id='confirmEquipmentModal' tabindex='-1' aria-labelledby='confirmEquipmentModalLabel' aria-hidden='true'>
  <div class='modal-dialog modal-dialog-centered'>
      <div class='modal-content'>
    <form method='post' action='./controller/equipment_controller.php'>
        <div class='modal-header'>
          <h5 class='modal-title' id='confirmEquipmentModalLabel'>申請宿舍設備報修</h5>
        </div>
        <div class='modal-body'>您確認要申請此宿舍設備報修嗎？</div>
        <div class='modal-footer'>
          <input id='id' required type='hidden' name='equipment_id' class='form-control' />
          <input id='name' required type='hidden' name='name' class='form-control' />
          <input id='apply_fix_state' required type='hidden' name='apply_fix_state' class='form-control' />
          <input id='dormitory_room' required type='hidden' name='dormitory_room' class='form-control' />
          <input id='expired_year' required type='hidden' name='expired_year' class='form-control' />
          <button type='button' class='btn btn-secondary' data-mdb-dismiss='modal'>取消</button>
          <button type='submit' class='btn btn-primary' name='update' value='update'>確認</button>
        </div>
    </form>
      </div>
  </div>
</div>



<script>
function put_equipment(a, b, c, d, e){
  var elms = document.querySelectorAll("[id='id']");
  for(var i = 0; i < elms.length; i++) 
    elms[i].value=a

  var elms = document.querySelectorAll("[id='dormitory_room']");
  for(var i = 0; i < elms.length; i++) 
    elms[i].value=b

  var elms = document.querySelectorAll("[id='name']");
  for(var i = 0; i < elms.length; i++) 
    elms[i].value=c

  var elms = document.querySelectorAll("[id='apply_fix_state']");
  for(var i = 0; i < elms.length; i++) 
    elms[i].value=d

  var elms = document.querySelectorAll("[id='expired_year']");
  for(var i = 0; i < elms.length; i++) 
    elms[i].value=e
  
}
</script>