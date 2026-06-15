<?php

namespace App\Controllers;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\Files\Exceptions\FileNotFoundException;
use App\Models\IndexModel;
use CodeIgniter\Files\File;


class Index extends BaseController
{

    

	public function index()
	{
        if($this->template->get_session('url_documento')){
            $url = $this->template->get_session('url_documento');
            $this->template->remove_session('url_documento');
            $name = $url;
            $partes = explode('.',$url);
            $extension = $partes[count($partes)-1];
            $doc = $_SERVER['DOCUMENT_ROOT'].'../../uploads/'.$url;
           // echo $extension.'<br>'.$doc; exit;
            switch ($extension) {
    
                case 'docx':
                case 'doc':
                case 'DOCX':
                case 'DOC':
                    header('Content-Type: application/msword');
                    header('Content-Length: ' . filesize($doc));
                    break;
                case 'xlsx':
                case 'xls':
                case 'XLSX':
                case 'XLS':
                    header('Content-Type: application/x-msexcel');
                    break;
                case 'ppt':
                case 'pptx':
                case 'PPT':
                case 'PPTX':
                    header('Content-Type: application/vnd.ms-powerpoint');
                    break;
                case 'txt':
                case 'TXT':
                    header('Content-Type:text/plain');
                    header('Content-Length: ' . filesize($doc));
                    header('Content-Type:application/force-download');
                    break;
                case 'rar':
                case 'zip':
                case 'RAR':
                case 'ZIP':
                    header('Content-Type:application/x-rar-compressed');
                    header('Content-Type:application/force-download');
                    break;
                case 'odt':
                case 'ODT':
                    header('Content-Type:application/vnd.oasis.opendocument.text');
                    break;
                case 'ods':
                case 'ODS':
                    header('Content-Type:application/vnd.oasis.opendocument.spreadsheet');
                    break;
                case 'odp':
                case 'ODP':
                    header('Content-Type:application/vnd.oasis.opendocument.presentation');
                    break;
                case 'pdf':
                case 'PDF':
                    header('Content-Length: ' . filesize($doc));
                    header('Content-Type: application/pdf');
                    break;
                case 'jpg':
                case 'png':
                case 'jpeg':
                case 'JPG':
                case 'PNG':
                case 'JPEG':
                    header('Content-Length: ' . filesize($doc));
                    header('Content-Type:image/' . $extension);
                    break;
            }
            header("Content-Transfer-Encoding: binary");
            header("Content-type: application/octet-stream");
            header("Content-Disposition: attachment; filename=$name");
            header('Content-Type:application/force-download');
            header("Content-Length: filesize($doc)");
            $fp = fopen("$doc", "r");
            fpassthru($fp);
            }
        $this->template->add_css('assets/css/home');
        $this->template->title_page('Home PQRSD');
        return $this->template->renderview('index/home');
    }

    public function login()
	{
        if($this->template->get_session('usuario_pqrsd')){
            $persona = $this->template->get_session('usuario_pqrsd');
            $nombres = $persona['nombres'].' '.$persona['apellidos'];
            $this->template->session_messages('success','Bienvenido nuevamente '.$nombres);
            return $this->response->redirect('procesos');
        }
        if ($this->request->getMethod() === 'post') {
			$post = $this->request->getPost();
            if($post['login'] == '1'){
                
                $indexmodel = new IndexModel();
                $usuario = $indexmodel->usuario($post['documento']);
                if($usuario){
                    
                    $user = array(
                        "nombres" => $usuario[0]['nombres'],
                        "apellidos" => $usuario[0]['apellidos'],
                        "email"   => $usuario[0]['email'],
                        "documento"  => $usuario[0]['documento'],
                        "tipo_usuario"  => "usuario",
                        "dependencia"  => "",
                    );
                    $clave_valida = true;
                    if(ENVIRONMENT == 'production'){
                        $clave_valida = $this->validarClaveUsuario($post['password'], $usuario[0]['clave']);
                    }

                    if($clave_valida){
                        $nombres = $usuario[0]['nombres'].' '.$usuario[0]['apellidos'];
                        $this->template->set_session('usuario_pqrsd',$user);
                        $this->template->session_messages('success','Bienvenido nuevamente '.$nombres);
                        return $this->response->redirect('procesos');
                    }else{
                        $this->template->add_messages('error','La clave ingresada no es correcta.');
                    }
                }else{
                        $this->template->add_messages('error','El documento ingresado no se encuentra registrado.');
                }
            }
        }

        $this->template->title_page('Login');
        return $this->template->renderview('index/login');
    }

