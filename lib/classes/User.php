<?php
/**
 * Description of EsUser
 *
 * @author Neithan
 */
class User
{
	/**
	 * @var integer
	 */
	protected $userId;

	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var string
	 */
	protected $password;

	/**
	 * @var string
	 */
	protected $email;

	/**
	 * @var boolean
	 */
	protected $admin;

	/**
	 * @var string
	 */
	protected $orderDuration;

	/**
	 * @var integer
	 */
	protected $languageId;

	/**
	 * @var boolean
	 */
	protected $active;

	/**
	 * Get the logged in user by userId.
	 *
	 * @param integer $userId
	 * @return \self
	 */
	public static function getUserById($userId)
	{
		$sql = '
			SELECT
				`userId`,
				`name`,
				password,
				email,
				active,
				`admin`
			FROM users
			WHERE userId = '.\sqlval($userId).'
				AND !deleted
		';
		$userData = query($sql);

		$object = new self();
		$object->userId        = intval($userData['userId']);
		$object->name          = $userData['name'];
		$object->password      = $userData['password'];
		$object->email         = $userData['email'];
		$object->admin         = !!$userData['admin'];
		$object->orderDuration = $userData['orderDuration'];
		$object->active        = !!$userData['active'];

		return $object;
	}

	/**
	 * Get the user that wants to log in.
	 *
	 * @param string $name
	 * @param string $password
	 * @return boolean|\self
	 */
	public static function getUser($name, $password)
	{
		$sql = '
			SELECT
				`userId`,
				`name`,
				password
			FROM users
			WHERE name = '.\sqlval($name).'
				AND !deleted
		';
		$userData = query($sql);
		$passwordParts = explode('$', $userData['password']);

		$encPassword = self::encryptPassword($password, $passwordParts['2']);

		if (strcasecmp($name, $userData['name']) === 0 && $encPassword == $userData['password'])
		{
			return self::getUserById($userData['userId']);
		}
		else
			return false;
	}

	/**
	 * Get the user by the entered email address
	 *
	 * @param string $mail
	 *
	 * @return boolean|\self
	 */
	public static function getUserByMail($mail)
	{
		$sql = '
			SELECT `userId`
			FROM users
			WHERE email = '.\sqlval($mail).'
				AND !deleted
		';
		$userId = query($sql);

		if (!$userId)
		{
			return false;
		}

		return self::getUserById($userId);
	}

	/**
	 * Create a new user and save it into the database.
	 *
	 * @param string $name
	 * @param string $password
	 * @return integer
	 */
	public static function createUser($name, $password, $email)
	{
		$sql = '
			INSERT INTO users
			SET name = '.\sqlval($name).',
				password = '.\sqlval(self::encryptPassword($password, uniqid())).',
				email = '.\sqlval($email).'
		';
		return query($sql);
	}

	/**
	 * Checks if the username is already in use or not.
	 *
	 * @param string $name
	 * @return boolean
	 */
	public static function checkUsername($name)
	{
		$sql = '
			SELECT COUNT(*)
			FROM users
			WHERE name = '.\sqlval($name).'
		';
		return !!query($sql);
	}

	/**
	 * Check if the email is already in use or not.
	 *
	 * @param string $email
	 *
	 * @return boolean
	 */
	public static function checkEmail($email)
	{
		$sql = '
			SELECT COUNT(*)
			FROM users
			WHERE email = '.\sqlval($email).'
		';
		return !!query($sql);
	}

	/**
	 * Encrypt the user password and a salt with md5.
	 *
	 * @param string $password
	 * @param string $salt
	 * @return string
	 */
	protected static function encryptPassword($password, $salt)
	{
		return '$m5$'.$salt.'$'.md5($password.'-'.$salt);
	}

	/**
	 * @return integer
	 */
	public function getUserId()
	{
		return $this->userId;
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @return string
	 */
	public function getEmail()
	{
		return $this->email;
	}

	/**
	 * @return boolean
	 */
	public function getAdmin()
	{
		return $this->admin;
	}

	/**
	 * @return boolean
	 */
	public function getStatus()
	{
		return $this->active;
	}

	/**
	 * @return string
	 */
	public function getOrderDuration()
	{
		return $this->orderDuration;
	}

	/**
	 * @return integer
	 */
	public function getLanguageId()
	{
		return $this->languageId;
	}

	/**
	 * @param string $name
	 */
	public function setName($name)
	{
		$this->name = $name;
		$sql = '
			UPDATE users
			SET name = '.\sqlval($this->name).'
			WHERE userId = '.\sqlval($this->userId).'
		';
		query($sql);
	}

	/**
	 * Encrypts and sets the password.
	 *
	 * @param string $password
	 */
	public function setPassword($password)
	{
		$this->password = self::encryptPassword($password, $this->salt);
		$sql = '
			UPDATE users
			SET password = '.\sqlval($this->password).'
			WHERE userId = '.\sqlval($this->userId).'
		';
		query($sql);
	}

	/**
	 * @param string $email
	 */
	public function setEmail($email)
	{
		$this->email = $email;
		$sql = '
			UPDATE users
			SET email = '.\sqlval($this->email).'
			WHERE userId = '.\sqlval($this->userId).'
		';
		query($sql);
	}

	/**
	 * Activate the current user.
	 */
	public function activate()
	{
		$sql = '
			UPDATE users
			SET active = 1
			WHERE userId = '.\sqlval($this->userId).'
		';
		query($sql);
		$this->active = true;
	}

	/**
	 * @param boolean $admin
	 */
	public function setAdmin($admin)
	{
		$this->admin = $admin;
		$sql = '
			UPDATE users
			SET admin = '.\sqlval($admin ? 1 : 0).'
			WHERE userId = '.\sqlval($this->userId).'
		';
		query($sql);
	}

	/**
	 * @param string $orderDuration
	 */
	public function setOrderDuration($orderDuration)
	{
		$this->orderDuration = $orderDuration;
		$sql = '
			UPDATE users
			SET orderDuration = '.\sqlval($orderDuration).'
			WHERE userId = '.\sqlval($this->userId).'
		';
		query($sql);
	}

	/**
	 * @param integer $languageId
	 */
	public function setLanguageId($languageId)
	{
		$this->languageId = $languageId;
		$sql = '
			UPDATE users
			SET `languageId` = '.\sqlval($languageId).'
			WHERE `userId` = '.\sqlval($this->userId).'
		';
		query($sql);
	}

	public function lostPassword()
	{
		$translator = \Translator::getInstance();
		$password = $this->generatePassword();
		$passwordParts = explode('$', $this->password);
		$sql = '
			UPDATE users
			SET password = '.\sqlval($this->encryptPassword($password, $passwordParts[2])).'
			WHERE `userId` = '.\sqlval($this->userId).'
		';
		query($sql);

		\Helper\Mail::send(
			array($this->email, $this->name),
			$translator->getTranslation('lostPasswordSubject'),
			str_replace(
				array('##USER##', '##PASSWORD##'),
				array($this->name, $password),
				$translator->getTranslation('lostPasswordMessage')
			)
		);
	}

	protected function generatePassword($length = 8)
	{
		$characters = '0123456789!$%&abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLengh = strlen($characters);
		$password = '';

		for ($i = 0; $i < $length; $i++)
		{
			$password .= $characters[rand(0, $charactersLengh - 1)];
		}

		return $password;
	}
}
