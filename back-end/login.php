<?php
session_start();
require_once("connect.php");
class User extends Database
{
    function login($email, $password)
    {
        $connect = $this->connect_database();
        $password = md5($password);
        $query = "Select email, password from account where email='$email' and password='$password'";
        $result = mysqli_query($connect, $query);
        $i = mysqli_num_rows($result);
        if ($i == 1) {
            while ($row = mysqli_fetch_array($result)) {
                $_SESSION["email"] = $row["email"];
                $_SESSION["password"] = $row["password"];
                echo "<script>
                    window.location = '../front-end/index.php';
                </script>";
            }
        } else {
            echo 'username or password is wrong!';
        }
    }
    function confirm($email, $password){
        $connect = $this->connect_database();
        $query="Select email, password from account where email='$email' and password='$password'";
        $result= mysqli_query($connect, $query);
        if(!$result){
            echo "<script>
                    window.location = '../front-end/qr.php';
                </script>";
        }
    }

}