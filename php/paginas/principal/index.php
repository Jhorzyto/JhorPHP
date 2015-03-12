<?php if( defined('KEY_MASTER') &&  @KEY_MASTER == md5( Principal::NOME_PROJETO.date( 'd-m-Y' ) ) ) : ?>	

	<div class="container grey lighten-5 z-depth-1">
		
		<div class="row">

			<div class="col s12 m12 l12">

				<div id="color-usage" class="section scrollspy">
					<h4 class="header"><?php Principal::getInstance()->Getlang('main_header');?></h4>
					<p class="caption"><?php Principal::getInstance()->Getlang('main_info');?></p>
				</div>
			</div>

		</div>
	</div>

<?php endif; ?>