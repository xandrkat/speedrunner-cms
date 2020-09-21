<?php

namespace frontend\components;

use Yii;
use yii\web\UrlRuleInterface;
use yii\base\BaseObject;


class ProductCategoryUrlRule extends BaseObject implements UrlRuleInterface
{
    public $route;
    
    public function createUrl($manager, $route, $params)
    {
        if ($route == $this->route) {
            $path = '/catalog/' . $params['url'];
            unset($params['url']);
            
            if ($params) {
                $path .= '?';
                
                foreach ($params as $key => $value) {
                    if (is_array($value)) {
                        foreach ($value as $v) {
                            $path .= $key . '[]=' . $v . '&';
                        }
                    } else {
                        $path .= $key . '=' . $value . '&';
                    }
                }
            }
            
            return rtrim($path, '&');
        } else {
            return false;
        }
    }
    
    public function parseRequest($manager, $request)
    {
        $path = explode('/', $request->pathInfo);
        
        if (array_shift($path) == 'catalog') {
            return [$this->route, ['url' => implode('/', $path)]];
        } else {
            return false;
        }
    }
}
