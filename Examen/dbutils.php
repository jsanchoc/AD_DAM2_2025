<?php
function conectarDB()
{
    try
    {
        $nombre_base_datos = "LaSetaNegra";
        
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


function getIDAtraccionPorNombre($db, $nombre) {
    try {
        $sql = "SELECT ID FROM ATRACCION WHERE NOMBRE = :nom";
        $stmt = $db->prepare($sql);
        $stmt->execute(array(':nom' => $nombre));
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($fila) {
            return $fila['ID'];
        } else {
            return false; 
        }
    } catch (PDOException $e) {
        return false;
    }
}

function insertarAtraccion($db, $nombre, $tipo, $altura) {
    try {
        $sql = "INSERT INTO ATRACCION (NOMBRE, TIPO, ALTURA_MINIMA) VALUES (:n, :t, :a)";
        $stmt = $db->prepare($sql);
        $stmt->execute(array(':n' => $nombre, ':t' => $tipo, ':a' => $altura));
        return $db->lastInsertId();
    } catch (PDOException $e) {
        echo "Error insertando atracción: " . $e->getMessage();
        return false;
    }
}


function getIDEmpleadoPorDNI($db, $dni) {
    try {
        $sql = "SELECT ID FROM EMPLEADO WHERE DNI = :d";
        $stmt = $db->prepare($sql);
        $stmt->execute(array(':d' => $dni));
        $fila = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($fila) {
            return $fila['ID'];
        } else {
            return false;
        }
    } catch (PDOException $e) {
        return false;
    }
}

function insertarEmpleado($db, $nombre, $dni) {
    try {
        $sql = "INSERT INTO EMPLEADO (NOMBRE, DNI) VALUES (:n, :d)";
        $stmt = $db->prepare($sql);
        $stmt->execute(array(':n' => $nombre, ':d' => $dni));
        return $db->lastInsertId();
    } catch (PDOException $e) {
        echo "Error insertando empleado: " . $e->getMessage();
        return false;
    }
}


function insertarTurno($db, $idAtraccion, $idEmpleado, $horario) {
    try {
        $sql = "INSERT INTO TURNO_asignado (ID_ATRACCION, ID_EMPLEADO, HORARIO) VALUES (:ida, :ide, :h)";
        $stmt = $db->prepare($sql);
        $stmt->execute(array(
            ':ida' => $idAtraccion,
            ':ide' => $idEmpleado,
            ':h'   => $horario
        ));
        return true;
    } catch (PDOException $e) {
        echo "Error insertando turno: " . $e->getMessage();
        return false;
    }
}


function getDatosCombinados($db) {
    $lista = array();
    try {
        
        $sql = "SELECT 
                    A.NOMBRE as ATR_NOMBRE, 
                    A.TIPO, 
                    A.ALTURA_MINIMA, 
                    E.NOMBRE as EMP_NOMBRE, 
                    E.DNI, 
                    T.HORARIO 
                FROM TURNO_ASIGNADO T 
                INNER JOIN ATRACCION A ON T.id_atraccion = A.id_atraccion 
                INNER JOIN EMPLEADO E ON T.id_empleado = E.id_empleado";

        $stmt = $db->query($sql);
        $lista = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
    } catch (PDOException $e) {
        echo "<h1>ERROR SQL: " . $e->getMessage() . "</h1>";
    }
    return $lista;
}













