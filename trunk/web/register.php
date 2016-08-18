<?php
    if(isset($_REQUEST['verifyaccount']) && trim($_REQUEST['verifyaccount']) != '') {
        $verifyLink = trim($_REQUEST['verifyaccount']);
        if (strlen($verifyLink) > 32) {
            $secureLink = substr($verifyLink, 0, 32);
            $linkId = substr($verifyLink, 32);
            $linkUser = DB_Query('Select userdata.email from userdata left join verificationlinks on userdata.id = verificationlinks.userId where verificationlinks.linkId='.$linkId.' and verificationlinks.verificationLink="'.$secureLink.'"','ASSOC','');
            if($linkUser && count($linkUser) == 1) {
                $userEmail = $linkUser[0]['email'];
                echo $userEmail;
            } else {
                echo "Invalid request";
                die();
            }
        } else {
            echo "Failed";
            die();
        }
    } else {
        header ('location: ./');
        exit();
    }
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
        <link rel="shortcut icon" href="./../../web/images/favicon.ico">
        <link href="./../../web/css/font1.css" rel="stylesheet" type="text/css">
        <link href="./../../web/css/font2.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="./../../web/css/bootstrap.min.css">
        <link rel="stylesheet" href="./../../web/css/font-awesome.css">
        <link rel="stylesheet" href="./../../web/css/flexslider.css">
        <link rel="stylesheet" href="./../../web/css/animate.min.css">
        <link rel="stylesheet" href="./../../web/css/styles.css">
    </head> 
    <body>
        <header id="top" class="header navbar-fixed-top">  
            <div class="container" data-ng-controller="registerController">            
                <h1 class="logo pull-left">
                    <a class="scrollto" href="#">
                        <img id="logo-image" class="logo-image" src="./../../web/images/logo/logo.png" alt="Logo">
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
                </nav>
                <div class="modal" id="register-modal" tabindex="-1" role="dialog" aria-labelledby="registerModal" data-backdrop="static">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Complete Registration</h4>
                            </div>
                            <div class="modal-body">
                                <div class="body-container">
                                    <form class="form-horizontal">
                                        <div class="form-group">
                                            <div class="col-md-3 text-right">
                                                <label class="control-label">Email</label>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="email" class="form-control" name="registeremail" placeholder="Email address" maxlength="30" data-ng-model="registeremail" readonly disabled />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-3 text-right">
                                                <label class="control-label">First Name</label>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="firstname" placeholder="First Name" maxlength="25" data-ng-model="firstname" required />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-3 text-right">
                                                <label class="control-label">Last Name</label>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="text" class="form-control" name="lastname" placeholder="Last Name" maxlength="25" data-ng-model="lastname" required />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-3 text-right">
                                                <label class="control-label">Password</label>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="password" class="form-control" name="registerpswd" placeholder="Create password" maxlength="25" data-ng-model="registerpswd" required />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-md-3 text-right">
                                                <label class="control-label">Confirm Password</label>
                                            </div>
                                            <div class="col-md-9">
                                                <input type="password" class="form-control" name="confirmpswd" placeholder="Re-enter password" maxlength="25" data-ng-model="confirmpswd" required />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <button type="button" class="btn btn-success center-block" data-ng-click="registerUser()">Register</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="modal-footer">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <section id="promo" class="promo section offset-header has-pattern">
            <div class="container">
                <div class="row">
                    <div class="overview col-md-8 col-sm-12 col-xs-12">
                        <h2 class="title animated fadeInUp delayp1" style="opacity: 0;">Delta helps you broadcast live images using your mobile</h2>
                        <ul class="summary animated fadeInUp delayp2" style="opacity: 0;">
                            <li>Quickly setup your mobile device to broadcast images</li>
                            <li>View your broadcast live on web</li>
                            <li>Choose to broadcast publicly or start a private stream</li>
                            <li>Many more interesting features</li>
                        </ul>
                        <div class="download-area">
                            <ul class="btn-group list-inline">
                                <li class="ios-btn"><a href="./#">Download from the App Store</a></li>
                                <li class="android-btn"><a href="./#">Get it from Google Play</a></li>
                            </ul>
                        </div>
                    </div>

                    <!--// iPhone starts -->
                    <div class="phone iphone iphone-black col-md-4 col-sm-12 col-xs-12 ">
                        <div class="iphone-holder phone-holder animated fadeInRight delayp4" style="opacity: 0;">
                            <div class="iphone-holder-inner">
                                <div class="slider flexslider">
                                    <ul class="slides">
                                        <li style="width: 100%; float: left; margin-right: -100%; position: relative; opacity: 1; display: block; z-index: 2;" class="flex-active-slide">
                                            <img src="./../../web/images/iphone/iphone-slide-1.png" alt="" draggable="false">
                                        </li>
                                        <li style="width: 100%; float: left; margin-right: -100%; position: relative; opacity: 0; display: block; z-index: 1;" class="">
                                            <img src="./../../web/images/iphone/iphone-slide-2.png" alt="" draggable="false">
                                        </li>
                                        <li style="width: 100%; float: left; margin-right: -100%; position: relative; opacity: 0; display: block; z-index: 1;" class="">
                                            <img src="./../../web/images/iphone/iphone-slide-3.png" alt="" draggable="false">
                                        </li>
                                    </ul>
                                    <ol class="flex-control-nav flex-control-paging">
                                        <li>
                                            <a class="flex-active">1</a>
                                        </li>
                                        <li>
                                            <a class="">2</a>
                                        </li>
                                        <li>
                                            <a class="">3</a>
                                        </li>
                                    </ol>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ******FEATURES****** --> 
        <section id="features" class="features section">
            <div class="container">
                <div class="row">
                    <h2 class="title text-center sr-only">Features</h2>
                    <div class="item col-md-3 col-sm-6 col-xs-12 text-center">
                        <div class="icon animated fadeInUp delayp1" style="opacity: 0;">
                            <i class="fa fa-cloud-upload"></i>                
                        </div><!--//icon-->
                        <div class="content">
                            <h3 class="title">Get power of cloud</h3>
                            <p>Broadcast with persistent cloud storage.</p>
                            <button class="modal-trigger btn btn-link" data-toggle="modal" data-target="#feature-modal-1">Find out more</button>
                        </div><!--//content-->               
                    </div><!--//item-->
                    <div class="item col-md-3 col-sm-6 col-xs-12 text-center">
                        <div class="icon animated fadeInUp delayp1" style="opacity: 0;">
                            <i class="fa fa-rocket"></i>                
                        </div><!--//icon-->
                        <div class="content">
                            <h3 class="title">Broadcast on the go</h3>
                            <p>Start your first live stream in seconds</p>   
                            <button class="modal-trigger btn btn-link" data-toggle="modal" data-target="#feature-modal-1">Find out more</button>
                        </div><!--//content-->               
                    </div><!--//item-->
                    <div class="item col-md-3 col-sm-6 col-xs-12 text-center">
                        <div class="icon animated fadeInUp delayp1" style="opacity: 0;">
                            <i class="fa fa-users"></i>                
                        </div><!--//icon-->
                        <div class="content">
                            <h3 class="title">Broadcast publicly</h3>
                            <p>Share interesting stream with the community</p> 
                            <button class="modal-trigger btn btn-link" data-toggle="modal" data-target="#feature-modal-1">Find out more</button>  
                        </div><!--//content-->               
                    </div><!--//item-->
                    <div class="item col-md-3 col-sm-6 col-xs-12 text-center">
                        <div class="icon animated fadeInUp delayp1" style="opacity: 0;">
                            <i class="fa fa-map-marker"></i>                
                        </div><!--//icon-->
                        <div class="content">
                            <h3 class="title">Track location of device</h3>
                            <p>Track coordinates of your device when it is not with you</p>   
                            <button class="modal-trigger btn btn-link" data-toggle="modal" data-target="#feature-modal-1">Find out more</button>
                        </div><!--//content-->               
                    </div><!--//item-->
                </div><!--//row-->

                <div class="row feature-row-last">
                    <div class="item col-md-4 col-sm-6 col-xs-12 text-center">
                        <div class="icon animated fadeInUp delayp1" style="opacity: 0;">
                            <i class="fa fa-calendar"></i>                
                        </div><!--//icon-->
                        <div class="content">
                            <h3 class="title">Schedule your stream</h3>
                            <p>Set scheduling when to automatically start broadcasting.</p>  
                            <button class="modal-trigger btn btn-link" data-toggle="modal" data-target="#feature-modal-1">Find out more</button>
                        </div><!--//content-->               
                    </div><!--//item-->
                    <div class="item col-md-4 col-sm-6 col-xs-12 text-center">
                        <div class="icon animated fadeInUp delayp1" style="opacity: 0;">
                            <i class="fa fa-comments"></i>                
                        </div><!--//icon-->
                        <div class="content">
                            <h3 class="title">Add comments while streaming live.</h3>
                            <p>Add some notes at the moment to be streamed along with media</p>  
                            <button class="modal-trigger btn btn-link" data-toggle="modal" data-target="#feature-modal-1">Find out more</button>
                        </div><!--//content-->               
                    </div><!--//item-->
                    <div class="item col-md-4 col-sm-6 col-xs-12 text-center">
                        <div class="icon animated fadeInUp delayp1" style="opacity: 0;">
                            <i class="fa fa-globe"></i>
                        </div><!--//icon-->
                        <div class="content">
                            <h3 class="title">Use globally</h3>
                            <p>Go anywhere, use with the same ease.</p> 
                            <button class="modal-trigger btn btn-link" data-toggle="modal" data-target="#feature-modal-1">Find out more</button>  
                        </div><!--//content-->               
                    </div><!--//item-->
                </div><!--//row-->
            </div><!--//container-->
        </section><!--//features-->
        <script type="application/javascript" src="./../../web/plugins/jquery-1.12.3.min.js"></script>
        <script type="application/javascript" src="./../../web/plugins/bootstrap.min.js"></script>
        <script type="application/javascript" src="./../../web/plugins/angular.min.js"></script>
        <script type="application/javascript" src="./../../web/js/homeapp.js"></script>
        <script type="application/javascript" src="./../../web/js/controllers/registerCtrl.js"></script>
        <script type="text/javascript">
            var registerObj = {};
            registerObj.email = '<?php echo $userEmail;?>';
            registerObj.secureId = '<?php echo $linkId;?>';
            registerObj.link = '<?php echo $secureLink;?>';
        </script>
    </body>
</html>