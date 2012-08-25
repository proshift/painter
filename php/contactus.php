<?PHP
	 ob_start();

	 $name = '';
	 $email = '';
	 $phone = '';
	 $website = '';
	 $type = '';
	 $message = '';

	if( validate_contact()) {
		global $name;
		global $email;
		global $phone;
		global $website;
		global $type;
		global $message;

		$formcontent=" From: $name \n Phone: $phone \n Website: $website \n Type: $type \n Message: $message";
		$recipient = 'info@terradoor.az';
		$subject = $_POST['subject'];
		$mailheader = "From: $email \r\n";

		if( @mail($recipient, $subject, $formcontent, $mailheader)) {
			echo 'ok';
			exit;
		} else {
			echo 'error';
			exit;
		}
	} else {
		echo 'error valdiation';
		exit;
	}

	function validate_contact() {
		global $name;
		global $email;
		global $phone;
		global $website;
		global $type;
		global $message;

		if( isset($_POST['author'], $_POST['email'], $_POST['phone'], $_POST['type'], $_POST['text'])) {
			$name = $_POST['author']; 		trim($name);
			$email = $_POST['email'];		trim($email);
			$phone = $_POST['phone'];		trim($phone);
			$type = $_POST['type'];			trim($type);
			$message = $_POST['text'];		trim($message);
			if( isset($website)) {
				$website = $_POST['website'];	trim($website);
			}

			if( !empty($name) && !empty($email) && !empty($phone) && !empty($type) && !empty($message)) {
				if( preg_match('@[A-Za-z]+[ ]+[A-Za-z]+@', $name) && preg_match('#[a-zA-Z0-9]+[a-zA-Z0-9_.-]+[a-zA-Z0-9_-]+@[a-zA-Z0-9]+[a-zA-Z0-9.-]+[a-zA-Z0-9]+.[a-z]{2,4}#', $email)
					&& preg_match('#[0-9]{10,13}#x', $phone)) {
						require_once('recaptchalib.php');
				  		$privatekey = '6LfZDtQSAAAAAM_wLuqtQCGIT0OiY16uUdCXarKv';
				 		$resp = recaptcha_check_answer ($privatekey,
				                                $_SERVER['REMOTE_ADDR'],
				                                $_POST['recaptcha_challenge_field'],
				                                $_POST['recaptcha_response_field']);

						if (!$resp->is_valid) {
						// What happens when the CAPTCHA was entered incorrectly
							echo 'not valid';
							exit;
							} else {
							// Your code here to handle a successful verification
								return true;
						}

				} else {
					echo 'not match';
					exit;
				}
			} else {
				echo 'not empty';
				exit;
			}
		} else {
			echo 'not set';
			exit;
		}
	}
?>
