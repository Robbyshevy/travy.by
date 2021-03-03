<?php  
class ControllerExtensionModuleCallback extends Controller {
	
	public function index() {
		$this->load->language('extension/module/callback');

		$json = array();

		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			if (!isset($this->request->post['callback_field_phone'])) {
				if ($this->config->get('module_callback_title') == 2) {
					if ((utf8_strlen($this->request->post['callback_title']) == 0) || (utf8_strlen($this->request->post['callback_title']) > 32)) {
						$json['error'] = $this->language->get('error_callback_title');
					}
				} elseif (!$this->config->get('module_callback_title')) {
					$this->request->post['callback_title'] = '';
				}
				
				if ($this->config->get('module_callback_name') == 2) {
					if ((utf8_strlen($this->request->post['callback_name']) == 0) || (utf8_strlen($this->request->post['callback_name']) > 32)) {
						$json['error'] = $this->language->get('error_callback_name');
					}
				} elseif (!$this->config->get('module_callback_name')) {
					$this->request->post['callback_name'] = '';
				}

				if ($this->config->get('module_callback_email') == 2) {
					if (utf8_strlen($this->request->post['callback_email']) > 96 || !filter_var($this->request->post['callback_email'], FILTER_VALIDATE_EMAIL)) {
						$json['error'] = $this->language->get('error_callback_email');
					}
				} elseif (!$this->config->get('module_callback_email')) {
					$this->request->post['callback_email'] = '';
				}
				
				if ($this->config->get('module_callback_time_required') == 2) {
					if (!$this->request->post['callback_time']) {
						$json['error'] = $this->language->get('error_callback_time');
					}				
				} elseif (!$this->config->get('module_callback_time_required')) {
					$this->request->post['callback_time'] = '';
				}
				
				if ($this->config->get('module_callback_phone') == 2) {
					if ((utf8_strlen($this->request->post['callback_phone']) < 2) || (utf8_strlen($this->request->post['callback_phone']) > 32)) {
						$json['error'] = $this->language->get('error_callback_phone');
					}
				} elseif (!$this->config->get('module_callback_phone')) {
					$this->request->post['callback_phone'] = '';
				}
				
				if ($this->config->get('module_callback_text') == 2) {
					if ((utf8_strlen($this->request->post['callback_text']) < 10) || (utf8_strlen($this->request->post['callback_text'] > 1000))) {
						$json['error'] = $this->language->get('error_callback_text');
					}
				} elseif (!$this->config->get('module_callback_text')) {
					$this->request->post['callback_text'] = '';
				}

				// Captcha
				if ($this->config->get('captcha_' . $this->config->get('config_captcha') . '_status') && $this->config->get('module_callback_captcha')) {
					$captcha = $this->load->controller('extension/captcha/' . $this->config->get('config_captcha') . '/validate');
					
					if ($captcha) {
						$json['error'] = $captcha;
					}
				}
			} else {
				if ((utf8_strlen($this->request->post['callback_field_phone']) < 2) || (utf8_strlen($this->request->post['callback_field_phone']) > 32)) {
					$json['error'] = $this->language->get('error_callback_phone');
				}
			}

			if (!isset($json['error'])) {
				$this->load->model('extension/module/callback');

				$this->model_extension_module_callback->addCallback($this->request->post);
				
				$json['success'] = $this->language->get('text_success');
			}
		}
		
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
?>