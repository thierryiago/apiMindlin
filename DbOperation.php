<?php
 
class DbOperation
{
    //Link de conexão com banco de dados
    private $con;
 
    //Construtor da classe
    function __construct()
    {
        // Obtendo o arquivo DbConnect.php
        require_once dirname(__FILE__) . '/DbConnect.php';
 
        // Criando um objeto DbConnect para se conectar ao banco de dados
        $db = new DbConnect();
 
        
		// Inicializando o link de conexão
        // chamando o método connect da classe DbConnect
        $this->con = $db->connect();
    }

	
	/*
	* A operação de leitura
	* Quando este método é chamado, ele está retornando todo o registro existente do banco de dados
	*/
	function getPublicacao(){
		$stmt = $this->con->prepare("SELECT pu.idLivro, pu.titulo, pu.subtitulo, pu.paginas, pu.pesquisatags, pu.sinopse, pu.imageURL 
		from publicacao pu
		inner join tombo tom on tom.FKPublicacao = pu.idLivro
		where tom.situacao = 'D' 
		group by pu.idLivro");
        
        $stmt->execute();
		$stmt->bind_result($idLivro,$titulo,$subtitulo,$paginas,$pesquisatags,$sinopse,$imageURL);
		
		$publicacoes = array(); 
		
		while($stmt->fetch()){
			$publicacao  = array();
			$publicacao['idLivro'] = $idLivro; 
			$publicacao['titulo'] = $titulo; 
			$publicacao['subtitulo'] = $subtitulo; 
            $publicacao['paginas'] = $paginas; 
            $publicacao['pesquisatags'] = $pesquisatags;
            $publicacao['sinopse'] = $sinopse; 
            $publicacao['imageURL'] = $imageURL;
			
			array_push($publicacoes, $publicacao); 
		}
		
		return $publicacoes; 
    }
    
}