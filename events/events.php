<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*                                                                        *
 * Bu script Ahmet ATAY tarafından codeigniter geliştiricileri için       *
 * yazılmıştır.                                                           *
 * 
 * Proje geliştirme aşamasında sıklıkla ihtiyaç duyulan event manager     *
 * mantığından yola çıkılarak yazıldı.								      *
 * 
 * Ücretsiz bir kütüphanedir.                                             *
 * Dilerseniz dağıtabilir yada geliştirip GNU General Public License      *
 * altında kullanabilir/yayınlayabilirsiniz.                              *
 *                                                                        *
 * Fark ettiğiniz hataları yada varsa önerilerinizi github üzerinden      *
 * codeigniter-event-manager projesi altında konu açarak paylaşa          *
 * bilirsiniz                                                             *
 * 
 * Çalışmalarınızda kolaylıklar dilerim.
 *  @package		CodeIgniter
 * @author		ExpressionEngine Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc.
 * @license		http://codeigniter.com/user_guide/license.html
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 *                                                                        */
 
/**
 *
 * @package		CodeIgniter Event Manager
 * @author		Ahmet ATAY
 * @license		GNU General Public License
 * @link		https://github.com/atayahmet/codeigniter-event-manager
 * @since		Version 1.0
 * @filesource
 */
 

 // We will process the event are included in the library
require_once('register.class.php');

// defined events
require_once('defined.php');

class Events {
	/**
	 * access the CI environment
	 *
	 * @return no return
	 */
	public static function __callStatic($name, $arguments)
    {
    	// receive CI environment variable and send to the register class
    	Register::Instance(self::_envInstance());
    	
		// usable methods
		if($name == 'add' || $name == 'fire' || $name == 'has' || $name == 'remove'){
			$argument1 = isset($arguments[0]) ? $arguments[0] : false;
			$argument2 = isset($arguments[1]) ? $arguments[1] : null;
			$argument3 = isset($arguments[2]) ? $arguments[2] : null;
			
			// send to the register class of incoming requests
    		return Register::$name($argument1, $argument2, $argument3);
		}
    }
	
	/**
	 * access the CI environment
	 *
	 * @return no return
	 */
	private static function _envInstance()
	{
		return $ci =& get_instance();
	}
}