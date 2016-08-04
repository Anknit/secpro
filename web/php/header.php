<?php
    require_once __DIR__.'/setUserData.php';
?>
<!DOCTYPE html>
<html lang="en" data-ng-app="mainapp">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Secpro</title>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="shortcut icon" href="./web/images/favicon.ico">
        <link href="./web/css/font1.css" rel="stylesheet" type="text/css">
        <link href="./web/css/font2.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="./web/css/bootstrap.min.css">
        <link rel="stylesheet" href="./web/css/styles.css">
    </head> 
    <body>
        <header class="header navbar-fixed-top">  
            <div class="container-fluid" data-ng-controller="headerController">            
                <h1 class="logo pull-left">
                    <a class="scrollto" href="#">
                        <img id="logo-image" class="logo-image" src="./web/images/logo/logo.png" alt="Logo">
                        <span class="logo-title">Delta</span>
                    </a>
                </h1>              
                <nav id="main-nav" class="main-nav navbar-right" role="navigation">
                    <div class="navbar-header">
                        <button class="navbar-toggle" type="button" data-toggle="collapse" data-target="#navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>
                    <div class="navbar-collapse collapse" id="navbar-collapse">
                        <ul class="nav navbar-nav">
                            <li class="nav-item">
                                <a>Hi,&nbsp;<span data-ng-bind="user.fname"></span></a>
                            </li>
                            <li class="nav-item last"><a role="button" data-ng-click="logout()">Logout</a></li>
                        </ul>
                    </div>
                </nav>
            </div>
        </header>
