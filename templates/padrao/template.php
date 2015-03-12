  <!DOCTYPE html>
  <html>

  <head>

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta name="theme-color" content="#004d40" />
    <meta name="google" content="notranslate" />
    <meta charset="utf-8">

    <?php Principal::getInstance()->carregarConteudo( "materialize.min.css" , "css" ) ;?>
    <?php Principal::getInstance()->carregarConteudo( "custom.css" , "css" ) ;?>

    <?php if( is_array( Principal::getInstance()->obterConteudo( 'css' ) ) ){

      foreach ( Principal::getInstance()->obterConteudo( 'css' ) as $row ) 
        Principal::getInstance()->carregarConteudo( $row , "css" ) ;    

    } ?>

    <title><?php echo PAGINA_TITULO;?></title>
    
  </head>

  <body class="grey lighten-4">

   <header>

    <div class="navbar-fixed">

      <nav>

        <div class="nav-wrapper teal darken-4 ">

          <a class="brand-logo spanPading"><?php echo Principal::NOME_PROJETO;?></a>

          <a href="#" data-activates="mobile-demo" class="button-collapse spanPading">
            <i class="mdi-navigation-menu"></i>
          </a>

          <ul class="right hide-on-med-and-down">

            <li>
              <a href="<?php Principal::getInstance()->gerarUrl( "principal/" );?>">
                <?php Principal::getInstance()->Getlang('start');?>
              </a>
            </li>

            <li>
              <a href="<?php Principal::getInstance()->gerarUrl( "administrador/" );?>">
                <?php Principal::getInstance()->Getlang('admin');?>
              </a>
            </li>

            <li class="red darken-4">
              <a href="<?php Principal::getInstance()->gerarUrl( "login/sair/" );?>">
                <i class="mdi-action-launch"></i>
              </a>
            </li>

          </ul>

        </div>

      </nav>

    </div>

    <div class="nav-wrapper">      

      <ul class="side-nav" id="mobile-demo">

        <li>
          <a href="<?php Principal::getInstance()->gerarUrl( "principal/" );?>" class="waves-effect">
            <span class="spanPading"><?php Principal::getInstance()->Getlang('start');?></span>
          </a>
        </li>

        <li>
          <a href="<?php Principal::getInstance()->gerarUrl( "administrador/" );?>" class="waves-effect">
            <span class="spanPading"><?php Principal::getInstance()->Getlang('admin');?></span>
          </a>
        </li>

        <li>
          <a href="<?php Principal::getInstance()->gerarUrl( "login/sair/" );?>" class="waves-effect">
            <span class="spanPading"><?php Principal::getInstance()->Getlang('logout');?></span>
          </a>
        </li>

      </ul>

    </div>

  </header>

  <main>

    <?php echo Principal::getInstance()->obterConteudo( 'main' );?>

  </main>

  <div id="carregarModalAjax" class="modal modal-fixed-footer"> 

    <div id="ModalAjaxLoad" class="col s12 center ocultarConteudo">

      <div class="clear"></div>
      <div class="clear"></div>
      <div class="clear"></div>
      <div class="clear"></div>

      <h4><?php Principal::getInstance()->Getlang('loading');?></h4>

      <div class="clear"></div>
      <div class="clear"></div>
      <div class="clear"></div>
      <div class="clear"></div>

      <div class="preloader-wrapper big active">
        <div class="spinner-layer spinner-green-only">
          <div class="circle-clipper left">
            <div class="circle"></div>
          </div>
          <div class="gap-patch">
            <div class="circle"></div>
          </div>
          <div class="circle-clipper right">
            <div class="circle"></div>
          </div>
        </div>
      </div>

      <div class="clear"></div>
      <div class="clear"></div>
      <div class="clear"></div>
      <div class="clear"></div>

      <a onclick="fecharModal();"><h5><?php Principal::getInstance()->Getlang('cancel');?></h5></a>

    </div>

    <div id="ModalAjaxBody"></div>

  </div>

  <footer class="page-footer">
    <div class="footer-copyright grey lighten-4">
      <div class="container black-text center">
        © <?php echo Principal::ANO_DESENVOLVIMENTO;?> <?php echo Principal::NOME_PROJETO;?>. <?php Principal::getInstance()->Getlang('version');?>: <?php echo Principal::VERSAO;?>
      </div>
    </div>
  </footer>

  </body>

  <?php Principal::getInstance()->carregarConteudo( "jquery-2.1.1.min.js" , "js" ) ;?>
  <?php Principal::getInstance()->carregarConteudo( "materialize.min.js" , "js" ) ;?>
  <?php Principal::getInstance()->carregarConteudo( "custom.js" , "js" ) ;?>

  <?php if( is_array( Principal::getInstance()->obterConteudo( 'js' ) ) ){

    foreach ( Principal::getInstance()->obterConteudo( 'js' ) as $row) 
      Principal::getInstance()->carregarConteudo( $row , "js" ) ;    

  } ?>

  <script type="text/javascript">

    var notificacao = <?php Principal::getInstance()->GetNotificacao(); ?>;

    $( document ).ready(function(){

      $('.tooltipped').tooltip({delay: 50});

      $(".button-collapse").sideNav();
    
      $.each(notificacao, function() {
        if(this != 0)
          toast(this, 4000);
      });

      <?php if( is_array( Principal::getInstance()->obterConteudo( 'jq' ) ) ){

        foreach ( Principal::getInstance()->obterConteudo( 'jq' ) as $row) 
          echo $row;    

      } ?>

    })

  </script>

</html>