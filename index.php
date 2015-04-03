<?php
@session_start();
ini_set('session.cookie_httponly', 1);

//Carregar classes automaticamente
function __autoload($classe){

    if(file_exists("php/classes/{$classe}.class.php"))

        require_once "php/classes/{$classe}.class.php";

    elseif (file_exists("php/classes/".strtolower($classe).".class.php"))

        require_once "php/classes/".strtolower($classe).".class.php";    

}

$rotasUrl = ( isset($_GET['isw']) ) ? $_GET['isw'] : null; 

Principal::getInstance()->SetUrl( $rotasUrl );

Principal::getInstance()->Setlang( );

Principal::getInstance()->SetString( );

unset($rotasUrl);

//Instanciar o objeto usuário
$usuario = new DaoUsuario();

DEFINE('KEY_MASTER', md5( Principal::NOME_PROJETO . date('d-m-Y') ) );

if( Principal::getInstance()->paginaExiste( Principal::getInstance()->GetUrl( 'pagina' ) ) ){

    if( Login::getInstance()->atribuirUsuarioId( $usuario ) ){

        PojoUsuario::getInstance()->atribuirDados( $usuario );

        if( $usuario->GetUsuarioStatusAcesso() == 0 ) {

            Principal::SetNotificacao( Principal::Getlang( 'user_disable', true ) );
            Login::getInstance()->logout( "login/" );  

        }

        if( isset( $_SESSION[ Login::SESSAO_USUARIO_1_ACESSO ] ) ){

            if( $_SESSION[ Login::SESSAO_USUARIO_1_ACESSO ] == true && Principal::getInstance()->GetUrl( 'pagina' ) != Principal::PAGINA_DOCUMENTACAO )

                Principal::irPara( Principal::PAGINA_DOCUMENTACAO );
        }

    } 

    include Principal::getInstance()->gerarIncludeEndereco( Principal::getInstance()->GetUrl( 'pagina' ) );    

    if( defined( 'PAGINA_LOGIN' ) && PAGINA_LOGIN ) {

        if( !Login::getInstance()->verificarSessao() )
            Login::getInstance()->logout( "login/" );  

    }

    if( defined( 'PAGINA_SETOR' ) ) {

        $__permissaoSetores = unserialize(base64_decode(PAGINA_SETOR));
        $__permissaoSetores = (is_array($__permissaoSetores))? $__permissaoSetores : array(0) ;
        $__usuarioSetor = is_null( $usuario->GetUsuarioSetor() ) ? 0 : $usuario->GetUsuarioSetor()->GetSetorId();
        $__setorAprovado = (in_array( $__usuarioSetor , $__permissaoSetores) or in_array(0, $__permissaoSetores)) ? true : false ;
        unset($__usuarioSetor);
        unset($__permissaoSetores);

    } else {

        $__setorAprovado = true;

    }

    if ( defined( 'PAGINA_PRIVILEGIO' ) ) {

        $__permissaoPrivilegio = unserialize(base64_decode(PAGINA_PRIVILEGIO));
        $__permissaoPrivilegio = (is_array($__permissaoPrivilegio)) ? $__permissaoPrivilegio : array(0) ;
        $__usuarioPrivilegio = is_null( $usuario->GetUsuarioPrivilegio() ) ? 0 : $usuario->GetUsuarioPrivilegio()->GetPrivilegioId();
        $__privilegioAprovado = (in_array( $__usuarioPrivilegio , $__permissaoPrivilegio) or in_array(0, $__permissaoPrivilegio)) ? true : false ;
        unset($__usuarioSetor);
        unset($__usuarioPrivilegio);

    } else {

        $__privilegioAprovado = true;

    }


    if( $__setorAprovado || $__privilegioAprovado ){

        unset($__setorAprovado);
        unset($__privilegioAprovado);
        include Principal::getInstance()->gerarIncludeEndereco( PAGINA_TEMPLATE , "template" );

    } else {

        Principal::irPara( Principal::PAGINA_ERROR . 403 );
    }

} else {

   Principal::irPara( Principal::PAGINA_ERROR );

}

?>