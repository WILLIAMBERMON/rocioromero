<?php

namespace App\Models;
use CodeIgniter\Model;
use Config\Services;

class RadicadosModel extends Model
{
    public function get_dependencias(){
        $query = $this->dbo->query("SELECT * FROM PQRS.DEPENDENCIAS ORDER BY NOMDEPEN ASC");
       if ($query->getResultArray())
       {
           $result = $query->getResultArray();
           return $result;
       }
       return '';
    }

    public function get_radicados(){
        $query = $this->db->query("SELECT r.id, r.anonima, r.tipo_documento, r.documento, r.codigo, r.nombres, r.apellidos, r.celular ,r.email , r.respuesta, r.descripcion,
                                   r.url_soporte, r.estado, r.dependencia, r.fecha_solicitud, r.fecha_respuesta, r.url_respuesta , (tp.descripcion) tipo_pqrs  
                                   FROM radicado r, tipo_pqrsd tp WHERE r.tipo_pqrsd = tp.tipo_pqrsd ORDER BY r.id ASC ");
       if ($query->getResultArray())
       {
           $result = $query->getResultArray();
           return $result;
       }
       return '';
    }

    public function get_sub_dependencias($depen){
        $query = $this->dbo->query("SELECT CODSUBDEPEN, NOMDEPEN FROM PERSONAL.DEPENDENCIAS WHERE CODDEPEN = '{$depen}' AND CODSECCION = '00' AND CODSUBSECCION='00'");
       if ($query->getResultArray())
       {
           $result = $query->getResultArray();
           return $result;
       }
       return '';
    }

    public function get_secciones($depen,$subdepen){
        $query = $this->dbo->query("SELECT CODSECCION, NOMDEPEN FROM PERSONAL.DEPENDENCIAS WHERE CODDEPEN = '{$depen}' AND CODSUBDEPEN = '{$subdepen}' AND CODSUBSECCION='00'");
       if ($query->getResultArray())
       {
           $result = $query->getResultArray();
           return $result;
       }
       return '';
    }

    public function get_sub_secciones($depen,$subdepen,$seccion){
        $query = $this->dbo->query("SELECT CODSUBSECCION, NOMDEPEN FROM PERSONAL.DEPENDENCIAS WHERE CODDEPEN = '{$depen}' AND CODSUBDEPEN = '{$subdepen}' AND CODSECCION='{$seccion}'");
       if ($query->getResultArray())
       {
           $result = $query->getResultArray();
           return $result;
       }
       return '';
    }

    public function dependencias_ugad(){
        $query = $this->dbo->query("SELECT * FROM PQRS.DEPENDENCIAS_UGAD order by N ASC");;
        if ($query->getResultArray())
        {
            $result = $query->getResultArray();
            return $result;
        }
        return '';
    }

    public function asignar_dependencia($id,$dependencia){

        return $this->db->query("UPDATE radicado SET dependencia = '{$dependencia}' WHERE id = '{$id}'");

          
    }

    public function get_radicados_dependencia($dependencia){
        $query = $this->db->query("SELECT r.id, r.anonima, r.tipo_documento, r.documento, r.codigo, r.nombres, r.apellidos, r.celular ,r.email , r.respuesta, r.descripcion,
                                   r.url_soporte, r.estado, r.dependencia, r.fecha_solicitud, r.fecha_respuesta, r.url_respuesta , (tp.descripcion) tipo_pqrs  
                                   FROM radicado r, tipo_pqrsd tp WHERE r.tipo_pqrsd = tp.tipo_pqrsd AND r.dependencia = '{$dependencia}' ORDER BY r.id ASC ");
       if ($query->getResultArray())
       {
           $result = $query->getResultArray();
           return $result;
       }
       return '';
    }

    public function get_funcionarios_dependencia($dependencia){
        $query = $this->dbo->query("SELECT DISTINCT NOMBRES, CODIGO, EMAILI, CEDULA FROM PERSONAL.FUNCIONARIOS_ACTIVOS_PRO WHERE LUGAR = '{$dependencia}' ORDER BY NOMBRES");
       if ($query->getResultArray())
       {
           $result = $query->getResultArray();
           return $result;
       }
       return '';
    }

    public function get_dependencia_funcionario($codigo){
        $query = $this->dbo->query("SELECT * FROM PQRS.DEPENDENCIAS WHERE CODIGODEPEN = '{$codigo}'");
        
       if ($query->getResultArray())
       {
           $result = $query->getResultArray();
           return $result;
       }
       return '';
    }

    public function asignar_responsable($sql){
        return $this->dbo->query($sql);

          
    }

    public function get_responsables(){
       $query = $this->dbo->query("SELECT FA.NOMBRES, RE.ENCARGADO ,RE.ID_RADICADO FROM PERSONAL.FUNCIONARIOS_ACTIVOS_PRO FA , PQRS.RADICADO_ENCARGADO RE WHERE FA.CEDULA = RE.ENCARGADO");
        
       if ($query->getResultArray())
       {
           $result = $query->getResultArray();
           return $result;
       }
       return '';
    }

    public function get_responsables_radicado($radicado){
        $query = $this->dbo->query("SELECT FA.NOMBRES, RE.ENCARGADO ,RE.ID_RADICADO FROM PERSONAL.FUNCIONARIOS_ACTIVOS_PRO FA , PQRS.RADICADO_ENCARGADO RE WHERE FA.CEDULA = RE.ENCARGADO AND RE.ID_RADICADO = '{$radicado}' ");
         
        if ($query->getResultArray())
        {
            $result = $query->getResultArray();
            return $result;
        }
        return '';
     }

     public function get_responsables_radicadow($radicado, $documento){
        $query = $this->dbo->query("SELECT * FROM  PQRS.RADICADO_ENCARGADO  WHERE ENCARGADO = '{$documento}' AND ID_RADICADO in ({$radicado}) ");
         
        if ($query->getResultArray())
        {
            $result = $query->getResultArray();
            return $result;
        }
        return '';
     }

     public function delete_responsable($radicado, $encargado){
        $this->dbo->query("DELETE FROM RADICADO_ENCARGADO WHERE ID_RADICADO = '{$radicado}' AND ENCARGADO = '{$encargado}'");

     }

     public function get_radicados_encargado($documento){
        $query = $this->dbo->query("SELECT * FROM RADICADO_ENCARGADO WHERE ENCARGADO = '{$documento}' ");
         
        if ($query->getResultArray())
        {
            $result = $query->getResultArray();
            return $result;
        }
        return '';
     }

     public function get_info_radicados_encargado($ids){
        $query = $this->db->query("SELECT DISTINCT r.id, r.anonima, r.tipo_documento, r.documento, r.codigo, r.nombres, r.apellidos, r.celular ,r.email , r.respuesta, r.descripcion,
        r.url_soporte, r.estado, r.dependencia, r.fecha_solicitud, r.fecha_respuesta, r.url_respuesta , (tp.descripcion) tipo_pqrs  
        FROM radicado r, tipo_pqrsd tp WHERE r.tipo_pqrsd = tp.tipo_pqrsd AND r.id in (".$ids.") ORDER BY r.id ASC");
         
        if ($query->getResultArray())
        {
            $result = $query->getResultArray();
            return $result;
        }
        return '';
     }

     public function get_info_radicado($id,$documento){
        $query = $this->dbo->query("SELECT * FROM RADICADO_ENCARGADO WHERE ID_RADICADO = '{$id}' AND ENCARGADO = '{$documento}' ");
        if ($query->getResultArray())
        {
            $result = $query->getResultArray();
            return $result;
        }
        return '';
     }

     public function responder_radicado($sql){
        return $this->dbo->query($sql);
     }

     public function guardar_url_respuesta($id,$url_respuesta){
        return $this->db->query("UPDATE radicado SET url_respuesta = '{$url_respuesta}' WHERE id = '{$id}'");
     }

     public function get_info_radicados_dependencia($id){
        $query = $this->dbo->query("SELECT RE.*, FA.NOMBRES FROM PQRS.RADICADO_ENCARGADO RE, PERSONAL.FUNCIONARIOS_ACTIVOS_PRO FA WHERE RE.ID_RADICADO = '{$id}' AND RE.ENCARGADO = FA.CEDULA ORDER BY FA.NOMBRES ASC");
         
        if ($query->getResultArray())
        {
            $result = $query->getResultArray();
            //echo var_dump($result);exit;
            return $result;
        }
        return '';
     }

     public function get_fecha_maxima($radicado){
        $query = $this->dbo->query("SELECT DISTINCT TO_CHAR(FECHA_MAXIMA,'YYYY-MM-DD') FECHA_MAXIMA FROM PQRS.RADICADO_ENCARGADO WHERE ID_RADICADO = '{$radicado}' ");
        if ($query->getResultArray())
        {
            $result = $query->getResultArray();
            //echo var_dump($result);exit;
            return $result;
        }
        return '';
     }

     public function actualizar_radicado($sql){
        $res = $this->db->query($sql);
         
        if($res){
            return true; 
        }
        
     }

     public function finalizar_radicado($sql,$sql2){
        $res1 = $this->db->query($sql);
        $res2 = $this->dbo->query($sql2);  
        if($res1 == $res2){
            return true; 
        }
        
     }

     public function get_soportes($id){
        $query = $this->db->query("SELECT url_respuesta FROM radicado WHERE  id= '{$id}'");
        if ($query->getResultArray())
        {
            $result = $query->getResultArray();
            return $result;
        }
        return '';

     }


    
}