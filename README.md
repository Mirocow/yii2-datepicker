# yii2-datepicker

This widget was created for a project and unstable for production use, I will not hold any responsibilites for any 
action you've made with this repository, please use with care.

To use this widget for your project, please follow this instruction.

* Include this repository to your composer.json

  ```
    "repositories": [
      {
        "type": "composer",
        "url": "https://asset-packagist.org"
      },
      {
        "type" : "git",
        "url" : "https://github.com/mattxw/yii2-datepicker.git"
      }
    ] 
  ```

* Make sure to set your minimum stability to `dev`
  ```
  "minimum-stability": "dev"
  ```

* Run following ocmmand from your project root
  ```
  composer require mattxw/yii2-datepicker
  ```

* Below is an example on how to show a simple datepicker to your view

  ```php
    $model->field('date')->widget(\mattxw\datepicker\DatePicker::class, [
        'jsOptions' => [
            'format' => 'dd/mm/yyyy', // This is optional
        ]
    ])
  ```
  
  You can use it to show two input for a date range picker too.
  ```php
    \mattxw\datepicker\DatePicker::widget([
        // Both model and attributes are required
        'model' => $model,
        'attribute' => [
            'date_from',
            'date_until'
        ],
        'containerOptions' => [
            'label' => 'Event Date Range', // This is optional
        ],
        'inputOptions' => [
            'separator' => 'Hingga', // This is required
        ],
        'jsOptions' => [
            'format' => 'dd/mm/yyyy', // This is optional
        ]
    ])
  ```
