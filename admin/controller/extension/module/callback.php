<?php
class ControllerExtensionModuleCallback extends Controller {
	private $error = array(); 
	
	public function index() {  

		$this->load->language('extension/module/callback');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$this->load->model('setting/setting');
		$this->load->model('extension/module/callback');
				
		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			$this->model_setting_setting->editSetting('module_callback', $this->request->post);

			$this->session->data['success'] = $this->language->get('text_success');
			
			if ($this->request->post['apply']) {
				$this->response->redirect($this->url->link('extension/module/callback', 'user_token=' . $this->session->data['user_token'], true));
			}

			$this->response->redirect($this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true));
		}
		
		$data = array();
		
		$data = $this->getList();
		
		if (isset($this->error['warning'])) {
			$data['error_warning'] = $this->error['warning'];
		} else {
			$data['error_warning'] = '';
		}
		
		if (isset($this->session->data['success'])) {
			$data['success'] = $this->session->data['success'];
			unset($this->session->data['success']);
		} else {
			$data['success'] = '';
		}
				
		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/dashboard', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_extension'),
			'href' => $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true)
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('heading_title'),
			'href' => $this->url->link('extension/module/callback', 'user_token=' . $this->session->data['user_token'], true)
		);

		$data['action'] = $this->url->link('extension/module/callback', 'user_token=' . $this->session->data['user_token'], true);

		$data['cancel'] = $this->url->link('marketplace/extension', 'user_token=' . $this->session->data['user_token'] . '&type=module', true);
		
		if (isset($this->request->post['module_callback_status'])) {
			$data['module_callback_status'] = $this->request->post['module_callback_status'];
		} else {
			$data['module_callback_status'] = $this->config->get('module_callback_status');
		}
		
		if (isset($this->request->post['module_callback_title'])) {
			$data['module_callback_title'] = $this->request->post['module_callback_title'];
		} else {
			$data['module_callback_title'] = $this->config->get('module_callback_title');
		}
		
		if (isset($this->request->post['module_callback_name'])) {
			$data['module_callback_name'] = $this->request->post['module_callback_name'];
		} else {
			$data['module_callback_name'] = $this->config->get('module_callback_name');
		}
		
		if (isset($this->request->post['module_callback_email'])) {
			$data['module_callback_email'] = $this->request->post['module_callback_email'];
		} else {
			$data['module_callback_email'] = $this->config->get('module_callback_email');
		}
		
		if (isset($this->request->post['module_callback_time_required'])) {
			$data['module_callback_time_required'] = $this->request->post['module_callback_time_required'];
		} else {
			$data['module_callback_time_required'] = $this->config->get('module_callback_time_required');
		}
		
		if (isset($this->request->post['module_callback_time'])) {
			$data['module_callback_time'] = $this->request->post['module_callback_time'];
		} elseif ($this->config->get('module_callback_time')) {
			$data['module_callback_time'] = $this->config->get('module_callback_time');
		} else {
			$data['module_callback_time'] = '08:00 - 09:00|09:00 - 10:00|10:00 - 11:00|11:00 - 12:00|13:00 - 14:00|14:00 - 15:00|15:00 - 16:00|16:00 - 17:00|17:00 - 18:00';	
		}
		
		if (isset($this->request->post['module_callback_phone'])) {
			$data['module_callback_phone'] = $this->request->post['module_callback_phone'];
		} else {
			$data['module_callback_phone'] = $this->config->get('module_callback_phone');
		}
		
		if (isset($this->request->post['module_callback_text'])) {
			$data['module_callback_text'] = $this->request->post['module_callback_text'];
		} else {
			$data['module_callback_text'] = $this->config->get('module_callback_text');
		}
		
		if (isset($this->request->post['module_callback_captcha'])) {
			$data['module_callback_captcha'] = $this->request->post['module_callback_captcha'];
		} else {
			$data['module_callback_captcha'] = $this->config->get('module_callback_captcha');
		}
		
		if (isset($this->request->post['module_callback_link'])) {
			$data['module_callback_link'] = $this->request->post['module_callback_link'];
		} else {
			$data['module_callback_link'] = $this->config->get('module_callback_link');
		}
		
		if (isset($this->request->post['module_callback_button'])) {
			$data['module_callback_button'] = $this->request->post['module_callback_button'];
		} else {
			$data['module_callback_button'] = $this->config->get('module_callback_button');
		}
		
		if (isset($this->request->post['module_callback_position'])) {
			$data['module_callback_position'] = $this->request->post['module_callback_position'];
		} else {
			$data['module_callback_position'] = $this->config->get('module_callback_position');
		}
		
		if (isset($this->request->post['module_callback_type'])) {
			$data['module_callback_type'] = $this->request->post['module_callback_type'];
		} else {
			$data['module_callback_type'] = $this->config->get('module_callback_type');
		}
		
		if (isset($this->request->post['module_callback_color_top'])) {
			$data['module_callback_color_top'] = $this->request->post['module_callback_color_top'];
		} elseif ($this->config->get('module_callback_color_top')) {
			$data['module_callback_color_top'] = $this->config->get('module_callback_color_top');
		} else {
			$data['module_callback_color_top'] = 'DE463B';
		}
		
		if (isset($this->request->post['module_callback_color_bottom'])) {
			$data['module_callback_color_bottom'] = $this->request->post['module_callback_color_bottom'];
		} elseif ($this->config->get('module_callback_color_bottom')) {
			$data['module_callback_color_bottom'] = $this->config->get('module_callback_color_bottom');
		} else {
			$data['module_callback_color_bottom'] = 'C02B21';
		}
		
		$this->load->model('tool/image');
		
		if (isset($this->request->post['module_callback_image'])) {
			$data['module_callback_image'] = $this->request->post['module_callback_image'];
		} else {
			$data['module_callback_image'] = $this->config->get('module_callback_image');
		}
		
		if (isset($this->request->post['module_callback_image_width'])) {
			$data['module_callback_image_width'] = $this->request->post['module_callback_image_width'];
		} elseif ($this->config->get('module_callback_image_width')) {
			$data['module_callback_image_width'] = $this->config->get('module_callback_image_width');
		} else {
			$data['module_callback_image_width'] = 50;
		}
		
		if (isset($this->request->post['module_callback_image_height'])) {
			$data['module_callback_image_height'] = $this->request->post['module_callback_image_height'];
		} elseif ($this->config->get('module_callback_image_height')) {
			$data['module_callback_image_height'] = $this->config->get('module_callback_image_height');
		} else {
			$data['module_callback_image_height'] = 50;
		}

		if (isset($this->request->post['module_callback_image']) && is_file(DIR_IMAGE . $this->request->post['module_callback_image'])) {
			$data['module_callback_thumb'] = $this->model_tool_image->resize($this->request->post['module_callback_image'], 100, 100);
		} elseif ($this->config->get('module_callback_image') && is_file(DIR_IMAGE . $this->config->get('module_callback_image'))) {
			$data['module_callback_thumb'] = $this->model_tool_image->resize($this->config->get('module_callback_image'), 100, 100);
		} else {
			$data['module_callback_thumb'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		}
		
		$data['placeholder'] = $this->model_tool_image->resize('no_image.png', 100, 100);
		
		if (isset($this->request->post['module_callback_sms_status'])) {
			$data['module_callback_sms_status'] = $this->request->post['module_callback_sms_status'];
		} else {
			$data['module_callback_sms_status'] = $this->config->get('module_callback_sms_status');
		}
		
		if (isset($this->request->post['module_callback_api_key'])) {
			$data['module_callback_api_key'] = $this->request->post['module_callback_api_key'];
		} else {
			$data['module_callback_api_key'] = $this->config->get('module_callback_api_key');
		}
		
		if (isset($this->request->post['module_callback_sender'])) {
			$data['module_callback_sender'] = $this->request->post['module_callback_sender'];
		} else {
			$data['module_callback_sender'] = $this->config->get('module_callback_sender');
		}

		$data['header'] = $this->load->controller('common/header');
		$data['column_left'] = $this->load->controller('common/column_left');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('extension/module/callback', $data));
	}
	
	private function getList() {
		if (isset($this->request->get['sort'])) {
			$sort = $this->request->get['sort'];
		} else {
			$sort = 'date_added';
		}
		
		if (isset($this->request->get['order'])) {
			$order = $this->request->get['order'];
		} else {
			$order = 'ASC';
		}
		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}
		
		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}

		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}
		
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['delete'] = $this->url->link('extension/module/callback/delete', 'user_token=' . $this->session->data['user_token'] . $url, true);

		$data['callbacks'] = array();

		$filter_data = array(
			'sort'  => $sort,
			'order' => $order,
			'start' => ($page - 1) * $this->config->get('config_limit_admin'),
			'limit' => $this->config->get('config_limit_admin')
		);
		
		$callback_total = $this->model_extension_module_callback->getTotalCallBacks();
		$data['module_callback_total'] = $callback_total;
		
		$results = $this->model_extension_module_callback->getCallBacks($filter_data);

    	foreach ($results as $result) {		
			$data['callbacks'][] = array(
				'callback_id' 	 => $result['callback_id'],
				'title'			 => $result['title'],
				'name'			 => $result['name'],
				'email'          => $result['email'],
				'time' 	 		 => $result['time'],
				'phone' 	 	 => $result['phone'],
				'text'			 => strip_tags(html_entity_decode($result['text'])),
				'date_added' 	 => $result['date_added'],			
				'url'     	 	 => $result['url']
			);
		}

		if (isset($this->request->post['selected'])) {
			$data['selected'] = (array)$this->request->post['selected'];
		} else {
			$data['selected'] = array();
		}

		$url = '';

		if ($order == 'ASC') {
			$url .= '&order=DESC';
		} else {
			$url .= '&order=ASC';
		}

		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}
		
		$data['sort_title'] = $this->url->link('extension/module/callback', 'user_token=' . $this->session->data['user_token'] . '&sort=title' . $url, true);
		$data['sort_name'] = $this->url->link('extension/module/callback', 'user_token=' . $this->session->data['user_token'] . '&sort=name' . $url, true);
		$data['sort_email'] = $this->url->link('extension/module/callback', 'user_token=' . $this->session->data['user_token'] . '&sort=email' . $url, true);
		$data['sort_time'] = $this->url->link('extension/module/callback', 'user_token=' . $this->session->data['user_token'] . '&sort=time' . $url, true);
		$data['sort_phone'] = $this->url->link('extension/module/callback', 'user_token=' . $this->session->data['user_token'] . '&sort=phone' . $url, true);
		$data['sort_text'] = $this->url->link('extension/module/callback', 'user_token=' . $this->session->data['user_token'] . '&sort=text' . $url, true);
		$data['sort_date_added'] = $this->url->link('extension/module/callback', 'user_token=' . $this->session->data['user_token'] . '&sort=date_added' . $url, true);
		
		$url = '';

		if (isset($this->request->get['sort'])) {
			$url .= '&sort=' . $this->request->get['sort'];
		}
												
		if (isset($this->request->get['order'])) {
			$url .= '&order=' . $this->request->get['order'];
		}

		$pagination = new Pagination();
		$pagination->total = $callback_total;
		$pagination->page = $page;
		$pagination->limit = $this->config->get('config_limit_admin');
		$pagination->url = $this->url->link('extension/module/callback', 'user_token=' . $this->session->data['user_token'] . $url . '&page={page}', true);
		
		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($callback_total) ? (($page - 1) * $this->config->get('config_limit_admin')) + 1 : 0, ((($page - 1) * $this->config->get('config_limit_admin')) > ($callback_total - $this->config->get('config_limit_admin'))) ? $callback_total : ((($page - 1) * $this->config->get('config_limit_admin')) + $this->config->get('config_limit_admin')), $callback_total, ceil($callback_total / $this->config->get('config_limit_admin')));

		$data['sort'] = $sort;
		$data['order'] = $order;
		
		return $data;
	}
	
	public function delete() {
		$this->load->language('extension/module/callback');

		$this->document->setTitle( $this->language->get('heading_title'));
		
		$this->load->model('extension/module/callback');
		
		if (isset($this->request->post['selected']) && $this->validateDelete()) {
			foreach ($this->request->post['selected'] as $callback_id) {
				$this->model_extension_module_callback->deleteCallBack($callback_id);
		}
			
			$this->session->data['success'] = $this->language->get('text_success');

			$url = '';
			
			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['sort'])) {
				$url .= '&sort=' . $this->request->get['sort'];
			}

			if (isset($this->request->get['order'])) {
				$url .= '&order=' . $this->request->get['order'];
			}
			
			$this->response->redirect($this->url->link('extension/module/callback', 'user_token=' . $this->session->data['user_token'] . $url, true));

		}
	}
	
	protected function validate() {
		if (!$this->user->hasPermission('modify', 'extension/module/callback')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}
		return !$this->error;
	}
	
	private function validateDelete() {
		if (!$this->user->hasPermission('modify', 'extension/module/callback')) {
			$this->error['warning'] = $this->language->get('error_permission');
		}

		return !$this->error;
	}
	
	public function install() {
		$this->load->model('extension/module/callback');
		$this->model_extension_module_callback->createDatabaseTables();
	}
}
?>