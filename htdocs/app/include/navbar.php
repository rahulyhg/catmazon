<?php require_once 'app/controllers/home.php';
?>
<!-- <!doctype html>
<html lang="en">
<head> -->
  
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
<!--   <title>Home</title>
 -->    <!-- Bootstrap -->
  <link href="/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="/css/catmazonstyle.css">
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js">
  </script>
  <!-- Include all compiled plugins (below), or include individual
  files as needed -->
  <script src="/js/bootstrap.min.js"></script>

</head>

<body>
  <nav class="navbar navbar-default navbar-fixed-top" >
    <div class="container-fluid">
      <div class="navbar-header" >
        <button type="button" class="navbar-toggle collapsed"
                data-toggle="collapse" data-target="#collapsedNav">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        </button>
        <a href="/home" class="navbar-brand">
        <img src="/images/logo.png"
             style="height: 30px; width: auto;" alt="Catmazon"/>
        </a>
      </div>

      <div class="collapse navbar-collapse" id="collapsedNav">
        <ul class="nav navbar-nav navbar-left">
          <li ><a href="/home">Home</a></li>
          <li class="dropdown">
            <a class="dropdown-toggle" href="#" data-toggle="dropdown">Products<strong class="caret"></strong></a>
            <div class="dropdown-menu" style="padding: 15px; padding-bottom: 0px;">
                <ul class="list-unstyled"> 
                    <?=home::LoadCategories()?>
                </ul>
                <br>
            </div>  
          </li>
          <li class="dropdown-header"></li>
        </ul>


        <form class="navbar-form navbar-nav" style="text-align: center;" role="search" action="/search" method="POST">
          <div class="form-group input-group">
            <input type="text" class="form-control"
                   placeholder="Search" name="searchString">
            <div class="input-group-btn">
                <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
            </div>
          </div>
        </form>
        
        <ul class="nav navbar-nav navbar-right">
          <!--
          IF LOGGED IN-->
          <?php
          if (isset($_SESSION['activeUser'])){ ?>
            <li><a href="/userPage">My Page</a></li>
            
            <!--+ IF ADMIN-->
            <?php
            if (isset($_SESSION['is_admin'])){ ?>
              <li><a href="/inventory">Administrate</a></li>
              <?php
            } ?>
              <li><a href="/home/logout">Log out</a></li>

          <?php
          } else { ?>
            <li><a href="/newUser">Sign Up</a></li>
            <li class="divider-vertical"></li>
            <li class="dropdown">
              <a class="dropdown-toggle" href="" data-toggle="dropdown">Sign In <strong class="caret"></strong></a>
              <div class="dropdown-menu" style="padding: 15px; padding-bottom: 0px;">
                <div class="form-group"></div>
                <form action="/home/login" method="POST">
                  <li><label for="email">Email</label></li>
                  <li><input type="email" autofocus required id="email"
                  placeholder="Email" class="form-control" name="email"></li>
                  <li><label for="password">Password</label></li>
                  <li><input type="password" required id="password"
                  placeholder="Password" name="password" class="form-control"></li>
                  <li class="divider"></li>
                    <div class="btn-group" role="group">
                      <button class="btn btn-default disabled" style="cursor: default"><img  src="/images/icon.png" width="18px" /></button>
                      <button class="btn btn-default" type="submit" style="margin-bottom: 10px;" name="loginSubmit"> Connect</button>
                    </div>
                </form>
              </div>
            </li>
          <?php } ?>
          <li id="cartCount"><a href="/cart">Cart (<?=home::cartCount()?>)</a></li>
        </ul>
      </div>
    </div>
  </nav>

