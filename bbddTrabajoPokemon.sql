
DELIMITER $$

DROP PROCEDURE IF EXISTS insertarPokemon$$
CREATE PROCEDURE insertarPokemon(IN numPokemon INT, IN nombre VARCHAR(15),IN peso DOUBLE,
IN altura DOUBLE, IN ps INT, IN ataque INT, IN defensa INT, IN especial INT, IN velocidad INT)
BEGIN
	INSERT INTO pokemon (numero_pokedex, nombre, peso, altura)VALUES (numPokemon, nombre, peso, altura);
	INSERT INTO estadisticas_base (numero_pokedex, ps, ataque, defensa, especial, velocidad)VALUES (numPokemon, ps, ataque, defensa, especial, velocidad);
END $$



SELECT * FROM pokemon p;

DELIMITER $$
DROP PROCEDURE IF EXISTS depurar_datos_insercion_pokemon$$
CREATE PROCEDURE depurar_datos_insercion_pokemon( IN numPokedex int, IN nombre text, IN peso double, IN altura double, OUT numPokedexSalida int, OUT nombreSalida text, OUT pesoSalida double, OUT alturaSalida double)
BEGIN
	SET numPokedexSalida = numPokedex ;
	SET nombreSalida = nombre ;
	SET pesoSalida = peso ;
	SET alturaSalida = altura ;
	IF numPokedexSalida IN (SELECT p.numero_pokedex FROM pokemon p)  OR numPokedexSalida < 0 THEN
		SET numPokedexSalida = null;
	END IF;
	
	SET nombreSalida = TRIM(nombreSalida);
	IF LENGTH(nombreSalida) > 15 THEN
		SET nombreSalida = LEFT(nombreSalida, 15);
	END IF;
	
	IF pesoSalida < 0 THEN
		SET pesoSalida = 0;
	END IF;
	
	IF alturaSalida < 0 THEN
		SET alturaSalida = 0;
	END IF;
	
END$$

CREATE DEFINER=`root`@`%` TRIGGER `depurarDatosPokemonInserccion` BEFORE INSERT ON `pokemon` FOR EACH ROW BEGIN 
	DECLARE numPokedexNuevo INT;
	DECLARE nombreNuevo TEXT;
	DECLARE pesoNuevo DOUBLE;
	DECLARE alturaNuevo DOUBLE;
	
	CALL depurar_datos_insercion_pokemon(NEW.numero_pokedex, NEW.nombre, NEW.peso, NEW.altura,
	numPokedexNuevo, nombreNuevo, pesoNuevo, alturaNuevo); 
	SET NEW.numero_pokedex = numPokedexNuevo;
	SET NEW.nombre = nombreNuevo;
	SET NEW.peso = pesoNuevo;
	SET NEW.altura = alturaNuevo;

END$$

CREATE TRIGGER `depurarDatosEstadisticasInserccion` BEFORE INSERT ON `estadisticas_base` FOR EACH ROW BEGIN  
	DECLARE numPokedexNuevo INT; 
	DECLARE psNuevo INT; 
	DECLARE ataqueNuevo INT; 
	DECLARE defensaNuevo INT; 
	DECLARE especialNuevo INT; 
	DECLARE velocidadNuevo INT; 
	CALL depurar_datos_insercion_estadisticas(NEW.numero_pokedex, NEW.ps, NEW.ataque, NEW.defensa, NEW.especial, NEW.velocidad, 
	numPokedexNuevo, psNuevo, ataqueNuevo, defensaNuevo, especialNuevo, velocidadNuevo);  
	SET NEW.numero_pokedex = numPokedexNuevo; 
	SET NEW.ps = psNuevo; 
	SET NEW.ataque = ataqueNuevo; 
	SET NEW.defensa = defensaNuevo; 
	SET NEW.especial = especialNuevo; 
	SET NEW.velocidad = velocidadNuevo; 
END$$

DROP TRIGGER IF EXISTS depurarDatosPokemonInserccion$$
CREATE TRIGGER depurarDatosPokemonInserccion BEFORE INSERT
ON pokemon FOR EACH ROW
BEGIN 
	DECLARE numPokedexNuevo INT;
	DECLARE nombreNuevo TEXT;
	DECLARE pesoNuevo DOUBLE;
	DECLARE alturaNuevo DOUBLE;
	
	CALL depurar_datos_insercion_pokemon(NEW.numero_pokedex, NEW.nombre, NEW.peso, NEW.altura,
	numPokedexNuevo, nombreNuevo, pesoNuevo, alturaNuevo); 
	SET NEW.numero_pokedex = numPokedexNuevo;
	SET NEW.nombre = nombreNuevo;
	SET NEW.peso = pesoNuevo;
	SET NEW.altura = alturaNuevo;

