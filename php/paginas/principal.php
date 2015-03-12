<?php if( defined('KEY_MASTER') &&  @KEY_MASTER == md5( Principal::NOME_PROJETO.date( 'd-m-Y' ) ) ) {

	//Constantes necessárias para carregamento no template
	
	//Título da página atual
	DEFINE("PAGINA_TITULO", "Início" );
	//Descrição da página atual
	DEFINE("PAGINA_DESC", "Página Incial" ); 
	//Setores limitados para acessar a página. Se 0 a página é de uso geral.
	DEFINE("PAGINA_SETOR", base64_encode( serialize( array( 0 ) ) ) ); 
	//Privigelio de usuários para acessar a página. Se 0 a página é de uso geral.
	DEFINE("PAGINA_PRIVILEGIO", base64_encode( serialize( array( 0 ) ) ) );

	//Página precisa efetuar login de usuário. True para sim ou false para não
	DEFINE("PAGINA_LOGIN", TRUE ); 
	//Template da página para carregamento
	DEFINE("PAGINA_TEMPLATE", "padrao" ); 

	ob_start();

	switch ( Principal::getInstance()->GetUrl( 'pagina_id' ) ) {

		default:
			include Principal::getInstance()->gerarIncludeEndereco( Principal::getInstance()->GetUrl( 'pagina' )."/index" );
		break;

	}

	Principal::adicionarConteudo( ob_get_contents() , 'main' ); 
	ob_end_clean(); 

} ?>