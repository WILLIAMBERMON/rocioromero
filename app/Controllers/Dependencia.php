<?php

namespace App\Controllers;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\Files\Exceptions\FileNotFoundException;
use App\Models\DependenciaModel;
use CodeIgniter\Files\File;



class Dependencia extends BaseController
{
    public function index(){
        if(!$this->template->get_session('usuario_pqrsd')){
            return $this->response->redirect('login');
        }

        $dependencias = new DependenciaModel();
        if ($this->request->getMethod() === 'post') {
			$post = $this->request->getPost();
            
            if(isset($post['crear'])){
                if ((($post['crear']) == '1') && ($post['descripcion'])){
                    $add_dependencias = $dependencias->add_dependencias($post['descripcion']);
                    if(isset($add_dependencias) && $add_dependencias){
                        $this->template->add_messages('success','Dependencia '.$post['descripcion'].', fue creada con éxito.'); 
                    }else{
                        $this->template->add_messages('error','Algo salio mal al tratar de crear la dependencia, por favor vuelva a intentarlo nuevamente.'); 
                    }
                }
            }
            
            if (isset($post['actualizar'])){
                if((($post['actualizar']) == '1') && ($post['descripcion']) && ($post['guardar'])){
                    $update_dependencias = $dependencias->update_dependencias($post['descripcion'],$post['guardar']);
                    if(isset($update_dependencias) && $update_dependencias){
                        $this->template->add_messages('success','Dependencia '.$post['descripcion'].', fue actualizada con éxito.'); 
                    }else{
                        $this->template->add_messages('error','Algo salio mal al tratar de actualizar la dependencia, por favor vuelva a intentarlo nuevamente.'); 
                    }
                }
            }

            if (isset($post['eliminar'])){
                if((($post['eliminar']) == '1') && ($post['elimina']) && ($post['des'])){
                    $delete_dependencias = $dependencias->delete_dependencias($post['elimina']);
                    if(isset($delete_dependencias) && $delete_dependencias){
                        $this->template->add_messages('success','Dependencia '.$post['des'].', fue eliminada con éxito.'); 
                    }else{
                        $this->template->add_messages('error','Algo salio mal al tratar de eliminar la dependencia, por favor vuelva a intentarlo nuevamente.'); 
                    }
                }
            }
            if (isset($post['add_document'])){
                if((($post['add_document']) == '1') && ($post['agregardoc']) && ($post['des'])){
                    $documento_eliminado = '';
                    if(isset($post['documento_eliminar'])){
                        $documento_eliminado = $post['documento_eliminar'];
                        $documento_nombre = isset($post['documento_eliminar_descripcion']) && $post['documento_eliminar_descripcion'] ? $post['documento_eliminar_descripcion'] : $documento_eliminado;
                        $delete_documento = $dependencias->del_documento($documento_eliminado);
                        if(isset($delete_documento) && $delete_documento){
                            $this->template->add_messages('success','Documento '.$documento_nombre.' eliminado con éxito.'); 
                        }else{
                            $this->template->add_messages('error','Algo salio mal al tratar de eliminar el documento '.$documento_nombre.', por favor vuelva a intentarlo nuevamente.'); 
                        }
                    }

                    if(isset($post['cambiar_doc']) && $post['cambiar_doc']){
                        $docum = explode(',',$post['cambiar_doc']);
                        foreach($docum as $docc){
                            if($documento_eliminado && $docc == $documento_eliminado){
                                continue;
                            }
                            $noelimino = true;
                            if(isset($post['del'.$docc]) && $post['del'.$docc]){
                                if($post['del'.$docc] == 'SI'){
                                    $noelimino = false;
                                    $documento_nombre = isset($post['doc_cambio'.$docc]) ? $post['doc_cambio'.$docc] : $docc;
                                    $delete_documento = $dependencias->del_documento($docc);
                                    if(isset($delete_documento) && $delete_documento){
                                        $this->template->add_messages('success','Documento '.$documento_nombre.' eliminado con éxito.'); 
                                    }else{
                                        $this->template->add_messages('error','Algo salio mal al tratar de eliminar el documento '.$documento_nombre.', por favor vuelva a intentarlo nuevamente.'); 
                                    }
                                }
                            }
                            if($noelimino){
                                if(isset($post['doc_cambio'.$docc]) && $post['doc_cambio'.$docc]){
                                        $dependencias->update_documento($docc,$post['doc_cambio'.$docc]);
                                }   
                            }
                        }
                    }    
                    if(isset($post['documento']) && $post['documento']){
                        $add_documento = $dependencias->add_documento($post['agregardoc'],$post['documento']);
                        if(isset($add_documento) && $add_documento){
                            $this->template->add_messages('success','Documnento '.$post['documento'].' agregado a la dependencia '.$post['des'].' con éxito.'); 
                        }else{
                            $this->template->add_messages('error','Algo salio mal al tratar de agregar el documento a la dependencia, por favor vuelva a intentarlo nuevamente.'); 
                        }
                    }
                }
            }
            
        }
        
        $get_dependencias = $dependencias->get_dependencias();
        $this->template->add_data('dependencias',$get_dependencias);   

        $get_documentos = $dependencias->get_documentos();
        $this->template->add_data('documentos',$get_documentos);  
        
        $this->template->active_sidebar('dependencias');
        $this->template->title_page('Dependencias');
        return $this->template->renderview('dependencias/index','1');
    }


    public function expediente(){
        if(!$this->template->get_session('usuario_pqrsd')){
            return $this->response->redirect('login');
        }

        $dependencias = new DependenciaModel();
        if ($this->request->getMethod() === 'post') {
            $post = $this->request->getPost();
            if(isset($post['actualizar'])){
                if ((($post['actualizar']) == '1') && ($post['contrato']) && ($post['dependencia']) && ($post['estado'])){
                    $finicio = ($post['finicio'])?("'".$post['finicio']."'"):'null'; $ffin = ($post['ffin'])?("'".$post['ffin']."'"):'null';
                    $cliente ='';
                    if(isset($post['clienter'])){
                    $cliente = explode(',',$post['clienter']);
                    $cliente = $cliente[0];}
                    
                    $actualizar = $dependencias->actualizarexpediente($post['contrato'],$post['contrato'],$finicio,$ffin,$post['dependencia'],$post['estado'],$cliente);

                    if(isset($actualizar) && $actualizar){
                        $this->template->add_messages('success','EL Expediente '.$post['contrato'].' se actualizo con éxito.'); 
                    }else{
                        $this->template->add_messages('error','Algo salio mal al tratar de actualizar el expediente, por favor vuelva a intentarlo nuevamente.'); 
                    }
                    
                }
            }
        }

        $get_dependencias = $dependencias->get_dependencias();
        $this->template->add_data('dependencias',$get_dependencias); 

        $expedientes = $dependencias->expedientes();
        $this->template->add_data('expedientes',$expedientes);  
        $this->template->add_js('assets/js/expediente');

        $this->template->active_sidebar('expediente');
        $this->template->title_page('Expedientes');
        return $this->template->renderview('dependencias/expediente','1');
    }

    public function add_expediente(){
        if(!$this->template->get_session('usuario_pqrsd')){
            return $this->response->redirect('login');
        }

        $dependencias = new DependenciaModel();

        
        $get_inmuebles = $dependencias->get_inmuebles('1',"'VENTA'");
        $this->template->add_data('get_inmuebles',$get_inmuebles);

        /*8 Arriendos y 9 ventas*/
        $this->template->add_data('tipoexpediente','8');

        $get_documentos = $dependencias->get_documentos();
        $this->template->add_data('documentos',$get_documentos);  

        $get_dependencias = $dependencias->get_dependencias();
        $this->template->add_data('dependencias',$get_dependencias);  

        $get_propietarios = $dependencias->get_propietarios();
        $this->template->add_data('get_propietarios',$get_propietarios); 

        if ($this->request->getMethod() === 'post') {
        $post = $this->request->getPost();
        if(isset($post['agregarpropietario'])){
            if ((($post['agregarpropietario']) == '1') && ($post['nombres']) && ($post['tipo_documento']) && ($post['tipo_cliente']) && ($post['documento']) && ($post['email']) && ($post['direccion']) && ($post['celular'])){
                $cantidad =count($post['tipo_cliente']);
                $tipo_cliente = '';
                if($cantidad > 1){
                    for($i=0;$i<$cantidad;$i++){
                        if($post['tipo_cliente'][$i]){
                            $tipo_cliente = ($tipo_cliente)?($tipo_cliente.','.$post['tipo_cliente'][$i]):$post['tipo_cliente'][$i];
                        }
                     }
                }
                $agregar = $dependencias->agregarpropietario($post['documento'],$post['tipo_documento'],$post['nombres'],$post['email'],$post['direccion'],$post['celular'],$tipo_cliente);  
                if(isset($agregar) && $agregar){
                    $this->template->add_messages('success','Propietario '.$post['nombres'].', fue creado con éxito.'); 
                }else{
                    $this->template->add_messages('error','Algo salio mal al tratar de crear el propietario, por favor vuelva a intentarlo nuevamente.'); 
                }
            }
        }
        
        if(isset($post['crearexpediente'])){
            if ((($post['crearexpediente']) == '1') && ($post['contrato']) && ($post['dependencia']) && ($post['estado'])){
                $finicio = ($post['finicio'])?("'".$post['finicio']."'"):'null'; $ffin = ($post['ffin'])?("'".$post['ffin']."'"):'null';
                $cliente ='';
                if(isset($post['inquilinos'])){
            /*    $cliente = explode(',',$post['clienter']);
                $cliente = $cliente[0];*/
                foreach($post['inquilinos'] as $inq){
                    $cliente = ($cliente)?($cliente.','.$inq):$inq;
                }
            
            }
                $agrego = $dependencias->agregarexpediente($post['contrato'],$post['contrato'],$finicio,$ffin,$post['dependencia'],$post['estado'],$cliente);
                $ruta_archivo = '';$sqlarchivo = '';
                $namedepen='';
                foreach($get_dependencias as $depen){
                    if($depen['id_dependencia']==$post['dependencia'])
                        {$namedepen = $depen['nombre'];}
                }    

                if(isset($get_documentos) && $get_documentos){
                    foreach($get_documentos as $docu){
                        $namearchivo = 'doc_'.$docu['id_documento'];
                        $file = $this->request->getFile($namearchivo);
                        $compl = (isset($post['comp_'.$docu['id_documento']]))?($post['comp_'.$docu['id_documento']]):'';

                        if(isset($file) && $file){
                            $fileExtension = $file->getClientExtension();
                            if(isset($fileExtension) && $fileExtension){
                                $ruta = $this->upload($file,$namedepen.'/'.$post['contrato']);
                                if($ruta['errors'] == 'success'){
                                    $ruta_archivo = $ruta['ruta'];
                                }else{
                                    $archivo_cargado = false;
                                    $this->template->add_messages('error',$ruta['errors']); 
                                }
                            }
                        }

                        if($ruta_archivo){
                            $dependencias->agregardocumento($docu['id_documento'],$compl,$ruta_archivo,$post['contrato']);
                        }
                    }
                }
                $files = $this->request->getFiles('imagenes');
                $url_respuesta = '';
                
                if ((empty($_FILES['imagenes']['name'][0]))) {
                    $files = '';
                }
                if(isset($files) && $files){ 
                    
                    foreach($files["imagenes"] as $key => $item){
                        $token = bin2hex(openssl_random_pseudo_bytes(12));
                            $ruta = $this->upload($item,$namedepen.'/'.$post['contrato'].'/imagenes');
                            if($ruta['errors'] == 'success'){
                                $archivos[] = $ruta;
                            }else{
                                $this->template->add_messages('info','El archivo no pude ser cargado.');
                            }
                    }
                    if(isset($archivos) && $archivos){
                        foreach($archivos as $files){
                            $dependencias->agregardocumento('0','imagenes',$files['ruta'],$post['contrato']);
                        }
                    }
                }


                if(isset($agrego) && $agrego){
                    $this->template->add_messages('success','Expediente '.$post['contrato'].' agregado con éxito.'); 
                }else{
                    $this->template->add_messages('error','Algo salio mal al tratar de crear el expediente, por favor vuelva a intentarlo nuevamente.'); 
                }
                
            }
        }
    }

         

        

        $tipos_cliente = $dependencias->tipos_cliente();
        $this->template->add_data('tipos_cliente',$tipos_cliente);   

        $this->template->add_css('template_admin/vendor/select2/select2.min');
        $this->template->add_js('template_admin/vendor/select2/select2.min');
        $this->template->add_js('assets/js/expediente');

        $this->template->active_sidebar('add_expediente');
        $this->template->title_page('Expedientes');
        return $this->template->renderview('dependencias/add_expediente','1');
    }

