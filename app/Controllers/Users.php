<?php

namespace App\Controllers;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\Files\Exceptions\FileNotFoundException;
use App\Models\UsersModel;
use CodeIgniter\Files\File;



class Users extends BaseController
{
    public function create(){
        if(!$this->template->get_session('usuario_pqrsd')){
            return $this->response->redirect('login');
        }
        $usermodel = new UsersModel();
        $get_users = $usermodel->usuario();
        $this->template->add_data('usuarios',$get_users);   

        if($post = $this->request->getPost()){
            if($post['agregarusuario'] == '1'){
                if(($post['tipo_documento']) && ($post['documento']) && ($post['nombres']) && ($post['apellidos']) && ($post['celular']) && ($post['email'])){
                    $token = bin2hex(openssl_random_pseudo_bytes(12));
                    $registro = $usermodel->registrarse($post['tipo_documento'],$post['documento'],$post['nombres'],$post['apellidos'],$post['celular'],$post['email'],'',$token);
                    if(isset($registro) && $registro){
                        
                        $this->sendMail("Finalizar registro", "Finalizar registro", "Para finalizar el proceso de registro en el portal Inmobiliaria Rocio Romero, es necesario que acceda al siguiente link: <br>", "<a href='".base_url('activar_usuario/'.$token)."' target='_blank' title='Activar Usuario'>Activar Usuario Rocio Romero</a><br><br>", $post['email'], "noreply@ufps.edu.co", true);
                        $this->template->session_messages('success','El registro fue realizado con éxito, por favor revise su correo electronico ('.$post['email'].') para terminar con el registro.');
                        return $this->response->redirect('createuser');
                    }else{
                        $this->template->add_messages('error','Algo salio mal, por favor vuelva a intentar enviar el formulario.');
                    }
                }else{
                    $this->template->add_messages('error','El formulario de registro no se lleno correctamente.');
                }
                
            }

            if($post['agregarusuario'] == '2'){
                if(($post['tipo_documento']) && ($post['documento']) && ($post['nombres']) && ($post['apellidos']) && ($post['celular']) && ($post['email']) && $post['cambioclave']){
                    $token = '';
                    if($post['cambioclave'] == 'SI'){
                        $token = bin2hex(openssl_random_pseudo_bytes(12));
                    }
                    $registro = $usermodel->updateregistro($post['tipo_documento'],$post['documento'],$post['nombres'],$post['apellidos'],$post['celular'],$post['email'],'',$token);
                    if(isset($registro) && $registro){
                        if($post['cambioclave'] == 'SI'){
                        $this->sendMail("Cambio de clave", "Cambio de clave", "Para finalizar el proceso de cambio de clave en el portal Inmobiliaria Rocio Romero, es necesario que acceda al siguiente link: <br>", "<a href='".base_url('activar_usuario/'.$token)."' target='_blank' title='Cambiar clave'>Cambiar clave Usuario Rocio Romero</a><br><br>", $post['email'], "noreply@ufps.edu.co", true);
                        }
                        $this->template->session_messages('success','La actualización fue realizada con éxito.');
                        return $this->response->redirect('createuser');
                    }else{
                        $this->template->add_messages('error','Algo salio mal, por favor vuelva a intentar enviar el formulario.');
                    }
                }else{
                    $this->template->add_messages('error','El formulario de actualización tro no se lleno correctamente.');
                }
                
            }
        }   

        $this->template->add_js('assets/js/create');
        $this->template->active_sidebar('createuser');
        $this->template->title_page('Create users');
        return $this->template->renderview('users/create','1');
    }

}

