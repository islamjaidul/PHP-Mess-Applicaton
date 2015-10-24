<!DOCTYPE html>

<head>

    <!-- Basics -->

    <meta charset="utf-8">


    <title>Login</title>

    <!-- CSS -->

    <link rel="stylesheet" href="<?php echo base_url("css/reset.css"); ?>">

    <link rel="stylesheet" href="<?php echo base_url("css/styles.css"); ?>">


</head>

<!-- Main HTML -->

<body>

<!-- Begin Page Content -->

<?php
defined('BASEPATH') OR exit('No direct script access allowed');
if (isset($login_error)) {
?>
<div class="error">
    <?php
    echo $login_error;
    }
    ?>
</div>

<div id="container">
    <!--<p style="color:#333399; margin:10px 0 -12px 15px; font-size:18px;">Login to JS-Global</p>-->
    <?php echo form_open("login") ?>

    <label for="name">Username:</label>

    <input type="name" name="username" id="username">

    <label for="username">Password:</label>

    <!--<p><a href="#">Forgot your password?</a>-->

    <input type="password" name="password" id="password">

    <div id="lower">

        <input type="checkbox" name="remember" id="remember"><label class="check" for="checkbox">Remember me</label>

        <input type="submit" value="Login" name="submit"> <br/>

    </div>


    </form>
    <a style="font-size: 12px; color:teal" href="<?php echo site_url("create"); ?>">Create New Account</a>

</div>


<!-- End Page Content -->

</body>

</html>
	
	
	
	
	
		
	