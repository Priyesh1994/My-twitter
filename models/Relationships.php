<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "relationships".
 *
 * @property integer $id
 * @property integer $follower_id
 * @property integer $followed_id
 *
 * @property Users $followed
 * @property Users $follower
 */
class Relationships extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'relationships';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['follower_id', 'followed_id'], 'required'],
            [['follower_id', 'followed_id'], 'integer'],
            [['followed_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['followed_id' => 'userId']],
            [['follower_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['follower_id' => 'userId']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'follower_id' => 'Follower ID',
            'followed_id' => 'Followed ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFollowed()
    {
        return $this->hasOne(Users::className(), ['userId' => 'followed_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFollower()
    {
        return $this->hasOne(Users::className(), ['userId' => 'follower_id']);
    }
}
