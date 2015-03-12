<?php
/**
 * Classe para login do usuário.
 * Dev: Jhordan Lima
 * Data: 21/10/2014
 */
class Login {

	public static $instance; 

	const SESSAO_USUARIO = "usuarioId";
	const SESSAO_USUARIO_1_ACESSO = "usuarioIdPrimeiroAcesso";
	const SESSAO_CHAVE = "176b2f9afd68f12484462d815e880ec5341eff2e";

    const TB_HISTORICO_ACESSO = "historicoAcessos" ;
    const TB_COL_HISTORICO_ID = "historioAcessoId";
    const TB_COL_HISTORICO_DATA = "historioAcessoData";
    const TB_COL_HISTORICO_COMPUTADOR = "historioAcessoComputador";
    const TB_COL_HISTORICO_IP = "historioAcessoIp";

  	//ISTANCIADOR DO PDO
	public static function getInstance() { 

		if (!isset(self::$instance)) 
			self::$instance = new Login(); 
		return self::$instance; 

	}

	public function atribuirUsuarioId( DaoUsuario $usuario ) {

   		return $usuario->SetUsuarioId( isset( $_SESSION[ self::SESSAO_USUARIO ]) ? (int) $_SESSION[ self::SESSAO_USUARIO ] : null , true , true ) ;

	}

	// FAZENDO LOGIN DO USUARIO
	public function logarUsuario( DaoUsuario $usuario ) {

		@session_start();

		$consulta =  new SelectPDO( PojoUsuario::TB_USUARIO );

		$consulta->adicionarCondicoes( PojoUsuario::TB_COL_USUARIO_NOME_USUA ,"=", $usuario->GetUsuarioNomeUsuario() );
		$consulta->adicionarColunas( PojoUsuario::TB_COL_USUARIO_ID );
		$consulta->adicionarColunas( PojoUsuario::TB_COL_USUARIO_NOME_USUA );
		$consulta->adicionarColunas( PojoUsuario::TB_COL_USUARIO_SENHA );
		$consulta->adicionarColunas( PojoUsuario::TB_COL_USUARIO_STATUS ); 

		$consulta->adicionarLimites(0,1); 

		$resultado = $consulta->processarPDO();

		if(is_object($resultado)){
			
			if($resultado->rowCount() > 0){

				$row = $resultado->fetch(PDO::FETCH_ASSOC);	

				$usuario->SetUsuarioId( $row[ PojoUsuario::TB_COL_USUARIO_ID ] );

				if(!password_verify( $usuario->GetUsuarioSenha() , $row[ PojoUsuario::TB_COL_USUARIO_SENHA ] ) ){

					return Principal::getInstance()->Getlang('password_wrong', true) ; 

				} elseif ( $row[ PojoUsuario::TB_COL_USUARIO_STATUS ] > 0) {

					$_SESSION[ self::SESSAO_USUARIO ] = $row[ PojoUsuario::TB_COL_USUARIO_ID ];
					$_SESSION[ self::SESSAO_CHAVE ] = md5( Principal::NOME_PROJETO . $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT'] );

					$this->registrarAcesso( $usuario );

					return true; 

				} else {

					return Principal::getInstance()->Getlang('user_disable' , true) ;

				}

			} else {

				return Principal::getInstance()->Getlang('user_wrong' , true) ;

			}

		} else {

			return Principal::getInstance()->Getlang('database_error' , true) ; 

		}

	}

	// VERIFICA SE O USUÁRIO ESTÁ LOGADO
	public function verificarSessao() {

		@session_start();
		// Se estiver logado
		if( isset( $_SESSION[ self::SESSAO_USUARIO ] ) and isset( $_SESSION[ self::SESSAO_CHAVE ] ) ) {

			if( $_SESSION[ self::SESSAO_CHAVE ] == md5( Principal::NOME_PROJETO . $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT'] ) ) {

				return true; 

			} else {

				$this->logout(); 
				return false; 

			}

		} else {

			$this->logout(); 
			return false; 

		}

	}

	// LOGOUT
	public function logout( $redirecionar = null ) {

		@session_start();

		unset( $_SESSION[ self::SESSAO_USUARIO ] );
		unset( $_SESSION[ self::SESSAO_CHAVE ] );
        ///unset( $_SESSION[ self::SESSAO_USUARIO_1_ACESSO ] );
        if( !is_null( $redirecionar ) )
			Principal::getInstance()->irPara( $redirecionar );

	}

	private function registrarAcesso( DaoUsuario $usuario ){

		$inserir = new InsertPDO( self::TB_HISTORICO_ACESSO );

		$inserir->adicionarConteudo( PojoUsuario::TB_COL_USUARIO_ID , $usuario->GetUsuarioId() );
		$inserir->adicionarConteudo( self::TB_COL_HISTORICO_DATA , Principal::getInstance()->dataHora('dateTimeMysql') );
		$inserir->adicionarConteudo( self::TB_COL_HISTORICO_COMPUTADOR , gethostbyaddr($_SERVER['REMOTE_ADDR']) );
		$inserir->adicionarConteudo( self::TB_COL_HISTORICO_IP , ($_SERVER['REMOTE_ADDR'] == "::1") ? "127.0.0.1" : $_SERVER['REMOTE_ADDR'] );

		return $inserir->processarPDO();

		}
	}

?>