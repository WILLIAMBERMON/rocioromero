<?php

namespace App\Entities;
use CodeIgniter\Entity;
use CodeIgniter\I18n\Time;
use Config\Services;

class Template extends Entity
{

    private $dataw;
	
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);
		$this->_js = '';
		$this->_css = '';
		$this->title_page = '';
		$this->active_sidebar = '';
		$this->dataw = array();
		$this->sticky = false;
	}

    public function renderview($view,$admin=0){
	  $template='template/template';
		if($admin){
			$template='template_admin/template';
		}
		$usuario_pqrsd = '';
		if($this->get_session('usuario_pqrsd')){
            $usuario_pqrsd = $this->get_session('usuario_pqrsd');
        }

		$vieww = ['view'=>$view,'title_page'=>$this->title_page,'js'=>$this->_js,'css'=>$this->_css,'active_sidebar'=>$this->active_sidebar,'usuario_pqrsd'=>$usuario_pqrsd];
		//$infoextra = ['data' =>$this->dataw];
		//$view = array_push($view,$infoextra);
		$vieww['data']=$this->dataw;
		$key = $this->dataw;
		if (is_array($key)) {
            foreach ($key as $k => $v) {
                $vieww[$k] = $v;
            }
        } elseif ($key) {
            $vieww[$key] = $value;
        }
		echo view($template,$vieww);
	}

    protected function _ci_object_to_array($object)
	{
		return is_object($object) ? get_object_vars($object) : $object;
	}

	public function active_sidebar($item){
		$this->active_sidebar = $item;
	}

	public function title_page($titulo){
		$this->title_page = $titulo;
	}

	public function add_data($key,$value){
		//array_push($this->dataw,[$key=>$value]);
		if (is_array($key)) {
            foreach ($key as $k => $v) {
                $this->dataw[$k] = $v;
            }
        } elseif ($key) {
            $this->dataw[$key] = $value;
        }
	}

	public function add_js($js){
		$this->_js .= '<script src="'.base_url($js).'.js"></script>';
	}

	public function add_css($css){
		$this->_css .= '<link href="'.base_url($css).'.css" rel="stylesheet">';
	}

	public function add_messages($tipo,$mensaje){
		if(($tipo == 'success') || ($tipo == 'info') || ($tipo == 'error') || ($tipo == 'warning')){
			$this->_js .= '<script>toastr.'.$tipo.'("'.$mensaje.'");</script>';
		}
	}

	public function session_messages($tipo,$mensaje){
		if(($tipo == 'success') || ($tipo == 'info') || ($tipo == 'error') || ($tipo == 'warning')){
			$s = Services::session();
			$s->set($tipo, $mensaje);
		}
	}

	public function set_session($name,$value){
		$s = Services::session();
		$s->set($name, $value);
	}

	public function get_session($name){
		$s = Services::session();
		return $s->get($name);
	}

	public function remove_session($name){
		$s = Services::session();
		return $s->remove($name);
	}	

	public function logout(){
		$s = Services::session();
		return $s->destroy();
	}

	public function notificaciones($variables){
		
		$tipos = ['success','info','error','warning'];
		foreach($tipos as $tipo){
			if($variables->get($tipo)){
				$this->add_messages($tipo,$variables->get($tipo));
				$variables->remove($tipo);
			}
		}
	}
}