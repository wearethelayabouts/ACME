<?php
class ACMEData {
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