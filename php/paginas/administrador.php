<?php if( defined('KEY_MASTER') &&  @KEY_MASTER == md5( Principal::NOME_PROJETO.date( 'd-m-Y' ) ) ) {

	//Constantes necessárias para carregamento no template
	
	//Título da página atual
	DEFINE("PAGINA_TITULO", "Administrador" );
	//Descrição da página atual
	DEFINE("PAGINA_DESC", "Painel Administrativo" ); 
	//Setores limitados para acessar a página. Se 0 a página é de uso geral.
	DEFINE("PAGINA_SETOR", base64_encode( serialize( array( 1 ) ) ) ); 
	//Privigelio de usuários para acessar a página. Se 0 a página é de uso geral.
	DEFINE("PAGINA_PRIVILEGIO", base64_encode( serialize( array( 1 ) ) ) );

	//Página precisa efetuar login de usuário. True para sim ou false para não
	DEFINE("PAGINA_LOGIN", TRUE ); 

	if( in_array( Principal::getInstance()->GetUrl( 'pagina_id' ) , 
		array( 'detalhes' , 'novo_usuario' , 'valid_novo_usuario' , 'validar_atualizar_usuario' ,'status' ) ) ) {
		//Template da página para carregamento
		DEFINE("PAGINA_TEMPLATE", "limpo" );		

	} else {
		//Template da página para carregamento
		DEFINE("PAGINA_TEMPLATE", "padrao" ); 
	}

	ob_start();

	switch (  Principal::getInstance()->GetUrl( 'pagina_id' )  ) {

		case 'form_novo_usuario':

			if($_SERVER['REQUEST_METHOD'] == 'POST') {

				$novoUsuario = new DaoUsuario();
				$novoUsuarioSetor = new DaoSetor();
				$novoUsuarioPrivilegio = new DaoPrivilegio();	

				$errors = 0;				
				
				if( !$novoUsuario->SetUsuarioNomeCompleto( $_POST[ PojoUsuario::TB_COL_USUARIO_NOME_COMP ] ) ) {
					Principal::getInstance()->SetNotificacao( Principal::getInstance()->Getlang( 'user_fullname_invalid', true) );
					$errors++;
				}

				if( !$novoUsuario->SetUsuarioEmail( $_POST[ PojoUsuario::TB_COL_USUARIO_EMAIL ] , true ) ) {
					Principal::getInstance()->SetNotificacao( Principal::getInstance()->Getlang( 'user_email_invalid_or_used', true) );
					$errors++;
				}

				if( !$novoUsuario->SetUsuarioNomeUsuario( $_POST[ PojoUsuario::TB_COL_USUARIO_NOME_USUA ], true ) ) {
					Principal::getInstance()->SetNotificacao( Principal::getInstance()->Getlang('user_name_invalid_or_used', true) );
					$errors++;
				}

				if( !$novoUsuario->SetUsuarioSenha( $_POST[ PojoUsuario::TB_COL_USUARIO_SENHA ] , true ) ) {
					Principal::getInstance()->SetNotificacao( Principal::getInstance()->Getlang('user_password_invalid', true) );
					$errors++;
				} 

				if( !$novoUsuarioPrivilegio->SetPrivilegioId( $_POST[ PojoPrivilegio::TB_COL_PRIVILEGIO_ID ] , true , true) ) {
					Principal::getInstance()->SetNotificacao( Principal::getInstance()->Getlang('privilege_invalid', true) );
					$errors++;
				}

				if( !$novoUsuarioSetor->SetSetorId( $_POST[ PojoSetor::TB_COL_SETOR_ID ] , true , true) ) {
					Principal::getInstance()->SetNotificacao( Principal::getInstance()->Getlang('department_invalid', true) );
					$errors++;
				} 

				if( $errors == 0 ) {

					$novoUsuario->SetUsuarioSetor( $novoUsuarioSetor );
					$novoUsuario->SetUsuarioPrivilegio( $novoUsuarioPrivilegio );

					if ( PojoUsuario::getInstance()->adicionarNovoUsuario( $novoUsuario ) ) {

						Principal::getInstance()->SetNotificacao( Principal::getInstance()->Getlang('admin_new_user_success', true) );						
						Principal::getInstance()->irPara( 'administrador/' );

					} else {

						Principal::getInstance()->SetNotificacao( Principal::getInstance()->Getlang('database_error', true) );						
						Principal::getInstance()->irPara( 'administrador/' );

					}

				} else {

					Principal::getInstance()->irPara( 'administrador/' );
				}

			} else {

				Principal::getInstance()->irPara( 'administrador/' );
			}

		break;

		case 'valid_novo_usuario':

			if( $_SERVER['REQUEST_METHOD'] == 'POST') {

				$novoUsuario = new DaoUsuario();
				$novoUsuarioSetor = new DaoSetor();
				$novoUsuarioPrivilegio = new DaoPrivilegio();		
				
				if( $novoUsuario->SetUsuarioEmail( $_POST[ PojoUsuario::TB_COL_USUARIO_EMAIL ] , true , true ) ) {

					$emailArray = array(
										"tipo"=>$_POST[ PojoUsuario::TB_COL_USUARIO_EMAIL ], 
										"situacao"=>false, 
										"mensagem"=> Principal::getInstance()->Getlang( 'user_email_invalid_or_used', true) 
										);


				} else {

					$emailArray = array(
										"tipo"=>$_POST[ PojoUsuario::TB_COL_USUARIO_EMAIL ], 
										"situacao"=>true, 
										"mensagem"=> false 
										);

				}

				if( $novoUsuario->SetUsuarioNomeUsuario( $_POST[ PojoUsuario::TB_COL_USUARIO_NOME_USUA ] , true , true ) ) {

					$userArray = array(
										"tipo"=>$_POST[ PojoUsuario::TB_COL_USUARIO_NOME_USUA ], 
										"situacao"=>false, 
										"mensagem"=> Principal::getInstance()->Getlang( 'user_name_invalid_or_used', true) 
										);


				} else {

					$userArray = array(
										"tipo"=>$_POST[ PojoUsuario::TB_COL_USUARIO_NOME_USUA ], 
										"situacao"=>true, 
										"mensagem"=> false 
										);

				}

				if( !$novoUsuario->SetUsuarioSenha( $_POST[ PojoUsuario::TB_COL_USUARIO_SENHA ] ) ) {

					$passArray = array(
										"tipo"=>$_POST[ PojoUsuario::TB_COL_USUARIO_SENHA ], 
										"situacao"=>false, 
										"mensagem"=> Principal::getInstance()->Getlang( 'user_password_invalid', true) 
										);


				} else {

					$passArray = array(
										"tipo"=>$_POST[ PojoUsuario::TB_COL_USUARIO_SENHA ], 
										"situacao"=>true, 
										"mensagem"=> false 
										);

				}

				if( !$novoUsuarioPrivilegio->SetPrivilegioId( $_POST[ PojoPrivilegio::TB_COL_PRIVILEGIO_ID ] , true , true ) ) {

					$privgArray = array(
										"tipo"=>$_POST[ PojoPrivilegio::TB_COL_PRIVILEGIO_ID ], 
										"situacao"=>false, 
										"mensagem"=> Principal::getInstance()->Getlang( 'privilege_invalid', true) 
										);


				} else {

					$privgArray = array(
										"tipo"=>$_POST[ PojoPrivilegio::TB_COL_PRIVILEGIO_ID ], 
										"situacao"=>true, 
										"mensagem"=> false 
										);

				}

				if( !$novoUsuarioSetor->SetSetorId( $_POST[ PojoSetor::TB_COL_SETOR_ID ] , true , true ) ) {

					$setorArray = array(
										"tipo"=>$_POST[ PojoSetor::TB_COL_SETOR_ID ], 
										"situacao"=>false, 
										"mensagem"=> Principal::getInstance()->Getlang( 'department_invalid', true) 
										);


				} else {

					$setorArray = array(
										"tipo"=>$_POST[ PojoSetor::TB_COL_SETOR_ID ], 
										"situacao"=>true, 
										"mensagem"=> false 
										);

				}


				header('content-type: application/json; charset=utf-8');
				header("access-control-allow-origin: *");

				$json = array( $emailArray , $userArray , $passArray , $privgArray , $setorArray );
				echo json_encode( $json );

				exit();

			} 

		break;

		case 'novo_usuario':

			Principal::getInstance()->adicionarConteudo( "$('select').material_select();", 'jq' );
			$listaSetores = PojoSetor::getInstance()->mostrarSetores();
			$listaPrivilegios = PojoPrivilegio::getInstance()->mostrarPrivilegios();
			include Principal::getInstance()->gerarIncludeEndereco( Principal::getInstance()->GetUrl( 'pagina' ) ."/novo_usuario" );

		break;

		case 'form_atualizar_usuario':

			if($_SERVER['REQUEST_METHOD'] == 'POST') {

				$atualizarUsuario = new DaoUsuario();
				$atualizarUsuarioSetor = new DaoSetor();
				$atualizarUsuarioPrivilegio = new DaoPrivilegio();	

				$errors = 0;	

				if( !$atualizarUsuario->SetUsuarioId( $_POST[ PojoUsuario::TB_COL_USUARIO_ID ] , true, true ) ) {

					Principal::getInstance()->SetNotificacao( Principal::getInstance()->Getlang( 'user_id_invalid', true) );
					$errors++;

				} else {

					PojoUsuario::getInstance()->atribuirDados( $atualizarUsuario );

					if( !$atualizarUsuario->SetUsuarioNomeCompleto( $_POST[ PojoUsuario::TB_COL_USUARIO_NOME_COMP ] ) ) {

						Principal::getInstance()->SetNotificacao( Principal::getInstance()->Getlang( 'user_fullname_invalid', true) );
						$errors++;

					}

					if ( $_POST[ PojoUsuario::TB_COL_USUARIO_EMAIL ] != $atualizarUsuario->GetUsuarioEmail() ) {

						if( !$atualizarUsuario->SetUsuarioEmail( $_POST[ PojoUsuario::TB_COL_USUARIO_EMAIL ] , true ) ) {
							Principal::getInstance()->SetNotificacao( Principal::getInstance()->Getlang( 'user_email_invalid_or_used', true) );
							$errors++;
						}

					}

					if ( $_POST[ PojoUsuario::TB_COL_USUARIO_NOME_USUA ] != $atualizarUsuario->GetUsuarioNomeUsuario() ) {

						if( !$atualizarUsuario->SetUsuarioNomeUsuario( $_POST[ PojoUsuario::TB_COL_USUARIO_NOME_USUA ], true ) ) {
							Principal::getInstance()->SetNotificacao( Principal::getInstance()->Getlang('user_name_invalid_or_used', true) );
							$errors++;
						}

					}

					if ( !empty($_POST[ PojoUsuario::TB_COL_USUARIO_SENHA ]) ) {

						if( !$atualizarUsuario->SetUsuarioSenha( $_POST[ PojoUsuario::TB_COL_USUARIO_SENHA ] , true ) ) {
							Principal::getInstance()->SetNotificacao( Principal::getInstance()->Getlang('user_password_invalid', true) );
							$errors++;
						} 

					}

					if( !$atualizarUsuarioPrivilegio->SetPrivilegioId( $_POST[ PojoPrivilegio::TB_COL_PRIVILEGIO_ID ] , true , true) ) {
						Principal::getInstance()->SetNotificacao( Principal::getInstance()->Getlang('privilege_invalid', true) );
						$errors++;
					}

					if( !$atualizarUsuarioSetor->SetSetorId( $_POST[ PojoSetor::TB_COL_SETOR_ID ] , true , true) ) {
						Principal::getInstance()->SetNotificacao( Principal::getInstance()->Getlang('department_invalid', true) );
						$errors++;
					} 

					if( $errors == 0 ) {

						$atualizarUsuario->SetUsuarioSetor( $atualizarUsuarioSetor );
						$atualizarUsuario->SetUsuarioPrivilegio( $atualizarUsuarioPrivilegio );

						if ( PojoUsuario::getInstance()->atualizarUsuarioDados( $atualizarUsuario ) ) {

							Principal::getInstance()->SetNotificacao( Principal::getInstance()->Getlang('admin_update_user_success', true) );						
							Principal::getInstance()->irPara( 'administrador/' );

						} else {

							Principal::getInstance()->SetNotificacao( Principal::getInstance()->Getlang('database_error', true) );						
							Principal::getInstance()->irPara( 'administrador/' );

						}

					} else {

						Principal::getInstance()->irPara( 'administrador/' );
					}

				}

			} else {

				Principal::getInstance()->irPara( 'administrador/' );
			}

		break;

		case 'validar_atualizar_usuario':

			if($_SERVER['REQUEST_METHOD'] == 'POST') {

				$atualizarUsuario = new DaoUsuario();
				$atualizarUsuarioSetor = new DaoSetor();
				$atualizarUsuarioPrivilegio = new DaoPrivilegio();	

				if( !$atualizarUsuario->SetUsuarioId( $_POST[ PojoUsuario::TB_COL_USUARIO_ID ] , true, true ) ) {

					$userId = array(
										"tipo"=>$_POST[ PojoUsuario::TB_COL_USUARIO_ID ], 
										"situacao"=>false, 
										"mensagem"=> Principal::getInstance()->Getlang( 'user_id_invalid', true) 
										);

					$json = array( $userId );
					echo json_encode( $json );

					exit();

				} else {

					PojoUsuario::getInstance()->atribuirDados( $atualizarUsuario );

					if ( $_POST[ PojoUsuario::TB_COL_USUARIO_EMAIL ] != $atualizarUsuario->GetUsuarioEmail() ) {

						if( !$atualizarUsuario->SetUsuarioEmail( $_POST[ PojoUsuario::TB_COL_USUARIO_EMAIL ] , true ) ) {
							
							$SetUsuarioEmail = array(
										"tipo"=>$_POST[ PojoUsuario::TB_COL_USUARIO_EMAIL ], 
										"situacao"=>false, 
										"mensagem"=> Principal::getInstance()->Getlang( 'user_email_invalid_or_used', true) 
										);

						} else {

							$SetUsuarioEmail = array(
											"tipo"=>$_POST[ PojoUsuario::TB_COL_USUARIO_EMAIL ], 
											"situacao"=> true, 
											"mensagem"=> true 
											);

						}

					} else {

						$SetUsuarioEmail = array(
										"tipo"=>$_POST[ PojoUsuario::TB_COL_USUARIO_EMAIL ], 
										"situacao"=> true, 
										"mensagem"=> true 
										);

					}

					if ( $_POST[ PojoUsuario::TB_COL_USUARIO_NOME_USUA ] != $atualizarUsuario->GetUsuarioNomeUsuario() ) {

						if( !$atualizarUsuario->SetUsuarioNomeUsuario( $_POST[ PojoUsuario::TB_COL_USUARIO_NOME_USUA ], true ) ) {
							
							$SetUsuarioNomeUsuario = array(
										"tipo"=>$_POST[ PojoUsuario::TB_COL_USUARIO_NOME_USUA ], 
										"situacao"=>false, 
										"mensagem"=> Principal::getInstance()->Getlang( 'user_name_invalid_or_used', true) 
										);

						} else {

							$SetUsuarioNomeUsuario = array(
											"tipo"=>$_POST[ PojoUsuario::TB_COL_USUARIO_NOME_USUA ], 
											"situacao"=> true, 
											"mensagem"=> true 
											);

						}

					} else {

						$SetUsuarioNomeUsuario = array(
										"tipo"=>$_POST[ PojoUsuario::TB_COL_USUARIO_NOME_USUA ], 
										"situacao"=> true, 
										"mensagem"=> true 
										);

					}

					if( !$atualizarUsuarioPrivilegio->SetPrivilegioId( $_POST[ PojoPrivilegio::TB_COL_PRIVILEGIO_ID ] , true , true ) ) {

						$SetPrivilegioId = array(
											"tipo"=>$_POST[ PojoPrivilegio::TB_COL_PRIVILEGIO_ID ], 
											"situacao"=>false, 
											"mensagem"=> Principal::getInstance()->Getlang( 'privilege_invalid', true) 
											);


					} else {

						$SetPrivilegioId = array(
											"tipo"=>$_POST[ PojoPrivilegio::TB_COL_PRIVILEGIO_ID ], 
											"situacao"=>true, 
											"mensagem"=> false 
											);

					}

					if( !$atualizarUsuarioSetor->SetSetorId( $_POST[ PojoSetor::TB_COL_SETOR_ID ] , true , true ) ) {

						$SetSetorId = array(
											"tipo"=>$_POST[ PojoSetor::TB_COL_SETOR_ID ], 
											"situacao"=>false, 
											"mensagem"=> Principal::getInstance()->Getlang( 'department_invalid', true) 
											);


					} else {

						$SetSetorId = array(
											"tipo"=>$_POST[ PojoSetor::TB_COL_SETOR_ID ], 
											"situacao"=>true, 
											"mensagem"=> false 
											);

					}

					header('content-type: application/json; charset=utf-8');
					header("access-control-allow-origin: *");

					$json = array( $SetUsuarioEmail , $SetUsuarioNomeUsuario , $SetPrivilegioId , $SetSetorId);
					echo json_encode( $json );

					exit();

				}

			}

		break;

		case 'detalhes':

			Principal::getInstance()->adicionarConteudo( "$('select').material_select();", 'jq' );

			$editarUsuario = new DaoUsuario();

			$editarUsuario->SetUsuarioId(!is_null(Principal::getInstance()->GetUrl('pagina_busca')) ? (int) Principal::getInstance()->GetUrl('pagina_busca') : null) ;

			if( PojoUsuario::getInstance()->verificarUsuarioId( $editarUsuario ) ){

				PojoUsuario::getInstance()->atribuirDados( $editarUsuario );

				$listaSetores = PojoSetor::getInstance()->mostrarSetores();
				$listaPrivilegios = PojoPrivilegio::getInstance()->mostrarPrivilegios();

				include Principal::getInstance()->gerarIncludeEndereco( Principal::getInstance()->GetUrl( 'pagina' ) ."/detalhes" );

			} else {

				include Principal::getInstance()->gerarIncludeEndereco( Principal::PAGINA_ERROR ."/e_user_invalid" );

			}

			unset( $editarUsuario );

		break;

		case 'status':
			
				$atualizarUsuario = new DaoUsuario();

				if( !$atualizarUsuario->SetUsuarioId( Principal::getInstance()->GetUrl('pagina_busca') , true, true ) ) {

					$status = array(
									"situacao"=> false , 
									"mensagem"=> Principal::getInstance()->Getlang( 'user_id_invalid', true) 
									);

				} elseif( $atualizarUsuario->GetUsuarioId() == $usuario->GetUsuarioId() ) {

					$status = array(
									"situacao"=> false , 
									"mensagem"=> Principal::getInstance()->Getlang( 'admin_update_status_your_user_info', true) 
									);

				} else {

					PojoUsuario::getInstance()->atribuirDados( $atualizarUsuario );
					$atualizarUsuario->SetUsuarioStatusAcesso( abs( $atualizarUsuario->GetUsuarioStatusAcesso() - 1 ) );

					if( PojoUsuario::getInstance()->atualizarUsuarioStatus( $atualizarUsuario ) ) {

						$status = array(
									"situacao"=> true , 
									"mensagem"=> Principal::getInstance()->Getlang( 'admin_update_status_success', true) 
									);

					} else {

						$status = array(
									"situacao"=> false , 
									"mensagem"=> Principal::getInstance()->Getlang( 'database_error', true) 
									);

					}

				}

				echo json_encode( $status );
				exit();

		break;

		default:

			Principal::getInstance()->adicionarConteudo( "$('#tabela_usuarios_sistema').DataTable({ responsive: true });", 'jq' );
			Principal::getInstance()->adicionarConteudo( "$('select').material_select();", 'jq' );
			Principal::getInstance()->adicionarConteudo( "jquery.dataTables.js", 'js' );
			Principal::getInstance()->adicionarConteudo( "dataTables.responsive.js", 'js' );
			Principal::getInstance()->adicionarConteudo( "dataTables.css", 'css' );
			Principal::getInstance()->adicionarConteudo( "dataTables.responsive.css", 'css' );			
			Principal::getInstance()->adicionarConteudo( "administrador.js", 'js' );

			$listaUsuarioCadastrados = PojoUsuario::getInstance()->mostrarUsuarios();

			include Principal::getInstance()->gerarIncludeEndereco(  Principal::getInstance()->GetUrl( 'pagina' ) ."/index" );
			
		break;

	}

	Principal::getInstance()->adicionarConteudo( ob_get_contents() , 'main' ); 
	ob_end_clean(); 

} ?>