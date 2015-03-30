<?php
/**
* Classe principal do Sistema.
* Dev: Jhordan Lima
*/
class Principal {

	public static $instance; 
	private static $rotaUrl; 

	private static $mainContainer;
	private static $javaScriptContainer;
	private static $jQueryContainer;
	private static $CSSContainer;

	private static $lang;

	const NOME_PROJETO = "EMPRESA";
	const DESCRICAO = "SLOGAM DA EMPRESA";
	const DESENVOLVEDOR = "JHORDAN LIMA";
	const GIT_DESENVOLVEDOR = "http://fb.com/JhorZyto";
	const ANO_DESENVOLVIMENTO = "2015";
	const VERSAO = "0.3.0";

	const ENDERECO_SISTEMA = "http://localhost/framework-jhor/";	
	const ENDERECO_ARQUIVO = "C:/wamp/www/framework-jhor/";

	const ENDERECO_PASTAS = "php/paginas/";
	const ENDERECO_TEMPLATE = "templates/";
	const ENDERECO_CONTEUDOS = "conteudos/";
	const ENDERECO_IDIOMAS = "lang/";

	const PAGINA_DOCUMENTACAO = "termos/";
	const PAGINA_ERROR = "error/";

	public static function getInstance(){ 

		if (!isset(self::$instance)) 
			self::$instance = new Principal(); 

		return self::$instance; 
	
	} 

	public function SetUrl( $redir_solicitacao ){ 

		//vamos testar se a variável pag possui alguma “/”
		if (substr_count($redir_solicitacao, '/') > 0) {

			//utilizamos o explode para separar os valores depois de cada “/”
			$redir_solicitacao = explode('/', $redir_solicitacao);

			/*testamos se depois do endereço do site, o valor da página é um arquivo existente
			caso não exista, iremos atribuir o valor “erro” que será uma página de erro
			personalizada que existirá dentro da pasta '$pasta', esse arquivo será incluido sempre que um endereço invalido for digitado */			
			$redir_pagina = ( $this->paginaExiste ( $redir_solicitacao[0] ) ) ? $redir_solicitacao[0] : self::PAGINA_ERROR ;

			self::$rotaUrl['pagina'] = $redir_solicitacao[0] ; 
			self::$rotaUrl['pagina_id'] = isset( $redir_solicitacao[1] ) ? $redir_solicitacao[1] : null ; 
			self::$rotaUrl['pagina_busca'] = isset( $redir_solicitacao[2] ) ? $redir_solicitacao[2] : null ;  
			self::$rotaUrl['pagina_busca_id'] = isset( $redir_solicitacao[3] ) ? $redir_solicitacao[3] : null ; 
			self::$rotaUrl['pagina_busca_id_busca'] = isset( $redir_solicitacao[4] ) ? $redir_solicitacao[4] : null ; 
			self::$rotaUrl['pagina_busca_id_busca_id'] = isset( $redir_solicitacao[4] ) ? $redir_solicitacao[4] : null ; 

		} else {

			self::$rotaUrl['pagina'] = 'principal';
			self::$rotaUrl['pagina_id'] = 'index';

		}

	}

	public function GetUrl($conteudo){

		return self::$rotaUrl[$conteudo] ;

	}

	public function SetNotificacao( $mensagem ){

		$_SESSION['notificacao'][] = $mensagem;

	}

	public function GetNotificacao(){

		if (isset($_SESSION['notificacao'])) {

			if(is_array($_SESSION['notificacao'])){

				$notificacao = json_encode($_SESSION['notificacao']);
				unset($_SESSION['notificacao']);

				return print $notificacao;

			} else {

				return print json_encode(array(0));

			}

		} else {

			return print json_encode(array(0));

		}

	}

	public function Setlang ( $idioma ){

		ob_start();
			
			include $this->gerarIncludeEndereco( $idioma, "idioma" );

		$json = ob_get_contents(); 		
		ob_end_clean(); 

		self::$lang = json_decode($json, true);

	}

	public function Getlang( $conteudo , $noPrint = false){

		if( isset( self::$lang[ $conteudo ] ) ){

			return ($noPrint) ? self::$lang[ $conteudo ] : print self::$lang[ $conteudo ] ;

		} else {

			$this->SetNotificacao('No translation to "'.$conteudo.'"!');
			return ($noPrint) ? $conteudo : print $conteudo ;

		}

	}

	public function paginaExiste( $redir_pagina , $tipo = "pagina" ){

		switch ($tipo) {

			case "pagina":

				if( file_exists( self::ENDERECO_ARQUIVO . self::ENDERECO_PASTAS . $redir_pagina . '.php' ) )
					return true;
				else
					return false;
			break;
			
			case "template":

				if( file_exists( self::ENDERECO_ARQUIVO . self::ENDERECO_TEMPLATE . $redir_pagina . '/template.php' ) )
					return true;
				else
					return false;				
			break;
			
			case "idioma":

				if( file_exists( self::ENDERECO_ARQUIVO . self::ENDERECO_IDIOMAS . $redir_pagina . '.json' ) )
					return true;
				else
					return false;				
			break;

		}
		
	}