   /* public function radicar($tiporadicado = '')
	{
        $indexmodel = new IndexModel();
        $this->template->add_data('tiporadicado',$tiporadicado);      

        $radicadosmodel = new RadicadosModel();
        $get_dependencias = $radicadosmodel->get_dependencias();
        $this->template->add_data('dependencias',$get_dependencias);   

        if ($this->request->getMethod() === 'post') {
			$post = $this->request->getPost();
            $sql = array();
            $error = '';
            $ruta_archivo = '';
			if ((($post['radicar']) == '1') && (isset($post["anonima"]))  && (isset($post["tipo_pqrsd"]))  && (isset($post["dependencia"]))  && (isset($post["descripcion"]))) {
                $archivo_cargado = true;

                $file = $this->request->getFile('archivo_soporte');
                
                if(isset($file) && $file){
                    $fileExtension = $file->getClientExtension();
                    if(isset($fileExtension) && $fileExtension){
                        $ruta = $this->upload();
                        if($ruta['errors'] == 'success'){
                            $ruta_archivo = $ruta['ruta'];
                        }else{
                            $archivo_cargado = false;
                            $this->template->add_messages('error',$ruta['errors']); 
                        }
                    }
                }
                
                if($post["anonima"]=='NO'){
                    $variables = ['tiene_codigo','codigo','tipo_documento','documento','nombres','apellidos','celular','email'];
                    foreach($variables as $var){
                        if((isset($post[$var]))){
                            array_push($sql,[$var => $post[$var]]);
                        }else{
                            if(($var == 'codigo')){
                                if(($post["tiene_codigo"]=='SI')){
                                    if((isset($post[$var]))){
                                        array_push($sql,[$var => $post[$var]]);
                                    }else{
                                        $error = ($error)?($error.', '.$var.' es obligatorio'):' '.$var.' es obligatorio';
                                    }
                                }else{
                                    array_push($sql,[$var => '']);
                                }
                            }else{
                                $error = ($error)?($error.', '.$var.' es obligatorio'):' '.$var.' es obligatorio';
                            }
                        }
                    }
                    $variables2 = ['anonima','tipo_pqrsd','dependencia','descripcion'];
                    foreach($variables2 as $var2){
                        if((isset($post[$var2]))){
                            array_push($sql,[$var2 => $post[$var2]]);
                        }else{
                            $error = ($error)?($error.', '.$var2.' es obligatorio'):' '.$var2.' es obligatorio';
                        }
                    }
                    
                }else{
                    $variables = ['tiene_codigo','codigo','tipo_documento','documento','nombres','apellidos','celular','email'];
                    foreach($variables as $var){
                        if((isset($post[$var]))){
                            array_push($sql,[$var => $post[$var]]);
                        }else{
                            array_push($sql,[$var => '']);
                        }
                    }
                    $variables2 = ['anonima','tipo_pqrsd','dependencia','descripcion'];
                    foreach($variables2 as $var2){
                        if((isset($post[$var2]))){
                            array_push($sql,[$var2 => $post[$var2]]);
                        }else{
                            $error = ($error)?($error.', '.$var2.' es obligatorio'):' '.$var2.' es obligatorio';
                        }
                    }
                }
                
                if($error || !$archivo_cargado){
                    if($error){
                    $this->template->add_messages('error','Los siguientes campos contienen errores: '.$error.'.');}
                }else{
                    $token = bin2hex(openssl_random_pseudo_bytes(12));
                    array_push($sql,['token' => $token]);
                    if($ruta_archivo){
                        array_push($sql,['url_soporte' => $ruta_archivo]);
                    }
                    $campos = ''; $valores = '';

                    foreach($sql as $col){
                        foreach ($col as $name => $valor) {
                        $campos = ($campos)?($campos.", ".$name):($name);
                        $valores = ($valores)?($valores.", '".$valor."'"):("'".$valor."'");
                        }
                    }    
                    $radicado = $indexmodel->radicarpqrsd("INSERT INTO radicado (".$campos.") VALUES (".$valores.")");
                    if(isset($radicado) && $radicado){
                        $this->template->set_session('token',$token);
                        $this->template->session_messages('success','La solicitud de radicar PQRSD fue realizada satisfactoriamente.');
                        return $this->response->redirect('radicar');
                    }else{
                        $this->template->add_messages('error','Algo salio mal al tratar de radicar un PQRSD, por favor vuelva a intentarlo nuevamente.'); 
                    }
                    
                }
                
            }else{
                $this->template->add_messages('error','Debe completar el formulario para poder radicar un PQRSD');
            }
            
        }
        $token = '';
        if($this->template->get_session('token')){
            $token = $this->template->get_session('token');
            $radicado = $indexmodel->verificarradicado($token);
            if(isset($radicado) && $radicado){
                $this->template->add_data('radicado',$radicado[0]);
            }
        }
        $this->template->add_data('token',$token);

        $this->template->add_css('assets/css/select2w.min');
        $this->template->add_js('assets/js/select2w.min');
        

        $this->template->add_css('assets/css/radicar');
        $this->template->add_js('assets/js/radicar');
        $this->template->title_page('Radicar PQRSD');
        return $this->template->renderview('index/radicar');
        //return view('template/template', ['view'=>'index/home']);
    }*/

