<?php
namespace Page;
/**
 * Description of Admin
 *
 * @author Neithan
 */
class Admin extends \SmartWork\Page
{
	public function __construct()
	{
		parent::__construct('admin');
	}

	public function process()
	{
		if ($_GET['activate'])
		{
			$this->activateUser($_GET['activate']);
			redirect('index.php?page=Admin');
		}

		if ($_GET['setAdmin'])
		{
			$this->changeAdminStatus($_GET['setAdmin'], true);
			redirect('index.php?page=Admin');
		}

		if ($_GET['removeAdmin'])
		{
			$this->changeAdminStatus($_GET['removeAdmin'], false);
			redirect('index.php?page=Admin');
		}

		$user = \SmartWork\User::getUserById($_SESSION['userId']);

		if (!$user->getAdmin())
			redirect('index.php?page=Index');

		$this->template->assign('userList', $this->getUserList());
	}

	/**
	 * Get a list with all users that are not deleted.
	 *
	 * @return array
	 */
	protected function getUserList()
	{
		$sql = '
			SELECT userId
			FROM users
			WHERE !deleted
		';
		$users = query($sql, true);

		$userList = array();
		foreach ($users as $user)
			$userList[] = \SmartWork\User::getUserById($user['userId']);

		return $userList;
	}

	/**
	 * Activate the given user.
	 *
	 * @param integer $userId
	 */
	protected function activateUser($userId)
	{
		$user = \SmartWork\User::getUserById($userId);
		$user->activate();
	}

	/**
	 * Set the admin status of the given user to $status.
	 *
	 * @param integer $userId
	 * @param boolean $status
	 */
	protected function changeAdminStatus($userId, $status)
	{
		$user = \SmartWork\User::getUserById($userId);
		$user->setAdmin($status);
	}
}
