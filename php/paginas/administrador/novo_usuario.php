<?php if( defined('KEY_MASTER') &&  @KEY_MASTER == md5( Principal::NOME_PROJETO.date( 'd-m-Y' ) ) ) : ?>

    <form id="formAjax" action="<?php Principal::getInstance()->gerarUrl( "administrador/form_novo_usuario/" ); ?>" autocomplete="off" method="POST">

        <div class="modal-content">

            <h4><?php Principal::getInstance()->Getlang('admin_new_user_header');?></h4>
            <p><?php Principal::getInstance()->Getlang('admin_new_user_info');?></p>

            <div class="progress" style="display: none;" id="loadAjax">
              <div class="indeterminate"></div>
            </div>

            <div class="row">

                <div class="row"> 

                    <div class="input-field col s12 m6">
                        <i class="mdi-action-account-circle prefix"></i>
                        <input id="icon_prefix" type="text" name="<?php echo PojoUsuario::TB_COL_USUARIO_NOME_COMP; ?>" class=""/ required>
                        <label for="icon_prefix">
                            <?php Principal::getInstance()->Getlang('user_full_name');?>
                        </label>
                    </div>

                    <div class="input-field col s12 m6">
                        <i class="mdi-content-mail prefix"></i>
                        <input id="icon_telephone" type="email" name="<?php echo PojoUsuario::TB_COL_USUARIO_EMAIL; ?>" class="" required>
                        <label for="icon_telephone">
                            <?php Principal::getInstance()->Getlang('user_email');?>
                        </label>
                    </div>

                    <div class="input-field col s12 m6">
                        <i class="mdi-action-perm-identity prefix"></i>
                        <input id="icon_prefix" type="text" name="<?php echo PojoUsuario::TB_COL_USUARIO_NOME_USUA; ?>" class="" required>
                        <label for="icon_prefix">
                            <?php Principal::getInstance()->Getlang('user_name');?>
                        </label>
                    </div>

                    <div class="input-field col s12 m6">
                        <i class="mdi-action-lock prefix"></i>
                        <input id="icon_telephone" type="password" name="<?php echo PojoUsuario::TB_COL_USUARIO_SENHA; ?>" class="" required>
                        <label for="icon_telephone">
                            <?php Principal::getInstance()->Getlang('user_password');?>
                        </label>
                    </div>

                    <div class="input-field col s12 m6">
                        <select name="<?php echo PojoPrivilegio::TB_COL_PRIVILEGIO_ID; ?>" required>
                             <?php if ($listaPrivilegios): ?>

                                <?php foreach ($listaPrivilegios as $value): ?>

                                    <option value="<?php echo $value[PojoPrivilegio::TB_COL_PRIVILEGIO_ID]; ?>"><?php echo $value[PojoPrivilegio::TB_COL_PRIVILEGIO_NOME]; ?></option>

                                <?php endforeach ?>
                                
                            <?php endif ?>
                        </select>
                    </div>

                    <div class="input-field col s12 m6">
                        <select name="<?php echo PojoSetor::TB_COL_SETOR_ID; ?>" required>
                            <?php if ($listaSetores): ?>

                                <?php foreach ($listaSetores as $value): ?>

                                    <option value="<?php echo $value[PojoSetor::TB_COL_SETOR_ID] ?>"><?php echo $value[PojoSetor::TB_COL_SETOR_NOME] ?></option>
                                    
                                <?php endforeach ?>
                                
                            <?php endif ?>
                        </select>
                    </div>

                </div>
            </div>

        </div>

        <div class="modal-footer">

           <button type="reset" onclick="fecharModal();" class="left waves-effect waves-yellow btn-flat modal-action modal-close">
              <?php Principal::getInstance()->Getlang('close');?>
              <i class="mdi-action-flip-to-back left"></i>
          </button>

          <button type="submit" class="waves-effect waves-red btn-flat modal-action" id="submitButton" disabled>
              <?php Principal::getInstance()->Getlang('send');?>
              <i class="mdi-content-send right"></i>
          </button>

          <button type="button" onclick="validarSubmit('<?php Principal::getInstance()->gerarUrl( "administrador/valid_novo_usuario/" ); ?>');" class="waves-effect waves-green btn-flat modal-action" id="validatButton">
              <?php Principal::getInstance()->Getlang('validate');?>
              <i class="mdi-action-settings-backup-restore right"></i>
          </button>

        </div>

  </form>

<?php endif; ?>