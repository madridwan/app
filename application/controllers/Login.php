<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$this->load->library('user_agent');

		$config_url = $this->config->item('env');
		$package = $this->config->item('package');
		$scheme = $this->config->item('scheme');

		if ($this->agent->is_browser())
		{
			$agent = $this->agent->browser().' '.$this->agent->version();
		}
		elseif ($this->agent->is_robot())
		{
			$agent = $this->agent->robot();
		}
		elseif ($this->agent->is_mobile())
		{
			$agent = $this->agent->mobile();
		}
		else
		{
			$agent = 'Unidentified User Agent';
		}

		$path = 'assets/img/selamat_selamat_copy.jpg';
		$type = pathinfo($path, PATHINFO_EXTENSION);
		$data = file_get_contents($path);
		$base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
		$single_param = $this->input->get('code');
		$data = [
			'param' => $single_param,
			'url' => $config_url,
			'image' => $base64,
			'package' => $package,
			'scheme' => $scheme
		];

		if ($this->agent->platform() == "Android") {
			return $this->load->view('android_login', $data);
		} elseif ($this->agent->platform() == "iOS") {
			return $this->load->view('ios_login', $data);
		} else {
			return $this->load->view('other', $data);
		}
	}
}
