<?php
class Playmodel extends CI_Model {
	function __construct() {
		parent::__construct();
	}
	
	function fetchFSInfo() {
		$playdirs = scandir('./application/plays');
		
		foreach ($playdirs as $play) {
			if ($play !== "." && $play !== "..") {
				if (file_exists('./application/plays/'.$play.'/meta.json')) {
					$playmeta = json_decode(file_get_contents('./application/plays/'.$play.'/meta.json'));
					$uplays[$play] = $playmeta;
				} else {
					return Array('error' => $play." doesn't have a meta.json file!");
				}
			}
		}
		
		foreach ($uplays as $name => $uplay) {
			foreach ($uplay->contents as $id => $content) {
				if (file_exists('./application/plays/'.$name.'/'.$content.'/meta.json')) {
					$actormeta = json_decode(file_get_contents('./application/plays/'.$name.'/'.$content.'/meta.json'));
					unset($uplays[$name]->contents[$id]);
					$uplays[$name]->contents[$content] = $actormeta;
				} else {
					return Array('error' => $content." doesn't have a meta.json file!");
				}
			}
		}
		
		return $uplays;
	}
	
	function fetchFSActors() {
		$playdirs = scandir('./application/plays');
		
		foreach ($playdirs as $play) {
			if ($play !== "." && $play !== "..") {
				if (file_exists('./application/plays/'.$play.'/meta.json')) {
					$playmeta = json_decode(file_get_contents('./application/plays/'.$play.'/meta.json'));
					$uplays[$play] = $playmeta;
				} else {
					return Array('error' => $play." doesn't have a meta.json file!");
				}
			}
		}
		
		foreach ($uplays as $name => $uplay) {
			foreach ($uplay->contents as $id => $content) {
				if (file_exists('./application/plays/'.$name.'/'.$content.'/meta.json')) {
					$actormeta = json_decode(file_get_contents('./application/plays/'.$name.'/'.$content.'/meta.json'));
					$actors[$content] = $actormeta;
				} else {
					return Array('error' => $content." doesn't have a meta.json file!");
				}
			}
		}
		
		return $actors;
	}
	
	function fetchDBActors() {
		$DBQuery = $this->db->get('actors');
		$DBQuery = $DBQuery->result_array();
		
		$actors = Array();
		
		foreach ($DBQuery as $actor) {
			$actors[$actor['bundle']] = $actor;
		}
		
		return $actors;
	}
	
	function syncActors($changes) {
		if (isset($changes['update'])) {
			foreach ($changes['update'] as $actorID => $actorChanges) {
				$this->db->update('actors', $actorChanges, array('id' => $actorID));
			}
		}
		if (isset($changes['add'])) {
			foreach ($changes['add'] as $actorID => $actorChanges) {
				$this->db->insert('actors', $actorChanges);
			}
		}
		if (isset($changes['delete'])) {
			foreach ($changes['delete'] as $actorBundle => $actorID) {
				$this->db->delete('actors', array('id' => $actorID));
			}
		}
	}
	
	function fetchAuthActors() {
		$DBQuery = $this->db->get_where('actors', array('type' => 'auth'));
		$DBQuery = $DBQuery->result_array();
		
		$actors = Array();
		
		foreach ($DBQuery as $actor) {
			$actors[$actor['bundle']] = $actor;
		}
		
		return $actors;
	}
	
	function loadActor($bundle) {
		$CI =& get_instance(); 
		$DBQuery = $this->db->get_where('actors', array('bundle' => $bundle));
		$DBQuery = $DBQuery->row_array();
		$actorInfo = json_decode(file_get_contents(APPPATH.'plays/'.$DBQuery['play'].'/'.$DBQuery['bundle'].'/'.'meta.json'));
		
		foreach ($actorInfo->actor->libraries as $lib) {
			$this->load->library($lib);
		}
		
		if ($actorInfo->type == "auth") {
			$GLOBALS['authactorclass'] = $actorInfo->actor->auth;
			$this->load->library('Authwrap');
		}
	}
	
	function loadAuth() {
		return $this->loadActor($this->config->item('auth_actor'));
	}
	
	function loadExtras() {
		$DBQuery = $this->db->get_where('actors', array('type' => 'extra'));
		$DBQuery = $DBQuery->result_array();
		
		foreach ($DBQuery as $extra) {
			$this->loadActor($extra['bundle']);
		}
	}
}