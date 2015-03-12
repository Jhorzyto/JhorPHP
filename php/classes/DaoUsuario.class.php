  <?php
  /**
  * Classe para controle de usuários.
  * Dev: Jhordan Lima
  * Data: 21/10/2014
  */
  class DaoUsuario {
  /**
  * Variaveis usadas pelo Sistema.
  */
  private $usuarioId;
  private $usuarioNomeCompleto;
  private $usuarioNomeUsuario;
  private $usuarioSenha;
  private $usuarioEmail;
  private $usuarioStatusAcesso;

  private $usuarioPrivilegio;
  private $usuarioSetor;

  public function SetUsuarioId( $usuarioId , $validar = false , $existe = false ) {

    if(is_numeric($usuarioId)) {

      if( $validar ){

        $usuario = new DaoUsuario();
        $usuario->SetUsuarioId( $usuarioId );

        $verificarUsuarioId = PojoUsuario::getInstance()->verificarUsuarioId( $usuario );

        if( $verificarUsuarioId && $existe ){

          $this->usuarioId = $usuarioId;
          return true;

        } elseif ( !$verificarUsuarioId && !$existe ) {

          $this->usuarioId = $usuarioId;
          return true;

        } else {

          return false;

        }

      } else {

        $this->usuarioId = $usuarioId;
        return true;

      }

    } else {

      return false;

    }

  }

  public function SetUsuarioNomeCompleto( $usuarioNomeCompleto ) {

    if(is_string($usuarioNomeCompleto) && !empty($usuarioNomeCompleto)) {

      $this->usuarioNomeCompleto = substr( $usuarioNomeCompleto , 0, 50 );
      return true;

    } else {

      return false;

    }

  }

  public function SetUsuarioNomeUsuario( $usuarioNomeUsuario , $validar = false , $existe = false ) {

    if(is_string($usuarioNomeUsuario) && !empty($usuarioNomeUsuario)) {

      if( $validar ){

        $usuario = new DaoUsuario();
        $usuario->SetUsuarioNomeUsuario( $usuarioNomeUsuario );
        $verificarUsuarioNome = PojoUsuario::getInstance()->verificarUsuarioNome( $usuario );

        if( $verificarUsuarioNome && $existe ){

          $this->usuarioNomeUsuario = substr( $usuarioNomeUsuario , 0, 10 );
          return true;

        } elseif( !$verificarUsuarioNome && !$existe ) {

            $this->usuarioNomeUsuario = substr( $usuarioNomeUsuario , 0, 10 );
            return true;

        } else {

          return false;

        }

      } else {

        $this->usuarioNomeUsuario = substr( $usuarioNomeUsuario , 0, 10 );
        return true;

      }

    } else {

      return false;      

    }

  }

  public function SetUsuarioSenha( $usuarioSenha , $hash = false ) {

    if(is_string($usuarioSenha) && !empty($usuarioSenha)){

      $this->usuarioSenha = ( $hash ) ? password_hash( substr( $usuarioSenha , 0, 15), PASSWORD_DEFAULT ) : substr( $usuarioSenha , 0, 15 );
      return true;

    } else {

      return false;

    }

  }

  public function SetUsuarioEmail( $usuarioEmail , $validar = false , $existe = false ) {

    if( filter_var( substr( $usuarioEmail , 0, 50 ) , FILTER_VALIDATE_EMAIL) ) {

      if( $validar ){

        $usuario = new DaoUsuario();
        $usuario->SetUsuarioEmail( $usuarioEmail );
        $verificarUsuarioEmail = PojoUsuario::getInstance()->verificarUsuarioEmail( $usuario ) ;

        if( $verificarUsuarioEmail && $existe ){

          $this->usuarioEmail = substr( $usuarioEmail , 0, 50 );
          return true;

        } elseif( !$verificarUsuarioEmail && !$existe ) {

          $this->usuarioEmail = substr( $usuarioEmail , 0, 50 );
          return true;

        } else {

          return false;

        }

      } else {

        $this->usuarioEmail = substr( $usuarioEmail , 0, 50 );
        return true;

      }

    } else {

      return false;

    }

  }

  public function SetUsuarioStatusAcesso( $usuarioStatusAcesso ){

    if(is_numeric($usuarioStatusAcesso)) {

      $this->usuarioStatusAcesso = $usuarioStatusAcesso;
      return true;

    } else {

      return false;

    }

  }

  public function SetUsuarioPrivilegio( DaoPrivilegio $usuarioPrivilegio ){

    if(is_object($usuarioPrivilegio)) {

      $this->usuarioPrivilegio = $usuarioPrivilegio;
      return true;

    } else {

      return false;

    }

  }

  public function SetUsuarioSetor( DaoSetor $usuarioSetor ){

    if(is_object($usuarioSetor)) {

      $this->usuarioSetor = $usuarioSetor;
      return true;

    } else {

      return false;

    }

  }

  public function GetUsuarioId(){

    return $this->usuarioId;

  }

  public function GetUsuarioNomeCompleto(){

    return $this->usuarioNomeCompleto;

  }

  public function GetUsuarioNomeUsuario(){

    return $this->usuarioNomeUsuario;

  }

  public function GetUsuarioSenha(){

    return $this->usuarioSenha;

  }

  public function GetUsuarioEmail(){

    return $this->usuarioEmail;

  }

  public function GetUsuarioStatusAcesso(){

    return $this->usuarioStatusAcesso;

  }

  public function GetUsuarioPrivilegio(){

      return $this->usuarioPrivilegio;

  }

  public function GetUsuarioSetor(){

      return $this->usuarioSetor;

  }

}

?>