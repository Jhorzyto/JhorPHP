<?php if( defined('KEY_MASTER') &&  @KEY_MASTER == md5( Principal::NOME_PROJETO.date( 'd-m-Y' ) ) ) : ?>

	<div class="col s12 m12 l12">

		<div class="clear"></div>
		<div class="clear"></div>

		<div id="color-usage" class="section scrollspy">
			<h1 class="header center"><i class="large mdi-alert-warning"></i></h1>
			<h3 class="header center"> <?php Principal::getInstance()->Getlang('admin_update_user_invalid_header');?></h3>
			<p class="caption center"><?php Principal::getInstance()->Getlang('admin_update_user_invalid_info');?></p>
		</div>

	</div>

<?php endif; ?>