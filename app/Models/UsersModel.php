<?php

namespace App\Models;
use CodeIgniter\Model;
use Config\Services;

class UsersModel extends Model
{

       public function registrarse($tipo_documento,$documento,$nombres,$apellidos,$celular,$email,$clave,$token){
        if ($this->db) 
        {
            return $query = $this->db->query("insert into rr_usuario(documento,tipo_documento,nombres,apellidos,email,celular,clave,token) VALUES('{$documento}','{$tipo_documento}','{$nombres}','{$apellidos}','{$email}','{$celular}','{$clave}','{$token}')");
        }else{
            echo '<script>toastr.error("No hay conexión a la base de datos.");</script>';
        }
        return '';
    }

    public function activar_usuario($token){
        if ($this->db) 
        {
            return $query = $this->db->query("update rr_usuario set activo = '1',token = '' where token = '{$token}' ");
        }else{
            echo '<script>toastr.error("No hay conexión a la base de datos.");</script>';
        }
        return '';
    }

    public function updateregistro($tipo_documento,$documento,$nombres,$apellidos,$celular,$email,$clave,$token){
        if ($this->db) 
        {
            return $query = $this->db->query("update rr_usuario set tipo_documento='{$tipo_documento}',nombres='{$nombres}',apellidos='{$apellidos}',email='{$email}',celular='{$celular}' ".(($token)?" ,activo='0',clave='',token='{$token}' ":"")." where documento = '{$documento}' ");
        }else{
            echo '<script>toastr.error("No hay conexión a la base de datos.");</script>';
        }
        return '';
    }

    public function usuario($documento =''){
		if ($this->db) 
        {
            $query = $this->db->query("select * from rr_usuario ".(($documento)? "where documento = '{$documento}'" : ""));
            if ($query->getResultArray())
        {
            $result = $query->getResultArray();
            return $result;
        }
        }else{
            echo '<script>toastr.error("No hay conexión a la base de datos.");</script>';
        }
       return '';
    }
    
   
}