<?php if( defined('KEY_MASTER') &&  @KEY_MASTER == md5( Principal::NOME_PROJETO.date( 'd-m-Y' ) ) ) {

	//Constantes necessárias para carregamento no template
	
	//Título da página atual
	DEFINE("PAGINA_TITULO", "ERROR" );
	//Descrição da página atual
	DEFINE("PAGINA_DESC", "Página de erro" ); 
	//Setores limitados para acessar a página. Se 0 a página é de uso geral.
	DEFINE("PAGINA_SETOR", base64_encode( serialize( array( 0 ) ) ) ); 
	//Privigelio de usuários para acessar a página. Se 0 a página é de uso geral.
	DEFINE("PAGINA_PRIVILEGIO", base64_encode( serialize( array( 0 ) ) ) );

	if( in_array( Principal::getInstance()->GetUrl( 'pagina_id' ) , array( 500 ) ) ) {

		//Página precisa efetuar login de usuário. True para sim ou false para não
		DEFINE("PAGINA_LOGIN", FALSE ); 
		//Template da página para carregamento
		DEFINE("PAGINA_TEMPLATE", "login" ); 	

	} else {
		
		//Página precisa efetuar login de usuário. True para sim ou false para não
		DEFINE("PAGINA_LOGIN", TRUE ); 
		//Template da página para carregamento
		DEFINE("PAGINA_TEMPLATE", "padrao" ); 
	}

	ob_start();

	switch ( Principal::getInstance()->GetUrl( 'pagina_id' ) ) {

		case 403:
			include Principal::getInstance()->gerarIncludeEndereco( Principal::getInstance()->GetUrl( 'pagina' ) ."/e_403" );
		break;

		case 500:
			include Principal::getInstance()->gerarIncludeEndereco( Principal::getInstance()->GetUrl( 'pagina' ) ."/e_500" );
		break;

		default:
			include Principal::getInstance()->gerarIncludeEndereco( Principal::getInstance()->GetUrl( 'pagina' ) ."/index" );
		break;

	}

	Principal::getInstance()->adicionarConteudo( ob_get_contents() , 'main' ); 
	ob_end_clean(); 

} ?>