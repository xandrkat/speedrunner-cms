<?php

namespace backend\modules\Block\models;

use Yii;
use common\components\framework\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\behaviors\SluggableBehavior;
use backend\modules\Block\modelsTranslation\BlockPageTranslation;


class BlockPage extends ActiveRecord
{
    public $translation_table = 'BlockPageTranslation';
    public $translation_attrs = [
        'name',
    ];
    
    public $name;
    
    public $blocks_tmp;
    
    public $seo_meta = [];
    
    public static function tableName()
    {
        return 'BlockPage';
    }
    
    public function behaviors()
    {
        return [
            'sluggable' => [
                'class' => SluggableBehavior::className(),
                'attribute' => 'name',
                'slugAttribute' => 'url',
            ],
        ];
    }
    
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'url'], 'string', 'max' => 100],
            [['url'], 'unique'],
            [['url'], 'match', 'pattern' => '/^[a-zA-Z0-9\-]+$/'],
            [['blocks_tmp'], 'safe'],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'url' => Yii::t('app', 'Url'),
            'created' => Yii::t('app', 'Created'),
            'updated' => Yii::t('app', 'Updated'),
            'blocks_tmp' => Yii::t('app', 'Blocks'),
        ];
    }
    
    public function getTranslation()
    {
        return $this->hasOne(BlockPageTranslation::className(), ['item_id' => 'id'])->andWhere(['lang' => Yii::$app->language]);
    }
    
    public function getBlocks()
    {
        return $this->hasMany(Block::className(), ['page_id' => 'id'])->orderBy('sort');
    }
    
    public function afterSave($insert, $changedAttributes)
    {
        //        BLOCKS
        
        $blocks = ArrayHelper::map($this->blocks, 'id', 'id');
        $counter = 0;
        
        if ($this->blocks_tmp) {
            foreach ($this->blocks_tmp as $key => $b) {
                $block_mdl = Block::findOne($key) ?: new Block;
                $block_mdl->page_id = $this->id;
                $block_mdl->type_id = $b['type_id'];
                $block_mdl->sort = $counter;
                $block_mdl->save();
                
                ArrayHelper::remove($blocks, $key);
                $counter++;
            }
        }
        
        if ($blocks = Block::find()->where(['id' => $blocks])->all()) {
            foreach ($blocks as $b) { $b->delete(); }
        }
        
        return parent::afterSave($insert, $changedAttributes);
    }
    
    public function afterDelete()
    {
        foreach ($this->blocks as $b) { $b->delete(); };
        
        BlockPageTranslation::deleteAll(['item_id' => $this->id]);
        
        return parent::afterDelete();
    }
}