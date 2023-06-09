<!-- Sidebar -->
<header>
  <nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse bg-white p-0">
    <div class="sidebar-sticky position-sticky">
      <div class="mt-4">
        <div id="header-content" class="w-auto">
          <div class="d-flex justify-content-center">
            <img src="./image/baby.jpg"
              alt="avatar" class="rounded-circle img-fluid mb-3 m-auto" style="max-width: 100px;">
          </div>
          <h4 class="text-center">
            <span style="white-space: nowrap;"><?php echo $_SESSION['name']?></span>
          </h4>
          <p class="text-center"><?php echo $_SESSION['email']?></p>
        </div>
        <hr class="mb-0">
      </div>
      <div class="list-group list-group-flush mx-3 mt-4">
        <a class="list-group-item list-group-item-action py-2 ripple pb-2 active" id="tab-main" data-mdb-toggle="pill" href="#pills-main" role="tab" aria-controls="pills-main" aria-selected="true">
          <i class="fas fa-house pe-3"></i>主畫面
        </a>
        <a class="list-group-item list-group-item-action py-2 ripple pb-2" id="tab-announcement" data-mdb-toggle="pill" href="#pills-announcement" role="tab" aria-controls="pills-announcement" aria-selected="false">
          <i class="fas fa-envelope pe-3"></i>公告
        </a>
        <a class="list-group-item list-group-item-action py-2 ripple pb-2" id="tab-message" data-mdb-toggle="pill" href="#pills-message" role="tab" aria-controls="pills-message" aria-selected="false">
          <i class="fas fa-comment pe-3"></i>留言板
        </a>

        <!-- border
        <a class="list-group-item list-group-item-action py-2 ripple pb-2" id="tab-violated-record" data-mdb-toggle="pill" href="#pills-violated-record" role="tab" aria-controls="pills-violated-record" aria-selected="false">
          <i class="fas fa-book pe-3"></i>違規紀錄
        </a>
        <a class="list-group-item list-group-item-action py-2 ripple pb-2" id="tab-bill" data-mdb-toggle="pill" href="#pills-bill" role="tab" aria-controls="pills-bill" aria-selected="false">
          <i class="fas fa-money-bills pe-3"></i>帳單紀錄 
        </a> -->
        <a class="list-group-item list-group-item-action py-2 ripple pb-2" id="tab-help" data-mdb-toggle="pill" href="#pills-help" role="tab" aria-controls="pills-help" aria-selected="false">
          <i class="fas fa-square-info pe-3"></i>協助
        </a>
      </div>
      <div class="list-group list-group-flush mx-3">
        <a href="./login.php" class="list-group-item py-2 ripple pb-2">
          <i class="fas fa-right-from-bracket pe-3"></i>登出
        </a>
      </div>
      <div class=" text-center text-reset mt-5">
        <em><small>Copyright © 2023 - PYSY</small></em>
      </div>
  </nav>
</header>

<!--Main layout-->
<main>

  <div class="tab-content" style="max-height: 100vh;">

    <!--main-->
    <div class="tab-pane fade show active" id="pills-main" role="tabpanel" aria-labelledby="tab-main">
      <div class="card m-2 px-4 py-3">
        <div class="d-flex justify-content-between">
            <h4 class="mb-0">個人資料</h4>
        </div>
      </div>
      <div class="card m-2 px-4 py-3">
        <div>
          <p class="m-1"><b>名稱：</b><?php echo $_SESSION['name'];?></p>
          <p class="m-1"><b>帳號：</b><?php echo $_SESSION['account'];?></p>
          <p class="m-1"><b>Email：</b><?php echo $_SESSION['email'];?></p>
          <p class="m-1"><b>電話：</b><?php echo $_SESSION['phone'];?></p>
          <p class="m-1"><b>種類：</b><?php echo $types[$_SESSION['type']];?></p>
          <p class="m-1"><b>性別：</b><?php echo $genders[$_SESSION['gender']];?></p>
          <p class="m-1"><b>科系：</b><?php echo $_SESSION['department'];?></p>
        </div>
      </div>
      <div class="card m-2 px-4 py-3">
        <div class="d-flex justify-content-between">
            <h4 class="mb-0">宿舍申請</h4>
        </div>
      </div>
      <?php
        require("./components/applyDormComponent.php");
      ?>
    </div>
  
    <!--announcement-->
    <div class="tab-pane fade" id="pills-announcement" role="tabpanel" aria-labelledby="tab-announcement">
      <?php
        require("./components/announcementComponent.php");
      ?>
    </div>

    <!--message-->
    <div class="tab-pane fade" id="pills-message" role="tabpanel" aria-labelledby="tab-message">
      <?php
        require("./components/messageComponent.php");
      ?>
    </div>

    <!--bill-->
    <!-- <div class="tab-pane fade" id="pills-bill" role="tabpanel" aria-labelledby="tab-bill">
      <?php
        // require("./views/bill_table.php");
      ?>
    </div> -->

    <!--violated record-->
    <!-- <div class="tab-pane fade" id="pills-violated-record" role="tabpanel" aria-labelledby="tab-violated-record">
      <?php
        // require("./views/violated_record_table.php")
      ?>
    </div> -->

    <!--help-->
    <div class="tab-pane fade" id="pills-help" role="tabpanel" aria-labelledby="tab-help">
      <?php
        require("./components/helpComponent.php");
      ?>
    </div>
  </div>
</main>

<script>
  document.querySelectorAll('.form-outline').forEach((formOutline) => {
    new mdb.Input(formOutline).init();
  });

  if (location.hash === "#pills-main") {
    const triggerEl = document.querySelector('a[href="#pills-main"]');
    if (triggerEl) {
      let instance = mdb.Tab.getInstance(triggerEl)
      if (!instance) {
        instance = new mdb.Tab(triggerEl);
      }
      instance.show();
    }
  } else if (location.hash === "#pills-announcement") {
    const triggerEl = document.querySelector('a[href="#pills-announcement"]');
    if (triggerEl) {
      let instance = mdb.Tab.getInstance(triggerEl)
      if (!instance) {
        instance = new mdb.Tab(triggerEl);
      }
      instance.show();
    }
  } else if (location.hash === "#pills-message") {
    const triggerEl = document.querySelector('a[href="#pills-message"]');
    if (triggerEl) {
      let instance = mdb.Tab.getInstance(triggerEl)
      if (!instance) {
        instance = new mdb.Tab(triggerEl);
      }
      instance.show();
    }
  } else if (location.hash === "#pills-help") {
    const triggerEl = document.querySelector('a[href="#pills-help"]');
    if (triggerEl) {
      let instance = mdb.Tab.getInstance(triggerEl)
      if (!instance) {
        instance = new mdb.Tab(triggerEl);
      }
      instance.show();
    }
  } 
  // else if (location.hash === "#pills-violated-record") {
  //   const triggerEl = document.querySelector('a[href="#pills-violated-record"]');
  //   if (triggerEl) {
  //     let instance = mdb.Tab.getInstance(triggerEl)
  //     if (!instance) {
  //       instance = new mdb.Tab(triggerEl);
  //     }
  //     instance.show();
  //   }
  // } else if (location.hash === "#pills-bill") {
  //   const triggerEl = document.querySelector('a[href="#pills-bill"]');
  //   if (triggerEl) {
  //     let instance = mdb.Tab.getInstance(triggerEl)
  //     if (!instance) {
  //       instance = new mdb.Tab(triggerEl);
  //     }
  //     instance.show();
  //   }
  // } 
</script>


