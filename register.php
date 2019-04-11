<?php include("includes/views/header.php"); ?>
<?php 
if($session->isSignedIn())
{
	redirect("index.php");
}

    $user = new User();

if (isset($_POST['create'])) {

  if($user){
    if(strlen($_POST['password'])<6)
    {   
        $username = $_POST['username'];
        $message = "Password length is bellow 6 characters!";
    } else {
        $user->username   = $_POST['username'];
        $user->password   = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $user->first_name = $_POST['first_name'];
        $user->last_name  = $_POST['last_name'];
        $user->created_at = date("F d, Y \a\\t g:i A");
        $user->set_file($_FILES['user_image']);

        $verified = User::verifyUser($user->username, $_POST['password']);
        if(empty($verified))
        {
            $user->uploadPhoto();
            $user->create();
            $session->login($user);
            redirect("index.php");
        } else {
            $message = "User with name {$user->username} is allredy exists!";
        }  
    }    
  }
} else {
    $username = '';
}
?>








<div id="page-wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header text-center">
                        Registration
                    </h1>
                    <h4 class="bg-danger"><?= $message; ?></h4>

                    <form action="" method="post" enctype="multipart/form-data">
                    <div class="col-md-6 col-lg-offset-3">
                        
                       <div class="form-group">
                           <label for="username">Username <font color="red">*</font></label>
                           <input type="text" name="username" class="form-control" value="<?= empty($user->username) ? htmlentities($username) : htmlentities($user->username) ?>">

                       </div>

                       <div class="form-group">
                           <label for="password">Password <font color="red">*</font></label>
                           <input type="password" placeholder="min 6 characters" name="password" class="form-control">

                       </div>

                       <div class="form-group">
                           <label for="first_name">First Name</label>
                           <input type="text" name="first_name" class="form-control" value="<?= empty($user->first_name) ? '' : htmlentities($user->first_name);?>">

                       </div>

                       <div class="form-group">
                           <label for="last_name">Last Name</label>
                           <input type="text" name="last_name" class="form-control" value="<?= empty($user->last_name) ? '' : htmlentities($user->last_name);?>">

                       </div>

                       <div class="form-group">
                        <label for="user_image">User photo</label>
                           <input type="file" name="user_image">

                       </div>

                       <div class="form-group">
                           <input type="submit" name="create" value="Register" class="btn btn-primary pull-right">

                       </div>

                    </div>

                    </form>
                    
                </div>
            </div>
        </div>
    </div>
















<?php include("includes/views/footer.php"); ?>