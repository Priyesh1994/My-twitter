<?php

namespace app\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "users".
 *
 * @property integer $userId
 * @property string $userName
 * @property string $userEmail
 * @property string $userPass
 *
 * @property Microposts[] $microposts
 * @property Relationships[] $relationships
 * @property Relationships[] $relationships0
 */
class Users extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * @inheritdoc
     */
    public $confPass;
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['userName', 'userEmail', 'userPass','confPass'], 'required'],
            [['userName'], 'string', 'max' => 30],
            [['userEmail'], 'string', 'max' => 60],
            [['userPass'], 'string', 'max' => 255],
            [['confPass'], 'string', 'max' => 255],
            [['userEmail'], 'unique'],
            ['confPass', 'compare', 'compareAttribute'=>'userPass', 'message'=>"Passwords don't match" ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'userName' => 'User Name',
            'userEmail' => 'User Email',
            'userPass' => 'User Password',
            'confPass' => 'Confirm Password',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMicroposts()
    {
        return $this->hasMany(Microposts::className(), ['userId' => 'userId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelationships()
    {
        return $this->hasMany(Relationships::className(), ['followed_id' => 'userId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRelationships0()
    {
        return $this->hasMany(Relationships::className(), ['follower_id' => 'userId']);
    }

    /**
     * Configuration starts from here
     * @inheritdoc
     */
    /*public static function findIdentity($id)
    {
        return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;
    }*/

    /**
     * @inheritdoc
     */
    /*public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }*/

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['userName' => $username]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->userId;
    }
    /**
     * @inheritdoc
     */
    /*public function getAuthKey()
    {
        return $this->authKey;
    }*/

    /**
     * @inheritdoc
     */
    /*public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }*/

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->userPass === $password;
    }

    /**
     * Finds an identity by the given ID.
     * @param string|integer $id the ID to be looked for
     * @return IdentityInterface the identity object that matches the given ID.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentity($id)
    {
        return static::findOne(['userId' => $id]);
    }

    /**
     * Finds an identity by the given token.
     * @param mixed $token the token to be looked for
     * @param mixed $type the type of the token. The value of this parameter depends on the implementation.
     * For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
     * @return IdentityInterface the identity object that matches the given token.
     * Null should be returned if such an identity cannot be found
     * or the identity is not in an active state (disabled, deleted, etc.)
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // TODO: Implement findIdentityByAccessToken() method.
    }

    /**
     * Returns a key that can be used to check the validity of a given identity ID.
     *
     * The key should be unique for each individual user, and should be persistent
     * so that it can be used to check the validity of the user identity.
     *
     * The space of such keys should be big enough to defeat potential identity attacks.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @return string a key that is used to check the validity of a given identity ID.
     * @see validateAuthKey()
     */
    public function getAuthKey()
    {
        // TODO: Implement getAuthKey() method.
    }

    /**
     * Validates the given auth key.
     *
     * This is required if [[User::enableAutoLogin]] is enabled.
     * @param string $authKey the given auth key
     * @return boolean whether the given auth key is valid.
     * @see getAuthKey()
     */
    public function validateAuthKey($authKey)
    {
        // TODO: Implement validateAuthKey() method.
    }
}
