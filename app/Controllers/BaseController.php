<?php
namespace App\Controllers;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 *
 * @package CodeIgniter
 */

use CodeIgniter\Controller;
use CodeIgniter\Database\BaseConnection;
use CodeIgniter\Session\Session;
use App\Entities\Template;
use Config\Services;
use App\Libraries\AuthLdap;
use CodeIgniter\Files\Exceptions\FileNotFoundException;
use CodeIgniter\Files\File;

class BaseController extends Controller
{

	/**
	 * An array of helpers to be loaded automatically upon
	 * class instantiation. These helpers will be available
	 * to all other controllers that extend BaseController.
	 *
	 * @var array
	 */
	protected $helpers = ['form', 'url'];
	/** @var Session */
	protected $session;
	/** @var BaseConnection */
	protected $db;
	
	protected $authLdap;
	/**
	 * Constructor.
	 */
	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);

		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------
		$this->session = \Config\Services::session();
		//$this->db = \Config\Database::connect();
		$this->template = new Template();
		$this->template->notificaciones(Services::session());
		$this->ldap = new AuthLdap();
		$this->email = \Config\Services::email();
		// $this->authLdap = new AuthLdap();
		//$this->_js = '';
		//$this->_css = '';
		//$this->title_page = '';
//$this->data = array();
	}
