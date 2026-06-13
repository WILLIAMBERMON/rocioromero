<?php

namespace App\Models;

use CodeIgniter\Model;
use Config\Services;

class IndexModel extends Model
{

    /* public function buscarinfo($codigo){

       $query = $this->dbo->query("SELECT * FROM sia.datos_alu WHERE cod_carrera||cod_alumno = '{$codigo}'");
       if ($query->getResultArray())
       {
           $result = $query->getResultArray();
           return $result;
       }
       return '';
    }*/

    public function radicarpqrsd($sql)
    {
        if ($this->db) {
            return $this->db->query($sql);
        } else {
            echo '<script>toastr.error("No hay conexión a la base de datos.");</script>';
        }

        return '';
    }

    public function registrarse($tipo_documento, $documento, $nombres, $apellidos, $celular, $email, $clave, $token)
    {
        if ($this->db) {
            return $this->db->query("
                INSERT INTO rr_usuario
                (
                    documento,
                    tipo_documento,
                    nombres,
                    apellidos,
                    email,
                    celular,
                    clave,
                    token
                )
                VALUES
                (
                    '{$documento}',
                    '{$tipo_documento}',
                    '{$nombres}',
                    '{$apellidos}',
                    '{$email}',
                    '{$celular}',
                    '{$clave}',
                    '{$token}'
                )
            ");
        } else {
            echo '<script>toastr.error("No hay conexión a la base de datos.");</script>';
        }

        return '';
    }

    public function activar_usuario($token)
    {
        if ($this->db) {
            return $this->db->query("
                UPDATE rr_usuario
                SET
                    activo = '1',
                    token = ''
                WHERE token = '{$token}'
            ");
        } else {
            echo '<script>toastr.error("No hay conexión a la base de datos.");</script>';
        }

        return '';
    }

    public function usuario($documento)
    {
        if ($this->db) {
            $query = $this->db->query("
                SELECT *
                FROM rr_usuario
                WHERE documento = ?
            ", [$documento]);

            if ($query->getResultArray()) {
                return $query->getResultArray();
            }
            
        } else {
            echo '<script>toastr.error("No hay conexión a la base de datos.");</script>';
        }

        return '';
    }

    public function info_usuario($token)
    {
        if ($this->db) {

            $query = $this->db->query("
                SELECT *
                FROM rr_usuario
                WHERE token = '{$token}'
            ");

            if ($query->getResultArray()) {
                return $query->getResultArray();
            }
        } else {
            echo '<script>toastr.error("No hay conexión a la base de datos.");</script>';
        }

        return '';
    }

    public function updateregistro($clave, $token)
    {
        if ($this->db) {

            return $this->db->query("
                UPDATE rr_usuario
                SET
                    clave = '{$clave}',
                    activo = '1',
                    token = ''
                WHERE token = '{$token}'
            ");
        } else {
            echo '<script>toastr.error("No hay conexión a la base de datos.");</script>';
        }

        return '';
    }

    public function radicado($token)
    {
        if ($this->db) {

            $query = $this->db->query("
                SELECT
                    r.*,
                    t.descripcion AS desc_pqrsd,
                    TO_CHAR(r.fecha_solicitud, 'dd-mm-yyyy HH12:MI') AS fecha_sol
                FROM radicado r,
                     tipo_pqrsd t
                WHERE r.tipo_pqrsd = t.tipo_pqrsd
                AND r.token = '{$token}'
            ");

            if ($query->getResultArray()) {
                return $query->getResultArray();
            }
        } else {
            echo '<script>toastr.error("No hay conexión a la base de datos.");</script>';
        }

        return '';
    }

    public function get_radicados_persona($documento)
    {
        if ($this->db) {

            $query = $this->db->query("
                SELECT
                    r.*,
                    t.descripcion AS tipopqrs
                FROM radicado r,
                     tipo_pqrsd t
                WHERE r.tipo_pqrsd = t.tipo_pqrsd
                AND r.documento = '{$documento}'
                ORDER BY id DESC
            ");

            if ($query->getResultArray()) {
                return $query->getResultArray();
            }
        } else {
            echo '<script>toastr.error("No hay conexión a la base de datos.");</script>';
        }

        return '';
    }

    public function verificarradicado($token, $anonomia = 'SI')
    {
        if ($this->db) {

            $query = $this->db->query("
                SELECT
                    r.*,
                    t.descripcion AS tipo_desc
                FROM radicado r,
                     tipo_pqrsd t
                WHERE r.tipo_pqrsd = t.tipo_pqrsd
                AND r.token = '{$token}'
                AND r.anonima = '{$anonomia}'
            ");

            if ($query->getResultArray()) {
                return $query->getResultArray();
            }
        } else {
            echo '<script>toastr.error("No hay conexión a la base de datos.");</script>';
        }

        return '';
    }

    /* public function buscardependencia($documento){

        $query = $this->dbo->query("
            SELECT *
            FROM pqrs.dependencias
            WHERE documento = '{$documento}'
        ");

        if ($query->getResultArray())
        {
            $result = $query->getResultArray();
            return $result;
        }

        return '';
    }*/
}
