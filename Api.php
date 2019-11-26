<?php 

	//Recebendo a classe dboperation
	require_once '../android_register_login/DbOperation.php';
	
	// Método que irá validar todos os parâmetros que estão disponíveis
	// vamos passar os parâmetros necessários para este método

	function isTheseParametersAvailable($params){
		//assumindo que todos os parâmetros estão disponíveis
		$available = true; 
		$missingparams = ""; 
		
		foreach($params as $param){
			if(!isset($_POST[$param]) || strlen($_POST[$param])<=0){
				$available = false; 
				$missingparams = $missingparams . ", " . $param; 
			}
		}
		
		
		//se os parâmetros estiverem faltando
		if(!$available){
			$response = array(); 
			$response['error'] = true; 
			$response['message'] = 'Parameters ' . substr($missingparams, 1, strlen($missingparams)) . ' missing';
			
			//exibindo os erros
			echo json_encode($response);
			
			//parando a execução adicional
			die();
		}
	}
	
	//matriz para exibir a resposta
	$response = array();
	
	
	// se for uma chamada de API
	// isso significa que um parâmetro get chamado api call é definido na URL
	// e com este parâmetro estamos concluindo que é uma chamada de API

	if(isset($_GET['apicall'])){
		
		switch($_GET['apicall']){
			
			case 'getpublicacao':
				$db = new DbOperation();
				$response['error'] = false; 
				$response['message'] = 'Pedido concluído com sucesso';
				$response['publicacoes'] = $db->getPublicacao();
			break; 		
		}	
	}
	else{
		//se não for uma chamada api
		//respondendo com os valores apropriados para array
		$response['error'] = true; 
		$response['message'] = 'Chamda de API inválida.';
	}
	
	//exibindo a resposta na estrutura do JSON
	echo json_encode($response);
	
	
