<?php include("includes/views/header.php"); ?>
<?php if(!$session->isSignedIn()) {redirect("login.php");} ?>
<?php $logged_user = User::findById($session->user_id); ?>






<div id="page-wrapper">



        <div class="container-fluid">
            <!-- Page Heading -->
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header text-center">
                    	<?= $logged_user->username ?>
                   		<a href="logout.php" class="btn btn-danger pull-right">LOGOUT</a>

                    </h1>


                    <div class="col-md-6 user_image_box">
                      <img class="img-responsive" src="<?= $logged_user->imagePathOrPlaceholder() ?>" width="300px">
                    </div>
                    <form action="" method="post" enctype="multipart/form-data">



                    <div class="col-md-6">

                       <div class="form-group">
                           <label for="first_name">First Name</label>
                           <h5 class="first_name"><?= empty($logged_user->first_name) ? "You have no name" : $logged_user->first_name; ?></h5>

                       </div>

                       <div class="form-group">
                           <label for="last_name">Last Name</label>
                           <h5 class="last_name"><?= empty($logged_user->last_name) ? "You have no last name" : $logged_user->last_name; ?></h5>

                       </div>

                       
                    </div>


                    </form>






                    
                </div>

            </div>
            <!-- /.row -->

        </div>


        <!-- /.container-fluid -->

    </div>
















<?php include("includes/views/footer.php"); ?>