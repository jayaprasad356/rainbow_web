<?php
include_once('includes/functions.php');
$function = new functions;
include_once('includes/custom-functions.php');
$fn = new custom_functions;

$sql = "SELECT id, name FROM categories ORDER BY id ASC";
$db->sql($sql);
$res = $db->getResult();
date_default_timezone_set('Asia/Kolkata');
?>
<?php
 $ID = $db->escapeString($_GET['id']);
if (isset($_POST['btnAdd'])) {
        $coins = $db->escapeString(($_POST['coins']));
        $error = array();
       
        if (empty($coins)) {
            $error['coins'] = " <span class='label label-danger'>Required!</span>";
        }
       
            if (!empty($coins)) 
            {
            
                $sql = "UPDATE `users` SET  `coins` = coins + $coins WHERE `id` = $ID";
                $db->sql($sql);
                 $result = $db->getResult();
                 if (!empty($result)) {
                     $result = 0;
                 } else {
                     $result = 1;
                 }
     
                 if ($result == 1) {
                     $error['add_coins'] = "<section class='content-header'>
                                                     <span class='label label-success'>Coins Added Successfully</span> </section>";
                 }
            }

        }
?>
<section class="content-header">
    <h1>Add Coins <small><a href='users.php'> <i class='fa fa-angle-double-left'></i>&nbsp;&nbsp;&nbsp;Back to Users</a></small></h1>
    <?php echo isset($error['add_coins']) ? $error['add_coins'] : ''; ?>
    <ol class="breadcrumb">
        <li><a href="home.php"><i class="fa fa-home"></i> Home</a></li>
    </ol>
</section>
<section class="content">
    <div class="row">
        <div class="col-md-6">
           
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">

                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form name="add_coins_form" method="post" enctype="multipart/form-data">
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group">
                                <div class='col-md-8'>
                                    <label for="exampleInputEmail1">Coins</label> <i class="text-danger asterik">*</i><?php echo isset($error['coins']) ? $error['coins'] : ''; ?>
                                    <input type="number" class="form-control" name="coins" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->

                    <div class="box-footer">
                        <button type="submit" class="btn btn-primary" name="btnAdd">Add</button>
                    </div>

                </form>

            </div><!-- /.box -->
        </div>
    </div>
</section>

<div class="separator"> </div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>

<?php $db->disconnect(); ?>