    public function registro()
	{
        
        if($post = $this->request->getPost()){
            if($post['registrarse'] == '1'){
                if(($post['tipo_documento']) && ($post['documento']) && ($post['nombres']) && ($post['apellidos']) && ($post['celular']) && ($post['email']) && ($post['password']) && ($post['rpassword']) && (($post['password']) == ($post['rpassword']))){
                    $clave = $this->codificarClaveUsuario($post['password']);
                    $token = bin2hex(openssl_random_pseudo_bytes(12));
                    $indexmodel = new IndexModel();
                    $registro = $indexmodel->registrarse($post['tipo_documento'],$post['documento'],$post['nombres'],$post['apellidos'],$post['celular'],$post['email'],$clave,$token);
                    if(isset($registro) && $registro){
                        
                        $this->sendMail("Finalizar registro", "Finalizar registro", "Para finalizar el proceso de registro en el portal Inmobiliaria Rocio Romero, es necesario que acceda al siguiente link: <br>", "<a href='".base_url('activar_usuario/'.$token)."' target='_blank' title='Activar Usuario'>Activar Usuario Rocio Romero</a><br><br>", $post['email'], "noreply@ufps.edu.co", true);
                        $this->template->session_messages('success','El registro fue realizado con éxito, por favor revise su correo electronico ('.$post['email'].') para terminar con el registro.');
                        return $this->response->redirect('registro');
                    }else{
                        $this->template->add_messages('error','Algo salio mal, por favor vuelva a intentar enviar el formulario.');
                    }
                }else{
                    $this->template->add_messages('error','El formulario de registro no se lleno satisfactoriamente.');
                }
                
            }
        }    
        $this->template->add_css('assets/css/select2w.min');
        $this->template->add_js('assets/js/select2w.min');

        $this->template->add_css('assets/css/registro');
        $this->template->add_js('assets/js/radicar');
        $this->template->title_page('Radicar PQRSD');
        return $this->template->renderview('index/registro');
        //return view('template/template', ['view'=>'index/home']);
    }

