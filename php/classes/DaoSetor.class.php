<?php 

	/**
	* 
	*/
	class DaoSetor {

		private $setorId;
		private $setorNome;		
		private $setorPai;

		public function SetSetorId( $setorId , $validar = false , $existe = false ) {

			if(is_numeric($setorId)) {

				if( $validar ){

					$setor = new DaoSetor();
					$setor->SetSetorId( $setorId );

					$verificarSetorId = PojoSetor::getInstance()->verificarSetorId( $setor );

					if( $verificarSetorId && $existe ){

						$this->setorId = $setorId;
						return true;

					} elseif ( !$verificarSetorId && !$existe ) {

						$this->setorId = $setorId;
						return true;

					} else {

						return false;

					}

				} else {

					$this->setorId = $setorId;
					return true;

				}

			}  else {

				return false;

			}

		}

		public function SetSetorNome( $setorNome ) {

			if(is_string($setorNome) && !empty($setorNome)) {

				$this->setorNome = $setorNome;
				return true;

			} else {

				return false;

			}

		}

		public function GetSetorId(){

			return $this->setorId;

		}

		public function GetSetorNome(){

			return $this->setorNome;

		}
	}
?>