<?php
class SessionManager{

    /**
     * @brief Start session securely
     * @param string $name Custom name of a session
     * @param boolean $secure
     * @param type $path
     * @param type $domain
     * @param type $secure
     */
    static function sessionStart($name, $secure, $domain=null){

        // Set the cookie name before we start.
        session_name($name . '_Session');

        // Make sure the session cookie is not accessible via javascript.
        $httponly = true;

        // Hash algorithm to use for the session. (use hash_algos() to get a list of available hashes.)
        $session_hash = 'sha512';

        // Check if hash is available
        if (in_array($session_hash, hash_algos())) { ini_set('session.hash_function', $session_hash); }

        // Number of bits per character of the hash (possible values are '4' (0-9, a-f), '5' (0-9, a-v), and '6' (0-9, a-z, A-Z, "-", ","))
        ini_set('session.hash_bits_per_character', 5);

        // Force the session to only use cookies, not URL variables.
        ini_set('session.use_only_cookies', 1);

        //Cookies should only be sent over secure connections
        ini_set('session.cookie_secure', 1);

        // Set the domain to default to the current domain.
        $domain_sec = isset($domain) ? $domain : $_SERVER['SERVER_NAME'];

        // Get session cookie parameters
        $cookieParams = session_get_cookie_params();

        // Set the parameters
        session_set_cookie_params($cookieParams["lifetime"], $cookieParams["path"], $domain_sec, $secure, $httponly);

        session_start();

        // Make sure the session hasn't expired, and destroy it if it has
	if(self::validateSession())
	{
            // Clear out session data and register IP address and user agent into the new session
            if(!self::preventHijacking())
            {
                $_SESSION = array();
                $_SESSION['IPaddress'] = $_SERVER['REMOTE_ADDR'];
                $_SESSION['userAgent'] = $_SERVER['HTTP_USER_AGENT'];

            // Give a 5% chance of the session id changing on any request
            }elseif(rand(1, 100) <= 5){
                self::regenerateSession();
            }

        }else{
            $_SESSION = array();
            session_destroy();
            session_start();
	}
    }


    /**
     * @brief Return false on new sessions or when a session is loaded by a host with a different IP address or browser
     * @return boolean
     */
    static protected function preventHijacking(){

        if(!isset($_SESSION['IPaddress']) || !isset($_SESSION['userAgent'])){
            return false;
        }
        if ($_SESSION['IPaddress'] != $_SERVER['REMOTE_ADDR']){
            return false;
        }
        if( $_SESSION['userAgent'] != $_SERVER['HTTP_USER_AGENT']){
            return false;
        }
        return true;
    }

    /*
     * @brief Adds the obsolete flag and expiration to the session, regenerates
     * the ID to create the new session and saves them both
     */
    static function regenerateSession(){

	// If this session is obsolete it means there already is a new id
	if(isset($_SESSION['OBSOLETE']) || $_SESSION['OBSOLETE'] == true){
            return;
        }

	// Set current session to expire in 10 seconds
	$_SESSION['OBSOLETE'] = true;
	$_SESSION['EXPIRES'] = time() + 10;

	// Create new session without destroying the old one
	session_regenerate_id(false);

	// Grab current session ID and close both sessions to allow other scripts to use them
	$newSession = session_id();
	session_write_close();

	// Set session ID to the new one, and start it back up again
	session_id($newSession);
	session_start();

	// Now we unset the obsolete and expiration values for the session we want to keep
	unset($_SESSION['OBSOLETE']);
	unset($_SESSION['EXPIRES']);
    }


    /*
     * @brief Check for obsolete flag and to see if the session has expired
     */
    static protected function validateSession(){

	if( isset($_SESSION['OBSOLETE']) && !isset($_SESSION['EXPIRES']) ){
            return false;
        }
	if(isset($_SESSION['EXPIRES']) && $_SESSION['EXPIRES'] < time()){
            return false;
        }
	return true;
    }
}


//Usage
// SessionManager::sessionStart('apnicfs', true);
