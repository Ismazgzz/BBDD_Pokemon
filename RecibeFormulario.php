<html>
    <head>
        <title>RecibeDatosFormulario</title>

    <?php

        function exception_handler(Throwable $exception){
            echo "Uncuaght exception:", $exception->getMessage(),"\n";
        }

        set_exception_handler('exception_handler');

        // Recibe los datos de Formulario.php
        $numPokedex = $_POST['numPokedex'];
        $nombre = $_POST['nombre'];
        $altura = $_POST['altura'];
        $peso = $_POST['peso'];
        $ps = $_POST['ps'];
        $ataque = $_POST['ataque'];
        $defensa = $_POST['defensa'];
        $especial = $_POST['especial'];
        $velocidad = $_POST['velocidad'];

        

        // Conecta a la base de datos (donde esta, usuario, contraseña, nombre de la base de datos)
        $BBDDPokemon = mysqli_connect("172.17.0.2", "root", "contrasena", "pokemondb");


        $insert = "CALL insertarPokemon($numPokedex,'$nombre', $altura, $peso, $ps, $ataque, $defensa, $especial, $velocidad)";

        echo $numPokedex . "<br>";
        

        // cierra la base
        mysqli_close($BBDDPokemon);

    ?>
    </head>
    <body>
    </body>
</html>