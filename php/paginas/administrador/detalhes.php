<?php if( defined('KEY_MASTER') &&  @KEY_MASTER == md5( Principal::NOME_PROJETO.date( 'd-m-Y' ) ) ) : ?>

 <form id="formAjax" action="<?php Principal::getInstance()->gerarUrl( "administrador/form_atualizar_usuario/" ); ?>" autocomplete="off" method="POST">

        <div class="modal-content">

            <h4><?php Principal::getInstance()->Getlang('admin_update_user_header');?></h4>
            <p><?php Principal::getInstance()->Getlang('admin_update_user_info');?></p>

            <div class="row">

                <div class="row"> 

                    <input type="hidden" name="<?php echo PojoUsuario::TB_COL_USUARIO_ID; ?>" value="<?php echo $editarUsuario->GetUsuarioId(); ?>">

                    <div class="input-field col s12 m6">
                        <i class="mdi-action-account-circle prefix"></i>
                        <input id="icon_prefix" type="text" name="<?php echo PojoUsuario::TB_COL_USUARIO_NOME_COMP; ?>" value="<?php echo $editarUsuario->GetUsuarioNomeCompleto(); ?>" class="validate"/>
                        <label for="icon_prefix">
                            <?php Principal::getInstance()->Getlang('user_full_name');?>
                        </label>
                    </div>

                    <div class="input-field col s12 m6">
                        <i class="mdi-content-mail prefix"></i>
                        <input id="icon_telephone" type="email" name="<?php echo PojoUsuario::TB_COL_USUARIO_EMAIL; ?>" value="<?php echo $editarUsuario->GetUsuarioEmail(); ?>" class="validate">
                        <label for="icon_telephone">
                            <?php Principal::getInstance()->Getlang('user_email');?>
                        </label>
                    </div>

                    <div class="input-field col s12 m6">
                        <i class="mdi-action-perm-identity prefix"></i>
                        <input id="icon_prefix" type="text" name="<?php echo PojoUsuario::TB_COL_USUARIO_NOME_USUA; ?>" value="<?php echo $editarUsuario->GetUsuarioNomeUsuario(); ?>" class="validate"/>
                        <label for="icon_prefix">
                            <?php Principal::getInstance()->Getlang('user_name');?>
                        </label>
                    </div>

                    <div class="input-field col s12 m6">
                        <i class="mdi-action-lock prefix" onclick="removeDisable('<?php echo PojoUsuario::TB_COL_USUARIO_SENHA; ?>');"></i>
                        <input id="icon_telephone" type="password" name="<?php echo PojoUsuario::TB_COL_USUARIO_SENHA; ?>" disabled>
                        <label for="icon_telephone">
                            <?php Principal::getInstance()->Getlang('user_new_password');?>
                        </label>
                    </div>

                    <div class="input-field col s12 m6">
                        <select name="<?php echo PojoPrivilegio::TB_COL_PRIVILEGIO_ID; ?>">

                            <?php if ($listaPrivilegios): ?>

                                <?php foreach ($listaPrivilegios as $value): ?>

                                    <?php $usuarioPrivilegio = ($editarUsuario->GetUsuarioPrivilegio()->GetPrivilegioId() == $value[PojoPrivilegio::TB_COL_PRIVILEGIO_ID] ) ? true : false ; ?>

                                    <option value="<?php echo $value[PojoPrivilegio::TB_COL_PRIVILEGIO_ID]; ?>"<?php echo ($usuarioPrivilegio)?' selected':''; ?>><?php echo $value[PojoPrivilegio::TB_COL_PRIVILEGIO_NOME]; ?></option>

                                <?php endforeach ?>
                                
                            <?php endif ?>

                        </select>
                    </div>

                    <div class="input-field col s12 m6">
                        <select name="<?php echo PojoSetor::TB_COL_SETOR_ID; ?>">

                            <?php if ($listaSetores): ?>

                                <?php foreach ($listaSetores as $value): ?>

                                    <?php $usuarioSetor = ($editarUsuario->GetUsuarioSetor()->GetSetorId() == $value[PojoSetor::TB_COL_SETOR_ID] ) ? true : false ; ?>

                                    <option value="<?php echo $value[PojoSetor::TB_COL_SETOR_ID] ?>"<?php echo ($usuarioSetor)?' selected':''; ?>><?php echo $value[PojoSetor::TB_COL_SETOR_NOME] ?></option>
                                    
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
              <?php Principal::getInstance()->Getlang('update');?>
              <i class="mdi-content-send right"></i>
          </button>

          <button type="button" onclick="validarSubmit('<?php Principal::getInstance()->gerarUrl( "administrador/validar_atualizar_usuario/" ); ?>');" class="waves-effect waves-green btn-flat modal-action" id="validatButton">
              <?php Principal::getInstance()->Getlang('validate');?>
              <i class="mdi-action-settings-backup-restore right"></i>
          </button>

        </div>

  </form>

<?php endif; ?>