<?php

if ($_SERVER['REQUEST_METHOD'] =='POST'){

    $email = $_POST['email'];
    $rm = $_POST['rm'];
    $rg = $_POST['rg'];
    $password = $_POST['password'];
    

    $password = password_hash($password, PASSWORD_DEFAULT);

    require_once 'connect.php';

    $sql = "UPDATE usuario SET email_usuario='$email', senha='$password', imagemUsuario='https://mindlinapp.herokuapp.com/imagens/' '$rm' '.jpg'  WHERE rm='$rm' AND rg='$rg' ";

    $response = mysqli_query($conn, $sql);
 
    if ($response) {
    	if (mysqli_affected_rows($conn) > 0) {
    		$result["success"] = "1";
        	$result["message"] = "success";

        	echo json_encode($result);
        	mysqli_close($conn);
    	} else {
    		$result["success"] = "0";
       	 	$result["message"] = "error";

        	echo json_encode($result);
        	mysqli_close($conn);
    	}
    	
    } else {
    	$result["success"] = "0";
        $result["message"] = "error";

        echo json_encode($result);
        mysqli_close($conn);
    } 
}

?>