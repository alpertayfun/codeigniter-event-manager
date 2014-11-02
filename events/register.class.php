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
		// event anahtarı kontrol ediliyor..
		if(isset(self::$closures[$key])){
			// anahtar önce bir değişkene aktarılıyor..
			$_closure = self::$closures[$key];
			
			// sonrasında closure çalıştırılıyor
			$_closure(self::$CI, $extra_parm);
		}
	}
	
	/**
	 * Event kayıtlarının static closure dizisine katarır
	 *
	 * @return no return
	 */
	public static function add($key, $closure)
	{
		// event ekleniyor..
		self::$closures[$key] = $closure;
	}
}