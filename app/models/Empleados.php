<?php

namespace App\Models;

require('Model.php');

class Empleados extends Model
{
    public function obtenerEmpleados()
    {
        $query = "SELECT  e.id , CONCAT(e.nombre1, ' ', e.nombre2) AS Nombres, CONCAT(e.apellido1, ' ', e.apellido2) AS Apellidos, e.identificacion, e.tipo_contrato, e.correo_personal , e2.nombre_empresa AS Empresa, s.nombre AS Sede, c.nombre_cargos AS Cargo from empleados e
        INNER JOIN empresas e2 ON e.empresa = e2.id_empresa
        INNER JOIN sede s ON e.sede = s.id
        INNER JOIN cargos c on e.cargo = c.id_cargos 
        WHERE e.estado != 0
        ORDER BY e.id DESC";

        return  self::$connection->query($query)->fetch_all(MYSQLI_ASSOC);
    }
}