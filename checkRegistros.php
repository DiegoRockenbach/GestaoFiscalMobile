<html>
  <head>
    <meta charset="UTF-8">
    <title>Página principal</title>
  </head>
  <body>
    <div>
      <?php
        $banco = json_decode(file_get_contents("banco.json"));
        
      echo  "<table>";
      echo  "  <tr>";
      echo  "    <th>Valor</th>";
      echo  "    <th>Data</th>";
      echo  "  </tr>";
      foreach($banco as $count) {
        echo "<tr>";
        echo "<td>" . $count->valor . "</td>";
        echo "<td>" . $count->data . "</td>";
        echo "</tr>";
      }
      echo  "</table>";
      ?>
    </div>
    <br> <br>
    <a href="index.php">
      <button >Voltar</button>
    </a>
  </body>
</html>