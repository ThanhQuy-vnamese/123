<?php
include_once("../backend/login.php");
$tokens = $_REQUEST['token'] ?? '';
$p=new User();
if($tokens) {
    $p->pass_login($tokens);
}
if(empty($_SESSION["email"])||empty($_SESSION["password"]) and $tokens==='') {
    echo "<script>
	window.location = 'login.php';
    </script>";
}
else{
    $email=$_SESSION["email"];
    $password=$_SESSION["password"];
    $p->confirm($email,$password);
}
$email = $_SESSION['email'];
function getUsernameFromEmail($email) {
    $find = '@';
    $pos = strpos($email, $find);
    $username = substr($email, 0, $pos);
    return $username;
}
$filename = getUsernameFromEmail($email);

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    <title>Login</title>
    <style>
        body {
            color: #000;
            overflow-x: hidden;
            height: auto;
            background-color: #B0BEC5;
            background-repeat: no-repeat
        }

        .card0 {
            box-shadow: 0px 4px 8px 0px #757575;
            border-radius: 0px
        }

        .card2 {
            margin: 0px 40px
        }

        .logo {
            width: 200px;
            height: 100px;
            margin-top: 20px;
            margin-left: 35px
        }

        .image {
            width: 360px;
            height: 280px
        }

        .border-line {
            border-right: 1px solid #EEEEEE
        }

        .facebook {
            background-color: #3b5998;
            color: #fff;
            font-size: 18px;
            padding-top: 5px;
            border-radius: 50%;
            width: 35px;
            height: 35px;
            cursor: pointer
        }

        .twitter {
            background-color: #1DA1F2;
            color: #fff;
            font-size: 18px;
            padding-top: 5px;
            border-radius: 50%;
            width: 35px;
            height: 35px;
            cursor: pointer
        }

        .linkedin {
            background-color: #2867B2;
            color: #fff;
            font-size: 18px;
            padding-top: 5px;
            border-radius: 50%;
            width: 35px;
            height: 35px;
            cursor: pointer
        }

        .line {
            height: 1px;
            width: 45%;
            background-color: #E0E0E0;
            margin-top: 10px
        }

        .or {
            width: 10%;
            font-weight: bold
        }

        .text-sm {
            font-size: 14px !important
        }

        ::placeholder {
            color: #BDBDBD;
            opacity: 1;
            font-weight: 300
        }

        :-ms-input-placeholder {
            color: #BDBDBD;
            font-weight: 300
        }

        ::-ms-input-placeholder {
            color: #BDBDBD;
            font-weight: 300
        }

        input,
        textarea {
            padding: 10px 12px 10px 12px;
            border: 1px solid lightgrey;
            border-radius: 2px;
            margin-bottom: 5px;
            margin-top: 2px;
            width: 100%;
            box-sizing: border-box;
            color: #2C3E50;
            font-size: 14px;
            letter-spacing: 1px
        }

        input:focus,
        textarea:focus {
            -moz-box-shadow: none !important;
            -webkit-box-shadow: none !important;
            box-shadow: none !important;
            border: 1px solid #304FFE;
            outline-width: 0
        }

        button:focus {
            -moz-box-shadow: none !important;
            -webkit-box-shadow: none !important;
            box-shadow: none !important;
            outline-width: 0
        }

        a {
            color: inherit;
            cursor: pointer
        }

        .btn-blue {
            background-color: #1A237E;
            width: 150px;
            color: #fff;
            border-radius: 2px
        }

        .btn-blue:hover {
            background-color: #000;
            cursor: pointer
        }

        .bg-blue {
            color: #fff;
            background-color: #1A237E
        }

        @media screen and (max-width: 991px) {
            .logo {
                margin-left: 0px
            }

            .image {
                width: 300px;
                height: 220px
            }

            .border-line {
                border-right: none
            }

            .card2 {
                border-top: 1px solid #EEEEEE !important;
                margin: 0px 15px
            }
        }
    </style>
