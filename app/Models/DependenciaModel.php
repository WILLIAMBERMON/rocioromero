<?php

namespace App\Models;
use CodeIgniter\Model;
use Config\Services;

class DependenciaModel extends Model
{

    public function get_dependencias(){
		if ($this->db) 
        {
            $query = $this->db->query("SELECT * FROM rr_dependencias ORDER BY 1 ASC");
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
    
    public function add_dependencias($nombre){
        if ($this->db) 
        {
            return $query = $this->db->query("INSERT INTO rr_dependencias(nombre) VALUES('{$nombre}')");
        }else{
            echo '<script>toastr.error("No hay conexión a la base de datos.");</script>';
        }
        return '';
    }

    public function update_dependencias($nombre,$id){
        if ($this->db) 
        {
            return $query = $this->db->query("UPDATE rr_dependencias SET nombre = '{$nombre}' WHERE id_dependencia = '{$id}'");
        }else{
            echo '<script>toastr.error("No hay conexión a la base de datos.");</script>';
        }
        return '';
    }

    public function delete_dependencias($id){
        if ($this->db) 
        {
            return $query = $this->db->query("DELETE FROM rr_dependencias WHERE id_dependencia = '{$id}'");
        }else{
            echo '<script>toastr.error("No hay conexión a la base de datos.");</script>';
        }
        return '';
    }

    public function add_documento($id,$documento){
        if ($this->db) 
        {
            return $query = $this->db->query("INSERT INTO rr_documentos_dependencia(id_dependencia, tipo_documento) VALUES('{$id}','{$documento}')");
        }else{
            echo '<script>toastr.error("No hay conexión a la base de datos.");</script>';
        }
        return '';
    }

    public function get_documentos(){
		if ($this->db) 
        {
            $query = $this->db->query("SELECT * FROM rr_documentos_dependencia ORDER BY 2,1 ASC");
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
    
    public function del_documento($id){
        if ($this->db) 
        {
            $this->db->query("DELETE FROM rr_documentos_expediente WHERE id_documento = '{$id}'");
            return $query = $this->db->query("DELETE FROM rr_documentos_dependencia WHERE id_documento = '{$id}'");
        }else{
            echo '<script>toastr.error("No hay conexión a la base de datos.");</script>';
        }
        return '';
    }
    
    public function update_documento($id,$nombre){
        if ($this->db) 
        {
            return $query = $this->db->query("UPDATE rr_documentos_dependencia SET tipo_documento = '{$nombre}' WHERE id_documento = '{$id}'");
        }else{
            echo '<script>toastr.error("No hay conexión a la base de datos.");</script>';
        }
        return '';
    }
    
    public function agregarpropietario($documento,$nombres,$email,$direccion,$celular,$estado){
        if ($this->db) 
        {
            $query = $this->db->query("SELECT * FROM rr_propietario where documento = '{$documento}'");
            if ($query->getResultArray())
            {
                $result = $query->getResultArray();
                return $result;
            }else{
                return $query = $this->db->query("INSERT INTO rr_propietario(documento,nombres,email,direccion,celular,estado) VALUES('{$documento}','{$nombres}','{$email}','{$direccion}','{$celular}','{$estado}')");
            }
        }else{
            echo '<script>toastr.error("No hay conexión a la base de datos.");</script>';
        }
        return '';
    }
    
    public function get_propietarios($documento = ''){
        if ($this->db) 
        {
            $query = $this->db->query("SELECT * FROM rr_propietario ".$documento." ORDER BY nombres ASC");
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

    public function get_arrendatarios($documento = ''){
        if ($this->db) 
        {
            $query = $this->db->query("SELECT * FROM rr_inquilino ".$documento." ORDER BY nombres ASC");
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

    public function agregararrendatario($documento,$nombres,$email,$direccion,$celular,$estado,$num_contrato){
        if ($this->db) 
        {//cedula,nombres,direccion,celular,num_contrato
            $query = $this->db->query("SELECT * FROM rr_inquilino where documento = '{$documento}'");
            if ($query->getResultArray())
            {
                $result = $query->getResultArray();
                return $result;
            }else{
                return $query = $this->db->query("INSERT INTO rr_inquilino(documento,nombres,email,direccion,celular,estado,num_contrato) VALUES('{$documento}','{$nombres}','{$email}','{$direccion}','{$celular}','{$estado}','{$num_contrato}')");
            }
        }else{
            echo '<script>toastr.error("No hay conexión a la base de datos.");</script>';
        }
        return '';
    }

    public function agregardocumento($id_documento, $complemento,$url,$contrato){
        if ($this->db) 
        {
            $es_imagen = ((string)$id_documento === '0' && strpos((string)$complemento, 'imagenes') === 0);
            if(!$es_imagen && !$url){
                return $this->db->query(
                    "UPDATE rr_documentos_expediente SET complemento = ? WHERE num_contrato = ? AND id_documento = ?",
                    [$complemento, $contrato, $id_documento]
                );
            }

            if(!$es_imagen){
                $this->db->query("delete from rr_documentos_expediente where num_contrato = ? and id_documento = ?", [$contrato, $id_documento]);
            }

            return $query = $this->db->query(
                "INSERT INTO rr_documentos_expediente(id_documento,complemento,url_documento,num_contrato) VALUES(?,?,?,?)",
                [$id_documento, $complemento, $url, $contrato]
            );
        }else{
            echo '<script>toastr.error("No hay conexión a la base de datos.");</script>';
        }
        return '';
    }

    public function eliminar_imagen_arriendo($contrato, $url)
    {
        if ($this->db) 
        {
            return $this->db->query(
                "DELETE FROM rr_documentos_expediente WHERE num_contrato = ? AND id_documento = '0' AND url_documento = ?",
                [$contrato, $url]
            );
        }else{
            echo '<script>toastr.error("No hay conexiÃ³n a la base de datos.");</script>';
        }
        return '';
    }

    public function agregarexpediente($num_contrato,$codigo,$fecha_inicio,$fecha_fin,$dependencia,$estado,$cliente){
        if ($this->db) 
        {
             $this->db->query("UPDATE rr_expediente set estado = 'cerrado' where dependencia = '{$dependencia}' and num_contrato = '{$num_contrato}'");
             return $query = $this->db->query("INSERT INTO rr_expediente(num_contrato,codigo,fecha_inicio,fecha_fin,dependencia,estado,cliente) VALUES('{$num_contrato}',(select codigo_pagina from rr_inmuebles where codinmueble = '{$codigo}'),{$fecha_inicio},{$fecha_fin},'{$dependencia}','{$estado}','{$cliente}')");
        }else{
            echo '<script>toastr.error("No hay conexión a la base de datos.");</script>';
        }
        return '';
    }

    public function agregarexpedientearriendo($num_contrato,$codigo,$fecha_inicio,$fecha_fin,$dependencia,$estado,$cliente){
        if ($this->db) 
        {
             $this->db->query("UPDATE rr_expediente set estado = 'cerrado' where dependencia = '{$dependencia}' and num_contrato = '{$codigo}'");
             return $query = $this->db->query("INSERT INTO rr_expediente(num_contrato,codigo,fecha_inicio,fecha_fin,dependencia,estado,cliente) VALUES('{$codigo}','{$num_contrato}',{$fecha_inicio},{$fecha_fin},'{$dependencia}','{$estado}','{$cliente}')");
        }else{
            echo '<script>toastr.error("No hay conexión a la base de datos.");</script>';
        }
        return '';
    }

    public function elimiarexpediente($num_contrato,$depen = '11'){
        if ($this->db) 
        {
            $this->db->query("delete from rr_documentos_expediente where num_contrato = '{$num_contrato}' and id_documento in (select id_documento from rr_documentos_dependencia where id_dependencia = '{$depen}')");
             return $this->db->query("delete from rr_expediente where num_contrato = '{$num_contrato}' and dependencia = '{$depen}'");
        }else{
            echo '<script>toastr.error("No hay conexión a la base de datos.");</script>';
        }
        return '';
    }

    public function actualizarcompraventa($id_compraventa,$consecutivo,$nombres){
        if ($this->db) 
        {
             return $this->db->query("UPDATE rr_compraventa consecutivo set comprador = '{$nombres}',consecutivo = '{$consecutivo}' where id_compraventa = '{$id_compraventa}'");
        }else{
            echo '<script>toastr.error("No hay conexión a la base de datos.");</script>';
        }
        return '';
    }

    public function deletecompraventa($id_compraventa){
        if ($this->db) 
        {
            
            $this->db->query("UPDATE rr_expediente set estado = 'abierto' where CAST(num_contrato as text) in (select CAST(codinmueble as text) from rr_compraventa where id_compraventa = '{$id_compraventa}')");
             return $this->db->query("delete from rr_compraventa where id_compraventa = '{$id_compraventa}'");
        }else{
            echo '<script>toastr.error("No hay conexión a la base de datos.");</script>';
        }
        return '';
    }
    
    

    public function tipos_cliente(){
        if ($this->db) 
        {
            $query = $this->db->query("SELECT * FROM rr_tipo_cliente ORDER BY id ASC");
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

    public function expedientes($tipo){
        if ($this->db) 
        {
            $query = $this->db->query("SELECT e.*,(select p.nombres from rr_propietario p where p.documento = e.cliente) nombre_cliente,(select p.nombre from rr_dependencias p where p.id_dependencia = e.dependencia) nombre_dependencia FROM rr_expediente e ".(($tipo)?(" where e.dependencia = '{$tipo}' "):"")." ORDER BY e.fecha DESC");
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

    public function ensureCodigoInactivadoColumn()
    {
        if ($this->db) 
        {
            try {
                $campos = $this->db->getFieldNames('rr_expediente');
                if(!in_array('codigo_inactivado', $campos)){
                    $this->db->query("ALTER TABLE rr_expediente ADD COLUMN codigo_inactivado VARCHAR(100)");
                }
                return true;
            } catch (\Throwable $e) {
                return false;
            }
        }
        return false;
    }

    public function expedientes_compra($tipo,$estado = 'abierto'){
        if ($this->db) 
        {
            $query = $this->db->query("SELECT e.*,(select p.nombres from rr_propietario p where p.documento = e.cliente) nombre_cliente,
            (select p.nombre from rr_dependencias p where p.id_dependencia = e.dependencia) nombre_dependencia,i.nompropietario, i.direccion,i.ciudad,i.barrio, i.codigo_pagina
            FROM rr_expediente e, rr_inmuebles i where e.num_contrato = i.codinmueble and e.estado = '{$estado}' and e.dependencia = '{$tipo}' ORDER BY e.fecha DESC");
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

    public function actualizarexpediente($num_contrato,$codigo,$fecha_inicio,$fecha_fin,$dependencia,$estado,$cliente,$contrato_arriendo = '', $codigo_inactivado = null){
        if ($this->db) 
        {
                $codigo_inactivado_sql = '';
                if($codigo_inactivado !== null){
                    if(!$this->ensureCodigoInactivadoColumn()){
                        return false;
                    }
                    $codigo_inactivado_sql = ", codigo_inactivado = ".(($codigo_inactivado !== '') ? $this->db->escape($codigo_inactivado) : 'null');
                }

                return $query = $this->db->query("UPDATE rr_expediente set codigo='{$codigo}',fecha_inicio={$fecha_inicio},fecha_fin={$fecha_fin},dependencia='{$dependencia}',estado='{$estado}',cliente='{$cliente}'".(($contrato_arriendo)?(", contrato_arriendo = '{$contrato_arriendo}'"):'').$codigo_inactivado_sql." WHERE num_contrato = '{$num_contrato}'");
        }else{
            echo '<script>toastr.error("No hay conexión a la base de datos.");</script>';
        }
        return '';
    }
   
    
    public function updatepropietario($documento,$nombres,$email,$direccion,$celular,$estado){
        if ($this->db) 
        {
            return $query = $this->db->query("UPDATE rr_propietario SET nombres='{$nombres}',email='{$email}',direccion='{$direccion}',celular='{$celular}',estado='{$estado}' WHERE documento = '{$documento}'");
        }else{
            echo '<script>toastr.error("No hay conexión a la base de datos.");</script>';
        }
        return '';
    }

    public function updatearrendatario($documento,$nombres,$email,$direccion,$celular,$estado,$num_contrato,$id){
        if ($this->db) 
        {
            return $query = $this->db->query("UPDATE rr_inquilino SET nombres='{$nombres}',email='{$email}',direccion='{$direccion}',celular='{$celular}',estado='{$estado}',num_contrato='{$num_contrato}',documento='{$documento}' WHERE id_inquilino = '{$id}'");
        }else{
            echo '<script>toastr.error("No hay conexión a la base de datos.");</script>';
        }
        return '';
    }

    
    public function get_documentos_depen($tipo,$num_contrato = ''){
        //echo "SELECT r.* ".(($num_contrato)?(",(select concat(e.url_documento,'*w*',e.complemento) from rr_documentos_expediente e where e.num_contrato = '{$num_contrato}' and e.id_documento = r.id_documento) url_documento"):"")." FROM rr_documentos_dependencia r WHERE r.id_dependencia = '{$tipo}' ORDER BY 2,1 ASC";exit;
		if ($this->db) 
        {
            $query = $this->db->query("SELECT r.* ".(($num_contrato)?(",(select concat(e.url_documento,'*w*',e.complemento) from rr_documentos_expediente e where e.num_contrato = '{$num_contrato}' and e.id_documento = r.id_documento) url_documento"):"")." FROM rr_documentos_dependencia r WHERE r.id_dependencia = '{$tipo}' ORDER BY 2,1 ASC");
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

    public function documentos_cargados($num_contrato, $tipo = 'imagenes'){
        if ($this->db) 
        {
            $query = $this->db->query(
                "select * from rr_documentos_expediente where num_contrato = ? and complemento like ? order by fecha desc",
                [$num_contrato, $tipo.'%']
            );
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

    public function get_inmuebles($estado = '1',$tipo_actividad="'ARRIENDO','VENTA'",$add="",$tipo = '11'){
        if ($this->db) 
        {
            $query = $this->db->query("select * from rr_inmuebles where estado = '{$estado}' and tipo_actividad in ({$tipo_actividad}) ".(($add)?(" and codinmueble not in (select num_contrato from rr_expediente where dependencia = '{$tipo}') "):'')." order by codinmueble");
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

    public function tipo_inmuebles(){
        if ($this->db) 
        {
            $query = $this->db->query("select * from rr_tipo_inmueble order by nombre asc");
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

    public function tipo_actividad(){
        if ($this->db) 
        {
            $query = $this->db->query("select * from rr_tipo_actividad order by nombre asc");
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

    public function addinmuebles($codinmueble,$direccion,$barrio,$ciudad,$nompropietario,$tipo,$tipo_inmueble,$tipo_actividad,$estado,$codigo_pagina){
        if ($this->db) 
        {
                if($tipo == 'nuevo'){
                    return $query = $this->db->query("insert into rr_inmuebles(codigo_pagina,nompropietario,direccion,ciudad,barrio,tipo_inmueble,tipo_actividad,estado) values ('{$codigo_pagina}','{$nompropietario}','{$direccion}','{$ciudad}','{$barrio}','{$tipo_inmueble}','{$tipo_actividad}','{$estado}')");
                }else{
                    return $query = $this->db->query("UPDATE rr_inmuebles set nompropietario='{$nompropietario}',direccion='{$direccion}',ciudad='{$ciudad}',barrio='{$barrio}',tipo_inmueble='{$tipo_inmueble}',tipo_actividad='{$tipo_actividad}',estado='{$estado}',codigo_pagina='{$codigo_pagina}' WHERE codinmueble = '{$codinmueble}'");
                }
                
        }else{
            echo '<script>toastr.error("No hay conexión a la base de datos.");</script>';
        }
        return '';
    }

    public function agregaravaluo($codigo,$nombres,$direccion,$tipo_inmueble,$ano,$estado,$id_avaluo='',$tipo='nuevo'){
        if ($this->db) 
        {
                if($tipo == 'nuevo'){
                    return $query = $this->db->query("insert into rr_avaluo(codigo_pagina, nombres,direccion,tipo_inmueble,ano) values ('{$codigo}','{$nombres}','{$direccion}','{$tipo_inmueble}','{$ano}')");
                }else{
                    return $query = $this->db->query("UPDATE rr_avaluo set nombres='{$nombres}',direccion='{$direccion}',codigo_pagina='{$codigo}',ano='{$ano}',tipo_inmueble='{$tipo_inmueble}',estado='{$estado}' WHERE id_avaluo = '{$id_avaluo}'");
                }
                
        }else{
            echo '<script>toastr.error("No hay conexión a la base de datos.");</script>';
        }
        return '';
    }
    

    public function avaluos(){
        if ($this->db) 
        {
            $query = $this->db->query("select * from rr_avaluo order by id_avaluo desc");
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

    public function agregarcompraventa($codigo,$nombres,$direccion,$tipo_inmueble,$ano,$estado,$id_avaluo='',$tipo='nuevo'){
        if ($this->db) 
        {
                if($tipo == 'nuevo'){
                    return $query = $this->db->query("insert into rr_avaluo(codigo_pagina, nombres,direccion,tipo_inmueble,ano) values ('{$codigo}','{$nombres}','{$direccion}','{$tipo_inmueble}','{$ano}')");
                }else{
                    return $query = $this->db->query("UPDATE rr_avaluo set nombres='{$nombres}',direccion='{$direccion}',codigo_pagina='{$codigo}',ano='{$ano}',tipo_inmueble='{$tipo_inmueble}',estado='{$estado}' WHERE id_avaluo = '{$id_avaluo}'");
                }
                
        }else{
            echo '<script>toastr.error("No hay conexión a la base de datos.");</script>';
        }
        return '';
    }

    public function add_compraventa($consecutivo, $vendedor,$comprador, $direccion,$codinmueble){
        if ($this->db){
                    return $query = $this->db->query("insert into rr_compraventa(consecutivo, vendedor,comprador, direccion,codinmueble) values ('{$consecutivo}','{$vendedor}','{$comprador}','{$direccion}','{$codinmueble}')");
        }else{
            echo '<script>toastr.error("No hay conexión a la base de datos.");</script>';
        }
        return '';
    }
    
    

    public function compraventa(){
        if ($this->db) 
        {
            $query = $this->db->query("select * from rr_compraventa order by id_compraventa desc");
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
