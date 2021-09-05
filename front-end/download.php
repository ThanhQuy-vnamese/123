<?php
include_once("../back-end/login.php");
$p=new User();
if(empty($_SESSION["email"])||empty($_SESSION["password"]) ){
    echo "<script>
	window.location = '../front-end/login.php';
</script>";
}
else{
    $email=$_SESSION["email"];
    $password=$_SESSION["password"];
    $p->confirm($email,$password);
}

if(!empty($_GET['file'])){
    $fileName = basename($_GET['file']);
    $filePath = 'qr_file/'.$fileName;
    if(!empty($fileName) && file_exists($filePath)){
        // Define headers
        header('Content-Length: ' . filesize($filePath));
        header('Content-Encoding: none');
        header("Cache-Control: public");
        header("Content-Description: File Transfer");
        header("Content-Disposition: attachment; filename=$fileName");
        header("Content-Type: application/zip");
        header("Content-Transfer-Encoding: binary");

        // Read the file
        readfile($filePath);
        exit;
    }else{
        echo 'The File '.$fileName.' does not exist.';
    }
}