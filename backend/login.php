<?php
session_start();
require_once("connect.php");
use App\Backend\Token;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once '../vendor/autoload.php';
class User extends Database
{
    function login($email, $password)
    {
        $connect = $this->connect_database();
        $password = md5($password);
        $query = "Select email, password, token from account where email='$email' and password='$password'";
        $result = mysqli_query($connect, $query);
        $i = mysqli_num_rows($result);
        if ($i == 1) {
            while ($row = mysqli_fetch_array($result)) {
                $_SESSION["email"] = $row["email"];
                $_SESSION["password"] = $row["password"];
                $_SESSION["token"] = $row["token"];
                echo "<script>
                    window.location = '../frontend/index.php';
                </script>";
            }
        } else {
            echo 'username or password is wrong!';
        }
    }
    function register($email, $pass)
    {
        $link=$this->connect_database();
        $sql="select * from account where email='$email'";
        $result=mysqli_query($link,$sql);
        $numberUser = mysqli_num_rows($result);
        if($numberUser == 0)
        {
            $token = new Token();
            $payload = [
                "email" => $email,
                "password" => $pass,
            ];

            $token->setPayload($payload);
            $token->setKey('abc');
            $token_regs = $token->encode();

            if($token_regs){
                $mail = new PHPMailer(true);

                $mail->SMTPDebug = 3;
                $mail->isSMTP();
                $mail->Host = "smtp.gmail.com";
                $mail->SMTPAuth = true;
                $mail->Username = "tranthanhquythkg@gmail.com";
                $mail->Password = "quy1234123";
                $mail->SMTPSecure = "tls";
                $mail->Port = 587;

                $mail->From = "tranthanhquythkg@gmail.com";
                $mail->FromName = "Caroline";
                $mail->addAddress("$email", "Recepient Name");

                $mail->isHTML(true);

                $mail->Subject = "Active Your Account";
                $mail->Body = "<h6>Please Click the link below to active your account</h6><br/><a href='http://localhost:81/test/frontend/register.php?token=$token_regs'>'http://localhost:81/test/frontend/register.php?token=$token_regs'</a>";
                $mail->AltBody = "This is the plain text version of the email content";

                try {
                    if($mail->send()) {
                        echo "Message has been sent successfully";
                    }
                } catch (Exception $e) {
                    echo "Mailer Error: " . $mail->ErrorInfo;
                }
            }
        }
        else
        {
            echo"<script>alert('Email already exists');</script>";
        }
    }

    function active($tokens){
        $connect = $this->connect_database();
        $token = new Token();
        $token->setKey('abc');
        $payload = $token->decode($tokens);
        $email = $payload->email;
        $password = $payload->password;
        $pass = md5($password);
        $sql2 = "insert into account(username, email, password, token) values('$email','$email','$pass','$tokens')";

        if (mysqli_query($connect, $sql2)) {

            echo "<script>alert('Your Account have been active success!');</script>";
            $this->login($email, $password);
        } else {
            echo "<script>alert('Something went wrong! Try later!');</script>";
        }
    }
    function confirm($email, $password){
        $connect = $this->connect_database();
        $query="Select email, password from account where email='$email' and password='$password'";
        $result= mysqli_query($connect, $query);
        if(!$result){
            echo "<script>
                    window.location = '../frontend/qr.php';
                </script>";
        }
    }
    function pass_login($tokens){
        $connect = $this->connect_database();
        $token = new Token();
        $token->setKey('abc');
        $payload = $token->decode($tokens);
        $email = $payload->username;
        $password = $payload->password;
        $query = "Select email, password, token from account where email='$email' and password='$password'";
        $result = mysqli_query($connect, $query);
        $i = mysqli_num_rows($result);
        if ($i == 1) {
            while ($row = mysqli_fetch_array($result)) {
                $_SESSION["email"] = $row["email"];
                $_SESSION["password"] = $row["password"];
                $_SESSION["token"] = $row["token"];
                $this ->confirm($_SESSION["email"], $_SESSION["password"]);
            }
        }
        else {
            echo "<script>
                    window.location = '../frontend/login.php';
                </script>";
        }
    }

}