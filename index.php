<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/shared.php");

if (isset($_POST["name"])) {
    $name = $_POST["name"];
    $phone = $_POST["phone"];
    $location = $_POST["location"];
    $skill = $_POST["skill"];
    $econtact = $_POST["econtact"];

    // insert a new account
    DB::insert('user', array(
        'name' => $name,
        'phone' => $phone,
        'location' => $location,
        'econtact' => $econtact,
        'skill' => $skill,
        'state' => "registered",
    ));

    redirect("/registered.php");

}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Village Alert</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="css/freelancer.css" rel="stylesheet" type="text/css">

    <!-- Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>

    <!-- IE8 support for HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>

<body id="page-top" class="index">

<!-- Navigation -->
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header page-scroll">
            <button type="button" class="navbar-toggle" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#page-top">Village Alert</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav navbar-right">
                <li class="hidden">
                    <a href="#page-top"></a>
                </li>
                <li class="page-scroll">
                    <a href="admin.php">Admin</a>
                </li>
            </ul>
        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
</nav>

<section id="contact" style="margin-top: 10px">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h3>Register</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8 col-lg-offset-2">
                <form role="form" method="post">
                    <div class="row">
                        <div class="form-group col-xs-12 floating-label-form-group">
                            <label for="name">Name</label>
                            <input class="form-control" type="text" name="name" placeholder="Name">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-xs-12 floating-label-form-group">
                            <label for="name">Phone</label>
                            <input class="form-control" type="text" name="phone" placeholder="Phone">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-xs-12 floating-label-form-group">
                            <label for="name">Emergency Contact phone</label>
                            <input class="form-control" type="text" name="econtact" placeholder="Emergency Contact">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-xs-12 floating-label-form-group">
                            <label for="name">Current Location</label>
                            <input class="form-control" type="text" name="location" placeholder="Location">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-xs-12 floating-label-form-group">
                            <label for="name">Can you help in emergency? Note your skill (e.g. Doctor)</label>
                            <input class="form-control" type="text" name="skill" placeholder="Skill">
                        </div>
                    </div>
                    <br>

                    <div class="row">
                        <div class="form-group col-xs-12 text-center">
                            <button type="submit" class="btn btn-lg btn-success">Register</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<footer class="text-center">
    <div class="footer-above">
        <div class="container">
            <div id="contact" class="row">
                <div class="footer-col col-md-6">
                    <h3>Contact</h3>

                    <p>1 Connought Place
                        <br>New Delhi, India</p>
                </div>
                <div class="footer-col col-md-6">
                    <h3>About VillageAlert</h3>

                    <p>Finding and saving lives in emergencies</p>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-below">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    Copyright &copy; 2014 - VillageAlert
                </div>
            </div>
        </div>
    </div>
</footer>

<div class="scroll-top page-scroll visible-xs visble-sm">
    <a class="btn btn-primary" href="#page-top">
        <i class="fa fa-chevron-up"></i>
    </a>
</div>


<script src="js/jquery-1.10.2.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>
<script src="js/classie.js"></script>
<script src="js/cbpAnimatedHeader.js"></script>
<script src="js/freelancer.js"></script>

</body>

</html>
