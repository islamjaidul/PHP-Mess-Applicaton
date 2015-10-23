<html>
<head>
    <title>Registration</title>
    <link rel="stylesheet" href="<?php echo base_url("css/bootstrap.min.css");?>">
    <style>
        body{
            background-color:#eee;
        }
        .container{
            margin-top:15px;
        }
        .form-control{
            width:300px;
            border-radius:0px;
            margin-left:20px;
            margin-bottom:15px;
            border-color:skyblue;
        }
        .btn{
            border-radius:0px;
            width: 300px;
            margin-left:20px;
        }
        h1{
            margin-bottom:27px;
        }
        .p{
            text-align: right;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Sign Up</h1>
    <?php
    if(validation_errors()) {
        ?>
        <div class="alert alert-danger">
            <?php echo validation_errors();?>
        </div>
    <?php }?>
    <?php echo form_open("create")?>
    <table>
        <tr>
            <td>
                <p class="p">Username: </p>
            </td>
            <td>
                <input type="text" class="form-control" name="username" value="<?php echo set_value('username')?>">
            </td>
        </tr>

        <tr>
            <td>
                <p class="p">Password: </p>
            </td>
            <td>
                <input type="password" class="form-control" name="password">
            </td>
        </tr>

        <tr>
            <td>
                <p class="p">Confirm Password: </p>
            </td>
            <td>
                <input type="password" class="form-control" name="cpassword">
            </td>
        </tr>

        <tr>
            <td>
                <p class="p">E-mail: </p>
            </td>
            <td>
                <input type="text" class="form-control" name="email" value="<?php echo set_value('email')?>">
            </td>
        </tr>

        <tr>
            <td>
                <p class="p">Mobile: </p>
            </td>
            <td>
                <input type="text" class="form-control" name="mobile" value="<?php echo set_value('mobile')?>">
            </td>
        </tr>

        <tr>
            <td></td>
            <td>
                <input type="submit" class="btn btn-primary" value="Signup">
            </td>
        </tr>
    </table>
</div>
</body>