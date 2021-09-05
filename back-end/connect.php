<?php

class Database
{
    function connect_database()
    {
        $connect = mysqli_connect("localhost", "root", "", "test");
        if (!$connect) {
            die("khong ket noi duoc");
        }
        $connect->set_charset("utf8");
        return $connect;
    }

    function insert_profile($email, $full_name, $phone, $birth, $address, $health)
    {
        $connect = $this->connect_database();
        $sql = "SELECT * FROM `profile` WHERE email='$email'";
        $res = mysqli_query($connect, $sql);
        if ($row = mysqli_num_rows($res)) {
            $query = "UPDATE `profile` SET `email`='$email',`full_name`='$full_name', `phone`='$phone',`address`='$address',`birth`='$birth',`health`='$health'WHERE email='$email'";
        } else {
            $query = "INSERT INTO `profile`(`id`, `email`, `full_name`, `phone`, `address`, `birth`, `health`) 
                    VALUES ( '','$email','$full_name','$phone','$address','$birth','$health')";
        }
        $result = mysqli_query($connect, $query);
        if (isset($result) == 1) {
            echo "<script>alert('Đã thực hiện');</script>";
        } else {
            echo "<script>alert('Thất bại');</script>";
        }
    }

    function get_value($email)
    {
        $connect = $this->connect_database();
        $query = "select*from profile p where p.email='$email'";
        $result = mysqli_query($connect, $query);
        $num = mysqli_num_rows($result);
        $data = [];
        if ($num > 0) {
            while ($row = mysqli_fetch_array($result)) {
                $data['email'] = $row['email'];
                $data['full_name'] = $row['full_name'];
                $data['address'] = $row['address'];
                $data['phone'] = $row['phone'];
                $data['birth'] = $row['birth'];
                $data['health'] = $row['health'];
            }
        }

        return $data;
    }
}
