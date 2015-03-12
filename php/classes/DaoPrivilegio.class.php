<?php 
	
	/**
	* 
	*/
	class DaoPrivilegio {

		private $privilegioId;
		private $privilegioNome;


		public function SetPrivilegioId( $privilegioId , $validar = false , $existe = false ) {

			if(is_numeric($privilegioId)) {

				if( $validar ){

					$privilegio = new DaoPrivilegio();
					$privilegio->SetPrivilegioId( $privilegioId );

					$verificarPrivilegioId = PojoPrivilegio::getInstance()->verificarPrivilegioId( $privilegio );

					if( $verificarPrivilegioId && $existe ){

						$this->privilegioId = $privilegioId;
						return true;

					} elseif ( !$verificarPrivilegioId && !$existe ) {

						$this->privilegioId = $privilegioId;
						return true;

					} else {

						return false;

					}

				} else {

					$this->privilegioId = $privilegioId;
					return true;

				}

			}  else {

				return false;

			}

		}

		public function SetPrivilegioNome( $privilegioNome ) {

			if(is_string($privilegioNome) && !empty($privilegioNome)) {

				$this->privilegioNome = $privilegioNome;
				return true;

			} else {

				return false;

			}

		}

		public function GetPrivilegioId(){

			return $this->privilegioId;

		}

		public function GetPrivilegioNome(){

			return $this->privilegioNome;

		}
	}
	?>