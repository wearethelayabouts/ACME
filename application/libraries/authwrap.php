<?php
class Authwrap {
	function __call($name, $arguments) {
		$CI =& get_instance();
		return call_user_func(Array($CI->$GLOBALS['authactorclass'], $name), $arguments);
	}
}