<?php
function conectarDB()
{
    try
    {
        // -----------------------------------------------------------
        // 1. AQUÍ SOLO CAMBIAS EL NOMBRE DE LA BASE DE DATOS
        // -----------------------------------------------------------
        $nombre_base_datos = "TEST_EXAMEN"; // <--- CAMBIA ESTO EN EL EXAMEN
        
        $cadenaConexion = "mysql:host=localhost;dbname=$nombre_base_datos";
        $usu="root";
        $pw="";
        $db = new PDO($cadenaConexion,$usu,$pw);
        $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        return $db;
    }
    catch (PDOException $ex)
    {
        echo "Error conectando: ".$ex->getMessage();
        return null;
    }
}

// COPIAR ESTO SI TE PIDEN LISTAR TODO
function getTodos($db, $tabla)
{
    $vectorTotal = array();
    try
    {
        $stmt = $db->query("SELECT * FROM $tabla");
        while ($fila = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $vectorTotal[] = $fila;
        }
    }
    catch(PDOException $ex)
    {
        return array(); // Devuelve array vacio si falla
    }
    return $vectorTotal;
}

// COPIAR ESTO SI TE PIDEN FILTRAR (BUSCADOR)
function getFiltrado($db, $tabla, $columna, $valor)
{
    $vectorTotal = array();
    try
    {
        $query= "SELECT * FROM $tabla WHERE $columna = :VALOR";
        $pstmt = $db->prepare($query);
        $pstmt->execute(array(':VALOR' => $valor));
        while ($fila = $pstmt->fetch(PDO::FETCH_ASSOC))
        {
            $vectorTotal[] = $fila;
        }
    }
    catch(PDOException $ex)
    {
        return array();
    }
    return $vectorTotal;
}

// COPIAR ESTO SI TE PIDEN INSERTAR (AÑADIR)
// NOTA: Esta función tendrás que adaptarla en el examen según cuantas columnas haya.
function insertarGenerico($db, $sql, $params)
{
    try
    {
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        return $db->lastInsertId();
    }
    catch(PDOException $ex)
    {
        echo "Error insertando: ".$ex->getMessage();
        return false;
    }
}
?>