<html>
  <head>
    <meta charset="UTF-8">
    <title>Página principal</title>
  </head>
  <body>
    <div>
      <?php
        //$dados = file_get_contents("banco.txt");
        //var_dump(json_decode($dados));
        //$dados = file_get_contents("banco.txt");
        //$cabaço = json_decode($dados);
        //var_dump($cabaço);

        $key = "natalia";
        $lol = "amo muito ela";
        $coisacod = hash_hmac("SHA256", $lol, $key);
        var_dump($coisacod);
      ?>
    </div>
    <br> <br>
    <a href="index.html">
      <button >Voltar</button>
    </a>
  </body>
</html>