    public function propietario(){
        if(!$this->template->get_session('usuario_pqrsd')){
            return $this->response->redirect('login');
        }

        $dependencias = new DependenciaModel();

        if ($this->request->getMethod() === 'post') {
			$post = $this->request->getPost();
            if(isset($post['agregarpropietario'])){
                if ((($post['agregarpropietario']) == '1') && ($post['nombres']) && ($post['documento']) && ($post['email']) && ($post['direccion']) && ($post['celular'])){
                    $cantidad =count($post['tipo_cliente']);
                    
                    $estado = ($post['estado'])?($post['estado']):0;
                    $agregar = $dependencias->agregarpropietario($post['documento'],$post['nombres'],$post['email'],$post['direccion'],$post['celular'],$estado);  
                    if(isset($agregar) && $agregar){
                        $this->template->add_messages('success','Propietario '.$post['nombres'].', fue creado con éxito.'); 
                    }else{
                        $this->template->add_messages('error','Algo salio mal al tratar de crear el propietario, por favor vuelva a intentarlo nuevamente.'); 
                    }
                }
                if ((($post['agregarpropietario']) == '2') && ($post['nombres']) && ($post['crear']) && ($post['email']) && ($post['direccion']) && ($post['celular'])){
                    
                    $estado = ($post['estado'])?($post['estado']):0;
                    $agregar = $dependencias->updatepropietario($post['crear'],$post['nombres'],$post['email'],$post['direccion'],$post['celular'],$estado);  
                    if(isset($agregar) && $agregar){
                        $this->template->add_messages('success','Propietario '.$post['nombres'].', fue actualizado con éxito.'); 
                    }else{
                        $this->template->add_messages('error','Algo salio mal al tratar de actualizar el propietario, por favor vuelva a intentarlo nuevamente.'); 
                    }
                }
            }
            $_POST = null;
        }

        $get_propietarios = $dependencias->get_propietarios();
        $this->template->add_data('get_propietarios',$get_propietarios);   

        $tipos_cliente = $dependencias->tipos_cliente();
        $this->template->add_data('tipos_cliente',$tipos_cliente);   

        $this->template->add_css('template_admin/vendor/select2/select2.min');
        $this->template->add_js('template_admin/vendor/select2/select2.min');
        $this->template->add_js('assets/js/propietarios');

        $this->template->active_sidebar('propietarios');
        $this->template->title_page('Propietario');
        return $this->template->renderview('dependencias/propietario','1');
    }

    public function arrendatario(){
        if(!$this->template->get_session('usuario_pqrsd')){
            return $this->response->redirect('login');
        }

        $dependencias = new DependenciaModel();

        if ($this->request->getMethod() === 'post') {
			$post = $this->request->getPost();
            if(isset($post['agregararrendatario'])){
                if ((($post['agregararrendatario']) == '1') && ($post['nombres']) && ($post['documento']) && ($post['direccion']) && ($post['celular']) && ($post['num_contrato'])){
                    $estado = ($post['estado'])?($post['estado']):0;
                    $agregar = $dependencias->agregararrendatario($post['documento'],$post['nombres'],$post['email'],$post['direccion'],$post['celular'],$estado,$post['num_contrato']);  
                    if(isset($agregar) && $agregar){
                        $this->template->add_messages('success','arrendatario '.$post['nombres'].', fue creado con éxito.'); 
                    }else{
                        $this->template->add_messages('error','Algo salio mal al tratar de crear el arrendatario, por favor vuelva a intentarlo nuevamente.'); 
                    }
                }
                if ((($post['agregararrendatario']) == '2') && ($post['nombres']) && ($post['documento'])  && ($post['crear']) && ($post['direccion']) && ($post['celular']) && ($post['num_contrato']) && ($post['id'])){
                    
                    $estado = ($post['estado'])?($post['estado']):0;
                    $agregar = $dependencias->updatearrendatario($post['documento'],$post['nombres'],$post['email'],$post['direccion'],$post['celular'],$estado,$post['num_contrato'],$post['id'],$post['documento']);  
                    if(isset($agregar) && $agregar){
                        $this->template->add_messages('success','arrendatario '.$post['nombres'].', fue actualizado con éxito.'); 
                    }else{
                        $this->template->add_messages('error','Algo salio mal al tratar de actualizar el arrendatario, por favor vuelva a intentarlo nuevamente.'); 
                    }
                }
            }
            $_POST = null;
        }

        $get_arrendatarios = $dependencias->get_arrendatarios();
        $this->template->add_data('get_arrendatarios',$get_arrendatarios);   

        $tipos_cliente = $dependencias->tipos_cliente();
        $this->template->add_data('tipos_cliente',$tipos_cliente);   

        $this->template->add_css('template_admin/vendor/select2/select2.min');
        $this->template->add_js('template_admin/vendor/select2/select2.min');
        $this->template->add_js('assets/js/propietarios');

        $this->template->active_sidebar('arrendatarios');
        $this->template->title_page('arrendatario');
        return $this->template->renderview('dependencias/arrendatario','1');
    }


    public function buscardocumentos()
    {
        if ($this->request->isAJAX()) {
            $post = $this->request->getPost();
            $tipo = $post['tipo'];
            $num_contrato = $post['num_contrato'];
            $tipodoc = $post['tipodoc'];
            if(isset($tipo)) {
                $dependencias = new DependenciaModel();
               
                if($num_contrato){
                    if($tipodoc == 'imagenes'){
                        $get_documentos = true;
                        $documentos_cargados = $dependencias->documentos_cargados($num_contrato,$tipodoc);
                    }else{
                        $documentos_cargados = true;
                        $get_documentos = $dependencias->get_documentos_depen($tipo,$num_contrato);
                    }
                }else{
                    $get_documentos = $dependencias->get_documentos_depen($tipo);
                }
                
                $tabla = ''; $ruta_archivos='';
                if(isset($get_documentos) && $get_documentos){
                    if($tipodoc == 'imagenes'){
                        $tabla = '<input type="hidden" name="contrato" value="'.htmlspecialchars($num_contrato, ENT_QUOTES, 'UTF-8').'">';
                        $tabla .= '<hr><br><b>Imagenes cargadas: </b><br>';

                        if(is_array($documentos_cargados) && $documentos_cargados){
                            $modales_imagenes = '';
                            $tabla .= '<table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th style="text-align:center; width: 25%">IMAGEN</th>
                                <th style="text-align:center; width: 55%">DESCRIPCION</th>
                                <th style="text-align:center; width: 20%">ELIMINAR</th>
                            </tr>
                          </thead>
                          <tbody>';

                            foreach($documentos_cargados as $index => $image){
                                $url_archivo = $image['url_documento'];
                                $url = (((substr($url_archivo, 0,1)) != '/')?'/':'').$url_archivo;
                                $url = str_replace($_SERVER['DOCUMENT_ROOT'], base_url(), $url);
                                $datos_imagen = explode('*w*', $image['complemento']);
                                $descripcion_imagen = (isset($datos_imagen[1]) && $datos_imagen[1]) ? $datos_imagen[1] : '-';
                                $descripcion_segura = htmlspecialchars($descripcion_imagen, ENT_QUOTES, 'UTF-8');
                                $url_archivo_seguro = htmlspecialchars($url_archivo, ENT_QUOTES, 'UTF-8');
                                $modal_id = 'modal-eliminar-imagen-'.preg_replace('/[^A-Za-z0-9_-]/', '', $num_contrato).'-'.$index;

                                $tabla .= '<tr>
                                <td style="text-align:center"><img src="'.$url.'" style="width:90px; height:70px; object-fit:cover"></td>
                                <td>'.$descripcion_segura.'</td>
                                <td style="text-align:center"><button type="button" class="btn btn-flat btn-danger" data-toggle="modal" data-target="#'.$modal_id.'"><i class="fa fa-fw fa-times"></i></button></td>
                            </tr>';

                                $modales_imagenes .= '<div class="modal fade" id="'.$modal_id.'">
                                    <div class="modal-dialog">
                                      <div class="modal-content bg-info">
                                        <div class="modal-header">
                                          <h4 class="modal-title text-white">Eliminar imagen</h4>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        <div class="modal-body">
                                          <p>Esta seguro de eliminar esta imagen?</p>
                                          <p><b>Descripcion:</b> '.$descripcion_segura.'</p>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                          <button type="button" class="btn btn-outline-light" data-dismiss="modal">Cancelar</button>
                                          <button type="submit" name="eliminar_imagen" value="'.$url_archivo_seguro.'" class="btn btn-danger">Eliminar</button>
                                        </div>
                                      </div>
                                    </div>
                                  </div>';
                            }

                            $tabla .= '</tbody></table>'.$modales_imagenes.'<br>';
                        }else{
                            $tabla .= '<div class="alert alert-info">No hay imagenes cargadas para este arriendo.</div>';
                        }

                        $tabla .= '<label>Descripcion de la imagen a cargar</label>
                            <input type="text" class="form-control" name="descripcion_imagen" placeholder="Descripcion de la imagen">
                            <br><label>Imagenes</label><br>
                            <input id="input-24" name="imagenes[]" type="file" multiple data-show-upload="false" data-show-caption="true" data-msg-placeholder="Seleccionar Archivos...">';

                        return json_encode(array('carga'=> true, 'tabla' => $tabla,'ruta_archivos'=>$ruta_archivos));
                    }

                    if(isset($documentos_cargados) && $documentos_cargados){
                        if($tipodoc == 'imagenes'){
                            $tabla = '<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
  </ol>
  <div class="carousel-inner">';
  $active = true;
        foreach($documentos_cargados as $index=> $image){
            $url = $image['url_documento'];
            $url = (((substr($url, 0,1)) != '/')?'/':'').$url;
            $url = str_replace($_SERVER['DOCUMENT_ROOT'], base_url(), $url);
            $ruta_archivos = ($ruta_archivos)?(($ruta_archivos).','.$url):($url);
            
                $tabla .= '<div class="carousel-item '.(($active)?'active':'').'">
      <img src="'.$url.'" class="d-block w-100" >
    </div>';
    $active = false;
        }

    
  $tabla .= '<button class="carousel-control-prev" type="button" data-target="#carouselExampleIndicators" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-target="#carouselExampleIndicators" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </button>
</div>';
$tabla .= ($tipo == '8')?('<br> <label>Imagenes</label><br><input id="input-24" name="imagenes[]" type="file"  multiple data-show-upload="false" data-show-caption="true" data-msg-placeholder="Seleccionar Archivos...">'):'';
                        }else{
                            $tabla = '<hr><br><b>Documentos cargados: </b><br><table class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th style="text-align:center; width: 20%">DOCUMENTO</th>
                                <th style="text-align:center; width: 25%">CARGADO</th>
                                <th style="text-align:center; width: 25%">CARGAR</th>
                                <th style="text-align:center; width: 30%">COMPLEMENTO</th>
                            </tr>
                          </thead>
                          <tbody>';
                            foreach($get_documentos as $doc){
                                $datos = explode('*w*',$doc['url_documento']);
                                $tabla .= '<tr>
                                <td>'.$doc['tipo_documento'].'</td>
                                <td>'.((isset($datos[0]) && $datos[0])?('<a class="btn btn-accion-tabla tooltipsC" type="button" title="Documento de Soporte" onclick="versoporte(`'.$datos[0].'`)" > <i class="fa-regular fa-file" style="color:   #a93226  ;"></i> Ver documento</a>'):'-').'</td>
                                <td><input type="file" class="form-control" name="doc_'.$doc['id_documento'].'" ></td>
                                <td><input type="text" class="form-control" value="'.((isset($datos[1]) && $datos[1]) ? ($datos[1]): '').'" name="comp_'.$doc['id_documento'].'"></td>
                            </tr>';
                            }
                            
                          $tabla .= '</tbody>
                            </table><br>';
                        }
                        
                    }else{
                        if($tipodoc != 'imagenes'){
                        $tabla = '<table class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th style="text-align:center; width: 40%">DOCUMENTO</th>
                            <th style="text-align:center; width: 30%">CARGAR</th>
                            <th style="text-align:center; width: 30%">COMPLEMENTO</th>
                        </tr>
                      </thead>
                      <tbody>';
                      
                        foreach($get_documentos as $doc){
                            $tabla .= '<tr>
                            <td>'.$doc['tipo_documento'].'</td>
                            <td><input type="file" class="form-control" name="doc_'.$doc['id_documento'].'" ></td>
                            <td><input type="text" class="form-control" name="comp_'.$doc['id_documento'].'"></td>
                        </tr>';
                        }
                    }
                      $tabla .= '</tbody>
                        </table>';
                        $tabla .= ($tipo == '8')?('<br> <label>Imagenes</label><br><input id="input-24" name="imagenes[]" type="file"  multiple data-show-upload="false" data-show-caption="true" data-msg-placeholder="Seleccionar Archivos...">'):'';
                    }
                    


                    return json_encode(array('carga'=> true, 'tabla' => $tabla,'ruta_archivos'=>$ruta_archivos));
                }else{
                    return json_encode(array('carga' => false));
                }
            }else{
                return json_encode(array('carga' => false));
            }
        } else {
            return json_encode(array('carga' => false));
        }
    }

