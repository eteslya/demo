<?php
/**
 * FLASH
 *
 * The flash file, creates a simple message that
 * expires after the user has seen it.
 *
 * @package Simple. Secure. Login v3
 * @author John Crossley <hello@phpcodemonkey.com>
 * @copyright John Crossley, 2013
 * @link http://phpcodemonkey.com/docs/sslv3.pdf
 * @version 3.4
 */
class Flash {

	public static function get() {
		if ( isset($_SESSION['FLASH_MESSAGE']) ) {
			$flash = $_SESSION['FLASH_MESSAGE'];
			self::destroy();
			return $flash;
		}
	}

	public static function set($true_or_false, $msg) {
		$_SESSION['FLASH_MESSAGE'] = array(
			'error' => (bool)$true_or_false,
			'msg' => $msg
		);
	}

	private static function destroy() {
		if ( isset($_SESSION['FLASH_MESSAGE']) ) {
			unset($_SESSION['FLASH_MESSAGE']);
		}
	}

}