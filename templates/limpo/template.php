  <!DOCTYPE html>
  <html>

  <head>

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no"/>
    <meta name="theme-color" content="#000000" />
    <meta name="google" content="notranslate" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

    <title><?php echo PAGINA_TITULO;?></title>
    
  </head>

  <body>

    <?php echo Principal::getInstance()->obterConteudo( 'main' ) ;?>

  </body>

  <?php Principal::getInstance()->carregarConteudo( "jquery-2.1.1.min.js" , "js" ) ;?>
  <?php Principal::getInstance()->carregarConteudo( "materialize.min.js" , "js" ) ;?>
  <?php Principal::getInstance()->carregarConteudo( "custom.js" , "js" ) ;?>

  <script type="text/javascript">

    $( document ).ready(function(){

      <?php if(is_array( Principal::getInstance()->obterConteudo( 'jq' ) )){

        foreach ( Principal::getInstance()->obterConteudo( 'jq' )  as $row) 
          echo $row;    

      } ?>

    })

  </script>

</html>