    public function buscarpropietario(){
        if ($this->request->isAJAX()) {
            $post = $this->request->getPost();
            $tipo_busqueda = $post['tipo_busqueda'];
            $complemento = str_replace(' ','%',$post['complemento']);
            $complemento = str_replace("'",'%',$complemento);
            $complemento = str_replace('"','%',$complemento);
            $complemento = str_replace('.','%',$complemento);
            if($tipo_busqueda && $complemento) {
                $dependencias = new DependenciaModel();
                $get_propietarios = $dependencias->get_propietarios(" where  CAST(".$tipo_busqueda." AS TEXT) like '%".$complemento."%' ");
                
                if(isset($get_propietarios) && $get_propietarios){
                    return json_encode(array('carga'=> true, 'info' => $get_propietarios[0]));
                }else{
                    return json_encode(array('carga' => false));
                }
            }else{
                return json_encode(array('carga' => false));
            }
        } else {
            return json_encode(array('carga' => false));
        }
    }

    public function inmuebles(){
        if(!$this->template->get_session('usuario_pqrsd')){
            return $this->response->redirect('login');
        }

        $dependencias = new DependenciaModel();
        if ($this->request->getMethod() === 'post') {
			$post = $this->request->getPost();
            if(isset($post['accion'])){
                if (($post['accion']) && ($post['codinmueble']) && ($post['direccion']) && ($post['barrio']) && ($post['ciudad']) && ($post['nompropietario']) && ($post['tipo_inmueble']) && ($post['tipo_actividad'])&& ($post['codigo_pagina'])){
                    $tipo = $post['accion'];
                    $codinmueble = $post['codinmueble']; 
                    $direccion = $post['direccion']; 
                    $barrio = $post['barrio']; 
                    $ciudad = $post['ciudad']; 
                    $nompropietario = $post['nompropietario'];
                    $tipo_inmueble = $post['tipo_inmueble'];
                    $tipo_actividad = $post['tipo_actividad'];
                    $estado = ($post['estado'])?($post['estado']):0;
                    $codigo_pagina = ($post['codigo_pagina'])?($post['codigo_pagina']):0;
                    
                    $addinmuebles = $dependencias->addinmuebles($codinmueble,$direccion,$barrio,$ciudad,$nompropietario,$tipo,$tipo_inmueble,$tipo_actividad,$estado,$codigo_pagina);

                    if(isset($addinmuebles) && $addinmuebles){
                        $this->template->add_messages('success', (($tipo == 'nuevo')?('El inmueble nuevo fue creado con éxito con el código '.$codigo_pagina.'.'):('El inmueble '.$codigo_pagina.' fue editado con éxito.'))); 
                    }else{
                        $this->template->add_messages('error','Algo salio mal al tratar de '.(($tipo == 'nuevo')?'crear':'editar').' el inmueble, por favor vuelva a intentarlo nuevamente.'); 
                    }
                }
            }
        }
        

        $get_inmuebles = $dependencias->get_inmuebles();
        $this->template->add_data('get_inmuebles',$get_inmuebles);   

        $tipo_inmuebles = $dependencias->tipo_inmuebles();
        $this->template->add_data('tipo_inmuebles',$tipo_inmuebles);   
        
        $tipo_actividad = $dependencias->tipo_actividad();
        $this->template->add_data('tipo_actividad',$tipo_actividad);   
        
        
        $this->template->add_js('assets/js/inmuebles');

        $this->template->active_sidebar('inmuebles');
        $this->template->title_page('Inmuebles');
        return $this->template->renderview('dependencias/inmuebles','1');
    }

    public function arriendos2(){
        if(!$this->template->get_session('usuario_pqrsd')){
            return $this->response->redirect('login');
        }

        $dependencias = new DependenciaModel();

        
        $get_inmuebles = $dependencias->get_inmuebles('1',"'ARRIENDO'");
        $this->template->add_data('get_inmuebles',$get_inmuebles);

        /*8 Arriendos y 9 ventas*/
        $this->template->add_data('tipoexpediente','8');
        $this->template->add_data('tiporeal','arriendos');

        $get_documentos = $dependencias->get_documentos();
        $this->template->add_data('documentos',$get_documentos);  

        $get_dependencias = $dependencias->get_dependencias();
        $this->template->add_data('dependencias',$get_dependencias);  

        $get_propietarios = $dependencias->get_propietarios();
        $this->template->add_data('get_propietarios',$get_propietarios); 

        if ($this->request->getMethod() === 'post') {
        $post = $this->request->getPost();
        if(isset($post['agregarpropietario'])){
            if ((($post['agregarpropietario']) == '1') && ($post['nombres']) && ($post['tipo_documento']) && ($post['tipo_cliente']) && ($post['documento']) && ($post['email']) && ($post['direccion']) && ($post['celular'])){
                $cantidad =count($post['tipo_cliente']);
                $tipo_cliente = '';
                if($cantidad > 1){
                    for($i=0;$i<$cantidad;$i++){
                        if($post['tipo_cliente'][$i]){
                            $tipo_cliente = ($tipo_cliente)?($tipo_cliente.','.$post['tipo_cliente'][$i]):$post['tipo_cliente'][$i];
                        }
                     }
                }
                $agregar = $dependencias->agregarpropietario($post['documento'],$post['tipo_documento'],$post['nombres'],$post['email'],$post['direccion'],$post['celular'],$tipo_cliente);  
                if(isset($agregar) && $agregar){
                    $this->template->add_messages('success','Propietario '.$post['nombres'].', fue creado con éxito.'); 
                }else{
                    $this->template->add_messages('error','Algo salio mal al tratar de crear el propietario, por favor vuelva a intentarlo nuevamente.'); 
                }
            }
        }
        
        if(isset($post['crearexpediente'])){
            if ((($post['crearexpediente']) == '1') && ($post['contrato']) && ($post['dependencia']) && ($post['estado'])){
                $finicio = ($post['finicio'])?("'".$post['finicio']."'"):'null'; $ffin = ($post['ffin'])?("'".$post['ffin']."'"):'null';
                $cliente ='';
                if(isset($post['inquilinos'])){
            /*    $cliente = explode(',',$post['clienter']);
                $cliente = $cliente[0];*/
                foreach($post['inquilinos'] as $inq){
                    $cliente = ($cliente)?($cliente.','.$inq):$inq;
                }
            
            }
                $agrego = $dependencias->agregarexpediente($post['contrato'],$post['contrato'],$finicio,$ffin,$post['dependencia'],$post['estado'],$cliente);
                $ruta_archivo = '';$sqlarchivo = '';
                $namedepen='';
                foreach($get_dependencias as $depen){
                    if($depen['id_dependencia']==$post['dependencia'])
                        {$namedepen = $depen['nombre'];}
                }    

                if(isset($get_documentos) && $get_documentos){
                    foreach($get_documentos as $docu){
                        $namearchivo = 'doc_'.$docu['id_documento'];
                        $file = $this->request->getFile($namearchivo);
                        $compl = (isset($post['comp_'.$docu['id_documento']]))?($post['comp_'.$docu['id_documento']]):'';
                        $ruta_archivo = '';
                        if(isset($file) && $file){
                            $fileExtension = $file->getClientExtension();
                            if(isset($fileExtension) && $fileExtension){
                                $ruta = $this->upload($file,$namedepen.'/'.$post['contrato']);
                                if($ruta['errors'] == 'success'){
                                    $ruta_archivo = $ruta['ruta'];
                                }else{
                                    $archivo_cargado = false;
                                    $this->template->add_messages('error',$ruta['errors']); 
                                }
                            }
                        }

                        if($ruta_archivo){
                            $dependencias->agregardocumento($docu['id_documento'],$compl,$ruta_archivo,$post['contrato']);
                        }
                    }
                }
                $files = $this->request->getFiles('imagenes');
                $url_respuesta = '';
                
                if ((empty($_FILES['imagenes']['name'][0]))) {
                    $files = '';
                }
                if(isset($files) && $files){ 
                    $archivos = array();
                    foreach($files["imagenes"] as $key => $item){
                        $token = bin2hex(openssl_random_pseudo_bytes(12));
                            $ruta = $this->upload($item,$namedepen.'/'.$post['contrato'].'/imagenes');
                            if($ruta['errors'] == 'success'){
                                array_push($archivos,$ruta);
                                //$archivos[] = $ruta;
                            }else{
                                $this->template->add_messages('info','El archivo no pude ser cargado.');
                            }
                    }
                    if(isset($archivos) && $archivos){
                        foreach($archivos as $files){
                            $dependencias->agregardocumento('0','imagenes',$files['ruta'],$post['contrato']);
                        }
                    }
                }


                if(isset($agrego) && $agrego){
                    $this->template->add_messages('success','Expediente '.$post['contrato'].' agregado con éxito.'); 
                }else{
                    $this->template->add_messages('error','Algo salio mal al tratar de crear el expediente, por favor vuelva a intentarlo nuevamente.'); 
                }
                
            }
        }
    }

         

        

        $tipos_cliente = $dependencias->tipos_cliente();
        $this->template->add_data('tipos_cliente',$tipos_cliente);   

        $this->template->add_css('template_admin/vendor/select2/select2.min');
        $this->template->add_js('template_admin/vendor/select2/select2.min');
        $this->template->add_js('assets/js/expediente');

        $this->template->active_sidebar('arriendos');
        $this->template->title_page('Expedientes');
        return $this->template->renderview('dependencias/add_expediente','1');
    }

