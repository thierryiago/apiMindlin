<?php

if ($_SERVER['REQUEST_METHOD'] =='POST'){

    $oldsenha = $_POST['oldsenha'];
    $newsenha = $_POST['newsenha'];
    $confirmnewsenha = $_POST['confirmnewsenha'];
    $id = $_POST['id'];

    require_once 'connect.php';


    $sql = "SELECT senha FROM usuario WHERE idUsuario='$id' ";
    $response = mysqli_query($conn, $sql);

    $row = mysqli_fetch_assoc($response);


    if (password_verify($oldsenha, $row['senha'])) {

    	if ($newsenha === $confirmnewsenha) {
    		$confirmnewsenha = password_hash($confirmnewsenha, PASSWORD_DEFAULT);
    		$alterar = "UPDATE usuario SET senha='$confirmnewsenha' WHERE idUsuario='$id'";
    		$response1 = mysqli_query($conn, $alterar);

    		$result["success"] = "1";
        	$result["message"] = "success";

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