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
 

// event'ları kayıt edecek static 
// kütüphanemizi dahil ediyoruz.
require_once('register.class.php');

class Events {
	public static function __callStatic($name, $arguments)
    {
    	// codeigniter ortam değişkenini alıp register class'ına inject ediyoruz
    	Register::Instance(get_instance());
    	
		// Magic methoda gelen istekleri kontrol ediyoruz.
		if($name == 'add' || $name == 'fire'){
			// Gelen isteği register class'sımıza gönderiyoruz
    		Register::$name($arguments[0], $arguments[1]);
		}
		
    }
}