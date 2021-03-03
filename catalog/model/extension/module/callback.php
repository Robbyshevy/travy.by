<?php
class ModelExtensionModuleCallback extends Model {
	
	public function addCallback($data) {

		$this->load->language('mail/callback');

		$subject = html_entity_decode($this->language->get('text_subject'), ENT_QUOTES, 'UTF-8');
			
		$message = '';
		$sms = '';
		
		if(isset($data['callback_field_phone'])) {
			
			$this->db->query("INSERT INTO " . DB_PREFIX . "callback SET phone = '" . $this->db->escape($data['callback_field_phone']) . "', url = '" . $this->db->escape($data['callback_field_url']) . "', date_added = NOW()");
			
			$message .= html_entity_decode($this->language->get('text_phone') . $data['callback_field_phone'], ENT_QUOTES, 'UTF-8') . "\n";			
			$message .= html_entity_decode($this->language->get('text_url') . $data['callback_field_url'], ENT_QUOTES, 'UTF-8') . "\n";
			
			$sms = html_entity_decode($this->language->get('text_sms_phone') . $data['callback_field_phone'], ENT_QUOTES, 'UTF-8');
		} else {
			
			$this->db->query("INSERT INTO " . DB_PREFIX . "callback SET title = '" . $this->db->escape($data['callback_title']) . "', name='" .$this->db->escape($data['callback_name']) . "', email='" . $this->db->escape($data['callback_email']) . "', time = '" . $this->db->escape($data['callback_time']) . "', phone = '" . $this->db->escape($data['callback_phone']) . "', text = '" . $this->db->escape($data['callback_text']) . "', url = '" . $this->db->escape($data['callback_url']) . "', date_added = NOW()");
			
			if ($data['callback_title']) {
				$message .= html_entity_decode($this->language->get('text_title') . $data['callback_title'], ENT_QUOTES, 'UTF-8') . "\n";
			}
			
			if ($data['callback_name']) {
				$message .= html_entity_decode($this->language->get('text_name') . $data['callback_name'], ENT_QUOTES, 'UTF-8') . "\n";
			}
			
			if ($data['callback_email']) {
				$message .= html_entity_decode($this->language->get('text_email') . $data['callback_email'], ENT_QUOTES, 'UTF-8') . "\n";
			}
			
			if ($data['callback_time']) {
				$message .= html_entity_decode($this->language->get('text_time') . $data['callback_time'], ENT_QUOTES, 'UTF-8') . "\n";
			}

			if ($data['callback_phone']) {
				$message .= html_entity_decode($this->language->get('text_phone') . $data['callback_phone'], ENT_QUOTES, 'UTF-8') . "\n";
			}
			
			if ($data['callback_text']) {
				$message .= html_entity_decode($this->language->get('text_text'). $data['callback_text'], ENT_QUOTES, 'UTF-8') . "\n";
			}
			
			$sms = html_entity_decode($this->language->get('text_sms_phone') . $data['callback_phone'], ENT_QUOTES, 'UTF-8');
			
			if ($data['callback_url']) {
				$message .= html_entity_decode($this->language->get('text_url'). $data['callback_url'], ENT_QUOTES, 'UTF-8') . "\n";
			}
		}
		
		// SMS
		if ($this->config->get('module_callback_sms_status')) {
			$this->sms_send($this->config->get('module_callback_api_key'), $this->config->get('module_callback_sender'), $sms, $this->config->get('module_callback_sender'));
		}
		
		// E-mail
		$mail = new Mail($this->config->get('config_mail_engine'));
		$mail->parameter = $this->config->get('config_mail_parameter');
		$mail->smtp_hostname = $this->config->get('config_mail_smtp_hostname');
		$mail->smtp_username = $this->config->get('config_mail_smtp_username');
		$mail->smtp_password = html_entity_decode($this->config->get('config_mail_smtp_password'), ENT_QUOTES, 'UTF-8');
		$mail->smtp_port = $this->config->get('config_mail_smtp_port');
		$mail->smtp_timeout = $this->config->get('config_mail_smtp_timeout');

		$mail->setTo($this->config->get('config_email'));
		$mail->setFrom($this->config->get('config_email'));
		$mail->setSender(html_entity_decode($this->config->get('config_name'), ENT_QUOTES, 'UTF-8'));
		$mail->setSubject(html_entity_decode($subject, ENT_QUOTES, 'UTF-8'));
		$mail->setText($message);
		$mail->send();
	
		// Send to additional alert emails
		$emails = explode(',', $this->config->get('config_mail_alert_email'));

		foreach ($emails as $email) {
			if ($email && filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$mail->setTo($email);
				$mail->send();
			}
		}	
	}
	
	private function sms_send($api_id, $to, $message, $sender) {
		
		$param = array(
			"api_id"	 =>	$api_id,
			"to"		 =>	$to,
			"text"		 =>	$message,
			"from"		 =>	$sender
		);
		
		$ch = curl_init("http://sms.ru/sms/send");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
		$result = curl_exec($ch);
		curl_close($ch);
		
		return $result;
	}
}
?>