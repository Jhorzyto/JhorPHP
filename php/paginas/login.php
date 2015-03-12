<?php if( defined('KEY_MASTER') &&  @KEY_MASTER == md5( Principal::NOME_PROJETO.date( 'd-m-Y' ) ) ) {

	//Constantes necessárias para carregamento no template
	
	//Título da página atual
	DEFINE("PAGINA_TITULO", "Login" );
	//Descrição da página atual
	DEFINE("PAGINA_DESC", "Acesse seu usuário" ); 
	//Setores limitados para acessar a página. Se 0 a página é de uso geral.
	DEFINE("PAGINA_SETOR", base64_encode( serialize( array( 0 ) ) ) ); 
	//Privigelio de usuários para acessar a página. Se 0 a página é de uso geral.
	DEFINE("PAGINA_PRIVILEGIO", base64_encode( serialize( array( 0 ) ) ) );

	//Página precisa efetuar login de usuário. True para sim ou false para não
	DEFINE("PAGINA_LOGIN", FALSE ); 
	//Template da página para carregamento
	DEFINE("PAGINA_TEMPLATE", "login" ); 

	ob_start();

	switch ( Principal::getInstance()->GetUrl( 'pagina_id' ) ) {

		case 'form_autenticar_usuario':

			if( !Login::getInstance()->verificarSessao() ) {
					
				if( $_SERVER['REQUEST_METHOD'] == 'POST' ) {

					if( !$usuario->SetUsuarioNomeUsuario( $_POST[ PojoUsuario::TB_COL_USUARIO_NOME_USUA ] ) ) {

						Principal::getInstance()->SetNotificacao( Principal::getInstance()->Getlang('user_invalid', true) );
						Principal::getInstance()->irPara( 'login/' );

					} elseif( !$usuario->SetUsuarioSenha( $_POST[ PojoUsuario::TB_COL_USUARIO_SENHA ] ) ) {

						Principal::getInstance()->SetNotificacao( Principal::getInstance()->Getlang('password_invalid', true) );
						Principal::getInstance()->irPara( 'login/' );

					} else {

						$autenticacao_respon = Login::getInstance()->logarUsuario( $usuario );

						if( is_bool( $autenticacao_respon ) ){

							unset($autenticacao_respon);
							Principal::getInstance()->irPara( 'principal/' );

						} else {

							Principal::getInstance()->SetNotificacao( $autenticacao_respon );
							Principal::getInstance()->irPara( 'login/' );
						}

					}

				} else {

					Principal::getInstance()->irPara( 'login/' );
				}

			} else {

				Principal::getInstance()->irPara( "principal/" ); 
				
			}

		break;

		case 'sair':
			Login::getInstance()->logout("login/"); 
		break;

		default:

			if( !Login::getInstance()->verificarSessao() ) 
				include Principal::getInstance()->gerarIncludeEndereco( Principal::getInstance()->GetUrl( 'pagina' )."/index" );
			else 
				Principal::getInstance()->irPara( "principal/" ); 

		break;

	}

	Principal::getInstance()->adicionarConteudo( ob_get_contents() , 'main' ); 
	ob_end_clean(); 

} ?>