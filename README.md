To install formatter
```
    'components' => [
        'formatter' => [
            'class' => 'achertovsky\formatter\i18n\Formatter',
        ],
        //...
    ],
```

to use formatter
```
Yii::$app->formatter->asJson($array);
```
