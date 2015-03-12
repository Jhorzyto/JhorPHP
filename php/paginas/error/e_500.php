<?php if( defined('KEY_MASTER') &&  @KEY_MASTER == md5( Principal::NOME_PROJETO.date( 'd-m-Y' ) ) ) : ?>

	<div class="container grey lighten-5 z-depth-1">

		<div class="row">

			<div class="col s12 m12 l12">

				<div id="color-usage" class="section scrollspy">
					<h1 class="header center"><i class="large mdi-alert-warning"></i></h1>
					<h3 class="header center"> <?php Principal::getInstance()->Getlang('error_500_header');?></h3>
					<p class="caption center"><?php Principal::getInstance()->Getlang('error_500_info');?></p>
				</div>

			</div>

		</div>

	</div>

<?php endif; ?>