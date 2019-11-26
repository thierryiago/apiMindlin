<?php

if ($_SERVER['REQUEST_METHOD'] =='POST'){

    $idLivro = $_POST['idLivro'];
    $idUsuario = $_POST['idUsuario'];
    $data_espera = $_POST['data_espera'];

    require_once 'connect.php';

	$verifica = "SELECT * FROM listaespera WHERE vencido='N' AND confirmaReserva='N'";
	$teste = mysqli_query($conn, $verifica);
	$temp = mysqli_fetch_assoc($teste);
	
	$reservado = "SELECT * FROM reserva WHERE devolvido='N'";
	$leve = mysqli_query($conn, $reservado);
	$chama = mysqli_fetch_assoc($leve);
	
	if($temp['FKUsuario'] === $idUsuario || $chama['FKUsuario'] === $idUsuario){
		$result["success"] = "2";
		$result["message"] = "success";

       	echo json_encode($result);
        mysqli_close($conn);
	} 
	else{
		
	$sql = "SELECT idTombo, numero_tombo from tombo 
	where situacao = 'D' and FKPublicacao = '$idLivro'
	limit 1";
	$response = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($response);
	
	if($row['numero_tombo']){
		$tombo = $row['numero_tombo'];
		$idTombo = $row['idTombo'];
		$alterar = "UPDATE tombo SET situacao='E' where numero_tombo = '$tombo'";
		$response1 = mysqli_query($conn, $alterar);
		
		$reserva = "INSERT INTO listaespera (FKUsuario, FKTombo, FKPublicacao, dataEspera) VALUES ('$idUsuario', '$idTombo', '$idLivro', '$data_espera')";
		$response2 = mysqli_query($conn, $reserva);
		
		} if($response1 && $response2){
		$result["success"] = "1";
        $result["message"] = "success";

       	echo json_encode($result);
        mysqli_close($conn);
		
		}else {
		$result["success"] = "0";
       	$result["message"] = "error";

        echo json_encode($result);
        mysqli_close($conn);
	}
		
	}
} 
?>