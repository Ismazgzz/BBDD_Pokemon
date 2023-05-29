<html>
    <head>
        <title>WEB POKEMON</title>
        <link rel="stylesheet" href="estilosIndex.css" type="text/css" />
        <link rel="stylesheet" href="estilosTablas.css" type="text/css" />
        <link rel="stylesheet" href="estilosFiltros.css" type="text/css" />
        <link rel="shortcut icon" href="imagenes/iconoPagina.ico">

        <?php

        function exception_handler(Throwable $exception){
            echo "Uncuaght exception:", $exception->getMessage(),"\n";
        }

        set_exception_handler('exception_handler');

        // Conecta a la base de datos (donde esta, usuario, contraseña, nombre de la base de datos)
        $BBDDPokemon = mysqli_connect("172.17.0.2", "root", "contrasena", "pokemondb"); 
        // Si no se puede conectar a la base de datos, muestra un error

        // Para que se muestren bien los caracteres especiales (acentos, eñes, etc)
        mysqli_query($BBDDPokemon, "SET NAMES 'utf8'"); 

        if($_GET['orden']){ 
            $cargar = $_GET['orden'];
        }

        //almaceno en las variables que almacenan los valores introducidos en el fitro en variables que hacen la consulta 
        $posAlm = strpos($_GET['columna'], '~' , 0);
        $columna2 = substr($_GET['columna'], 0 , $posAlm) ;
        $tipoColumna = substr($_GET['columna'], $posAlm + 1, 4) ;
        $valorMin2 = $_GET['valorMin'];
        $valorMax2 = $_GET['valorMax'];

        /* Guardamos parte de la consulta en una variable para no tener que escribirla todo el rato */
        $sql = "SELECT ctp.tipo , ctp.cantidad
        FROM cantidad_tipo_pokemon ctp";
        
        // creamos una variable que almacena la consulta para los filtrados por campos numéricos.
        if( $columna2 != null && $tipoColumna == "num" ){
            $sql2 = $sql . " WHERE $columna2 > $valorMin2 AND $columna2 < $valorMax2 " ;
        }

        // si se recarga la pagina para una ordenación, se lanza una consulta ordenando.
        if($cargar){
            $sql= $sql . " ORDER BY " . $_GET['orden'] . " " .  $_GET['ascendiente'] ;
        }

        // Hace una consulta a la base de datos dependiendo de si columna2 contiene un campo o no, guarda el resultado en la variable $resultado2
        if($columna2 != null){
            $resultado2 = mysqli_query($BBDDPokemon, $sql2);
        }else{
            $resultado2 = mysqli_query($BBDDPokemon, $sql);
        }  

        // Hace una consulta a la base de datos dependiendo de si columna2 contiene un campo o no, guarda el resultado en la variable $resultado2
        if($columna2 != null){
            $resultado2 = mysqli_query($BBDDPokemon, $sql2);
        }else{
            $resultado2 = mysqli_query($BBDDPokemon, $sql);
        }         

        mysqli_close($BBDDPokemon);
        // Cierra la conexion a la base de datos para ahorrar recursos del servidor (siempre que no se vaya a usar mas) 

        ?>

        <script>

            function ordena(recibe, tipoOrdenacion){
                window.location.replace("Tipos.php?orden=" + recibe + "&ascendiente=" + tipoOrdenacion);
            }
            
            //cambiamos la url para que funcione 
            function ordenaFiltro(columna, valorMin, valorMax, texto){
                    window.location.replace("Tipos.php?columna=" + columna + "&valorMin" + "=" + valorMin + "&valorMax" + "=" + valorMax);
            }

        </script>

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
            <div id="contenedor" class="contenedor">
                <table class="tabla" >
                    <tr>
                        <td width="10%"> Tipo </td>
                        <td width="5%"> Cantidad Pokemon </td>
                    </tr>
                    <tr>
                        <td><img src="Imagenes/flechaArriba.png" height="15px" onclick="ordena( 'ctp.tipo' , 'ASC')" ><img src="Imagenes/flechaAbajo.png"  height="15px" onclick="ordena( 'ctp.tipo' , 'DESC')"></td>
                        <td><img src="Imagenes/flechaArriba.png" height="15px" onclick="ordena( 'ctp.cantidad' , 'ASC')" ><img src="Imagenes/flechaAbajo.png"  height="15px" onclick="ordena( 'ctp.cantidad' , 'DESC')"></td>
                    </tr>

                    <?php
                    
                    while($resultadoFila = mysqli_fetch_assoc($resultado2)){ // Mientras haya filas con resultados se ejecutará el bucle

                    echo "<tr>";

                    foreach($resultadoFila as $campoFila){
                    
                    echo "<td>";

                    echo $campoFila;

                    echo "</td>";
                    
                    }

                    echo "</tr>";

                    }

                    ?>
                </table>
            </div>
            <div class="filtros2">
                <select name="campoFiltrar" id="campoFiltrar">
                <option value="predeterminado">Selecciona un campo</option>
                    <option value="ctp.tipo~text">Tipo</option>
                    <option value="ctp.cantidad~num">Cantidad Pokemon</option>
                </select><br><br>
                <label for="filtroValorMax"> Valor Máximo </label><input type="number" name="filtroValorMax" id="filtroValorMax" placeholder="Valor Máximo" step="0.1"> <br><br>
                <label for="filtroValorMin"> Valor Mínimo </label><input type="number" name="filtroValorMin" id="filtroValorMin" placeholder="Valor Mínimo" step="0.1"> <br><br>
                <input type="button" value="enviar" onclick="ordenaFiltro(campoFiltrar.value, filtroValorMin.value, filtroValorMax.value)"><br><br>
            </div>
            <img src="imagenes/Erico.png" width="200px" align="right">
        </div>
    </body>
</html>