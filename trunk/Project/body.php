<?php
?>
<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#"><?php echo PROJECT; ?></a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <div data-ng-controller="loginctrl">
                <ul class="nav navbar-nav navbar-right">
              <?php
                if(!isset($_SESSION['uid'])){
              ?>
                    <li><a href="" data-ng-click="openModal(1)">Login</a></li>
                    <li><a href="" data-ng-click="openModal(2)">Signup</a></li>
              <?php
                }
              else{
              ?>
                    <li><a href="">Welcome <?php echo $_SESSION['uname']; ?></a></li>
                    <li><a href="" data-ng-click="logout()">Logout</a></li>
              <?php
              }
              ?>
          </ul>
        </div>
    </div>
  </div>
</nav>
<h1>Hello World !</h1>