    public function ventas(){
        if(!$this->template->get_session('usuario_pqrsd')){
            return $this->response->redirect('login');
        }

        $dependencias = new DependenciaModel();

        
        $get_inmuebles = $dependencias->get_inmuebles('1',"'VENTA'");
        $this->template->add_data('get_inmuebles',$get_inmuebles);

        /*8 Arriendos y 9 ventas*/
        $this->template->add_data('tipoexpediente','9');
        $this->template->add_data('tiporeal','ventas');

        $get_documentos = $dependencias->get_documentos();
        $this->template->add_data('documentos',$get_documentos);  

        $get_dependencias = $dependencias->get_dependencias();
        $this->template->add_data('dependencias',$get_dependencias);  

        $get_propietarios = $dependencias->get_propietarios();
        $this->template->add_data('get_propietarios',$get_propietarios); 

        if ($this->request->getMethod() === 'post') {
        $post = $this->request->getPost();
        if(isset($post['agregarpropietario'])){
            if ((($post['agregarpropietario']) == '1') && ($post['nombres']) && ($post['tipo_documento']) && ($post['tipo_cliente']) && ($post['documento']) && ($post['email']) && ($post['direccion']) && ($post['celular'])){
                $cantidad =count($post['tipo_cliente']);
                $tipo_cliente = '';
                if($cantidad > 1){
                    for($i=0;$i<$cantidad;$i++){
                        if($post['tipo_cliente'][$i]){
                            $tipo_cliente = ($tipo_cliente)?($tipo_cliente.','.$post['tipo_cliente'][$i]):$post['tipo_cliente'][$i];
                        }
                     }
                }
                $agregar = $dependencias->agregarpropietario($post['documento'],$post['tipo_documento'],$post['nombres'],$post['email'],$post['direccion'],$post['celular'],$tipo_cliente);  
                if(isset($agregar) && $agregar){
                    $this->template->add_messages('success','Propietario '.$post['nombres'].', fue creado con éxito.'); 
                }else{
                    $this->template->add_messages('error','Algo salio mal al tratar de crear el propietario, por favor vuelva a intentarlo nuevamente.'); 
                }
            }
        }
        
        if(isset($post['crearexpediente'])){
            if ((($post['crearexpediente']) == '1') && ($post['contrato']) && ($post['dependencia']) && ($post['estado'])){
                $finicio = ($post['finicio'])?("'".$post['finicio']."'"):'null'; $ffin = ($post['ffin'])?("'".$post['ffin']."'"):'null';
                $cliente ='';
                if(isset($post['inquilinos'])){
            /*    $cliente = explode(',',$post['clienter']);
                $cliente = $cliente[0];*/
                foreach($post['inquilinos'] as $inq){
                    $cliente = ($cliente)?($cliente.','.$inq):$inq;
                }
            
            }
                $agrego = $dependencias->agregarexpediente($post['contrato'],$post['contrato'],$finicio,$ffin,$post['dependencia'],$post['estado'],$cliente);
                $ruta_archivo = '';$sqlarchivo = '';
                $namedepen='';
                foreach($get_dependencias as $depen){
                    if($depen['id_dependencia']==$post['dependencia'])
                        {$namedepen = $depen['nombre'];}
                }    

                if(isset($get_documentos) && $get_documentos){
                    foreach($get_documentos as $docu){
                        $namearchivo = 'doc_'.$docu['id_documento'];
                        $file = $this->request->getFile($namearchivo);
                        $compl = (isset($post['comp_'.$docu['id_documento']]))?($post['comp_'.$docu['id_documento']]):'';

                        if(isset($file) && $file){
                            $fileExtension = $file->getClientExtension();
                            if(isset($fileExtension) && $fileExtension){
                                $ruta = $this->upload($file,$namedepen.'/'.$post['contrato']);
                                if($ruta['errors'] == 'success'){
                                    $ruta_archivo = $ruta['ruta'];
                                }else{
                                    $archivo_cargado = false;
                                    $this->template->add_messages('error',$ruta['errors']); 
                                }
                            }
                        }

                        if($ruta_archivo){
                            $dependencias->agregardocumento($docu['id_documento'],$compl,$ruta_archivo,$post['contrato']);
                        }
                    }
                }
                $files = $this->request->getFiles('imagenes');
                $url_respuesta = '';
                
                if ((empty($_FILES['imagenes']['name'][0]))) {
                    $files = '';
                }
                if(isset($files) && $files){ 
                    
                    foreach($files["imagenes"] as $key => $item){
                        $token = bin2hex(openssl_random_pseudo_bytes(12));
                            $ruta = $this->upload($item,$namedepen.'/'.$post['contrato'].'/imagenes');
                            if($ruta['errors'] == 'success'){
                                $archivos[] = $ruta;
                            }else{
                                $this->template->add_messages('info','El archivo no pude ser cargado.');
                            }
                    }
                    if(isset($archivos) && $archivos){
                        foreach($archivos as $files){
                            $dependencias->agregardocumento('0','imagenes',$files['ruta'],$post['contrato']);
                        }
                    }
                }


                if(isset($agrego) && $agrego){
                    $this->template->add_messages('success','Expediente '.$post['contrato'].' agregado con éxito.'); 
                }else{
                    $this->template->add_messages('error','Algo salio mal al tratar de crear el expediente, por favor vuelva a intentarlo nuevamente.'); 
                }
                
            }
        }
    }

         

        

        $tipos_cliente = $dependencias->tipos_cliente();
        $this->template->add_data('tipos_cliente',$tipos_cliente);   

        $this->template->add_css('template_admin/vendor/select2/select2.min');
        $this->template->add_js('template_admin/vendor/select2/select2.min');
        $this->template->add_js('assets/js/expediente');

        $this->template->active_sidebar('ventas');
        $this->template->title_page('Expedientes');
        return $this->template->renderview('dependencias/add_expediente','1');
    }


    public function expediente_arriendos(){
        if(!$this->template->get_session('usuario_pqrsd')){
            return $this->response->redirect('login');
        }
        $this->template->add_data('tipo_expediente','expediente_arriendos'); 
        $dependencias = new DependenciaModel();
        if ($this->request->getMethod() === 'post') {
            $post = $this->request->getPost();
            if(isset($post['actualizar'])){
                if ((($post['actualizar']) == '1') && ($post['contrato']) && ($post['dependencia']) && ($post['estado'])){
                    $finicio = ($post['finicio'])?("'".$post['finicio']."'"):'null'; $ffin = ($post['ffin'])?("'".$post['ffin']."'"):'null';
                    $cliente ='';
                    if(isset($post['clienter'])){
                    $cliente = explode(',',$post['clienter']);
                    $cliente = $cliente[0];}
                    
                    $actualizar = $dependencias->actualizarexpediente($post['contrato'],$post['contrato'],$finicio,$ffin,$post['dependencia'],$post['estado'],$cliente);

                    if(isset($actualizar) && $actualizar){
                        $this->template->add_messages('success','EL Expediente '.$post['contrato'].' se actualizo con éxito.'); 
                    }else{
                        $this->template->add_messages('error','Algo salio mal al tratar de actualizar el expediente, por favor vuelva a intentarlo nuevamente.'); 
                    }
                    
                }
            }
        }

        $get_dependencias = $dependencias->get_dependencias();
        $this->template->add_data('dependencias',$get_dependencias); 

        $expedientes = $dependencias->expedientes('8');
        $this->template->add_data('expedientes',$expedientes);  
        $this->template->add_js('assets/js/expediente');

        $this->template->active_sidebar('expediente_arriendos');
        $this->template->title_page('Expedientes');
        return $this->template->renderview('dependencias/expediente','1');
    }

