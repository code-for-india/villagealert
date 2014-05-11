<?php
require_once($_SERVER['DOCUMENT_ROOT'] . "/shared.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/database.php");

$q = $_GET["tag"];
$on = "reglocation";
if (isset($_GET["submit-ppl"])) {
    $on = "name";
}
$searchResToShow = getAllList($q);

$sent_warning = "";

if (isset($_POST["broadcast-warn"])) {
    $totext = $_POST["totext"];
    $loc = "Rishikesh";
    send_warning($totext, $loc);
    $sent_warning = "Successfully broadcasted warning to $loc area!";
}

function getAllList($q)
{
    global $on;
    $html = "";
    if ($on == "name") {
        $ppl = DB::query("SELECT * FROM user WHERE $on LIKE '%%l%' OR skill LIKE '%%l%' ORDER BY name", $q, $q);
    } else {
        $ppl = DB::query("SELECT * FROM user WHERE $on LIKE '%%l%' OR location LIKE '%%l%' ORDER BY name", $q, $q);
    }

    foreach ($ppl as $p) {
//        print_r_pre($p);
        $html .= genRowHtml($p);
    }
    $html .= "</tbody>";
    $html = "<table id='results_table' class='table table-striped valign-middle' class=''>
    <thead>
        <tr>
            <th>Registered Place</th>
            <th>Updated</th>
            <th>Name</th>
            <th>Location</th>
            <th>Phone</th>
            <th>Skill</th>
            <th>State</th>
            <th></th>
        </tr>
        </thead>" . $html . "</table>";

    return $html;
}

function genRowHtml($p)
{
    $date = date('m/d/y g:i:sa', strtotime($p["last_modified"]) - 8 * 60 * 60);

    $name = htmlsafe($p["name"]);
    $reglocation = htmlsafe($p["reglocation"]);
    $location = htmlsafe($p["location"]);
    $phone = htmlsafe($p["phone"]);
    $skill = htmlsafe($p["skill"]);
    $state = htmlsafe($p["state"]);
    $uuid = $p["uuid"];

    $ret = "<tr id='$uuid'>";
    $ret .= "<td>" . $reglocation . "</td>";
    $ret .= "<td>" . $date . "</td>";
    $ret .= "<td>" . $name . "</td>";
    $ret .= "<td>" . $location . "</td>";
    $ret .= "<td>" . $phone . "</td>";
    $ret .= "<td>" . $skill . "</td>";
    $ret .= "<td>" . $state . "</td>";
    $ret .= "<td>";
    $ret .= "<button type='button' class='send-btn btn btn-success btn-sm'>Text</button>\n";
    $ret .= "<button type='button' class='emer-btn btn btn-success btn-sm'>Text Emer Contact</button>\n";
    if (strstr($skill, "doc")) {
        $ret .= "<button type='button' class='dispatch-btn btn btn-success btn-sm'>Dispatch</button>\n";
    }
    $ret .= "</td>";
    $ret .= "</tr>";

    return $ret;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Village Alert - Admin</title>

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

<body id="page-top" class="index admin-page">

<!-- Navigation -->
<nav class="navbar navbar-default">
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
            <a class="navbar-brand" href="#page-top">Village Alert - Admin</a>
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

<div class="modal fade" id="broadcastModal">
    <div class="modal-dialog">
        <form class="form-inline text-center" role="form" method="POST">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Broadcast Warning</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" name="totext" id="totext" autofocus=""
                               class="form-control" style="width: 100%">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" name="broadcast-warn" class="btn btn-warning">Broadcast Text</button>
                </div>
            </div>
        </form>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<?
if (!empty($sent_warning)) {
    echo "<h2>$sent_warning</h2>";
}
?>

<section id="search" style="margin: 20px;">
    <div class="container text-center">
        <a class='btn btn-warning btn-lg broad-warn-btn' href='#broadcastModal' rel='' data-toggle='modal'><span
                class="glyphicon glyphicon-bullhorn"></span> Broadcast Warning</a>
        <a class='btn btn-danger btn-lg broad-alert-btn' href='#checkModal' rel='' data-toggle='modal'><span
                class="glyphicon glyphicon-comment"></span> Broadcast Safety Check</a>
    </div>
</section>

<section id="search" style="margin: 20px;">
    <div class="container">
        <form class="form-inline text-center" role="form" method="GET">
            <div class="form-group">
                <input type="text" name="tag" id="tag" autofocus=""
                       class="curvy-border input-large form-control">
            </div>

            <div class="form-group">
                <button type="submit" name="submit-ppl" class="btn btn-default">Find Person</button>
                <button type="submit" name="submit-loc" class="btn btn-default">Find Location</button>
            </div>
        </form>
    </div>
</section>

<section id="results" style="margin-top: 10px">
    <div class="container">
        <div id="search_results" style="margin-top: 20px">
            <? echo $searchResToShow ?>
        </div>
    </div>
</section>


<footer class="text-center">
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