END $$


DROP TRIGGER IF EXISTS depurarDatosEstadisticasInserccion$$
CREATE TRIGGER depurarDatosEstadisticasInserccion BEFORE INSERT
ON estadisticas_base FOR EACH ROW
BEGIN 
	DECLARE numPokedexNuevo INT;
	DECLARE psNuevo INT;
	DECLARE ataqueNuevo INT;
	DECLARE defensaNuevo INT;
	DECLARE especialNuevo INT;
	DECLARE velocidadNuevo INT;
	CALL depurar_datos_insercion_estadisticas(NEW.numero_pokedex, NEW.ps, NEW.ataque, NEW.defensa, NEW.especial, NEW.velocidad,
	numPokedexNuevo, psNuevo, ataqueNuevo, defensaNuevo, especialNuevo, velocidadNuevo); 
	SET NEW.numero_pokedex = numPokedexNuevo;
	SET NEW.ps = psNuevo;
	SET NEW.ataque = ataqueNuevo;
	SET NEW.defensa = defensaNuevo;
	SET NEW.especial = especialNuevo;
	SET NEW.velocidad = velocidadNuevo;
END $$

Select * from pokemon p ;



DROP PROCEDURE IF EXISTS modificarPokemon$$
CREATE PROCEDURE modificarPokemon(IN numPokedex INT, IN newNombre VARCHAR(15),IN newPeso DOUBLE,
IN newAltura DOUBLE, IN newPS INT, IN newAtaque INT, IN newDefensa INT, IN newEspecial INT, IN newVelocidad INT)
BEGIN
    UPDATE pokemon 
    SET nombre = newNombre, peso = newPeso, altura = newAltura
    WHERE numero_pokedex = numPokedex;
    UPDATE estadisticas_base 
    SET ps = newPS, ataque = newAltura, defensa = newDefensa, especial = newEspecial, velocidad = newVelocidad
    WHERE numero_pokedex = numPokedex;
END $$


CREATE FUNCTION `pokemondb`.`formaInicialPokemon`(numPokedex INT) RETURNS int
    READS SQL DATA
BEGIN
    DECLARE numPokedexFormaInicial INT;

    SELECT ed.pokemon_origen
    INTO numPokedexFormaInicial
    FROM pokemon p LEFT JOIN evoluciona_de ed
        ON p.numero_pokedex = ed.pokemon_evolucionado
    WHERE p.numero_pokedex = numPokedex;

    RETURN numPokedexFormaInicial;
END$$

CREATE PROCEDURE `pokemondb`.`insertarPokemon`(IN numPokemon INT, IN nombre VARCHAR(15),IN peso DOUBLE,
IN altura DOUBLE, IN ps INT, IN ataque INT, IN defensa INT, IN especial INT, IN velocidad INT)
BEGIN
	INSERT INTO pokemon (numero_pokedex, nombre, peso, altura)VALUES (numPokemon, nombre, peso, altura);
	INSERT INTO estadisticas_base (numero_pokedex, ps, ataque, defensa, especial, velocidad)VALUES (numPokemon, ps, ataque, defensa, especial, velocidad);
END$$

CREATE PROCEDURE `pokemondb`.`muestraPokemonByTipo`(p_tipo varchar(10))
begin

    select p.nombre
    from pokemon p, pokemon_tipo pt, tipo t
    where p.numero_pokedex = pt.numero_pokedex and pt.id_tipo=t.id_tipo
    and lower(t.nombre) = trim(lower(p_tipo));
    
END$$

CREATE PROCEDURE `pokemondb`.`muestraPokemonByTipos`(p_tipo1 varchar(10), p_tipo2 varchar(10))
begin

    select nombre
    from pokemon
    where numero_pokedex in (select numero_pokedex
                            from pokemon_tipo pt, tipo t
                            where pt.id_tipo=t.id_tipo and lower(t.nombre)=lower(trim(p_tipo1)))
    and numero_pokedex in (select numero_pokedex
                            from pokemon_tipo pt, tipo t
                            where pt.id_tipo=t.id_tipo and lower(t.nombre)=lower(trim(p_tipo2)));
    
end$$

DELIMITER ;