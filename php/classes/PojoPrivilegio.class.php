<?php 

	/**
	* 
	*/
	class PojoPrivilegio {

		//Variavel para conexão
    	public static $instance;

		const TB_PRIVILEGIO = "privilegios" ;

		const TB_COL_PRIVILEGIO_ID = "privilegioId" ;
		const TB_COL_PRIVILEGIO_NOME = "privilegioNome";    

		/**
	    * Metodo estático para chamar o objeto. 
	    */
		public static function getInstance() { 

			if (!isset(self::$instance)) 
				self::$instance = new PojoPrivilegio(); 
			return self::$instance; 

		}

			    /**
	    * Verificar se o id existe.
	    */
	    public function verificarPrivilegioId( DaoPrivilegio $privilegio ){

	      $consulta =  new SelectPDO( self::TB_PRIVILEGIO );
	      $consulta->adicionarCondicoes( self::TB_COL_PRIVILEGIO_ID  ,"=",  $privilegio->GetPrivilegioId()  );
	      $consulta->adicionarColunas( self::TB_COL_PRIVILEGIO_NOME  );

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

		public function mostrarPrivilegios(){

			$consulta =  new SelectPDO( self::TB_PRIVILEGIO );

			$consulta->adicionarColunas( self::TB_COL_PRIVILEGIO_ID );
			$consulta->adicionarColunas( self::TB_COL_PRIVILEGIO_NOME ); 

			$resultado = $consulta->processarPDO();

			if(is_object($resultado)){

				return $resultado->fetchAll( PDO::FETCH_ASSOC ) ;

			} else {

				return false;

			}

		}

	}
?>