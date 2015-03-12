<?php 

	/**
	* 
	*/
	class PojoSetor {
		
		//Variavel para conexão
    	public static $instance;
		
		const TB_SETOR = "setores" ;

		const TB_COL_SETOR_ID = "setorId" ;  
		const TB_COL_SETOR_NOME = "setorNome";

		/**
	    * Metodo estático para chamar o objeto. 
	    */
		public static function getInstance() { 

			if (!isset(self::$instance)) 
				self::$instance = new PojoSetor(); 
			return self::$instance; 

		}

	    /**
	    * Verificar se o id existe.
	    */
	    public function verificarSetorId( DaoSetor $setor ){

	      $consulta =  new SelectPDO( self::TB_SETOR );
	      $consulta->adicionarCondicoes( self::TB_COL_SETOR_ID  ,"=",  $setor->GetSetorId()  );
	      $consulta->adicionarColunas( self::TB_COL_SETOR_NOME  );

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

		public function mostrarSetores(){

			$consulta =  new SelectPDO( self::TB_SETOR );

			$consulta->adicionarColunas( self::TB_COL_SETOR_ID );
			$consulta->adicionarColunas( self::TB_COL_SETOR_NOME ); 

			$resultado = $consulta->processarPDO();

			if(is_object($resultado)){

				return $resultado->fetchAll( PDO::FETCH_ASSOC ) ;

			} else {

				return false;

			}

		}

	}
?>