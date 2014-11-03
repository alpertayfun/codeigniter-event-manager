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
	 * CodeIgniter ortam değişkenini (get_instance) static değişkenine aktarır
	 *
	 * @return no return
	 */
	public static function Instance(&$instance)
	{
		// Codeignter instance
		self::$CI = $instance;
	}
	
	/**
	 * Gelen event anahtarı doğrultusunda event tetikler
	 *
	 * @return no return
	 */
	public static function fire($key, $extra_parm = null)
	{
		
		// Tüm event'lerin çalıştırılması kontrol ediliyor..
		if($key == '*'){
			return self::_runAll($extra_parm);
		}
		
		if(preg_match('/\*/', $key) > 0){
			return self::_runPrefixes($key, $extra_parm);
		}
		
		// event anahtarı kontrol ediliyor..
		if(isset(self::$closures[$key])){
			// anahtar önce bir değişkene aktarılıyor..
			$_closure = self::$closures[$key];
			
			// sonrasında closure çalıştırılıyor
			return $_closure(self::$CI, $extra_parm);
		}
	}
	
	private static function _runAll($extra_parm = array())
	{
		$result = array();
		
		foreach(self::$closures as $key => $closure){
			$parm = isset($extra_parm[$key]) ? $extra_parm[$key] : null;
			$result[$key] = $closure(self::$CI, $parm);
		}
		
		return $result;
	}
	
	private static function _runPrefixes($key = false, $extra_parm = array())
	{
		if($key){
			$keyArr = preg_split('/\./',$key);
			$newKey = '';
			
			if(count($keyArr) > 1 && end($keyArr) == '*'){
				foreach($keyArr as $k){
					if($k != '*'){
						$newKey .= empty($newKey) ? $k : '.' . $k;
					}
				}
				
				if(!empty($newKey)){
					$result = array();
					
					foreach(self::$closures as $key => $closure){
						if(preg_match('/'.preg_quote($newKey).'/', $key) > 0){
							
							if(isset($extra_parm['*'])){
								$parm = $extra_parm['*'];
							}else{
								$parm = isset($extra_parm[$key]) ? $extra_parm[$key] : null;
							}
							
							$result[$key] = $closure(self::$CI, $parm);
						}
					}
					
					return $result;
				}
				
				
			}
		}
		
		return false;
	}
	
	/**
	 * Event kayıtlarının static closure dizisine katarır
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
	 * Hali hazırda kayıt event'lerin varlığını kontrol eder
	 *
	 * @return bool
	 */
	public static function has($key = false)
	{
		return isset(self::$closures[$key]);
	}
	
	/**
	 * Kayıtlı event'leri siler
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
}