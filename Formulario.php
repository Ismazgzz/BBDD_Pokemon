<html>
  <head>
    <meta charset="UTF-8" />
    <title>WEB POKEMON</title>
    <link rel="stylesheet" href="estilosIndex.css" type="text/css" />
    <link rel="shortcut icon" href="imagenes/iconoPagina.ico">

    <link rel="stylesheet" href="estilosIndex.css" type="text/css" />
    <link rel="stylesheet" href="estilosTablas.css" type="text/css" />
  </head>

  <body>
    <header>
      <nav>
        <a href="Index.php"><img src="imagenes/logo.png" height="40px" ></a>
        <ul>
          <li><a href="Index.php">Inicio</a></li>
          <li><a href="Pokedex.php">Pokedex</a></li>
          <li><a href="Movimientos.php">Movimientos</a></li>
          <li><a href="Tipos.php">Tipos</a></li>
          <li><a href="Formulario.php">Formulario</a></li>
        </ul>
      </nav>
    </header>

    <div id="fondoContenido" class="fondoContenido">
      <div id="contenedor2" class="contenedor2">
        
        <!-- Crea un formulario que sea una tabla con inputs para todos los campos de la tabla pokemon. -->
        <form action="RecibeFormulario.php" method="post">
          <table style=" background-color: white; border-radius: 10px; margin:0 auto; font-size: 20px;">
            <tr>
              <td colspan="2"> <strong> INFORMACIÓN BÁSICA DEL POKEMON </strong> </td>
            </tr>
            <tr>
              <td>Número Pokedex</td>
              <td><input type="number" name="numPokedex" required></td>
            </tr>
            <tr>
              <td>Nombre</td>
              <td><input type="text" name="nombre" required></td>
            </tr>
            <tr>
              <td>Altura</td>
              <td><input type="number" step="0.1" name="altura" required></td>
            </tr>
            <tr>
              <td>Peso</td>
              <td><input type="number" step="0.1" name="peso" required></td>
            </tr>
            <tr>
              <td colspan="2"> <strong> ESTADÍSTICAS BASE DEL POKEMON </strong> </td>
            </tr>
            <tr>
              <td>PS</td>
              <td><input type="number" name="ps" required></td>
            </tr>
            <tr>
              <td>Ataque</td>
              <td><input type="number" name="ataque" required></td>
            </tr>
            <tr>
              <td>Defensa</td>
              <td><input type="number" name="defensa" required></td>
            </tr>
            <tr>
              <td>Especial</td>
              <td><input type="number" name="especial" required></td>
            </tr>
            <tr>
              <td>Velocidad</td>
              <td><input type="number" name="velocidad" required></td>
            </tr>
            <tr>
            <td><a href="ModificarPokemon.php"><img src="Imagenes/modificar.png" width="30px"></a>
            <a href="EliminarPokemon.php"><img src="Imagenes/papelera.png" width="30px"></a></td>
              <!-- Pon un boton de enviar datos del formulario -->
              <td colspan="2" align="center"><input type="submit" value="Enviar"></td>
              
              <td></td>
            </tr>

            <br><img src="imagenes/oak.png" width="250px" align="right">
            <br><img src="imagenes/serbal.png" width="250px" align="left">
          </table>
        </form>
      </div>
    </div>
  </body>
</html>