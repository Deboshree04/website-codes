<?php
session_start();
date_default_timezone_set("Asia/Kolkata");
require "includes/base_url.php";
require "includes/file_version.php";
require "includes/dbconnection.php";
global $BASE_URL;
global $FILE_VERSION;
global $con;

if (!isset($_SESSION["code"]))
{
    header("location: " . $BASE_URL);
    exit();
}

$session_code = md5(date('d-m-Y') . "vethub");
if ($session_code != $_SESSION["code"])
{
    header("location: " . $BASE_URL);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RentPro Dashboard</title>

    <link rel="icon" type="image/png" href="assets/images/favicon.png">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/dashboard.css">
    <link rel="stylesheet" href="assets/fonts/fontawesome/css/all.css">
    <link rel="stylesheet" href="assets/plugins/datepicker/css/bootstrap-datepicker.css">
    <link rel="stylesheet" href="assets/plugins/side-navbar/sidebar-menu.css">
    <link rel="stylesheet" href="assets/plugins/toast-message/toast.min.css">

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="logic/dashboard.js?version=<?php echo $FILE_VERSION; ?>"></script>
    <script src="assets/js/dashboard.js?version=<?php echo $FILE_VERSION; ?>"></script>
    <script src="assets/plugins/datepicker/js/bootstrap-datepicker.js"></script>
    <script src="assets/plugins/side-navbar/sidebar-menu.js?version=<?php echo $FILE_VERSION; ?>"></script>
    <script src="assets/plugins/toast-message/toast.min.js"></script>
    <script src="logic/box.js"></script>
</head>


<body>

<!-- include the header -->
<?php include 'includes/header-menu.php'; ?>

<!-- side-bar menu -->
<?php include 'includes/side-menu.php'; ?>

<!-- website content -->
<div class="site-content">
    <div class="container-fluid modal-container"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="box1">
                    <?php
                    $mon = date("F");
                    echo $mon;
                    ?>
                    <br><span class="s1">Opening balance</span><br>
                    <?php
                    $from = date("Y-m")."-01";

                    $stmt = $con->prepare("select sum(amount) from transaction where grp='Receipt' and tdate<?");
                    $stmt->bind_param('s',$from);
                    $stmt->execute();
                    $stmt->bind_result($receipt);
                    $stmt->fetch();
                    $stmt->close();
                    //echo $receipt;

                    $stmt = $con->prepare("select sum(amount) from transaction where grp='Payment' and tdate<?");
                    $stmt->bind_param("s",$from);
                    $stmt->execute();
                    $stmt->bind_result($payment);
                    $stmt->fetch();
                    $stmt->close();
                    //echo $payment;

                    $opening = $receipt - $payment;
                    echo "Rs ".$opening;
                    ?>
                    <br>
                    <input type="button" class="btn btn-sm btn-success" style="margin: 5px" value="Show Report" onclick="OpeningBalance()">
                </div>
            </div>

            <div class="col-md-3">
                <div class="box2">
                    <?php
                    $mon = date("F");
                    echo $mon;
                    ?>
                    <br><span class="s1">Total receipt</span><br>

                    <?php
                        $rdate=date("y-m-d");
                        $rdate1=date("y-m")."-01";
                        $stmt = $con->prepare("select sum(amount) from transaction where grp='Receipt' and tdate between ? and ?");
                        $stmt->bind_param('ss', $rdate1, $rdate);
                        $stmt->execute();
                        $stmt->bind_result($receipt);
                        $stmt->fetch();
                        echo "Rs ".$receipt;
                        $stmt->close();
                    ?>
                    <br>
                    <input type="button" class="btn btn-sm btn-warning" style="margin: 5px" value="Show Report" onclick="receipt()">
                </div>
            </div>

            <div class="col-md-3">
                <div class="box3">
                    <?php
                    $mon = date("F");
                    echo $mon;
                    ?>
                    <br><span class="s1">Total payment</span><br>
                    <?php
                        $stmt = $con->prepare("select sum(amount) from transaction where grp='Payment' and tdate between ? and ?");
                        $stmt->bind_param('ss',  $rdate1, $rdate);
                        $stmt->execute();
                        $stmt->bind_result($payment);
                        $stmt->fetch();
                        echo "Rs. ".$payment;
                        $stmt->close();
                    ?>
                    <br>
                    <input type="button" class="btn btn-sm btn-primary" style="margin: 5px" value="Show Report" onclick="payment()">
                </div>
            </div>

            <div class="col-md-3">
                <div class="box4">
                    <span class="mon"><?php
                        $mon = date("F");
                        echo $mon;
                        ?>
                    </span>
                    <br><span class="s1">Cash-in-hand</span><br>
                    <?php
                        $date = date("Y-m")."-01";
                        $from = date("Y-m",strtotime("first day of previous month"))."-01";
                        $grp1='Receipt';
                        $stmt = $con->prepare("select sum(amount) from transaction where grp=? and tdate between ? and ?");
                        $stmt->bind_param('sss',$grp1, $from, $date);
                        $stmt->execute();
                        $stmt->bind_result($receipt1);
                        $stmt->fetch();
                        //echo "Rs ".$receipt;
                        $stmt->close();

                        $grp2 = "Payment";
                        $stmt = $con->prepare("select sum(amount) from transaction where grp=? and tdate between ? and ?");
                        $stmt->bind_param('sss', $grp2, $from, $date);
                        $stmt->execute();
                        $stmt->bind_result($payment1);
                        $stmt->fetch();
                        $stmt->close();
                        $opening = $receipt1-$payment1;
                        $cash = $opening + ($receipt - $payment);
                        echo "Rs. ".$cash;
                    ?>
                    <br>
                    <input type="button" class="btn btn-sm btn-danger" style="margin: 5px" value="Show Report" onclick="cash()">
                </div>
            </div>
        </div>
    </div>
</div>



<script>
    $.sidebarMenu($('.sidebar-menu'));
    digitalClock();
</script>
</body>

</html>