<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 *
 * @package		CodeIgniter Event Manager
 * @author		Ahmet ATAY
 * @license		GNU General Public License
 * @link		https://github.com/atayahmet/codeigniter-event-manager
 * @since		Version 1.0
 * @filesource
 */
class Register {
	public static $CI;
	public static $closures;
	
	public function __construct()
	{
		self::$closures = array();
	}
	
	/**
	 * transfer to static variable of the ci environment variable
	 *
	 * @return no return
	 */
	public static function Instance(&$instance)
	{
		// Codeignter environment instance
		self::$CI = $instance;
	}
	
	/**
	 * Event triggers the switch in the direction of the incoming event
	 *
	 * @return no return
	 */
	public static function fire($key, $extra_parm = null, $callback_closure = false)
	{
		// checking parameter
		if(is_null($callback_closure)){
			if(self::isClosure($extra_parm)){
				$callback_closure = $extra_parm;
				$extra_parm = null;
			}else{
				$callback_closure = false;
			}
		}else{
			// if parameter is incorrect
			if(!self::_checkParameter($key, $extra_parm, $callback_closure)){
				return false;
			}
		}
		
		// if run all event...
		if($key == '*'){
			return self::_runAll($extra_parm, $callback_closure);
		}
		
		// if work only if event has prefixes...
		if(preg_match('/\*/', $key) > 0){
			return self::_runPrefixes($key, $extra_parm, $callback_closure);
		}
		
		// check event key
		if(isset(self::$closures[$key])){
			// key transfer to variable
			$_closure = self::$closures[$key];
			
			// running after event
			$result = self::_runClosure($_closure, $extra_parm);
			
			// check and running callback
			self::_runClosure($callback_closure, $result);
			
			return $result;
		}
	}
	
	/**
	 * Closure worker
	 *
	 * @return bool/array/string/null
	 */
	private static function _runClosure($closure, $data)
	{
		if($closure && self::isClosure($closure)){
			return $closure(self::$CI, $data);
		}
	}
	
	/**
	 * if will work if event has prefixes
	 *
	 * @return array
	 */
	private static function _runAll($extra_parm = array(), $callback_closure)
	{
		$result = array();
		
		// run all events
		foreach(self::$closures as $key => $closure){
			if(isset($extra_parm['*'])){
				$parm = $extra_parm['*'];
			}else{
				$parm = isset($extra_parm[$key]) ? $extra_parm[$key] : null;
			}
			
			// closure result
			$result[$key] = self::_runClosure($closure, $parm);
		}
		
		// running callback
		self::_runClosure($callback_closure, $result);
		
		return $result;
	}
	
	/**
	 * all events trigger
	 *
	 * @return array / bool
	 */
	private static function _runPrefixes($key = false, $extra_parm = array(), $callback_closure)
	{
		if($key){
			// event key parsing
			$keyArr = preg_split('/\./',$key);
			$newKey = '';
			
			// checking the parse result 
			if(count($keyArr) > 1 && end($keyArr) == '*'){
				
				// the parse result  pass into loop without star
				foreach($keyArr as $k){
					if($k != '*'){
						$newKey .= empty($newKey) ? $k : '.' . $k;
					}
				}
				
				if(!empty($newKey)){
					$result = array();
					
					// the request prefixes is running
					foreach(self::$closures as $key => $closure){
						
						// processing events if contain request prefix
						if(preg_match('/'.preg_quote($newKey).'/', $key) > 0){
							
							// incoming parameters are to be run for all events are available
							if(isset($extra_parm['*'])){
								$parm = $extra_parm['*'];
							}else{
								// otherwise the event is sent to each parameter belongs
								$parm = isset($extra_parm[$key]) ? $extra_parm[$key] : null;
							}
							
							// results are added to the array
							$result[$key] = self::_runClosure($closure, $parm);
						}
					}
					
					// running callback
					self::_runClosure($callback_closure, $result);
					
					return $result;
				}
			}
		}
		
		return false;
	}
	
	/**
	 * check the parameters  when the event is triggered
	 *
	 * @return bool
	 */
	public static function _checkParameter($key, $extra_parm, $callback_closure)
	{
		$result = true;
		
		// event controls the type of key
		if(!is_string($key)){
			$result = false;
		}
		
		// event cross-check the type of parameters
		if(!is_null($extra_parm) && !is_array($extra_parm) && (!is_string($extra_parm) && !is_object($extra_parm) ||  self::isClosure($extra_parm))){
			$result = false;
		}
		
		// check of closure type
		if(!self::isClosure($callback_closure)){
			$result = false;
		}
		
		return $result;
	}
	
	/**
	 * transfer to the closure  array of the event requests
	 *
	 * @return bool
	 */
	public static function add($key, $closure)
	{
		// event ekleniyor..
		if(isset($key) && isset($closure)){
			self::$closures[$key] = $closure;
			return true;
		}
		
		return false;
	}
	
	/**
	 * check asset of available events
	 *
	 * @return bool
	 */
	public static function has($key = false)
	{
		return isset(self::$closures[$key]);
	}
	
	/**
	 * delete the registered events
	 *
	 * @return bool
	 */
	public static function remove($key)
	{
		if(isset(self::$closures[$key])){
			unset(self::$closures[$key]);
			
			return true;
		}
	}
	
	/**
	 * check closure requests
	 *
	 * @return bool
	 */
	public function isClosure($closure)
	{
		return ($closure instanceof Closure);
	}
}