    public function compraventa2(){
        if(!$this->template->get_session('usuario_pqrsd')){
            return $this->response->redirect('login');
        }
        $this->template->add_data('tipo_expediente','expediente_ventas'); 
        $this->template->add_data('titulo_tabla','Listado de compraventas registradas'); 
        $this->template->add_data('titulo_boton','Agregar Compraventa'); 

        $dependencias = new DependenciaModel();
        if ($this->request->getMethod() === 'post') {
            $post = $this->request->getPost();
            if(isset($post['actualizar'])){
                if ((($post['actualizar']) == '1') && ($post['contrato']) && ($post['dependencia']) && ($post['estado'])){
                    $finicio = ($post['finicio'])?("'".$post['finicio']."'"):'null'; $ffin = ($post['ffin'])?("'".$post['ffin']."'"):'null';
                    $cliente ='';
                    if(isset($post['clienter'])){
                    $cliente = explode(',',$post['clienter']);
                    $cliente = $cliente[0];}
                    
                    $actualizar = $dependencias->actualizarexpediente($post['contrato'],$post['contrato'],$finicio,$ffin,$post['dependencia'],$post['estado'],$cliente);

                    if(isset($actualizar) && $actualizar){
                        $this->template->add_messages('success','La compraventa '.$post['contrato'].' se actualizo con éxito.'); 
                    }else{
                        $this->template->add_messages('error','Algo salio mal al tratar de actualizar la compraventa, por favor vuelva a intentarlo nuevamente.'); 
                    }
                    
                }
            }
        }

        /*Agregado para la parte de agregar expediente*/
        
        $get_inmuebles = $dependencias->get_inmuebles('1',"'VENTA'");
        $this->template->add_data('get_inmuebles',$get_inmuebles);

        /*8 Arriendos y 9 ventas*/
        $this->template->add_data('tipoexpediente','9');
        $this->template->add_data('tiporeal','compraventa');

        $get_documentos = $dependencias->get_documentos();
        $this->template->add_data('documentos',$get_documentos);  
        if ($this->request->getMethod() === 'post') {
            $post = $this->request->getPost();
            if(isset($post['crearexpediente'])){
                $get_dependencias = $dependencias->get_dependencias();
                $this->template->add_data('dependencias',$get_dependencias); 

                if ((($post['crearexpediente']) == '1') && ($post['contrato']) && ($post['dependencia']) && ($post['estado'])){
                    $finicio = ($post['finicio'])?("'".$post['finicio']."'"):'null'; $ffin = ($post['ffin'])?("'".$post['ffin']."'"):'null';
                    $cliente ='';
                    if(isset($post['inquilinos'])){
                /*    $cliente = explode(',',$post['clienter']);
                    $cliente = $cliente[0];*/
                        foreach($post['inquilinos'] as $inq){
                            $cliente = ($cliente)?($cliente.','.$inq):$inq;
                        }
                
                    }
                    $agrego = $dependencias->agregarexpediente($post['contrato'],$post['contrato'],$finicio,$ffin,$post['dependencia'],$post['estado'],$cliente);
                    $sqlarchivo = '';
                    $namedepen='';
                    foreach($get_dependencias as $depen){
                        if($depen['id_dependencia']==$post['dependencia'])
                            {$namedepen = $depen['nombre'];}
                    }    

                    if(isset($get_documentos) && $get_documentos){
                        foreach($get_documentos as $docu){
                            $ruta_archivo = '';
                            $namearchivo = 'doc_'.$docu['id_documento'];
                            $file = $this->request->getFile($namearchivo);
                            $compl = (isset($post['comp_'.$docu['id_documento']]))?($post['comp_'.$docu['id_documento']]):'';

                            if(isset($file) && $file){
                                $fileExtension = $file->getClientExtension();
                                if(isset($fileExtension) && $fileExtension){
                                    $ruta = $this->upload($file,$namedepen.'/'.$post['contrato']);
                                    if($ruta['errors'] == 'success'){
                                        $ruta_archivo = $ruta['ruta'];
                                    }else{
                                        $archivo_cargado = false;
                                        $this->template->add_messages('error',$ruta['errors']); 
                                    }
                                }
                            }

                            if($ruta_archivo){
                                $dependencias->agregardocumento($docu['id_documento'],$compl,$ruta_archivo,$post['contrato']);
                            }
                        }
                    }
                    $files = $this->request->getFiles('imagenes');
                    $url_respuesta = '';
                    $descripcion_imagen = isset($post['descripcion_imagen']) ? trim($post['descripcion_imagen']) : '';
                    $complemento_imagen = ($descripcion_imagen) ? ('imagenes*w*'.$descripcion_imagen) : 'imagenes';
                    
                    if ((empty($_FILES['imagenes']['name'][0]))) {
                        $files = '';
                    }
                    if(isset($files) && $files){ 
                        
                        foreach($files["imagenes"] as $key => $item){
                            $token = bin2hex(openssl_random_pseudo_bytes(12));
                                $ruta = $this->upload($item,$namedepen.'/'.$post['contrato'].'/imagenes');
                                if($ruta['errors'] == 'success'){
                                    $archivos[] = $ruta;
                                }else{
                                    $this->template->add_messages('info','El archivo no pude ser cargado.');
                                }
                        }
                        if(isset($archivos) && $archivos){
                            foreach($archivos as $files){
                                $dependencias->agregardocumento('0','imagenes',$files['ruta'],$post['contrato']);
                            }
                        }
                    }


                        if(isset($agrego) && $agrego){
                            $this->template->add_messages('success','Expediente '.$post['contrato'].' agregado con éxito.'); 
                        }else{
                            $this->template->add_messages('error','Algo salio mal al tratar de crear el expediente, por favor vuelva a intentarlo nuevamente.'); 
                        }
                        
                }
            }
        }
        $tipos_cliente = $dependencias->tipos_cliente();
        $this->template->add_data('tipos_cliente',$tipos_cliente);

        /*Fin de agregar expediente*/

        $get_dependencias = $dependencias->get_dependencias();
        $this->template->add_data('dependencias',$get_dependencias); 

        $expedientes = $dependencias->expedientes('9');
        $this->template->add_data('expedientes',$expedientes);  
        $this->template->add_js('assets/js/expediente');

        $this->template->active_sidebar('compraventa');
        $this->template->title_page('Compraventa');
        return $this->template->renderview('dependencias/expediente','1');
    }


    public function consignacion(){
        if(!$this->template->get_session('usuario_pqrsd')){
            return $this->response->redirect('login');
        }
        $this->template->add_data('tipo_expediente','consignacion_inmuebles'); 
        $this->template->add_data('titulo_tabla','Listado de inmuebles en consignación'); 
        $this->template->add_data('titulo_boton','Agregar consignacion'); 

        $dependencias = new DependenciaModel();
        $get_dependencias = $dependencias->get_dependencias();
        if ($this->request->getMethod() === 'post') {
            $post = $this->request->getPost();
            if(isset($post['guardar'])){
                if ((($post['guardar'])) && ($post['contrato']) && ($post['estado'])){
                    $finicio = (isset($post['finicio']))?("'".$post['finicio']."'"):'null'; $ffin = (isset($post['ffin']))?("'".$post['ffin']."'"):'null';
                    $cliente ='';
                    $consecutivo ='';
                    if(isset($post['consecutivo'])){
                        $consecutivo = $post['consecutivo'];
                    }
                    if(isset($post['clienter'])){
                    $cliente = $post['clienter'];
                    }
                    
                    $actualizar = $dependencias->actualizarexpediente($post['contrato'],$post['contrato'],$finicio,$ffin,'11',$post['estado'],($cliente.'*-*'.$consecutivo));

                    if(isset($actualizar) && $actualizar){
                        $this->template->session_messages('success','La consignación se actualizo con éxito.'); 
                    }else{
                        $this->template->session_messages('error','Algo salio mal al tratar de actualizar la consignación, por favor vuelva a intentarlo nuevamente.'); 
                    }
                    return $this->response->redirect('consignacion');
                }
            }    
            if(isset($post['vender'])){   
                if ((($post['vender'])) && ($post['contrato']) && ($post['consecutivo'])&& ($post['vendedor'])&& ($post['direccion']) && ($post['clienter']) && ($post['estado'])){
                    $finicio = (isset($post['finicio']))?("'".$post['finicio']."'"):'null'; $ffin = (isset($post['ffin']))?("'".$post['ffin']."'"):'null';
                    $cliente ='';
                    $consecutivo ='';
                    if(isset($post['consecutivo'])){
                        $consecutivo = $post['consecutivo'];
                    }
                    if(isset($post['clienter'])){
                    $cliente = $post['clienter'];
                    }
                    $actualizar = $dependencias->actualizarexpediente($post['contrato'],$post['contrato'],$finicio,$ffin,'11','cerrado',($cliente.'*-*'.$consecutivo));

                    if(isset($actualizar) && $actualizar){
                        $dependencias->add_compraventa($post['consecutivo'],$post['vendedor'],$cliente,$post['direccion'],$post['contrato']);
                        $this->template->session_messages('success','La consignación se paso a compraventa.'); 
                    }else{
                        $this->template->session_messages('error','Algo salio mal al tratar de eliminar la consignación, por favor vuelva a intentarlo nuevamente.'); 
                    }
                    return $this->response->redirect('consignacion');
                }
            }
            $get_documentos = $dependencias->get_documentos();
            if(isset($post['documentos']) && $post['contrato']){
                $namedepen='';
                foreach($get_dependencias as $depen){
                    if($depen['id_dependencia']=='11')
                        {$namedepen = $depen['nombre'];}
                }    

                if(isset($get_documentos) && $get_documentos){
                    foreach($get_documentos as $docu){
                        $ruta_archivo = '';
                        $namearchivo = 'doc_'.$docu['id_documento'];
                        $file = $this->request->getFile($namearchivo);
                        $compl = (isset($post['comp_'.$docu['id_documento']]))?($post['comp_'.$docu['id_documento']]):'';

                        if(isset($file) && $file){
                            $fileExtension = $file->getClientExtension();
                            if(isset($fileExtension) && $fileExtension){
                                $ruta = $this->upload($file,$namedepen.'/'.$post['contrato']);
                                if($ruta['errors'] == 'success'){
                                    $ruta_archivo = $ruta['ruta'];
                                }else{
                                    $archivo_cargado = false;
                                    $this->template->session_messages('error',$ruta['errors']); 
                                }
                            }
                        }

                        if($ruta_archivo){
                            $dependencias->agregardocumento($docu['id_documento'],$compl,$ruta_archivo,$post['contrato']);
                        }
                    }
                }
                $this->template->session_messages('success','La consignación fue actualizada.'); 
                return $this->response->redirect('consignacion');
            }

            if(isset($post['eliminar'])){   
                if ((($post['eliminar']) == '1') && ($post['elimina'])){
                    $actualizar = $dependencias->elimiarexpediente($post['elimina'],'11');
                    if(isset($actualizar) && $actualizar){
                        $this->template->session_messages('success','La consignación se elimino con éxito.'); 
                    }else{
                        $this->template->session_messages('error','Algo salio mal al tratar de eliminar la consignación, por favor vuelva a intentarlo nuevamente.'); 
                    }
                    
                }
                return $this->response->redirect('consignacion');
            }
            
             
        }
        /*Agregado para la parte de agregar expediente*/
        
        $get_inmuebles = $dependencias->get_inmuebles('1',"'VENTA'",true);
        $this->template->add_data('get_inmuebles',$get_inmuebles);

        /*8 Arriendos y 9 ventas*/
        $this->template->add_data('tipoexpediente','11');
        $this->template->add_data('tiporeal','consignacion');

        $get_documentos = $dependencias->get_documentos();
        $this->template->add_data('documentos',$get_documentos);  
        if ($this->request->getMethod() === 'post') {
            $post = $this->request->getPost();
            if(isset($post['crearexpediente'])){
                
                $this->template->add_data('dependencias',$get_dependencias); 

                if ((($post['crearexpediente']) == '1') && ($post['contrato']) && ($post['dependencia']) && ($post['estado'])){
                    $finicio = ($post['finicio'])?("'".$post['finicio']."'"):'null'; $ffin = ($post['ffin'])?("'".$post['ffin']."'"):'null';
                    $cliente ='';
                    
                    $agrego = $dependencias->agregarexpediente($post['contrato'],$post['contrato'],$finicio,$ffin,$post['dependencia'],$post['estado'],$cliente);
                    $sqlarchivo = '';
                    $namedepen='';
                    foreach($get_dependencias as $depen){
                        if($depen['id_dependencia']==$post['dependencia'])
                            {$namedepen = $depen['nombre'];}
                    }    

                    if(isset($get_documentos) && $get_documentos){
                        foreach($get_documentos as $docu){
                            $ruta_archivo = '';
                            $namearchivo = 'doc_'.$docu['id_documento'];
                            $file = $this->request->getFile($namearchivo);
                            $compl = (isset($post['comp_'.$docu['id_documento']]))?($post['comp_'.$docu['id_documento']]):'';

                            if(isset($file) && $file){
                                $fileExtension = $file->getClientExtension();
                                if(isset($fileExtension) && $fileExtension){
                                    $ruta = $this->upload($file,$namedepen.'/'.$post['contrato']);
                                    if($ruta['errors'] == 'success'){
                                        $ruta_archivo = $ruta['ruta'];
                                    }else{
                                        $archivo_cargado = false;
                                        $this->template->session_messages('error',$ruta['errors']); 
                                    }
                                }
                            }

                            if($ruta_archivo){
                                $dependencias->agregardocumento($docu['id_documento'],$compl,$ruta_archivo,$post['contrato']);
                            }
                        }
                    }
                    $files = $this->request->getFiles('imagenes');
                    $url_respuesta = '';
                    
                    if ((empty($_FILES['imagenes']['name'][0]))) {
                        $files = '';
                    }
                    if(isset($files) && $files){ 
                        
                        foreach($files["imagenes"] as $key => $item){
                            $token = bin2hex(openssl_random_pseudo_bytes(12));
                                $ruta = $this->upload($item,$namedepen.'/'.$post['contrato'].'/imagenes');
                                if($ruta['errors'] == 'success'){
                                    $archivos[] = $ruta;
                                }else{
                                    $this->template->add_messages('info','El archivo no pude ser cargado.');
                                }
                        }
                        if(isset($archivos) && $archivos){
                            foreach($archivos as $files){
                                $dependencias->session_messages('0','imagenes',$files['ruta'],$post['contrato']);
                            }
                        }
                    }


                        if(isset($agrego) && $agrego){
                            $this->template->session_messages('success','Expediente '.$post['contrato'].' agregado con éxito.'); 
                        }else{
                            $this->template->session_messages('error','Algo salio mal al tratar de crear el expediente, por favor vuelva a intentarlo nuevamente.'); 
                        }
                        return $this->response->redirect('consignacion');  
                        
                }
            }
        }
        $tipos_cliente = $dependencias->tipos_cliente();
        $this->template->add_data('tipos_cliente',$tipos_cliente);

        /*Fin de agregar expediente*/

        $get_dependencias = $dependencias->get_dependencias();
        $this->template->add_data('dependencias',$get_dependencias); 

        $expedientes = $dependencias->expedientes_compra('11');
        $this->template->add_data('expedientes',$expedientes);  
        $this->template->add_js('assets/js/expediente');

        $this->template->active_sidebar('compraventa');
        $this->template->title_page('Compraventa');
        return $this->template->renderview('dependencias/expediente_compra','1');
    }

