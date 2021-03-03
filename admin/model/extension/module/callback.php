<?php
class ModelExtensionModuleCallback extends Model {
	public function deleteCallBack($callback_id) {	
		$this->db->query("DELETE FROM " . DB_PREFIX . "callback WHERE callback_id = '" . (int)$callback_id . "'");
		
		$this->cache->delete('callback');
	}
		
	public function getCallBacks($data = array()) {
		$sql = "SELECT * FROM " . DB_PREFIX . "callback";
		
			$sort_data = array(			
				'title',
				'name',
				'email',
				'time',
				'phone',
				'text',
				'url',
				'date_added'
			);		
		
			if (isset($data['sort']) && in_array($data['sort'], $sort_data)) {
				$sql .= " ORDER BY " . $data['sort'];	
			} else {
				$sql .= " ORDER BY date_added";	
			}
	
			if (isset($data['order']) && ($data['order'] == 'DESC')) {
				$sql .= " DESC";
			} else {
				$sql .= " ASC";
			}
		
			if (isset($data['start']) || isset($data['limit'])) {
				if ($data['start'] < 0) {
					$data['start'] = 0;
				}		

				if ($data['limit'] < 1) {
					$data['limit'] = 20;
				}	
			
				$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
			}	
			
			$query = $this->db->query($sql);
			
			return $query->rows;
	}
	
	public function getTotalCallBacks() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "callback");
		
		return $query->row['total'];
	}

	public function createDatabaseTables() {
		$sql  = "CREATE TABLE IF NOT EXISTS `" . DB_PREFIX . "callback` ( ";
		$sql .= "`callback_id` int(11) NOT NULL AUTO_INCREMENT, "; 
		$sql .= "`email` varchar(96) COLLATE utf8_unicode_ci NOT NULL DEFAULT '', ";
		$sql .= "`title` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '', ";
		$sql .= "`text` text COLLATE utf8_unicode_ci NOT NULL DEFAULT '', ";
		$sql .= "`phone` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '', ";
		$sql .= "`name` varchar(32) COLLATE utf8_unicode_ci NOT NULL DEFAULT '', ";
		$sql .= "`time` text COLLATE utf8_unicode_ci NOT NULL DEFAULT '', ";
		$sql .= "`url` text COLLATE utf8_unicode_ci NOT NULL DEFAULT '', ";
		$sql .= "`date_added` date NOT NULL DEFAULT '0000-00-00', ";
		$sql .= "PRIMARY KEY (`callback_id`) ";
		$sql .= ") ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;";
		$this->db->query($sql);
	}
}
?>