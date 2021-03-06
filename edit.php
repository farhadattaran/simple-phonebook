<?php
if (!isset($_GET['edit_id'])){
    header('Location:index.php');
    exit();
}

include "core/config.php";
$id = $_GET['edit_id'];
$empty = $success = $error = "";
if (isset($_POST['edit'])) {
    if (!empty($_POST["name"]) and !empty($_POST['last_name']) and !empty($_POST['number']) and strlen($_POST['number']) == 11){
        $name = str_replace(' ', '', $_POST['name']);
        $last_name = str_replace(' ', '', $_POST['last_name']);
        $number = str_replace(' ', '', $_POST['number']);

        $sql = "UPDATE `users` SET `id`=:id,`name`=:name,`last_name`=:last_name,`number`=:number WHERE `id`=:id";
        $result = $connect->prepare($sql);
        $result->bindParam(":name",$name);
        $result->bindParam(":last_name",$last_name);
        $result->bindParam(":number",$number);
        $result->bindParam(":id",$id);    
        if ($result->execute()) {
           header("Location: index.php");
        } else {
            $error = "خطا در ویرایش";
        }
    } else {
        if(empty($_POST["name"])) $error ="نام نباید خالی باشد!";
        if(empty($_POST["last_name"])) $error ="نام خانوادگی نباید خالی باشد!";
        if(empty($_POST["number"])) $error ="شماره تلفن نباید خالی باشد";
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

    <title>ویرایش مخاطب</title>

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
</style>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 tooltipss and media queries -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->
   
</head>

<body>
    <section id="container" class="">
        <!--main content start-->
        <section id="main-content">
            <section class="wrapper">
                <!-- page start-->
                <div class="row">
                    <!--errors-->
                    <?php if(isset($success) && $success!=""){include "notice/positive_alarm.php";} ?>
                    <?php if(isset($error) && $error!=""){include "notice/wrong_err.php";} ?>
                    <!--erros-->
                    <?php
                    $SQL = "SELECT * FROM `users` WHERE `id`=:id";
                    $result = $connect->prepare($SQL);
                    $result->bindParam(':id',$id);
                    $result->execute();
                    $pes = $result->fetch(PDO::FETCH_ASSOC);
                    ?>
                    <div class="col-lg-12">
                        <section class="panel">
                            <header class="panel-heading">تغییر شماره فرد</header>
                            <div class="panel-body">
                                <form action="" class="form-horizontal" method="post">
                                    <div class="form">
                                        <label class="col-sm-2 control-label">نام:</label>
                                        <div class="col-sm-10">
                                            <span class="help-block">نام فرد مورد نظر را وارد نمایید </span>
                                            <input name="name" type="text" class="form-control" value="<?=$pes['name'];?>">
                                        </div>
                                        <label class="col-sm-2 control-label">نام خانوادگی :</label>
                                        <div class="col-sm-10">
                                            <span class="help-block">نام خانوادگی فرد مورد نظر را وارد نمایید </span>
                                            <input name="last_name" type="text" class="form-control" value="<?=$pes['last_name'];?>">
                                        </div>
                                        <label class="col-sm-2 control-label">شماره تلفن:</label>
                                        <div class="col-sm-10">
                                            <span class="help-block">شماره تلفن فرد مورد نظر را وارد نمایید </span>
                                            <input name="number" type="number" class="form-control" value="<?=$pes['number'];?>">
                                        </div>
                                        <button name="edit" type="submit" class="btn btn-success btn-lg btn-block">ثبت اطلاعات</button>
                                </form>
                                            
                            </div>
                    </div>
            </section>
            </div>
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