    public function avaluo(){
        if(!$this->template->get_session('usuario_pqrsd')){
            return $this->response->redirect('login');
        }
        $this->template->add_data('tipo_expediente','avaluos_inmuebles'); 
        $this->template->add_data('titulo_tabla','Listado de avaluos de inmuebles'); 
        $this->template->add_data('titulo_boton','Agregar avaluo'); 

        $dependencias = new DependenciaModel();
        if ($this->request->getMethod() === 'post') {
            $post = $this->request->getPost();
            if(isset($post['actualizar'])){
                if ((($post['actualizar']) == '1') && ($post['contrato']) && ($post['dependencia']) && ($post['estado'])){
                    $finicio = ($post['finicio'])?("'".$post['finicio']."'"):'null'; $ffin = ($post['ffin'])?("'".$post['ffin']."'"):'null';
                    $cliente ='';
                    if(isset($post['clienter'])){
                    $cliente = explode(',',$post['clienter']);
                    $cliente = $cliente[0];}
                    
                    $actualizar = $dependencias->actualizarexpediente($post['contrato'],$post['contrato'],$finicio,$ffin,$post['dependencia'],$post['estado'],$cliente);

                    if(isset($actualizar) && $actualizar){
                        $this->template->add_messages('success','El avaluo '.$post['contrato'].' se actualizo con éxito.'); 
                    }else{
                        $this->template->add_messages('error','Algo salio mal al tratar de actualizar el avaluo, por favor vuelva a intentarlo nuevamente.'); 
                    }
                    
                }
            }
        }

        /*Agregado para la parte de agregar expediente*/
        
        $get_inmuebles = $dependencias->get_inmuebles('1',"'VENTA'");
        $this->template->add_data('get_inmuebles',$get_inmuebles);

        /*8 Arriendos y 9 ventas*/
        $this->template->add_data('tipoexpediente','12');
        $this->template->add_data('tiporeal','avaluo');

        $get_documentos = $dependencias->get_documentos();
        $this->template->add_data('documentos',$get_documentos);  
        if ($this->request->getMethod() === 'post') {
            $post = $this->request->getPost();
            if(isset($post['crearexpediente'])){
                $get_dependencias = $dependencias->get_dependencias();
                $this->template->add_data('dependencias',$get_dependencias); 

                if ((($post['crearexpediente']) == '1') && ($post['codigo']) && ($post['nombres']) && ($post['direccion']) && ($post['tipo_inmueble']) && ($post['estado']) && ($post['ano'])){
                    $id_avaluo = '';
                    $tipo = 'nuevo';
                    $tipotext = ' agregado';
                    if($post['id_avaluo']){
                        $id_avaluo = $post['id_avaluo'];
                        $tipo = 'editar';
                        $tipotext = ' actualizado';
                    }
                    $agrego = $dependencias->agregaravaluo($post['codigo'],$post['nombres'],$post['direccion'],$post['tipo_inmueble'],$post['ano'],$post['estado'],$id_avaluo,$tipo);
                    $sqlarchivo = '';
                    $namedepen='';
                    foreach($get_dependencias as $depen){
                        if($depen['id_dependencia']=='12')
                            {$namedepen = $depen['nombre'];}
                    }    

                    if(isset($get_documentos) && $get_documentos){
                        foreach($get_documentos as $docu){
                            $ruta_archivo = '';
                            $namearchivo = 'doc_'.$docu['id_documento'];
                            $file = $this->request->getFile($namearchivo);
                            $compl = (isset($post['comp_'.$docu['id_documento']]))?($post['comp_'.$docu['id_documento']]):'';

                            if(isset($file) && $file){
                                $fileExtension = $file->getClientExtension();
                                if(isset($fileExtension) && $fileExtension){
                                    $ruta = $this->upload($file,$namedepen.'/'.$post['codigo']);
                                    if($ruta['errors'] == 'success'){
                                        $ruta_archivo = $ruta['ruta'];
                                    }else{
                                        $archivo_cargado = false;
                                        $this->template->add_messages('error',$ruta['errors']); 
                                    }
                                }
                            }

                            if($ruta_archivo){
                                $dependencias->agregardocumento($docu['id_documento'],$compl,$ruta_archivo,$post['codigo']);
                            }
                        }
                    }
                    $files = $this->request->getFiles('imagenes');
                    $url_respuesta = '';
                    

                        if(isset($agrego) && $agrego){
                            $this->template->add_messages('success','Avaluo '.$post['codigo'].$tipotext.' con éxito.'); 
                        }else{
                            $this->template->add_messages('error','Algo salio mal al tratar de crear el Avaluo, por favor vuelva a intentarlo nuevamente.'); 
                        }
                        
                }
            }
        }
        $tipos_cliente = $dependencias->tipos_cliente();
        $this->template->add_data('tipos_cliente',$tipos_cliente);

        /*Fin de agregar expediente*/

        $get_dependencias = $dependencias->get_dependencias();
        $this->template->add_data('dependencias',$get_dependencias); 

        $tipo_inmuebles = $dependencias->tipo_inmuebles();
        $this->template->add_data('tipo_inmuebles',$tipo_inmuebles);   

        $expedientes = $dependencias->avaluos();
        $this->template->add_data('expedientes',$expedientes);  
        $this->template->add_js('assets/js/expediente');

        $this->template->active_sidebar('compraventa');
        $this->template->title_page('Compraventa');
        return $this->template->renderview('dependencias/avaluo','1');
    }

    public function compraventa(){
        if(!$this->template->get_session('usuario_pqrsd')){
            return $this->response->redirect('login');
        }
        $this->template->add_data('tipo_expediente','expediente_ventas'); 
        $this->template->add_data('titulo_tabla','Listado de compraventas registradas'); 
        $this->template->add_data('titulo_boton','Agregar Compraventa'); 

        $dependencias = new DependenciaModel();
        $get_dependencias = $dependencias->get_dependencias();
        
        if ($this->request->getMethod() === 'post') {
            $post = $this->request->getPost();
            if(isset($post['editar'])){
                if ((($post['editar']) == '1') && ($post['id_compraventa']) && ($post['consecutivo']) && ($post['nombres'])){
                                      
                    $actualizar = $dependencias->actualizarcompraventa($post['id_compraventa'],$post['consecutivo'],$post['nombres']);
                    if(isset($actualizar) && $actualizar){
                        $this->template->session_messages('success','La compraventa '.$post['consecutivo'].' se actualizo con éxito.'); 
                    }else{
                        $this->template->session_messages('error','Algo salio mal al tratar de actualizar la compraventa, por favor vuelva a intentarlo nuevamente.'); 
                    }
                    return $this->response->redirect('compraventa');  
                }
            }
            if(isset($post['eliminar'])){
                if ((($post['eliminar']) == '1') && ($post['elimina'])){
                    $delete = $dependencias->deletecompraventa($post['elimina']);
                    if(isset($delete) && $delete){
                        $this->template->session_messages('success','La compraventa se elimino con éxito.'); 
                    }else{
                        $this->template->session_messages('error','Algo salio mal al tratar de eliminar la compraventa, por favor vuelva a intentarlo nuevamente.'); 
                    }
                    return $this->response->redirect('compraventa');  
                }
            }

            $get_documentos = $dependencias->get_documentos();
            if(isset($post['documentos']) && $post['contrato']){
                $namedepen='';
                foreach($get_dependencias as $depen){
                    if($depen['id_dependencia']=='9')
                        {$namedepen = $depen['nombre'];}
                }    

                if(isset($get_documentos) && $get_documentos){
                    foreach($get_documentos as $docu){
                        $ruta_archivo = '';
                        $namearchivo = 'doc_'.$docu['id_documento'];
                        $file = $this->request->getFile($namearchivo);
                        $compl = (isset($post['comp_'.$docu['id_documento']]))?($post['comp_'.$docu['id_documento']]):'';

                        if(isset($file) && $file){
                            $fileExtension = $file->getClientExtension();
                            if(isset($fileExtension) && $fileExtension){
                                $ruta = $this->upload($file,$namedepen.'/'.$post['contrato']);
                                if($ruta['errors'] == 'success'){
                                    $ruta_archivo = $ruta['ruta'];
                                }else{
                                    $archivo_cargado = false;
                                    $this->template->session_messages('error',$ruta['errors']); 
                                }
                            }
                        }

                        if($ruta_archivo){
                            $dependencias->agregardocumento($docu['id_documento'],$compl,$ruta_archivo,$post['contrato']);
                        }
                    }
                }
                $this->template->session_messages('success','La compraventa fue actualizada.'); 
                return $this->response->redirect('compraventa');
            }
        }

        /*Agregado para la parte de agregar expediente*/
        
        $get_inmuebles = $dependencias->get_inmuebles('1',"'VENTA'");
        $this->template->add_data('get_inmuebles',$get_inmuebles);

        /*8 Arriendos y 9 ventas*/
        $this->template->add_data('tipoexpediente','9');
        $this->template->add_data('tiporeal','compraventa');

        $get_documentos = $dependencias->get_documentos();
        $this->template->add_data('documentos',$get_documentos);  
        if ($this->request->getMethod() === 'post') {
            $post = $this->request->getPost();
            if(isset($post['crearexpediente'])){
                
                $this->template->add_data('dependencias',$get_dependencias); 

                if ((($post['crearexpediente']) == '1') && ($post['codigo']) && ($post['nombres']) && ($post['direccion']) && ($post['tipo_inmueble']) && ($post['estado']) && ($post['ano'])){
                    $id_avaluo = '';
                    $tipo = 'nuevo';
                    $tipotext = ' agregado';
                    if($post['id_avaluo']){
                        $id_avaluo = $post['id_avaluo'];
                        $tipo = 'editar';
                        $tipotext = ' actualizado';
                    }
                    $agrego = $dependencias->agregaravaluo($post['codigo'],$post['nombres'],$post['direccion'],$post['tipo_inmueble'],$post['ano'],$post['estado'],$id_avaluo,$tipo);
                    $sqlarchivo = '';
                    $namedepen='';
                    foreach($get_dependencias as $depen){
                        if($depen['id_dependencia']=='9')
                            {$namedepen = $depen['nombre'];}
                    }    

                    if(isset($get_documentos) && $get_documentos){
                        foreach($get_documentos as $docu){
                            $ruta_archivo = '';
                            $namearchivo = 'doc_'.$docu['id_documento'];
                            $file = $this->request->getFile($namearchivo);
                            $compl = (isset($post['comp_'.$docu['id_documento']]))?($post['comp_'.$docu['id_documento']]):'';

                            if(isset($file) && $file){
                                $fileExtension = $file->getClientExtension();
                                if(isset($fileExtension) && $fileExtension){
                                    $ruta = $this->upload($file,$namedepen.'/'.$post['codigo']);
                                    if($ruta['errors'] == 'success'){
                                        $ruta_archivo = $ruta['ruta'];
                                    }else{
                                        $archivo_cargado = false;
                                        $this->template->add_messages('error',$ruta['errors']); 
                                    }
                                }
                            }

                            if($ruta_archivo){
                                $dependencias->agregardocumento($docu['id_documento'],$compl,$ruta_archivo,$post['codigo']);
                            }
                        }
                    }
                    $files = $this->request->getFiles('imagenes');
                    $url_respuesta = '';
                    

                        if(isset($agrego) && $agrego){
                            $this->template->add_messages('success','Avaluo '.$post['codigo'].$tipotext.' con éxito.'); 
                        }else{
                            $this->template->add_messages('error','Algo salio mal al tratar de crear el Avaluo, por favor vuelva a intentarlo nuevamente.'); 
                        }
                        
                }
            }
        }
        $tipos_cliente = $dependencias->tipos_cliente();
        $this->template->add_data('tipos_cliente',$tipos_cliente);

        /*Fin de agregar expediente*/

        $get_dependencias = $dependencias->get_dependencias();
        $this->template->add_data('dependencias',$get_dependencias); 

        $tipo_inmuebles = $dependencias->tipo_inmuebles();
        $this->template->add_data('tipo_inmuebles',$tipo_inmuebles);   

        $expedientes = $dependencias->compraventa();
        $this->template->add_data('expedientes',$expedientes);  
        $this->template->add_js('assets/js/expediente');

        $this->template->active_sidebar('compraventa');
        $this->template->title_page('Compraventa');
        return $this->template->renderview('dependencias/compraventa','1');
    }

