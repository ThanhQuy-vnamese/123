<?php
session_start();
require_once("connect.php");
use App\Backend\Token;
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
            $password=md5($pass);
            $sql2="insert into account(username, email, password, token) values('$email','$email','$password','$token_regs')";

            if(mysqli_query($link,$sql2))
            {

                echo"<script>alert('User created');</script>";
                $this->login($email, $pass);
            }
            else
            {
                echo"<script>alert('Register failed');</script>";
            }
        }
        else
        {
            echo"<script>alert('Email already exists');</script>";
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
        } else {
            echo "<script>
                    window.location = '../frontend/login.php';
                </script>";
        }
    }

}