</head>
<body>
<div class="container-fluid px-1 px-md-5 px-lg-1 px-xl-5 py-5 mx-auto">
    <div class="card card0 border-0">
        <div class="row d-flex">
            <div class="col-lg-4" style="border-right: 5px dotted #f2e7c3">
                <div class="card1 pb-5">
                    <div class="row"> <a href="index.php"><img src="https://i.imgur.com/CXQmsmF.png" class="logo" alt=""></a> </div>
                    <div class="row px-3 justify-content-center mt-4 mb-5 border-line">
                        <div class="align-content-lg-center">
                        <div class="" style="border:2px solid black; width:210px; height:210px;">
                           <img src="qr_code.php" style="width:200px; height:200px;" hidden alt=""><br>
                            <?php
                                if(isset($_REQUEST['token'])){
                                    echo '<img src="./qr_file/'. $filename.'.png" style="width:200px; height:200px;"><br>';
                                }
                                elseif(isset($_REQUEST["submit"])){
                                    echo '<img src="./qr_file/'. $filename.'.png" style="width:200px; height:200px;"><br>';
                                }
                            ?>
                        </div>
                            <a class="btn btn-primary submitBtn" style="width:210px; margin:5px 0;" href="download.php?file=<?php  echo $filename; ?>.png ">Download QR Code</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card2 card border-0 px-4 py-5">
                    <h5>Your Medican Record</h5>
                    <form method="post">
                        <?php
                        $a=$p->get_value($email)
                        ?>
                        <div class="row px-3"> <label class="mb-1">
                                <h6 class="mb-0 text-sm">Email Address</h6>
                            </label> <input class="mb-4" type="text" name="email"  value="<?=$a['email']??@$email?>" placeholder="Enter a valid email address" required> </div>
                        <div class="row px-3"> <label class="mb-1">
                                <h6 class="mb-0 text-sm">Full Name</h6>
                            </label> <input  class="mb-4"  type="text" name="full_name" value="<?=$a['full_name']??''?>" placeholder="Enter your Full Name" required> </div>
                        <div class="row px-3"> <label class="mb-1">
                                <h6 class="mb-0 text-sm">Your Address</h6>
                            </label> <input class="mb-4" type="text" name="address" value="<?=$a['address']??''?>" placeholder="Enter a valid address" required> </div>
                        <div class="row px-3"> <label class="mb-1">
                                <h6 class="mb-0 text-sm">Date of Birth</h6>
                            </label> <input  class="mb-4" type="date" name="birth" value="<?=$a['birth']??''?>" required > </div>
                        <div class="row px-3"> <label class="mb-1">
                                <h6 class="mb-0 text-sm">Phone Number</h6>
                            </label> <input class="mb-4" type="number" name="phone" value="<?=$a['phone']??''?>" placeholder="Enter a valid Phone" pattern="^[+]{0,1}[0-9]{5,13}$" required> </div>
                        <div class="row px-3"> <label class="mb-1">
                                <h6 class="mb-0 text-sm">Health</h6></label>
                            <?php
                            if(isset($_REQUEST['token'])){
                                echo'<input class="mb-4" type="text" name="health[]" value="';
                                echo($a['health']);
                                echo'"required>';
                            }
                            else{
                                echo '<div class="form-check form-check-inline">
                                <label class="form-check-label"><input  class="form-check-inline" type="checkbox" name="healths[]" value="cough" >COUGH</label>
                                <label class="form-check-label"><input  class="form-check-inline" type="checkbox" name="healths[]" value="fever" >FEVER </label>
                                </div>';
                            }
                            ?>

                        </div>
                        <?php
                            if(isset($_REQUEST['token'])){
                                echo '<div class="row mb-4 px-3"> <small class="font-weight-bold">You Want to Edit?<a class="text-warning" href="qr.php">Edit</a></small> </div>';
                            }
                            else{
                                echo '<div class="row mb-3 px-3"> <button type="submit" name="submit" class="btn btn-blue text-center">SAVE</button> </div>';
                            }
                            ?>
                    </form>
                    <?php
                        if(isset($_REQUEST["submit"])){
                            $email=$_REQUEST["email"];
                            $full_name=$_REQUEST["full_name"];
                            $address=$_REQUEST["address"];
                            $birth=$_REQUEST["birth"];
                            $phone=$_REQUEST["phone"];
                            $user_health='';
                            if(!empty($_POST['healths'])) {
                                foreach ($_POST['healths'] as $health) {
                                    $user_health .= $health . ' ';
                                }
                            }
                            $p-> insert_profile($email, $full_name, $phone, $birth, $address, $user_health);
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
