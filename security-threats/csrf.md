
### Cross-Site Request Forgery (CSRF)

This attack forces an end user to execute unwanted actions on a web application in which he/she is currently authenticated. A successful CSRF exploit can compromise end user data and operation in case of normal user. If the targeted end user is the administrator account, this can compromise the entire web application.


#### Prevention Methods

There are two methods that I prefer:
- Random token with each request

  A application will generate the token which will be included in the form as a hidden input field. This unique token key will be use to varify valid request by comparing the submitted token with the one stored in the session.

  ```php
	// Create a new CSRF token.
	function generateCsrfToken($frm_name)
	{
		$token = base64_encode(openssl_random_pseudo_bytes(32));
		$_SESSION[$frm_name] = $token;
		return $token;
	}

	//Varify submitted token
	function validateCsrfToken($frm_name,$token_value)
	{
		$token = $_SESSION[$frm_name];
		if (!is_string($token_value)) {
			return false;
		}
		$result = hash_equals($token, $token_value);

		$_SESSION[$key]=' ';
		unset($_SESSION[$frm_name]);

		return $result;
	}

	//Inject csrf token in form
	function injectCsrfToken(){
		$name = "CSRFGuard_".mt_rand(0,mt_getrandmax());
		$token = generateCsrfToken($name);

		return "<input type='hidden' name='CSRFName' value='".$name."' />
				<input type='hidden' name='CSRFToken' value='".$token."' />";

	}	

	//Handle form submission
	if(isset($_POST['frmname'])){
		if ( !isset($_POST['CSRFName']) or !isset($_POST['CSRFToken']) )
		{
			//Invalid request
		} 
		
		if (!validateCsrfToken($_POST['CSRFName'], $_POST['CSRFToken']))
		{ 
			//Invalid CSRF token
		}

		//handle user input
	}
  ```

  ```html
	//HTML Form
	<form name='frmname' method='post' action=''>
		..
		.
		<?php echo injectCsrfToken();?>
	</form>
  ```


- Random name for each form field

  This method will generate random form field name and stored as an array where array key will be the field name and value will be new random name for the field. 

  ```php
   function form_names($names, $regenerate) {
 
        $values = array();
        foreach ($names as $n) {
                if($regenerate == true) {
                        unset($_SESSION[$n]);
                }
                $s = isset($_SESSION[$n]) ? $_SESSION[$n] : $this->randomStr(10);
                $_SESSION[$n] = $s;
                $values[$n] = $s;       
        }
        return $values;
  }

  function randomStr($chars = 8) {
   	$letters = 'abcefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
   	return substr(str_shuffle($letters), 0, $chars);
  }

  // Generate Random Form Names
  $form_names = form_names(array('user', 'password'), false);
  ```

  ```html
  <form action="index.php" method="post">
	<input type="text" name="<?php $form_names['user']; ?>" /><br/>
	<input type="text" name="<?php $form_names['password']; ?>" />
	<input type="submit" value="Login"/>
  </form>
  ```