    public function consignacion_arriendo(){
        if(!$this->template->get_session('usuario_pqrsd')){
            return $this->response->redirect('login');
        }
        $this->template->add_data('tipo_expediente','consignacion_arriendo'); 
        $this->template->add_data('titulo_tabla','Listado de inmuebles en consignación de arriendo'); 
        $this->template->add_data('titulo_boton','Agregar consignación'); 

        $dependencias = new DependenciaModel();
        $get_dependencias = $dependencias->get_dependencias();
        if ($this->request->getMethod() === 'post') {
            $post = $this->request->getPost();
            if(isset($post['actualizar'])){
                if ((($post['actualizar']) == '1') && ($post['contrato']) && ($post['num_consignacion'])&& ($post['estado'])){
                    $finicio = (isset($post['finicio']))?("'".$post['finicio']."'"):'null'; $ffin = (isset($post['ffin']))?("'".$post['ffin']."'"):'null';
                    $cliente ='';
                    if(isset($post['inquilinos'])){
                        foreach($post['inquilinos'] as $inq){
                            $cliente = ($cliente)?($cliente.','.$inq):$inq;
                        }
                    }
                    $contrato_arriendo = $post['contrato_arriendo'];
                   
                    $actualizar = $dependencias->actualizarexpediente($post['contrato'],$post['num_consignacion'],$finicio,$ffin,'13',$post['estado'],$cliente,$contrato_arriendo);

                    if(isset($actualizar) && $actualizar){
                        $this->template->add_messages('success','La consignación '.$post['num_consignacion'].' se actualizo con éxito.'); 
                    }else{
                        $this->template->add_messages('error','Algo salio mal al tratar de actualizar la consignación, por favor vuelva a intentarlo nuevamente.'); 
                    }
                    
                }
            }

            $get_documentos = $dependencias->get_documentos();
            if(isset($post['documentos']) && $post['contrato']){
                $namedepen='';
                foreach($get_dependencias as $depen){
                    if($depen['id_dependencia']=='13')
                        {$namedepen = $depen['nombre'];}
                }    

                if(isset($post['eliminar_imagen']) && $post['eliminar_imagen']){
                    $delete_imagen = $dependencias->eliminar_imagen_arriendo($post['contrato'], $post['eliminar_imagen']);
                    if(isset($delete_imagen) && $delete_imagen){
                        $this->template->session_messages('success','La imagen fue eliminada con exito.'); 
                    }else{
                        $this->template->session_messages('error','Algo salio mal al tratar de eliminar la imagen, por favor vuelva a intentarlo nuevamente.'); 
                    }
                    return $this->response->redirect('arriendos');
                }

                if(isset($get_documentos) && $get_documentos){
                    foreach($get_documentos as $docu){
                        $ruta_archivo = '';
                        $namearchivo = 'doc_'.$docu['id_documento'];
                        $file = $this->request->getFile($namearchivo);
                        $compl = (isset($post['comp_'.$docu['id_documento']]))?($post['comp_'.$docu['id_documento']]):'';

                        if(isset($file) && $file){
                            $fileExtension = $file->getClientExtension();
                            if(isset($fileExtension) && $fileExtension){
                                $ruta = $this->upload($file,$namedepen.'/'.$post['contrato']);
                                if($ruta['errors'] == 'success'){
                                    $ruta_archivo = $ruta['ruta'];
                                }else{
                                    $archivo_cargado = false;
                                    $this->template->session_messages('error',$ruta['errors']); 
                                }
                            }
                        }

                        if($ruta_archivo){
                            $dependencias->agregardocumento($docu['id_documento'],$compl,$ruta_archivo,$post['contrato']);
                        }
                    }
                }
                $this->template->session_messages('success','La consignación fue actualizada.'); 
                return $this->response->redirect('consignacion_arriendo');
            }

            if(isset($post['eliminar'])){   
                if ((($post['eliminar']) == '1') && ($post['elimina'])){
                    $actualizar = $dependencias->elimiarexpediente($post['elimina'],'13');
                    if(isset($actualizar) && $actualizar){
                        $this->template->session_messages('success','La consignación se elimino con éxito.'); 
                    }else{
                        $this->template->session_messages('error','Algo salio mal al tratar de eliminar la consignación, por favor vuelva a intentarlo nuevamente.'); 
                    }
                    
                }
                return $this->response->redirect('consignacion_arriendo');
            }

            if(isset($post['arrendar'])){
                if ((($post['arrendar'])) && ($post['contrato']) && ($post['num_consignacion']) && ($post['estado']) && ($post['contrato_arriendo']) && ($post['inquilinos'])){
                    $finicio = (isset($post['finicio']))?("'".$post['finicio']."'"):'null'; $ffin = (isset($post['ffin']))?("'".$post['ffin']."'"):'null';
                    $cliente ='';
                    foreach($post['inquilinos'] as $inq){
                        $cliente = ($cliente)?($cliente.','.$inq):$inq;
                    }
                    $actualizar = $dependencias->actualizarexpediente($post['contrato'],$post['num_consignacion'],$finicio,$ffin,'13','arrendado',$cliente,$post['contrato_arriendo']);

                    if(isset($actualizar) && $actualizar){
                        $this->template->add_messages('success','El contrato de arriendo '.$post['contrato_arriendo'].' se actualizo con éxito.'); 
                    }else{
                        $this->template->add_messages('error','Algo salio mal al tratar de actualizar el contrato de arriendo, por favor vuelva a intentarlo nuevamente.'); 
                    }
                    
                }
            }
        }

        /*Agregado para la parte de agregar expediente*/
        $get_inmuebles = $dependencias->get_inmuebles('1',"'ARRIENDO'",true,'13');
        $this->template->add_data('get_inmuebles',$get_inmuebles);

        /*8 Arriendos y 9 ventas*/
        $this->template->add_data('tipoexpediente','13');
        $this->template->add_data('tiporeal','consignacion_arriendo');

        $get_documentos = $dependencias->get_documentos();
        $this->template->add_data('documentos',$get_documentos);  
        if ($this->request->getMethod() === 'post') {
            $post = $this->request->getPost();
            
            if(isset($post['crearexpediente'])){
                
                $this->template->add_data('dependencias',$get_dependencias); 

                if ((($post['crearexpediente']) == '1') && ($post['contrato']) && ($post['dependencia']) && ($post['num_consignacion'])){
                    $finicio = ($post['finicio'])?("'".$post['finicio']."'"):'null'; $ffin = ($post['ffin'])?("'".$post['ffin']."'"):'null';
                    $cliente ='';
                    if(isset($post['inquilinos'])){
                /*    $cliente = explode(',',$post['clienter']);
                    $cliente = $cliente[0];*/
                        foreach($post['inquilinos'] as $inq){
                            $cliente = ($cliente)?($cliente.','.$inq):$inq;
                        }
                
                    }
                    $agrego = $dependencias->agregarexpedientearriendo($post['num_consignacion'],$post['contrato'],$finicio,$ffin,$post['dependencia'],'abierto',$cliente);
                    $sqlarchivo = '';
                    $namedepen='';
                    foreach($get_dependencias as $depen){
                        if($depen['id_dependencia']==$post['dependencia'])
                            {$namedepen = $depen['nombre'];}
                    }    

                    if(isset($get_documentos) && $get_documentos){
                        foreach($get_documentos as $docu){
                            $ruta_archivo = '';
                            $namearchivo = 'doc_'.$docu['id_documento'];
                            $file = $this->request->getFile($namearchivo);
                            $compl = (isset($post['comp_'.$docu['id_documento']]))?($post['comp_'.$docu['id_documento']]):'';

                            if(isset($file) && $file){
                                $fileExtension = $file->getClientExtension();
                                if(isset($fileExtension) && $fileExtension){
                                    $ruta = $this->upload($file,$namedepen.'/'.$post['num_consignacion']);
                                    if($ruta['errors'] == 'success'){
                                        $ruta_archivo = $ruta['ruta'];
                                    }else{
                                        $archivo_cargado = false;
                                        $this->template->add_messages('error',$ruta['errors']); 
                                    }
                                }
                            }

                            if($ruta_archivo){
                                $dependencias->agregardocumento($docu['id_documento'],$compl,$ruta_archivo,$post['num_consignacion']);
                            }
                        }
                    }
                    $files = $this->request->getFiles('imagenes');
                    $url_respuesta = '';
                    
                    if ((empty($_FILES['imagenes']['name'][0]))) {
                        $files = '';
                    }
                    if(isset($files) && $files){ 
                        
                        foreach($files["imagenes"] as $key => $item){
                            $token = bin2hex(openssl_random_pseudo_bytes(12));
                                $ruta = $this->upload($item,$namedepen.'/'.$post['num_consignacion'].'/imagenes');
                                if($ruta['errors'] == 'success'){
                                    $archivos[] = $ruta;
                                }else{
                                    $this->template->add_messages('info','El archivo no pude ser cargado.');
                                }
                        }
                        if(isset($archivos) && $archivos){
                            foreach($archivos as $files){
                                $dependencias->agregardocumento('0',$complemento_imagen,$files['ruta'],$post['num_consignacion']);
                            }
                        }
                    }


                        if(isset($agrego) && $agrego){
                            $this->template->session_messages('success','Consignación '.$post['num_consignacion'].' agregada con éxito.'); 
                        }else{
                            $this->template->session_messages('error','Algo salio mal al tratar de crear la consignación, por favor vuelva a intentarlo nuevamente.'); 
                        }
                        return $this->response->redirect('consignacion_arriendo'); 
                        
                }
            }
        }
        $tipos_cliente = $dependencias->tipos_cliente();
        $this->template->add_data('tipos_cliente',$tipos_cliente);

        /*Fin de agregar expediente*/

        $get_dependencias = $dependencias->get_dependencias();
        $this->template->add_data('dependencias',$get_dependencias); 

        $get_arrendatarios = $dependencias->get_arrendatarios();
        $this->template->add_data('get_arrendatarios',$get_arrendatarios);   

        $expedientes = $dependencias->expedientes_compra('13');
        $this->template->add_data('expedientes',$expedientes);  
        $this->template->add_js('assets/js/expediente');

        $this->template->active_sidebar('consignacion_arriendo');
        $this->template->title_page('Consignacion de arriendo');
        return $this->template->renderview('dependencias/consignacion_arriendo','1');
    }

