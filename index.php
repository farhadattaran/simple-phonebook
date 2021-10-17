<?php
include "core/config.php";

?>
<?php
$success = $error = "";
if (isset($_POST['send'])) {
    if (!empty($_POST["name"]) and !empty($_POST['last_name']) and !empty($_POST['number']) and strlen($_POST['number']) == 11) {
        $name= $_POST['name'];
        $last_name= $_POST['last_name'];
        $number= $_POST['number'];

        $sql = "INSERT INTO `users`(`name`,`last_name`,`number`) VALUES(:name,:last_name,:number)";
        $result = $connect->prepare($sql);
        $result->bindParam(":name",$name);
        $result->bindParam(":last_name",$last_name);
        $result->bindParam(":number",$number);
        if ($result->execute()) {
            $success = "شماره تلفن فرد مورد نظر با موفقیت ثبت گردید!";
        } else {
            $error = "خطا در  ثبت شماره";
        }

    } else {
        if(empty($_POST["name"])) $error ="نام نباید خالی باشد!";
        if(empty($_POST["last_name"])) $error ="نام خانوادگی نباید خالی باشد!";
        if(empty($_POST["number"])) $error ="شماره تلفن نباید خالی باشد";
        if(strlen($_POST["number"]) != 11) $error ="شماره تلفن باید 11 کاراکتر باشد";
    }
}
if (isset($_GET['del_id'])) {
    $id = $_GET['del_id'];
    $sql = "DELETE FROM `users` WHERE `id`=:id";
    $result = $connect->prepare($sql);
    $result->bindParam(":id",$id);
    if ($result->execute()) {
        $success = "افراد انتخاب شده با موفقیت از دیتابیس حذف گردیدند.";
    } else {
        $error = "پاک نمیشه!";
    }
}

?>
<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Mosaddek">
    <meta name="keyword" content="FlatLab, Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">
    <link rel="shortcut icon" href="img/favicon.html">

    <title>دفترچه تلفن</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/bootstrap-reset.css" rel="stylesheet">
    <!--external css-->
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <!-- Custom styles for this template -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style-responsive.css" rel="stylesheet" />
<style type="text/css">
    .form-horizontal .control-label {
        padding: 10px;
    }
    .wrapper{
      margin: 0 !important;
    }
</style>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->

</head>

<body>
<!-- Modal -->
<div class="modal fade" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">افزودن شماره جدید</h4>
            </div>
            <div class="modal-body">
                <div class="panel-body">
                    <form action="" class="form-horizontal" method="post">
                        <div class="form">

                            <label class="col-sm-2 control-label">نام:</label>
                            <div class="col-sm-10">
                                <span class="help-block">نام فرد مورد نظر را وارد نمایید </span>
                                <input name="name" type="text" class="form-control">
                            </div>
                            <label class="col-sm-2 control-label">نام خانوادگی :</label>
                            <div class="col-sm-10">
                                <span class="help-block">نام خانوادگی فرد مورد نظر را وارد نمایید </span>
                                <input name="last_name" type="text" class="form-control">
                            </div>

                            <label class="col-sm-2 control-label">شماره تلفن:</label>
                            <div class="col-sm-10">
                                <span class="help-block">شماره تلفن فرد مورد نظر را وارد نمایید </span>
                                <input name="number" type="number" class="form-control">
                            </div>
                            <button name="send" type="submit" class="btn btn-success btn-lg btn-block">ثبت اطلاعات</button>
                    </form>

                </div>
            </div>

            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" class="btn btn-default" type="button">بستن پنجره</button>
            </div>
        </div>
    </div>
</div>

<!-- modal -->

<section id="container" class="">
    <!--main content start-->
    <section id="main-content">
        <section class="wrapper">
            <!-- page start-->
            <div class="row">
                <!--errors-->

                <?php if(isset($success) and $success!=""){include "notice/positive_alarm.php";} ?>
                <?php if(isset($error) and $error!=""){include "notice/wrong_err.php";} ?>

                <!--erros-->
                <div class="col-lg-12">
                    <section class="panel">
                        <header class="panel-heading">اطلاعات ثبت شده</header>

                            <table class="table table-striped border-top" id="sample_1">
                                <thead>
                                <center>
                                    <a class="btn btn-shadow btn-success" data-toggle="modal" href="#myModal2">افزودن</a>
                                </center>
                                <tr>
                                    <th style="width: 8px;">شماره</th>
                                    <th class="hidden-phone">نام </th>
                                    <th class="hidden-phone">نام خانوادگی</th>
                                    <th class="hidden-phone"> شماره</th>
                                    <th class="hidden-phone">عملیات</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
								/*******variable $tbl_menu kar nakard!******/
								$sql = "SELECT * FROM `users` ORDER BY `id` DESC";
								$result = $connect->query($sql);
                                while($rowsha = $result->fetch(PDO::FETCH_ASSOC)){
                                ?>
                                    <tr class="odd gradeX">
                                        <td><?=$rowsha['id'];?></td>
                                        <td><?=$rowsha['name'];?></td>
                                        <td><?=$rowsha['last_name'];?></td>
                                        <td class="hidden-phone"><?=$rowsha['number'];?></td>
                                        <td class="hidden-phone">
                                            <a  href="?del_id=<?=$rowsha['id'];?>"> <button type="button" class="btn btn-round btn-danger"><i class="icon-remove-sign"></i>حذف</button></a>
                                            <a href="edit.php?edit_id=<?=$rowsha['id'];?>" data-toggle="modal"> <button type="button" class="btn btn-round btn-warning edit"><i class="icon-pencil" ></i>ویرایش</button></a>
                                        </td>
                                    </tr>
                                <?php } ?>
                                </tbody>

                            </table>
                        </form>
                    </section>
                </div>
                <!-- page end-->
        </section>
    </section>
    <!--main content end-->
</section>

    <!-- js placed at the end of the document so the pages load faster -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.scrollTo.min.js"></script>
    <script src="js/jquery.nicescroll.js" type="text/javascript"></script>
    <script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script>
    <script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script>
    <script type="text/javascript" src="assets/gritter/js/jquery.gritter.js"></script>

    <!--common script for all pages-->
    <script src="js/common-scripts.js"></script>

    <!--script for this page only-->
    <script src="js/dynamic-table.js"></script>


</body>
</html>