/*
	public function renderview($view){
		
		echo view('template/template', ['view'=>$view,'title_page'=>$this->title_page,'data'=>$this->data,'js'=>$this->_js,'css'=>$this->_css]);

//		echo view ('template/header');
//		echo view ($view,$data);

//echo view ('template/footer');
	}

	public function title_page($titulo){
		$this->title_page = $titulo;
	}

	public function add_data($key,$value){
		//array_push($this->data,[$variable=>$valor]);
		if (is_array($key)) {
            foreach ($key as $k => $v) {
                $this->data[$k] = $v;
            }
        } elseif ($key) {
            $this->data[$key] = $value;
        }
	}

	public function add_js($js){
		$this->_js .= '<script src="'.base_url($js).'.js"></script>';
	}

	public function add_css($css){
		$this->_css .= '<link href="'.base_url($css).'.css" rel="stylesheet">';
	}*/
	/**
     * Función que utiliza una plantilla estandar de la institución para enviar correos electronicos a cualquier destinatario.
     * 
     * @param String $tittle - Titulo del Cuerpo del mensaje
     * @param String $subject - Asunto del mensaje
     * @param String $body - Contenido del Cuerpo del mensaje.
     * @param String $link - Enlace del cuerpo del mensaje (Usado cuando se envian correos de activación de usuarios o recuperación de claves)
     * @param String $to - A quien se le envia el mensaje.
     * @param String $from - Quien envia el mensaje 
     * 
     * Generalmente se utiliza un correo que contenga la palabra "noreply", 
     * este correo puede existir o no. Debe ser del dominio @ufps.edu.co. 
     * Ejemplo: notifications-noreply@ufps.edu.co
     * 
     * @param boolean $template - Por defecto es TRUE, en caso de ser FALSE no utilizada la plantilla institucional
     * @return boolean - TRUE: Mensaje enviado con éxito, FALSE  de lo contrario.
     */
    public function send_emailw($tittle = "", $subject = "", $body = "", $link = "", $to = NULL, $from = NULL, $template = TRUE)
    {

        if (!$to && !$from) {
            return FALSE;
        }
		$this->email = new CI_Email();
        

        $configGmail = $this->_mailConfigPostfix();
        $this->email->initialize($configGmail);
        $this->email->clear(TRUE);
        //        $this->dump(base_url("assets/email/email_tpl.html"));
        //        $this->dump(file_get_contents(base_url("assets/email/email_tpl.html")));
        if ($template) {
            $tpl = "assets/email/email_tpl.php";
            $file = fopen($tpl, "r");
            $html = fread($file, filesize($tpl));
            //$html = file_get_contents(base_url("assets/email/email_tpl.php"));
            $html = str_replace("@tittle-email", $tittle, $html);
            $html = str_replace("@body-email", $body, $html);
            $html = str_replace("@link-email", $link, $html);
        } else {
            $html = $body;
        }

        $this->email->fromEmail($from, 'División de Sistemas UFPS');
        $this->email->to(strtolower($to));

        $this->email->subject($subject);
        $this->email->message($html);
        $send = $this->email->send();
        //        $this->dump($this->email->print_debugger());
        return $send;
    }

    private function _mailConfigGmail($credentials = array())
    {
        if (empty($credentials)) {
            exit;
        }

        $configMail = array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://smtp.gmail.com',
            'smtp_port' => 465,
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n"
        );

        $configMail['smtp_user'] = $credentials['smtp_user'];
        $configMail['smtp_pass'] = $credentials['smtp_pass'];

        return $configMail;
    }

    private function _mailConfigPostfix()
    {
        $mailConfig = array(
            'protocol' => 'smtp',
            'smtp_host' => 'ssl://mail.ufps.edu.co',
            'smtp_port' => 465,
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'newline' => "\r\n"
        );

        if (ENVIRONMENT == 'development') {
            $mailConfig['smtp_user'] = "Divisist180";
            $mailConfig['smtp_pass'] = "C0rre0M4sib0180";
        } else {
            $mailConfig['smtp_user'] = "Divisist8";
            $mailConfig['smtp_pass'] = "C0rre0M4sib0";
        }

        return $mailConfig;
    }

	function sendMail($tittle = "", $subject = "", $message = "", $link = "", $to = NULL, $from = NULL, $template = TRUE) {

		// Datos el email destino. Donde irá a parar el formulario
		$this->email->setTo($to);
	
		// Email desde el que se envía (el que hemos configurarado en el apartado anterior)
		$this->email->setFrom($from);
	
		$this->email->setSubject($subject);

		if ($template) {
            $tpl = "assets/email/email_tpl.php";
            $file = fopen($tpl, "r");
            $html = fread($file, filesize($tpl));
            //$html = file_get_contents(base_url("assets/email/email_tpl.php"));
            $html = str_replace("@tittle-email", $tittle, $html);
            $html = str_replace("@body-email", $message, $html);
            $html = str_replace("@link-email", $link, $html);
        } else {
            $html = $body;
        }

		$this->email->setMessage($html);
	
		if ($this->email->send())
		{
			$data = [
				'msg'	=> 'Email enviado correctamente'
			];
		}
		else
		{
			$data = [
				'msg'	=> 'Email No enviado'
			];
		}
	
		return $data;
	}


    public function upload($file='',$carpeta='')
    {
        if(!$file){
            $file = $this->request->getFile('url_respuesta');
        }
     
        if(isset($file) && $file){
                $fileExtension = $file->guessExtension();
                $allowedfileExtensions = array('jpg','jpeg', 'gif', 'png', 'zip', 'txt', 'xls', 'doc', 'docx', 'pdf','ppt','pptx','xls','xlsx');
                if (in_array($fileExtension, $allowedfileExtensions))
                {    
                    if ($file->isValid() && ! $file->hasMoved()) {
                        $newName = $file->getRandomName();
                        $file->move('uploads/'.$carpeta.'/' , $newName);
                        $filepath = 'uploads/'.$carpeta.'/' . $newName;
                        $filef = new File($filepath);
                        $data = [
                        'name' =>  $file->getName(),
                        'type'  => $file->getClientMimeType(),
                        'ruta' => $filef->getRealPath(),
                        'size' => $filef->getSizeByUnit('kb'),
                        'ext' => $filef->guessExtension(),
                        'errors' => 'success'
                        ];
                        return $data;
                    }
                   else{
                    $data = ['errors' => 'El archivo cargado fue movido y no pudo ser encontrado.'];
                    return $data;
                    }
                }else{
                $data = ['errors' => 'El archivo cargado tiene una extensión no permitida.'];
                return $data;
                }
            }else{
                $data = ['errors' => 'No se cargo ningún archivo. '];
                return $data;
            }
    }
    
}
