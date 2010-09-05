<?php
class ACMEData {
	
    function fetchUserFields() {
    	$CI =& get_instance();
    	$CI->load->database();
    	$query = $CI->db->query('SELECT * FROM `userfields`');
    	$query = $query->result_array();
    	
    	foreach ($query as $field) {
    		$fields[$field['id']] = $field;
    	}
    	
    	return $fields;
    }
    
    function fetchUser($uid, $fieldMap) {
    	$CI =& get_instance();
    	$CI->load->database();
    	$query = $CI->db->query('SELECT * FROM `userdata` WHERE `user-id` = '.$uid);
    	$query = $query->result_array();
    	
    	foreach ($query as $field) {
    		$fields[$fieldMap[$field['field-id']]['slug']] = $field['data'];
    	}
    	
    	return $fields;
    }
    
    private function writeXML(XMLWriter $xml, $data){
        foreach($data as $key => $value){
            if(is_array($value)){
                $xml->startElement($key);
                write($xml, $value);
                $xml->endElement();
                continue;
            }
            $xml->writeElement($key, $value);
        }
    }
    
    function toXML($data) {
    	$xml = new XmlWriter();
    	$xml->openMemory();
    	$xml->startDocument('1.0', 'UTF-8');
    	$xml->startElement('root');
    	
    	$this->writeXML($xml, $data);
    	
    	$xml->endElement();
    	return $xml->outputMemory(true);
    }
}