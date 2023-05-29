<html>
    <head>
        <title>WEB POKEMON</title>
        <link rel="stylesheet" href="estilosIndex.css" type="text/css" />
        <link rel="stylesheet" href="estilosTablas.css" type="text/css" />
        <link rel="stylesheet" href="estilosFiltros.css" type="text/css" />
        <link rel="shortcut icon" href="imagenes/iconoPagina.ico">

        <?php

        //sirve para que si explota el php sale un mensaje de error
        function exception_handler(Throwable $exception){
            echo "Uncuaght exception:", $exception->getMessage(),"\n";
        }

        set_exception_handler('exception_handler');

        // Conecta a la base de datos (donde esta, usuario, contraseña, nombre de la base de datos)
        $BBDDPokemon = mysqli_connect("172.17.0.2", "root", "contrasena", "pokemondb"); 
        // Si no se puede conectar a la base de datos, muestra un error

        // Para que se muestren bien los caracteres especiales (acentos, eñes, etc)
        mysqli_query($BBDDPokemon, "SET NAMES 'utf8'"); 

        //comprueba si en la url está la variable orden, si esta almacenamos lo que indica en $cargar.
        if($_GET['orden']){ 
            $cargar = $_GET['orden'];
        }

        //FILTROS
        //almaceno en las variables que almacenan los valores introducidos en el fitro en variables que hacen la consulta 
        $posAlm = strpos($_GET['columna'], '~' , 0);
        $columna2 = substr($_GET['columna'], 0 , $posAlm) ;
        $tipoColumna = substr($_GET['columna'], $posAlm + 1, 4) ;
        $valorMin2 = $_GET['valorMin'];
        $valorMax2 = $_GET['valorMax'];
        $texto2 = $_GET['texto'];

        /* Guardamos parte de la consulta en una variable para no tener que escribirla todo el rato */
        $sql = "SELECT p.numero_pokedex , p.imagen, p.nombre , p.peso, p.altura, eb.ps , eb.ataque , eb.defensa , eb.especial , eb.velocidad
                FROM pokemon p , estadisticas_base eb 
                WHERE p.numero_pokedex  = eb.numero_pokedex";

        // creamos una variable que almacena la consulta para los filtrados por campos numéricos.
        if( $columna2 != null && $tipoColumna == "num" ){
            $sql2 = $sql . " AND $columna2 > $valorMin2 AND $columna2 < $valorMax2 " ;
        }else{
            $sql2 = $sql . " AND MATCH ($columna2) AGAINST('$texto2' IN BOOLEAN MODE)";
        }
        
        
        // si se recarga la pagina para una ordenación, se lanza una consulta ordenando.
        if($cargar){
            $sql= $sql . " ORDER BY " . $_GET['orden'] . " " .  $_GET['ascendiente'];
        }

        // Hace una consulta a la base de datos dependiendo de si columna2 contiene un campo o no, guarda el resultado en la variable $resultado2
        if($columna2 != null){
            $resultado2 = mysqli_query($BBDDPokemon, $sql2);
        }else{
            $resultado2 = mysqli_query($BBDDPokemon, $sql);
        }         

        // Cierra la conexion a la base de datos para ahorrar recursos del servidor (siempre que no se vaya a usar mas) 
        mysqli_close($BBDDPokemon);
        
        ?>

        <script>

            function ordena(recibe, tipoOrdenacion){ 
                window.location.replace("Pokedex.php?orden=" + recibe + "&ascendiente=" + tipoOrdenacion);
            }

             //cambiamos la url para que funcione 
            function ordenaFiltro(columna, valorMin, valorMax, texto){
                window.location.replace("Pokedex.php?columna=" + columna + "&valorMin" + "=" + valorMin + "&valorMax" + "=" + valorMax + "&texto=" + texto);
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
                <table class="tabla">
                    <tr>
                        <td width="5%"> Nº Pokedex </td>
                        <td width="5%"> Imagen </td>
                        <td width="15%"> Nombre </td>
                        <td width="5%"> Peso (kg) </td>
                        <td width="5%"> Altura (m) </td>
                        <td width="5%"> PS </td>
                        <td width="5%"> Ataque </td>
                        <td width="5%"> Defensa </td>
                        <td width="5%"> Especial </td>
                        <td width="5%"> Velocidad </td>
                    </tr>
                    <tr>
                        <td><img src="Imagenes/flechaArriba.png" height="15px" onclick="ordena( 'p.numero_pokedex' , 'ASC')" ><br><img src="Imagenes/flechaAbajo.png"  height="15px" onclick="ordena( 'p.numero_pokedex' , 'DESC')"></td>
                        <td><img src="Imagenes/flechaArriba.png" height="15px" onclick="ordena( 'p.imagen' , 'ASC')" ><br><img src="Imagenes/flechaAbajo.png"  height="15px" onclick="ordena( 'p.imagen' , 'DESC')"></td>
                        <td><img src="Imagenes/flechaArriba.png" height="15px" onclick="ordena( 'p.nombre' , 'ASC')" ><br><img src="Imagenes/flechaAbajo.png"  height="15px" onclick="ordena( 'p.nombre' , 'DESC')"></td>
                        <td><img src="Imagenes/flechaArriba.png" height="15px" onclick="ordena( 'p.peso' , 'ASC')" ><br><img src="Imagenes/flechaAbajo.png"  height="15px" onclick="ordena( 'p.peso' , 'DESC')"></td>
                        <td><img src="Imagenes/flechaArriba.png" height="15px" onclick="ordena( 'p.altura' , 'ASC')" ><br><img src="Imagenes/flechaAbajo.png"  height="15px" onclick="ordena( 'p.altura' , 'DESC')"></td>
                        <td><img src="Imagenes/flechaArriba.png" height="15px" onclick="ordena( 'eb.ps' , 'ASC')"><br><img src="Imagenes/flechaAbajo.png"  height="15px " onclick="ordena( 'eb.ps' , 'DESC')"></td>
                        <td><img src="Imagenes/flechaArriba.png" height="15px" onclick="ordena( 'eb.ataque' , 'ASC')" ><br><img src="Imagenes/flechaAbajo.png"  height="15px" onclick="ordena( 'eb.ataque' , 'DESC')"></td>
                        <td><img src="Imagenes/flechaArriba.png" height="15px" onclick="ordena( 'eb.defensa' , 'ASC')"><br><img src="Imagenes/flechaAbajo.png"  height="15px" onclick="ordena( 'eb.defensa' , 'DESC')"></td>
                        <td><img src="Imagenes/flechaArriba.png" height="15px" onclick="ordena( 'eb.especial' , 'ASC')"><br><img src="Imagenes/flechaAbajo.png"  height="15px" onclick="ordena( 'eb.especial' , 'DESC')"></td>
                        <td><img src="Imagenes/flechaArriba.png" height="15px" onclick="ordena( 'eb.velocidad' , 'ASC')"><br><img src="Imagenes/flechaAbajo.png"  height="15px" onclick="ordena( 'eb.velocidad' , 'DESC')"></td>
                    </tr>

                    <?php
                    
                    while($resultadoFila = mysqli_fetch_assoc($resultado2)){ // Mientras haya filas con resultados se ejecutará el bucle

                    echo "<tr>";

                    foreach($resultadoFila as $campoFila){

                    if($campoFila == $resultadoFila['imagen']){ // Si el campo es la imagen, se muestra la imagen

                        echo "<td><img src='" . $campoFila . "' height='100px'> </td>";

                    }else{

                        echo "<td>";

                        echo $campoFila;

                        echo "</td>";
                    }

                    }



                    echo "</tr>";

                    }


                    ?>
                </table>
            </div>
            <div class="filtros">
                <select name="campoFiltrar" id="campoFiltrar">
                    <option value="predeterminado">Selecciona un campo</option>
                    <option value="p.numero_pokedex~num"> Nº Pokedex </option>
                    <option value="p.nombre~text"> Nombre </option>
                    <option value="p.peso~num"> Peso (kg) </option>
                    <option value="p.altura~num"> Altura (m) </option>
                    <option value="eb.ps~num"> PS </option>
                    <option value="eb.ataque~num"> Ataque </option>
                    <option value="eb.defensa~num"> Defensa </option>
                    <option value="eb.especial~num"> Especial </option>
                    <option value="eb.velocidad~num"> Velocidad </option>
                </select><br><br>
                <label for="filtroValorMax"> Valor Máximo </label><input type="number" name="filtroValorMax" id="filtroValorMax" placeholder="Valor Máximo" step="0.1"> <br><br>
                <label for="filtroValorMin"> Valor Mínimo </label><input type="number" name="filtroValorMin" id="filtroValorMin" placeholder="Valor Mínimo" step="0.1"> <br><br>
                <label for="filtroTexto"> Filtro de Texto </label><input type="text" name="filtroTexto" id="filtroTexto" placeholder="Pokemon a filtrar" step="0.1"><br><br>
                <input type="button" value="enviar" onclick="ordenaFiltro(campoFiltrar.value, filtroValorMin.value, filtroValorMax.value, filtroTexto.value)"><br><br>
            </div>
            <br><img src="imagenes/Mirto.png" width="250px" align="right">
        </div>
    </body>
</html>