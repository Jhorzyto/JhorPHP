<?php if( defined('KEY_MASTER') &&  @KEY_MASTER == md5( Principal::NOME_PROJETO.date( 'd-m-Y' ) ) ) : ?>

	<div class="section no-pad-bot hiddenTudo">

      <div class="row">

        <div class="col offset-l3 l6 offset-s1 s10 white z-depth-1">

         <div class="row">

          <form action="<?php Principal::getInstance()->gerarUrl( "login/form_autenticar_usuario/" ); ?>" method="POST" class="col s12">

            <div class="row">
              
             <blockquote>

                <?php Principal::getInstance()->Getlang('login_info');?>
                
             </blockquote>

              <div class="input-field col s12">

                <i class="mdi-action-perm-identity prefix"></i>
                <input id="icon_prefix" type="text" name="<?php echo PojoUsuario::TB_COL_USUARIO_NOME_USUA; ?>" class="validate" required>
                <label for="icon_prefix">
                    <?php Principal::getInstance()->Getlang('user_name');?>
                </label>

              </div>

              <div class="input-field col s12">

              	<i class="mdi-action-lock prefix"></i>
              	<input id="icon_prefix" type="password" name="<?php echo PojoUsuario::TB_COL_USUARIO_SENHA; ?>" class="validate" required>
              	<label for="icon_prefix">
                  <?php Principal::getInstance()->Getlang('user_password');?>
                </label>

              </div>

              <div class="input-field col s12">

               <button type="submit" class="btn waves-effect col grey darken-4 s12 waves-red">
                 <i class="mdi-action-input right"></i>
                  <?php Principal::getInstance()->Getlang('submit_login');?>
               </button>

             </div>

           </div>

         </form>
        </div>

        </div>

      </div>

    </div>

<?php endif; ?>