<?php if( defined('KEY_MASTER') &&  @KEY_MASTER == md5( Principal::NOME_PROJETO.date( 'd-m-Y' ) ) ) : ?>
	<div class="row">
		<div class="col s12 m10 offset-m1 white z-depth-1">
			
			<div class="row">

				<div class="col s12">

					<div id="color-usage" class="section scrollspy">
						<h4 class="header"><?php Principal::getInstance()->Getlang('admin_header');?></h4>
						<p class="caption"><?php Principal::getInstance()->Getlang('admin_info');?></p>
					</div>

				</div>

				<hr>

			</div>

			<div class="row">		

				<div class="col s12">

					<h5 class="center"><?php Principal::getInstance()->Getlang('admin_list_user_header');?></h5>

					<table id="tabela_usuarios_sistema" data-page-length='25' class="display">

						<thead>
							<tr>
								<th class="center">
									<?php Principal::getInstance()->Getlang('admin_table_user_id');?>
								</th>
								<th>
									<?php Principal::getInstance()->Getlang('admin_table_user_fullname');?>
								</th>
								<th>
									<?php Principal::getInstance()->Getlang('admin_table_user_nameuser');?>
								</th>
								<th class="center">
									<?php Principal::getInstance()->Getlang('admin_table_user_status');?>
								</th>
								<th class="center">
									<?php Principal::getInstance()->Getlang('admin_table_user_privilegename');?>
								</th>
								<th class="center">
									<?php Principal::getInstance()->Getlang('details');?>
								</th>
							</tr>
						</thead>

						<tbody>

							<?php foreach ($listaUsuarioCadastrados as $value): ?>

								<tr>
									<td class="center"><?php echo $value[ PojoUsuario::TB_COL_USUARIO_ID ] ; ?></td>
									<td><?php echo $value[ PojoUsuario::TB_COL_USUARIO_NOME_COMP ] ; ?></td>
									<td><?php echo $value[ PojoUsuario::TB_COL_USUARIO_NOME_USUA ] ; ?></td>
									<td class="center">
										<div class="switch">
											<label>
												<i class="mdi-action-lock-outline tooltipped"
												   data-position="top" 
												   data-delay="50" 
												   data-tooltip="<?php Principal::getInstance()->Getlang('admin_table_user_disable');?>"></i>

												<input id="statusUser" 
													   type="checkbox" <?php echo ( $value[ PojoUsuario::TB_COL_USUARIO_STATUS ] == 1 ) ? 'checked' : '' ;?> <?php echo ( $value[ PojoUsuario::TB_COL_USUARIO_ID ] == $usuario->GetUsuarioId() ) ? 'disabled' : '' ; ?>
													    onchange="statusUsuario( '<?php Principal::getInstance()->gerarUrl( "administrador/status/".$value[ PojoUsuario::TB_COL_USUARIO_ID ] ); ?>' , this );">

												<span class="lever"></span>

												<i class="mdi-action-lock-open tooltipped"
												   data-position="top" 
												   data-delay="50" 
												   data-tooltip="<?php Principal::getInstance()->Getlang('admin_table_user_enable');?>"></i>

											</label>
										</div>
									</td>
									<td class="center"><?php echo $value[ PojoPrivilegio::TB_COL_PRIVILEGIO_NOME ] ; ?></td>
									<td class="center">
										<a onclick="carregarModalAjax( '<?php Principal::getInstance()->gerarUrl( "administrador/detalhes/".$value[ PojoUsuario::TB_COL_USUARIO_ID ] ); ?>' );" class="waves-effect waves-light">
											<i class="mdi-action-flip-to-front right"></i>
											<?php Principal::getInstance()->Getlang('open');?>
										</a>
									</td>
								</tr>
								
							<?php endforeach ?>

						</tbody>

					</table>
					
				</div>

			</div>

			<div class="clear"></div>

		</div>
	</div>
	<div class="fixed-action-btn " style="bottom: 45px; right: 24px;">
		<a class="btn-floating btn-large teal z-depth-1">
			<i class="large mdi-content-add"></i>
		</a>
		<ul>
			<li>
				<a 	onclick="carregarModalAjax( '<?php Principal::getInstance()->gerarUrl( "administrador/novo_usuario/"); ?>' );"
					class="btn-floating teal lighten-2 tooltipped z-depth-1" 
					data-position="left" 
					data-delay="50" 
					data-tooltip="<?php Principal::getInstance()->Getlang('admin_new_user');?>">
					<i class="large mdi-social-person-add"></i>
				</a>
			</li>
		</ul>
	</div>

<?php endif; ?>