	public function gerarIncludeEndereco( $pagina , $tipo = "pagina" ) {

		switch ($tipo) {

			case "pagina":

				if( $this->paginaExiste( $pagina ) )

					return self::ENDERECO_ARQUIVO . self::ENDERECO_PASTAS . $pagina .'.php';

			break;
			
			case "template":

				if( $this->paginaExiste( $pagina , "template" ) )

					return self::ENDERECO_ARQUIVO . self::ENDERECO_TEMPLATE . $pagina  . '/template.php';

			break;

			case "idioma":

				if( $this->paginaExiste( $pagina , "idioma" ) )

					return self::ENDERECO_ARQUIVO . self::ENDERECO_IDIOMAS . $pagina  . '.json';

			break;

		}

	}

	public function criarArquivo ( $nomeArquivo , $conteudo , $concatenar = false ){

		$endereco = self::ENDERECO_ARQUIVO . self::ENDERECO_CONTEUDOS. $nomeArquivo;

		if( !file_exists( dirname( $endereco ) ) ) {

			mkdir( dirname( $endereco ) , 0777, true );

		}

		if ( file_exists( $endereco )  &&  $concatenar )

			file_put_contents( $endereco , $conteudo , FILE_APPEND);

		else

			file_put_contents( $endereco , $conteudo );	

	}

	public function irPara( $endereco ){

		header("Location: ".self::ENDERECO_SISTEMA."{$endereco}");
		exit();

	}

	public function adicionarConteudo( $conteudo , $tipo ) {

		switch ($tipo) {

			case 'main':

				self::$mainContainer = $conteudo ; 

			break;

			case 'js':

				self::$javaScriptContainer[] = $conteudo ; 

			break;

			case 'jq':

				self::$jQueryContainer[] = $conteudo ; 

			break;

			case 'css':

				self::$CSSContainer[] = $conteudo ; 

			break;
			
		}

	}

	public function carregarConteudo( $conteudo , $tipo ){

		$endereco = self::ENDERECO_SISTEMA."assert/{$tipo}/{$conteudo}";
			
		switch ($tipo) {

			case 'css':
				return print "<link type='text/css' rel='stylesheet' href='{$endereco}' media='screen,projection'/>";
			break;

			case 'js':
				return print "<script type='text/javascript' src='{$endereco}'></script>"; 			
			break;
			
		}

	}

	public function obterConteudo( $tipo ){

		switch ($tipo) {

			case 'main':

				return self::$mainContainer; 

			break;

			case 'js':

				return self::$javaScriptContainer; 

			break;

			case 'jq':

				return self::$jQueryContainer; 

			break;

			case 'css':

				return self::$CSSContainer; 

			break;

		}

	}

	public function gerarUrl( $conteudo ){

		return print self::ENDERECO_SISTEMA.$conteudo;

	}

	public function dataHora( $tipoRetorno , $dataHoraComparacao = null ) {

		$tz_object = new DateTimeZone('Brazil/East');

		$datetime = new DateTime($dataHoraComparacao);

		if(is_null($dataHoraComparacao))
			$datetime->setTimezone($tz_object);

		switch ($tipoRetorno) {

			case 'date':

				return $datetime->format('d\/m\/Y\ ');

			break;

			case 'time':

				return $datetime->format('H:i:s');

			break;

			case 'dateTime':

				return $datetime->format('d/m/Y H:i:s');

			break;

			case 'dateMysql':

				return $datetime->format('Y\-m\-d\ ');

			break;

			case 'dateTimeMysql':

				return $datetime->format('Y\-m\-d\ H:i:s');

			break;

			case 'hour':

				return $datetime->format('H');

			break;

			case 'day':

				return $datetime->format('d');

			break;

			case 'year':

				return $datetime->format('Y');

			break;

			case 'months':

				return $datetime->format('m');

			break;

			case 'dayWeek'

				:return $datetime->format('w');

			break;

			case 'object':

				return $datetime;

			break;

		}

	}

	public function validarData($data, $formato = 'Y-m-d H:i:s') {

		$d = DateTime::createFromFormat($formato, $data);
		return $d && $d->format($formato) == $data;
	
	}

	public function converterDataHora( $data ){

		$timestamp_atual = strtotime( $this->dataHora( "dateTimeMysql" ) );

		$timestamp = strtotime( $data );

		$hora = (int)$timestamp_atual - (int)$timestamp;

		if($hora < 60) 

			$resultado = "Agora";

		else if($hora < 3600) 

			$resultado = (($hora/60) < 2) ? "Há ".(int)($hora/60)." min" :"Há ".(int)($hora/60)." mins";

		 elseif($hora < 86400)	

			$resultado = (($hora/60/60) < 2) ? "Há ".(int)($hora/60/60)." hora" :"Há ".(int)($hora/60/60)." horas";

		 elseif($hora < 604800) 

			$resultado = (($hora/60/60/24) < 2) ? "Há ".(int)($hora/60/60/24)." dia" :"Há ".(int)($hora/60/60/24)." dias";

		 else 

			$resultado = date('d/m/Y', $timestamp); 		

		return $resultado; 
	
	}

}