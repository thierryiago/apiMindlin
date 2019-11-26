<?php

if ($_SERVER['REQUEST_METHOD']=='POST') {

	require_once 'connect.php';


	$sql = "SELECT pu.idLivro, pu.titulo, pu.subtitulo, pu.paginas, pu.pesquisatags, pu.sinopse, pu.imageURL 
		from publicacao pu
		inner join tombo tom on tom.FKPublicacao = pu.idLivro
		where tom.situacao = 'D' 
		group by pu.idLivro";
		
	$response = mysqli_query($conn, $sql);

	$result = array();
    $result['publicacoes'] = array();

  
    if ( mysqli_num_rows($response) === 1 ) {
        
        $row = mysqli_fetch_assoc($response);

			$index['idLivro'] = $row['idLivro'];
            $index['titulo'] = $row['titulo'];
            $index['subtitulo'] = $row['subtitulo'];
            $index['paginas'] = $row['paginas'];
			$index['pesquisatags'] = $row['pesquisatags'];
            $index['sinopse'] = $row['sinopse'];
            $index['imageURL'] = $row['imageURL'];

            array_push($result['login'], $index);

            $result['success'] = "1";
            $result['message'] = "success";
            echo json_encode($result);

            mysqli_close($conn);
	} else {
		
	}


}
?>