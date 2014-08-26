<?php
namespace Entity;

use Spot\Entity;
use Spot\EventEmitter;

class User extends Entity
{
    // Table
    protected static $table = "users";

    /**
     * Fields
     */
    public static function fields()
    {
        return [
            'id'            => ['type' => 'int', 'primary' => true, 'serial' => true],
            'name'          => ['type' => 'string', 'required' => true],
            'email'         => ['type' => 'string', 'required' => true, 'unique' => true],
            'password'      => ['type' => 'string', 'required' => true],
            'is_admin'      => ['type' => 'boolean', 'default' => false],
            'date_created'  => ['type' => 'datetime', 'default' => new \DateTime()],
            'date_modified' => ['type' => 'datetime', 'default' => new \DateTime()]
        ];
    }

    public function events(EventEmitter $events)
    {
        $events->on('beforeSave', function($mapper, $entity) {
            if (isset($this->_dataModified['password']) && ($this->_data['password'] != $this->_dataModified['password'])) {
                $this->password = $this->encryptedPassword($data['password']);
            }
        });
    }

    /**
     * Is user logged-in?
     *
     * @return boolean
     */
    public function isLoggedIn()
    {
        return $this->id ? true : false;
    }

    /**
     * Is user admin? (Has all rights)
     *
     * @return boolean
     */
    public function isAdmin()
    {
        return (boolean) $this->is_admin;
    }

    /**
     * Hash password
     *
     * @param string $pass Password needing encryption
     * @return string Encrypted password
     */
    public function encryptedPassword($pass)
    {
        return password_hash($pass, PASSWORD_BCRYPT, ["cost" => 12]);
    }

    /**
     * Array output for json_encode
     */
    public function toArray()
    {
        return [
            array_merge(
                parent::dataExcept(array('password')),
                [
                   'date_created' => ($this->date_created) ? $this->date_created->format('Y-m-d') : null
                ]
            ),
        ];
    }
}

