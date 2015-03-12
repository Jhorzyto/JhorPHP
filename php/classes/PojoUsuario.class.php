  <?php
  /**
  * Classe para controle de usuários.
  * Dev: Jhordan Lima
  * Data: 21/10/2014
  */
  class PojoUsuario {

    //Variavel para conexão
    public static $instance;

    //constantes com informações da tabelas
    const TB_USUARIO = "usuarios" ;

    const TB_COL_USUARIO_ID = "usuarioId" ;
    const TB_COL_USUARIO_NOME_COMP = "usuarioNomeCompleto" ;
    const TB_COL_USUARIO_NOME_USUA = "usuarioNomeUsuario" ;
    const TB_COL_USUARIO_SENHA = "usuarioSenha" ;
    const TB_COL_USUARIO_EMAIL = "usuarioEmail" ;
    const TB_COL_USUARIO_STATUS = "usuarioStatusAcesso" ;

    /**
    * Metodo estático para chamar o objeto. 
    */
    public static function getInstance() { 

      if (!isset(self::$instance)) 
        self::$instance = new PojoUsuario(); 
      return self::$instance; 

    }

    /** 
    * Atribuir informações ao objeto. 
    */
    public function atribuirDados( DaoUsuario $usuario ) {

      if( $this->verificarUsuarioId( $usuario ) ){

        $consulta =  new SelectPDO( self::TB_USUARIO );

        $consulta->adicionarCondicoes( self::TB_COL_USUARIO_ID , "=" , $usuario->GetUsuarioId() );

        $consulta->adicionarColunas( self::TB_COL_USUARIO_ID );
        $consulta->adicionarColunas( self::TB_COL_USUARIO_NOME_COMP );
        $consulta->adicionarColunas( self::TB_COL_USUARIO_NOME_USUA );
        $consulta->adicionarColunas( self::TB_COL_USUARIO_SENHA );
        $consulta->adicionarColunas( self::TB_COL_USUARIO_EMAIL );
        $consulta->adicionarColunas( self::TB_COL_USUARIO_STATUS );

        $consulta->adicionarColunas( PojoPrivilegio::TB_COL_PRIVILEGIO_ID );
        $consulta->adicionarColunas( PojoPrivilegio::TB_COL_PRIVILEGIO_NOME );
        $consulta->adicionarTabelas( PojoPrivilegio::TB_PRIVILEGIO );

        $consulta->adicionarColunas( PojoSetor::TB_COL_SETOR_NOME );
        $consulta->adicionarColunas( PojoSetor::TB_COL_SETOR_ID );
        $consulta->adicionarTabelas( PojoSetor::TB_SETOR );

        $consulta->adicionarOrdenacoes( self::TB_COL_USUARIO_NOME_COMP );

        $consulta->adicionarLimites( 0 , 1 ); 

        $resultado = $consulta->processarPDO();

        if(is_object($resultado)){

          $row = $resultado->fetch(PDO::FETCH_ASSOC);

          $usuario->SetUsuarioId( $row[ self::TB_COL_USUARIO_ID ] );
          $usuario->SetUsuarioNomeCompleto( $row[ self::TB_COL_USUARIO_NOME_COMP ] );
          $usuario->SetUsuarioNomeUsuario( $row[ self::TB_COL_USUARIO_NOME_USUA ] );
          $usuario->SetUsuarioSenha( $row[ self::TB_COL_USUARIO_SENHA ] );
          $usuario->SetUsuarioEmail( $row[ self::TB_COL_USUARIO_EMAIL ] );
          $usuario->SetUsuarioStatusAcesso( $row[ self::TB_COL_USUARIO_STATUS ] );

          $usuarioSetor = new DaoSetor();
          $usuarioSetor->SetSetorId( $row[ PojoSetor::TB_COL_SETOR_ID ] );
          $usuarioSetor->SetSetorNome( $row[ PojoSetor::TB_COL_SETOR_NOME ] );

          $usuarioPrivilegio = new DaoPrivilegio();
          $usuarioPrivilegio->SetPrivilegioId( $row[ PojoPrivilegio::TB_COL_PRIVILEGIO_ID ] );
          $usuarioPrivilegio->SetPrivilegioNome( $row[ PojoPrivilegio::TB_COL_PRIVILEGIO_NOME ] );

          $usuario->SetUsuarioSetor( $usuarioSetor );
          $usuario->SetUsuarioPrivilegio( $usuarioPrivilegio );

        } 

      }

    }

    /**
    * Verificar se o id existe.
    */
    public function verificarUsuarioId( DaoUsuario $usuario ){

      $consulta =  new SelectPDO( self::TB_USUARIO );
      $consulta->adicionarCondicoes( self::TB_COL_USUARIO_ID  ,"=",  $usuario->GetUsuarioId()  );
      $consulta->adicionarColunas( self::TB_COL_USUARIO_ID  );

      $resultado = $consulta->processarPDO();

      if(is_object($resultado)){

        if($resultado->rowCount() > 0)

          return true;

        else

          return false;

      } else {

        return false;

      }

    }

    /**
    * Exibir todos os usuários
    */
    public function mostrarUsuarios() {

      $consulta =  new SelectPDO( self::TB_USUARIO );

      $consulta->adicionarColunas( self::TB_COL_USUARIO_ID );
      $consulta->adicionarColunas( self::TB_COL_USUARIO_NOME_COMP );
      $consulta->adicionarColunas( self::TB_COL_USUARIO_NOME_USUA );
      $consulta->adicionarColunas( self::TB_COL_USUARIO_SENHA );
      $consulta->adicionarColunas( self::TB_COL_USUARIO_EMAIL );
      $consulta->adicionarColunas( self::TB_COL_USUARIO_STATUS );

      $consulta->adicionarColunas( PojoPrivilegio::TB_COL_PRIVILEGIO_ID );
      $consulta->adicionarColunas( PojoPrivilegio::TB_COL_PRIVILEGIO_NOME );
      $consulta->adicionarTabelas( PojoPrivilegio::TB_PRIVILEGIO );

      $consulta->adicionarColunas( PojoSetor::TB_COL_SETOR_ID );
      $consulta->adicionarColunas( PojoSetor::TB_COL_SETOR_NOME );
      $consulta->adicionarTabelas( PojoSetor::TB_SETOR );

      $consulta->adicionarOrdenacoes( self::TB_COL_USUARIO_NOME_COMP );

      $resultado = $consulta->processarPDO();

      if(is_object($resultado)){

        return $resultado->fetchAll( PDO::FETCH_ASSOC ) ;

      } else {

        return false;

      }
    }

    /**
    * Atualizar Status do usuário.
    */
    public function atualizarUsuarioStatus( DaoUsuario $usuario ) {

      $atualizar =  new UpdatePDO( self::TB_USUARIO );

      $atualizar->adicionarCondicoes( self::TB_COL_USUARIO_ID , "=" , $usuario->GetUsuarioId() );
      $atualizar->adicionarConteudo( self::TB_COL_USUARIO_STATUS , $usuario->GetUsuarioStatusAcesso() );

      if($atualizar->processarPDO()){

        return true;

      } else {

        return false;

      }

    }

    /**
    * Exibir historio de acesso do usuário
    */
    public function listaHistoricoAcessos( DaoUsuario $usuario , $tamanho = 20 ) {

      $consulta =  new SelectPDO( Login::TB_HISTORICO_ACESSO );

      $consulta->adicionarCondicoes( Login::TB_COL_USUARIO_ID ,"=", $usuario->GetUsuarioId() );

      $consulta->adicionarColunas( Login::TB_COL_HISTORICO_ID );
      $consulta->adicionarColunas( Login::TB_COL_USUARIO_ID );
      $consulta->adicionarColunas( Login::TB_COL_HISTORICO_DATA );
      $consulta->adicionarColunas( Login::TB_COL_HISTORICO_COMPUTADOR );
      $consulta->adicionarColunas( Login::TB_COL_HISTORICO_IP );

      $consulta->adicionarLimites( 0 , $tamanho ); 

      $resultado = $consulta->processarPDO();

      if(is_object($resultado)){

        return $resultado->fetchAll(PDO::FETCH_ASSOC);

      } else {

        return false;

      }
    }

    /**
    * Verificar se o nome de usuário existe.
    */
    public function verificarUsuarioNome( DaoUsuario $usuario ) {

      $consulta =  new SelectPDO( self::TB_USUARIO );
      $consulta->adicionarCondicoes( self::TB_COL_USUARIO_NOME_USUA ,"=", $usuario->GetUsuarioNomeUsuario() );
      $consulta->adicionarColunas( self::TB_COL_USUARIO_NOME_USUA );
      $resultado = $consulta->processarPDO();

      if(is_object($resultado)){

        if($resultado->rowCount() > 0)

          return true;

        else

          return false;

      } else {

        return false;

      }
    }

    /**
    * Verificar se o email do usuario existe.
    */
    public function verificarUsuarioEmail( DaoUsuario $usuario ) {

      $consulta =  new SelectPDO( self::TB_USUARIO );
      $consulta->adicionarCondicoes( self::TB_COL_USUARIO_EMAIL ,"=", $usuario->GetUsuarioEmail() );
      $consulta->adicionarColunas( self::TB_COL_USUARIO_EMAIL );
      $resultado = $consulta->processarPDO();

      if(is_object($resultado)){

        if($resultado->rowCount() > 0)

          return true;

        else

          return false;

      } else {

        return false;

      }
    }

    /**
    * adicionar novo usuário
    */
    public function adicionarNovoUsuario( DaoUsuario $usuario ) {

      $inserir = new InsertPDO( self::TB_USUARIO );

      $inserir->adicionarConteudo( self::TB_COL_USUARIO_NOME_COMP , $usuario->GetUsuarioNomeCompleto() );
      $inserir->adicionarConteudo( self::TB_COL_USUARIO_NOME_USUA , $usuario->GetUsuarioNomeUsuario() );
      $inserir->adicionarConteudo( self::TB_COL_USUARIO_SENHA , $usuario->GetUsuarioSenha() );
      $inserir->adicionarConteudo( self::TB_COL_USUARIO_EMAIL , $usuario->GetUsuarioEmail() );

      $inserir->adicionarConteudo( PojoPrivilegio::TB_COL_PRIVILEGIO_ID , $usuario->GetUsuarioPrivilegio()->GetPrivilegioId() );
      $inserir->adicionarConteudo( PojoSetor::TB_COL_SETOR_ID , $usuario->GetUsuarioSetor()->GetSetorId() );

      if($inserir->processarPDO()){

        return true;

      } else {

        return false;

      }

    }

    /**
    * Atualizar senha do usuário.
    */
    public function atualizarUsuarioSenha( DaoUsuario $usuario ) {

      $atualizar = new UpdatePDO( self::TB_USUARIO );

      $atualizar->adicionarCondicoes( self::TB_COL_USUARIO_ID ,"=", $usuario->GetUsuarioId() );
      $atualizar->adicionarConteudo( self::TB_COL_USUARIO_SENHA , $usuario->GetUsuarioSenha() );

      if($atualizar->processarPDO()){

        return true;

      } else {

        return false;

      }

    }

    /**
    * Atualizar conteudo do usuário.
    */
    public function atualizarUsuarioDados( DaoUsuario $usuario ) {

      $atualizar = new UpdatePDO( self::TB_USUARIO );

      $atualizar->adicionarCondicoes( self::TB_COL_USUARIO_ID ,"=",$usuario->GetUsuarioId() );

      $atualizar->adicionarConteudo( self::TB_COL_USUARIO_NOME_COMP , $usuario->GetUsuarioNomeCompleto() );
      $atualizar->adicionarConteudo( self::TB_COL_USUARIO_NOME_USUA , $usuario->GetUsuarioNomeUsuario() );
      $atualizar->adicionarConteudo( self::TB_COL_USUARIO_EMAIL , $usuario->GetUsuarioEmail() );
      $atualizar->adicionarConteudo( self::TB_COL_USUARIO_SENHA , $usuario->GetUsuarioSenha() );

      $atualizar->adicionarConteudo( PojoPrivilegio::TB_COL_PRIVILEGIO_ID , $usuario->GetUsuarioPrivilegio()->GetPrivilegioId() );
      $atualizar->adicionarConteudo( PojoSetor::TB_COL_SETOR_ID , $usuario->GetUsuarioSetor()->GetSetorId() );

      if($atualizar->processarPDO()){

        return true;

      } else {

        return false;

      }

    }
  
}


?>