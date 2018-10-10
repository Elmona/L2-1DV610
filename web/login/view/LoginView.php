<?php
namespace view;

class LoginView extends \view\FormView {
    private static $login = 'LoginView::Login';
    private static $logout = 'LoginView::Logout';
    private static $name = 'LoginView::UserName';
    private static $password = 'LoginView::Password';
    private static $cookieName = 'LoginView::CookieName';
    private static $cookiePassword = 'LoginView::CookiePassword';
    private static $keep = 'LoginView::KeepMeLoggedIn';
    private static $messageId = 'LoginView::Message';

    private $message = '';
    private $newUsername = false;

    /**
     * Create HTTP response
     *
     * Should be called after a login attempt has been determined
     *
     * @return  void BUT writes to standard output and cookies!
     */
    public function response($isLoggedIn) {
        if ($isLoggedIn) {
            $response = $this->generateLogoutButtonHTML($this->message);
        } else {
            $response = $this->generateLoginFormHTML($this->message);
        }

        return $response;
    }

    /**
     * Generate HTML code on the output buffer for the logout button
     * @param $message, String output message
     * @return  void, BUT writes to standard output!
     */
    private function generateLogoutButtonHTML($message) {
        return '
			<form  method="post" >
				<p id="' . self::$messageId . '">' . $message . '</p>
				<input type="submit" name="' . self::$logout . '" value="logout"/>
			</form>
		';
    }

    /**
     * Generate HTML code on the output buffer for the logout button
     * @param $message, String output message
     * @return  void, BUT writes to standard output!
     */
    private function generateLoginFormHTML($message) {
        $name;
        if ($this->newUsername) {
            $name = $this->newUsername;
        } else {
            $name = $this->getPost(self::$name);
        }

        return '
			<form method="post" >
				<fieldset>
					<legend>Login - enter Username and password</legend>
					<p id="' . self::$messageId . '">' . $message . '</p>

					<label for="' . self::$name . '">Username :</label>
                    <input type="text" id="' . self::$name . '" name="' . self::$name . '" value="' . $name . '" />

					<label for="' . self::$password . '">Password :</label>
					<input type="password" id="' . self::$password . '" name="' . self::$password . '" />

					<label for="' . self::$keep . '">Keep me logged in  :</label>
					<input type="checkbox" id="' . self::$keep . '" name="' . self::$keep . '" />

                    <input type="submit" name="' . self::$login . '" value="login" />
				</fieldset>
			</form>
		';
    }

    public function getCookieName() {
        return self::$cookieName;
    }

    public function getCookiePassword() {
        return self::$cookiePassword;
    }

    public function registeredUsername($username) {
        $this->newUsername = $username;
    }

    public function register() {
        return isset($_GET['register']);
    }

    public function getLogout() {
        return $this->getPost(self::$logout);
    }

    public function getUserName() {
        return $this->getPost(self::$name);
    }

    public function getPassword() {
        return $this->getPost(self::$password);
    }

    public function message($msg) {
        $this->message = $msg;
    }
    /**
     * Check if global variable is set and return it.
     *
     * @param [string] $name
     * @return string
     */
    private function getPost($name) {
        if (isset($_POST[$name]) && !empty($_POST[$name])) {
            return $_POST[$name];
        } else {
            return false;
        }
    }

    /**
     * Check if server REQUEST_METHOD is post
     *
     * @return boolean
     */
    public function isPost() {
        return $_SERVER['REQUEST_METHOD'] == 'POST';
    }
}