    public function activar_usuario($llave){
        $indexmodel = new IndexModel();
        $info_usuario = $indexmodel->info_usuario($llave);

        if(isset($info_usuario) && $info_usuario){
            $this->template->add_data('info',$info_usuario[0]);
            $this->template->add_data('llave',$llave);
        }else{
            return $this->response->redirect(base_url('/login'));    
        }

        if($post = $this->request->getPost()){
            if($post['registrarsew'] == '1'){
                if((($post['password']) && ($post['rpassword']) && (($post['password']) == ($post['rpassword'])))){
                    $clave = $this->codificarClaveUsuario($post['password']);
                    $indexmodel = new IndexModel();
                    $registro = $indexmodel->updateregistro($clave,$llave);
                    if(isset($registro) && $registro){
                        $email = $info_usuario[0]['email'];
                        $this->sendMail("Registro finalizado", "Registro finalizado", "A partir de este momento puede ingresar al portal de la Inmobiliaria Rocio Romero a traves del siguiente link: <br>", "<a href='".base_url()."' target='_blank' title='Ingresar'>Ingresar a Rocio Romero</a><br><br>", $email, "noreply@ufps.edu.co", true);
                        $this->template->session_messages('success','El registro fue realizado con éxito, por favor revise su correo electronico ('.$email.').');
                        sleep(1);
                        return $this->response->redirect('login');
                    }else{
                        $this->template->add_messages('error','Algo salio mal, por favor vuelva a intentar enviar el formulario.');
                    }
                }else{
                    $this->template->add_messages('error','El formulario de registro no se lleno satisfactoriamente.');
                }
                
            }
        }

       /* $activar_usuario = $indexmodel->activar_usuario($llave);
        if(isset($activar_usuario) && $activar_usuario){
            $this->template->session_messages('success','El usuario fue activado con éxito. Desde este momento puede ingresar al portal PQRSD UFPS.');
        }else{
            $this->template->session_messages('error','El toquen ingresado no es valido, por favor verifique el enlace de activación.');
        }
        return $this->response->redirect(base_url('/login'));*/
        $this->template->add_css('assets/css/registro');
        $this->template->add_js('assets/js/active');
        $this->template->title_page('Activar usuarios');
        return $this->template->renderview('users/active');
    }

