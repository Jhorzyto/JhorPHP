  <!DOCTYPE html>
  <html>

  <head>

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta name="theme-color" content="#004d40" />
    <meta name="google" content="notranslate" />
    <meta charset="utf-8">

    <?php Principal::getInstance()->carregarConteudo( "materialize.min.css" , "css" ) ;?>
    <?php Principal::getInstance()->carregarConteudo( "custom.css" , "css" ) ;?>

    <?php if(is_array( Principal::getInstance()->obterConteudo( 'css' ) )){

      foreach ( Principal::getInstance()->obterConteudo( 'css' )  as $row) 
        Principal::getInstance()->carregarConteudo( $row , "css" ) ;    

    } ?>

    <title><?php echo PAGINA_TITULO;?></title>
    
  </head>

  <body class="grey lighten-4">

    <header>

      <div class="navbar-fixed">
      
        <nav>

          <div class="nav-wrapper teal darken-4">

            <a class="brand-logo center"><?php echo Principal::NOME_PROJETO;?></a>

          </div>

        </nav>

      </div>

    </header>

    <main>

      <?php echo  Principal::getInstance()->obterConteudo( 'main' ) ;?>

    </main>

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

  <?php if(is_array( Principal::getInstance()->obterConteudo( 'js' ) )){

    foreach ( Principal::getInstance()->obterConteudo( 'js' )  as $row) 
      Principal::getInstance()->carregarConteudo( $row , "js" ) ;    

  } ?>

  <script type="text/javascript">

    var notificacao = <?php Principal::getInstance()->GetNotificacao(); ?>;

    $( document ).ready(function(){
    
      $.each(notificacao, function() {
        if(this != 0)
          toast(this, 4000);
      });

      $(".dropdown-button").dropdown();

      <?php if(is_array( Principal::getInstance()->obterConteudo( 'jq' ) )){

        foreach ( Principal::getInstance()->obterConteudo( 'jq' )  as $row) 
          echo $row;    

      } ?>

    })

  </script>

</html>