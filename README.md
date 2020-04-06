# install 

add to composer.json following

`"achertovsky/yii2-json-formatter": "@dev"`

or

`composer require achertovsky/yii2-json-formatter "@dev"`


# To configure formatter
```
    'components' => [
        'formatter' => [
            'class' => 'achertovsky\formatter\i18n\Formatter',
        ],
        //...
    ],
```

# to use formatter
```
Yii::$app->formatter->asJson($array);
```
