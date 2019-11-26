<?php

if ($_SERVER['REQUEST_METHOD']=='POST') {

    $idUsuario = $_POST['idUsuario'];

    require_once 'connect.php';

    $sql = "SELECT pu.titulo, au.nomeAutor, re.data_devolucao
FROM publicacao pu
inner join autor au on au.idAutor = pu.FKAutor
inner join reserva re on re.FKPublicacao = pu.idLivro
where re.devolvido = 'N' and re.FKUsuario = '$idUsuario'";


    $response = mysqli_query($conn, $sql);

    $result = array();
    $result['reservado'] = array();
    
    if ( mysqli_num_rows($response) === 1 ) {
        
        $row = mysqli_fetch_assoc($response);

        if ($row) {
            
            $index['titulo'] = $row['titulo'];
            $index['autor'] = $row['nomeAutor'];
            $index['data'] = $row['data_devolucao'];

            array_push($result['reservado'], $index);

            $result['success'] = "1";
            $result['message'] = "success";
            echo json_encode($result);

            mysqli_close($conn);

        } else {

            $result['success'] = "0";
            $result['message'] = "error";
            echo json_encode($result);

            mysqli_close($conn);

        }

    }

}

?>