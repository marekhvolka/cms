<?php

namespace backend\components;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use backend\models\ProductType;
use backend\models\ProductVar;

class IdentifierComponent extends Component
{

    /**
     * Method generates indetifier of specified text based on delimiter 
     * between words. Identifier is classic slug with specified delimiter 
     * (utf8 diacritic changed, special chars removed, spaces changed to delimier character).
     * @param string $text text to be transformed to identidier.
     * @param string $delimiter delimiter between words instead of spaces.
     * @return string returns generated identifier.
     */
    public static function generateIdentifier($text, $delimiter)
    {
        // ProductVar model was chosen as one model implementing SluggableBehavior.
        // This approach can be reused - other models does not have to imlement it
        // (even though they can).
        $model = new ProductVar();
        
        // Attribute type_id is required - thus it must be set here.
        $model->type_id = ProductType::find()->one()->id;   
        $model->name = $text;
        
        // Model is temporary created, slug is created as well and saved as identifier attribute.
        $model->save();     

        $res = $model->identifier;
        $model->delete();   // Temporary model can be deleted.
        
        // Set delimiter between words. Default: '-' as SluggableBehavior is implemented.s
        if ($delimiter != null) {
            $res = str_replace("-", $delimiter, $res);
        }
        return $res;
    }

}