    public function buscarinfo2()
    {
        if ($this->request->isAJAX()) {
            $post = $this->request->getPost();
            $codigo = $post['codigo'];
            if(isset($codigo)) {
                $indexmodel = new IndexModel();
                $info = $indexmodel->buscarinfo($codigo);
                if(isset($info) && $info){
                    return json_encode(array('carga'=> true, 'infod' => $info[0]));
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

    public function buscarinfo(){
        if ($this->request->isAJAX()) {
            $post = $this->request->getPost();
            $codigo = $post['codigo'];
            //return json_encode(array('carga' => false,'mensaje'=> 'passsso')); 
            if(isset($codigo)) {
                $login = array("usuario"=>"yCT+Cv4WhX3W9YeqfEBE0mQtYPs","clave"=>"39Xpy0ynhCCsGLJ5LcbYtbVYork");
                $ch = curl_init( "http://192.168.13.181:10001/Apiufps/token" );
                curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
                curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query($login) );
                curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
                curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0); 
                curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
                $result = curl_exec($ch);
                $err = curl_error($ch);
                $token = '';
                if(isset($result) && $result){
                    if(isset($err) && $err){
                        echo '<script>toastr.error("'.$err.'");</script>';
                    }else{
                        curl_close($ch);
                        $token = $result;
                        $datos = array("token"=>$token,"documento"=>$codigo);
                        $consultainfo = curl_init( "http://192.168.13.181:10001/Apiufps/infousuario" );
                        curl_setopt($consultainfo, CURLOPT_CONNECTTIMEOUT, 10);
                        curl_setopt( $consultainfo, CURLOPT_POSTFIELDS, http_build_query($datos) );
                        curl_setopt ($consultainfo, CURLOPT_SSL_VERIFYHOST, 0);
                        curl_setopt ($consultainfo, CURLOPT_SSL_VERIFYPEER, 0); 
                        curl_setopt( $consultainfo, CURLOPT_RETURNTRANSFER, true );
                        $resultinfo = curl_exec($consultainfo);
                        $err = curl_error($consultainfo);
                        if($err){
                            echo '<script>toastr.error("'.$err.'");</script>';
                        }
                        curl_close($consultainfo);
                    }
                }
                if(isset($resultinfo) && $resultinfo){
                    $informacion = json_decode($resultinfo);
                    if($informacion->LDAP == 'S'){
                        $this->template->session_messages('info','Hemos detectado que ya se encuentras registrado, accede con la contraseña registrada.');
                    }
                    return json_encode(array('carga'=> true, 'infod' => $resultinfo,'registrado'=>'N'));
                }else{
                    
                    $indexmodel = new IndexModel();
                    $info = $indexmodel->usuario($codigo);
                    if(isset($info) && $info){
                        $this->template->session_messages('info','Hemos detectado que ya se encuentras registrado, accede con la contraseña registrada.');
                        return json_encode(array('carga'=> true, 'infod' => $info[0],'registrado'=>'S'));
                    }else{
                        return json_encode(array('carga' => false,'mensaje'=> 'nada3'));
                    }
                }
            }else{
                return json_encode(array('carga' => false,'mensaje'=> 'nada2'));
            }
        } else {
            return json_encode(array('carga' => false,'mensaje'=> 'nada'));
        }
        

    }

    

    public function admin()
	{

        $this->template->active_sidebar('admin');
        $this->template->title_page('Admin PQRSD');
        return $this->template->renderview('index/admin','1');
    }

    public function radicado(){
        
        $this->template->active_sidebar('radicado');
        $this->template->title_page('Radicar PQRSD');
        return $this->template->renderview('index/radicar','1');
    }

    /*public function radicados()
	{

        $persona = $this->template->get_session('usuario_pqrsd');
        $radicados = new IndexModel();
        $informacion = $radicados->get_radicados_persona($persona["documento"]);
        $this->template->add_data('informacion',$informacion);
        $radicadosmodel = new RadicadosModel();
        $get_dependencias = $radicadosmodel->get_dependencias();
        $this->template->add_data('dependencias',$get_dependencias);
        $this->template->active_sidebar('radicados_personales');
        $this->template->title_page('Radicados PQRSD');
        return $this->template->renderview('index/radicados','1');
    }*/

    public function consultas()
	{
        if ($this->request->getMethod() === 'post') {
			$post = $this->request->getPost();
			if (($post['consultar'] == '1') && ($post['numeroradicado'])){
                
                $indexmodel = new IndexModel();
                $token = $post['numeroradicado'];
                $this->template->add_data('token',$token);
                $radicado = $indexmodel->verificarradicado($token);
                if(isset($radicado) && $radicado){
                    $this->template->add_data('radicado',$radicado[0]);
                    $this->template->add_messages('success','Radicado encontrado'); 
                }else{
                    $this->template->add_messages('error','Número de radicado digitado no fue encontrado o no se registo bajo la modalidad de anonimo.'); 
                }
            } 
        }
        $this->template->title_page('Consultas PQRSD');
        return $this->template->renderview('index/consultas');
    }

    public function logout()
	{
        $this->template->logout();
        return $this->response->redirect('/');
    }

    function visualizarsoporte(){
        //$url = 'var/www/html/rocio_romero/public/uploads/Ventas/123456/1722133789_f6881b5ed9b26a2b4f19.pdf';
        $url = $this->request->getPost('ruta');
        $url = (((substr($url, 0,1)) != '/')?'/':'').$url;
        //echo var_dump(realpath($url));exit;
        /*$partesurl = explode('/',$url);
        $comenzarruta = false;
        $rutaarchivo = '';
        foreach($partesurl as $purl){
            if($purl == 'uploads'){
                $comenzarruta = true;
            }
            if($comenzarruta){
                $rutaarchivo = $rutaarchivo.'/'.$purl;
            }
        }
        echo $_SERVER['DOCUMENT_ROOT']; exit;
        //
        //$name = $url;*/
        $partes = explode('.',$url);
        $extension = $partes[count($partes)-1];
        
        $ruta_real = realpath($url); 
        $data = '';
        if($ruta_real){
            $ruta_real = base64_encode(file_get_contents($ruta_real));
            if((strtoupper($extension) == 'PDF')){
                $data = '<object data="data:application/pdf;base64,'.$ruta_real.'"  type="application/pdf" width="100%" height="400px"/>';
            }
            if((strtoupper($extension) == 'JPG')||(strtoupper($extension) == 'PNG')||(strtoupper($extension) == 'JPEG')){
                $data = '<center><img width="50%" src="data:image/'.(strtolower($extension)).';base64,' . $ruta_real . '"/></center>';
            }
            if($data){
                return json_encode(array('carga' => true,'data'=>$data));
                exit;
            }
        }
        return json_encode(array('carga' => false));
        exit;
    }

    function file_delete($url){
        echo $url;
        return true;
    }
}
