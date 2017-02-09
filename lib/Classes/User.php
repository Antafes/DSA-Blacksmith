<?php
/**
 * Part of the dsa blacksmith
 *
 * @package Global
 * @author  friend8 <map@wafriv.de>
 * @license https://www.gnu.org/licenses/lgpl.html LGPLv3
 */

/**
 * Description of User
 *
 * @author frien
 */
class User extends SmartWork\User
{
    /**
     * @var boolean
     */
    protected $showPublicBlueprints;

    /**
     * Get the logged in user by userId.
     *
     * @param integer $userId
     *
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
                `admin`,
                showPublicBlueprints
            FROM users
            WHERE userId = ' . \sqlval($userId) . '
                AND !deleted
        ';
        $userData = \query($sql);

        $object = new self();
        $object->userId        = intval($userData['userId']);
        $object->name          = $userData['name'];
        $object->password      = $userData['password'];
        $object->email         = $userData['email'];
        $object->admin         = !!$userData['admin'];
        $object->orderDuration = $userData['orderDuration'];
        $object->active        = !!$userData['active'];
        $object->showPublicBlueprints = !!$userData['showPublicBlueprints'];

        return $object;
    }

    /**
     * Whether to show public blueprints.
     *
     * @return boolean
     */
    function getShowPublicBlueprints()
    {
        return $this->showPublicBlueprints;
    }

    /**
     * Set whether to show the public blueprints or not.
     *
     * @param boolean $showPublicBlueprints
     *
     * @return void
     */
    public function setShowPublicBlueprints($showPublicBlueprints)
    {
        $this->showPublicBlueprints = $showPublicBlueprints;
        $sql = '
            UPDATE users
            SET showPublicBlueprints = ' . \sqlval($showPublicBlueprints ? 1 : 0) . '
            WHERE userId = ' . \sqlval($this->userId) . '
        ';
        \query($sql);
    }
}
