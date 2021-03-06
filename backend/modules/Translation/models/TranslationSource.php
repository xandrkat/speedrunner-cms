<?php

namespace backend\modules\Translation\models;

use Yii;
use common\framework\ActiveRecord;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;


class TranslationSource extends ActiveRecord
{
    public $translations_tmp;
    
    public static function tableName()
    {
        return 'TranslationSource';
    }
    
    public function rules()
    {
        return [
            [['category'], 'required'],
            [['message'], 'string'],
            [['category'], 'string', 'max' => 32],
            [['translations_tmp'], 'safe'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'Id'),
            'category' => Yii::t('app', 'Category'),
            'message' => Yii::t('app', 'Message'),
            'translations_tmp' => Yii::t('app', 'Translations'),
            'has_translation' => Yii::t('app', 'Has translation'),
        ];
    }
    
    public function getTranslations()
    {
        return $this->hasMany(TranslationMessage::className(), ['id' => 'id']);
    }
    
    public function getCurrentTranslation()
    {
        return $this->hasOne(TranslationMessage::className(), ['id' => 'id'])->onCondition(['language' => Yii::$app->language]);
    }
    
    public function afterSave($insert, $changedAttributes)
    {
        if ($this->translations_tmp) {
            $available_langs = Yii::$app->services->i18n::$languages;
            
            foreach ($this->translations_tmp as $key => $value) {
                if (array_key_exists($key, $available_langs)) {
                    $relation_mdl = TranslationMessage::find()->andWhere(['id' => $this->id, 'language' => $key])->one() ?: new TranslationMessage;
                    $relation_mdl->id = $this->id;
                    $relation_mdl->language = $key;
                    $relation_mdl->translation = $value;
                    $relation_mdl->save();
                }
            }
        }
        
        return parent::afterSave($insert, $changedAttributes);
    }
}
