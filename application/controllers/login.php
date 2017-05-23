<?php

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
		$this->load->model('login_model');
		$this->load->library(array('session','form_validation'));
		$this->load->helper(array('url','form'));
		$this->load->helper('date');
		$this->load->database('default');
    }
	
	public function index()
	{	
		switch ($this->session->userdata('perfil')) {
			case '':
				$data['token'] = $this->token();
				$this->load->view('login_view',$data);
				break;
			case '0':
				redirect(base_url().'index.php/profesor');
				break;
			case '1':
				redirect(base_url().'index.php/alumno');
				break;	
			default:		
				$this->load->view('login_view',$data);
				break;		
		}
	}

	public function new_user()
	{
		if($this->input->post('token') && $this->input->post('token') == $this->session->userdata('token'))
		{
            $this->form_validation->set_rules('username', 'Nombre', 'required|trim|min_length[2]|max_length[150]');
            $this->form_validation->set_rules('password', 'Contraseña', 
            	'required|trim|min_length[5]|max_length[150]');
 
            // Una vez establecidas las reglas, validamos los campos.
            $this->form_validation->set_message('required', 'El campo <b>%s</b> es obligatorio.');
            $this->form_validation->set_message('min_length', 'El campo <b>%s</b> debe tener al menos %s caracteres.');
            $this->form_validation->set_message('max_length', '<b>%s</b> no puede tener más de %s caracteres.');

            
			if($this->form_validation->run() == FALSE)
			{
				$this->index();
			}else{
				$username = $this->input->post('username');
				$password = sha1($this->input->post('password'));
				$check_user = $this->login_model->login_user($username,$password);
				if($check_user == TRUE)
				{
					// Comprobamos primero si la aplicación está disponible (sólo si es alumno).
					$app = $this->login_model->aplicacion_activa();
					if ($check_user->iPerfil == 1 && $app->iActiva == 0) {
						// Acceso a la aplicacion no permitido.
						redirect(base_url().'index.php/inactiva/');
					}
					// Registramos el acceso.
					$timestamp = date('Y-m-d G:i:s');
					$data = array('dFecha' => $timestamp , 
						'iId_Usuario' => $check_user->iId, 
						'sIP' => $this->input->ip_address(),
						'sNombreCompleto' => $check_user->sNombre.", ".$check_user->sApellidos);
					$this->db->insert('acceso', $data);

					$data = array(
	                'is_logued_in' 	=> 		TRUE,
	                'id_usuario' 	=> 		$check_user->iId,
	                'perfil'		=>		$check_user->iPerfil,
	                'username' 		=> 		$check_user->sUsuario,
	                'iId_Partida'	=>		'',
	                'iId_Panel'		=>		'',
	                'iTurno'		=>		'',
	                'tirada'		=>		'',
	                'pregunta'		=>		'0'
            		);		
					$this->session->set_userdata($data);
					//$this->session->mark_as_temp($data, 30);
					$this->index();
				}
			}
		}else{
			redirect(base_url().'index.php/login');
		}
	}
	
	public function token()
	{
		$token = md5(uniqid(rand(),true));
		$this->session->set_userdata('token',$token);
		return $token;
	}
	
	public function logout_ci()
	{
		$this->session->sess_destroy();
		redirect(base_url().'index.php/login');
	}
}