    public function arriendos(){
        if(!$this->template->get_session('usuario_pqrsd')){
            return $this->response->redirect('login');
        }
        $this->template->add_data('tipo_expediente','arriendo'); 
        $this->template->add_data('titulo_tabla','Listado de inmuebles en arriendo'); 
        $this->template->add_data('titulo_boton','Agregar arriendo'); 

        $dependencias = new DependenciaModel();
        $get_dependencias = $dependencias->get_dependencias();
        if ($this->request->getMethod() === 'post') {
            $post = $this->request->getPost();
            if(isset($post['actualizar'])){
                if ((($post['actualizar']) == '1') && ($post['contrato']) && ($post['num_consignacion'])&& ($post['estado'])){
                    $finicio = (isset($post['finicio']))?("'".$post['finicio']."'"):'null'; $ffin = (isset($post['ffin']))?("'".$post['ffin']."'"):'null';
                    $cliente ='';
                    if(isset($post['inquilinos'])){
                        foreach($post['inquilinos'] as $inq){
                            $cliente = ($cliente)?($cliente.','.$inq):$inq;
                        }
                    }
                    $contrato_arriendo = $post['contrato_arriendo'];
                   
                    $actualizar = $dependencias->actualizarexpediente($post['contrato'],$post['num_consignacion'],$finicio,$ffin,'13',$post['estado'],$cliente,$contrato_arriendo);

                    if(isset($actualizar) && $actualizar){
                        $this->template->add_messages('success','La consignación '.$post['num_consignacion'].' se actualizo con éxito.'); 
                    }else{
                        $this->template->add_messages('error','Algo salio mal al tratar de actualizar la consignación, por favor vuelva a intentarlo nuevamente.'); 
                    }
                    
                }
            }

            $get_documentos = $dependencias->get_documentos();
            if(isset($post['documentos']) && $post['contrato']){
                $namedepen='';
                foreach($get_dependencias as $depen){
                    if($depen['id_dependencia']=='13')
                        {$namedepen = $depen['nombre'];}
                }    

                if(isset($post['eliminar_imagen']) && $post['eliminar_imagen']){
                    $delete_imagen = $dependencias->eliminar_imagen_arriendo($post['contrato'], $post['eliminar_imagen']);
                    if(isset($delete_imagen) && $delete_imagen){
                        $this->template->session_messages('success','La imagen fue eliminada con exito.'); 
                    }else{
                        $this->template->session_messages('error','Algo salio mal al tratar de eliminar la imagen, por favor vuelva a intentarlo nuevamente.'); 
                    }
                    return $this->response->redirect('arriendos');
                }

                if(isset($get_documentos) && $get_documentos){
                    foreach($get_documentos as $docu){
                        $ruta_archivo = '';
                        $namearchivo = 'doc_'.$docu['id_documento'];
                        $file = $this->request->getFile($namearchivo);
                        $compl = (isset($post['comp_'.$docu['id_documento']]))?($post['comp_'.$docu['id_documento']]):'';

                        if(isset($file) && $file){
                            $fileExtension = $file->getClientExtension();
                            if(isset($fileExtension) && $fileExtension){
                                $ruta = $this->upload($file,$namedepen.'/'.$post['contrato']);
                                if($ruta['errors'] == 'success'){
                                    $ruta_archivo = $ruta['ruta'];
                                }else{
                                    $archivo_cargado = false;
                                    $this->template->session_messages('error',$ruta['errors']); 
                                }
                            }
                        }

                        if($ruta_archivo){
                            $dependencias->agregardocumento($docu['id_documento'],$compl,$ruta_archivo,$post['contrato']);
                        }
                    }
                }

                $files = $this->request->getFiles('imagenes');
                if(isset($_FILES['imagenes']['name'][0]) && !empty($_FILES['imagenes']['name'][0]) && isset($files["imagenes"])){
                    $descripcion_imagen = isset($post['descripcion_imagen']) ? trim($post['descripcion_imagen']) : '';
                    $complemento_imagen = ($descripcion_imagen) ? ('imagenes*w*'.$descripcion_imagen) : 'imagenes';
                    foreach($files["imagenes"] as $item){
                        $ruta = $this->upload($item,$namedepen.'/'.$post['contrato'].'/imagenes');
                        if($ruta['errors'] == 'success'){
                            $dependencias->agregardocumento('0',$complemento_imagen,$ruta['ruta'],$post['contrato']);
                        }else{
                            $this->template->session_messages('error',$ruta['errors']); 
                        }
                    }
                }

                $this->template->session_messages('success','El contrato de arriendo fue actualizada.'); 
                return $this->response->redirect('arriendos');
            }

            if(isset($post['eliminar'])){   
                if ((($post['eliminar']) == '1') && ($post['elimina'])){
                    $actualizar = $dependencias->elimiarexpediente($post['elimina'],'13');
                    if(isset($actualizar) && $actualizar){
                        $this->template->session_messages('success','El contrato de arriendo se elimino con éxito.'); 
                    }else{
                        $this->template->session_messages('error','Algo salio mal al tratar de eliminar el contrato de arriendo, por favor vuelva a intentarlo nuevamente.'); 
                    }
                    
                }
                return $this->response->redirect('arriendos');
            }

        }

        /*Agregado para la parte de agregar expediente*/
        $get_inmuebles = $dependencias->get_inmuebles('1',"'ARRIENDO'",true,'13');
        $this->template->add_data('get_inmuebles',$get_inmuebles);

        /*8 Arriendos y 9 ventas*/
        $this->template->add_data('tipoexpediente','13');
        $this->template->add_data('tiporeal','arriendos');

        $get_documentos = $dependencias->get_documentos();
        $this->template->add_data('documentos',$get_documentos);  
        if ($this->request->getMethod() === 'post') {
            $post = $this->request->getPost();
            
            if(isset($post['crearexpediente'])){
                
                $this->template->add_data('dependencias',$get_dependencias); 

                if ((($post['crearexpediente']) == '1') && ($post['contrato']) && ($post['dependencia']) && ($post['num_consignacion'])){
                    $finicio = ($post['finicio'])?("'".$post['finicio']."'"):'null'; $ffin = ($post['ffin'])?("'".$post['ffin']."'"):'null';
                    $cliente ='';
                    if(isset($post['inquilinos'])){
                /*    $cliente = explode(',',$post['clienter']);
                    $cliente = $cliente[0];*/
                        foreach($post['inquilinos'] as $inq){
                            $cliente = ($cliente)?($cliente.','.$inq):$inq;
                        }
                
                    }
                    $agrego = $dependencias->agregarexpedientearriendo($post['num_consignacion'],$post['contrato'],$finicio,$ffin,$post['dependencia'],'abierto',$cliente);
                    $sqlarchivo = '';
                    $namedepen='';
                    foreach($get_dependencias as $depen){
                        if($depen['id_dependencia']==$post['dependencia'])
                            {$namedepen = $depen['nombre'];}
                    }    

                    if(isset($get_documentos) && $get_documentos){
                        foreach($get_documentos as $docu){
                            $ruta_archivo = '';
                            $namearchivo = 'doc_'.$docu['id_documento'];
                            $file = $this->request->getFile($namearchivo);
                            $compl = (isset($post['comp_'.$docu['id_documento']]))?($post['comp_'.$docu['id_documento']]):'';

                            if(isset($file) && $file){
                                $fileExtension = $file->getClientExtension();
                                if(isset($fileExtension) && $fileExtension){
                                    $ruta = $this->upload($file,$namedepen.'/'.$post['num_consignacion']);
                                    if($ruta['errors'] == 'success'){
                                        $ruta_archivo = $ruta['ruta'];
                                    }else{
                                        $archivo_cargado = false;
                                        $this->template->add_messages('error',$ruta['errors']); 
                                    }
                                }
                            }

                            if($ruta_archivo){
                                $dependencias->agregardocumento($docu['id_documento'],$compl,$ruta_archivo,$post['num_consignacion']);
                            }
                        }
                    }
                    $files = $this->request->getFiles('imagenes');
                    $url_respuesta = '';
                    
                    if ((empty($_FILES['imagenes']['name'][0]))) {
                        $files = '';
                    }
                    if(isset($files) && $files){ 
                        
                        foreach($files["imagenes"] as $key => $item){
                            $token = bin2hex(openssl_random_pseudo_bytes(12));
                                $ruta = $this->upload($item,$namedepen.'/'.$post['num_consignacion'].'/imagenes');
                                if($ruta['errors'] == 'success'){
                                    $archivos[] = $ruta;
                                }else{
                                    $this->template->add_messages('info','El archivo no pude ser cargado.');
                                }
                        }
                        if(isset($archivos) && $archivos){
                            $descripcion_imagen = isset($post['descripcion_imagen']) ? trim($post['descripcion_imagen']) : '';
                            $complemento_imagen = ($descripcion_imagen) ? ('imagenes*w*'.$descripcion_imagen) : 'imagenes';
                            foreach($archivos as $files){
                                $dependencias->agregardocumento('0',$complemento_imagen,$files['ruta'],$post['num_consignacion']);
                            }
                        }
                    }


                        if(isset($agrego) && $agrego){
                            $this->template->session_messages('success','Consignación '.$post['num_consignacion'].' agregada con éxito.'); 
                        }else{
                            $this->template->session_messages('error','Algo salio mal al tratar de crear la consignación, por favor vuelva a intentarlo nuevamente.'); 
                        }
                        return $this->response->redirect('arriendos'); 
                        
                }
            }
        }
        $tipos_cliente = $dependencias->tipos_cliente();
        $this->template->add_data('tipos_cliente',$tipos_cliente);

        /*Fin de agregar expediente*/

        $get_dependencias = $dependencias->get_dependencias();
        $this->template->add_data('dependencias',$get_dependencias); 

        $get_arrendatarios = $dependencias->get_arrendatarios();
        $this->template->add_data('get_arrendatarios',$get_arrendatarios);   

        $expedientes = $dependencias->expedientes_compra('13','arrendado');
        $this->template->add_data('expedientes',$expedientes);  
        $this->template->add_js('assets/js/expediente');

        $this->template->active_sidebar('arriendos');
        $this->template->title_page('Arriendos');
        return $this->template->renderview('dependencias/arriendos','1');
    }
}



