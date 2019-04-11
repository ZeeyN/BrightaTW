<?php require_once('includes/views/header.php') ?>
<?php 
if($session->isSignedIn())
{
	redirect("index.php");
}


if(isset($_POST['submit']))
{
	$username = trim($_POST['username']);
	$password = trim($_POST['password']);

	$user_found = User::verifyUser($username, $password);

	if($user_found)
	{
		$session->login($user_found);
		redirect("index.php");
	} else {
		$message = "Your password or username are incorrect!";
	}
} else {
		$message = "";
		$username = "";
		$password = "";
}



 ?>

 <div class="col-md-4 col-md-offset-4">

<h4 class="bg-danger"><?= $message; ?></h4>
	
<form id="login-id" action="" method="post">
	
<div class="form-group">
	<label for="username">Username</label>
	<input type="text" class="form-control" name="username" value="<?= htmlentities($username); ?>" >

</div>

<div class="form-group">
	<label for="password">Password</label>
	<input type="password" class="form-control" name="password" value="<?= htmlentities($password); ?>">
	
</div>


<div class="form-group">
<input type="submit" name="submit" value="Login" class="btn btn-primary">
<a href="register.php" class="btn btn-primary pull-right">Register</a>

</div>


</form>


</div>