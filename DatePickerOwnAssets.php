<?php
/**
 * Created by PhpStorm.
 * User: Matthew
 * Date: 02/06/2018
 * Time: 16:22
 */

namespace mattxw\datepicker;


use yii\web\AssetBundle;

class DatePickerOwnAssets extends AssetBundle
{
    public $sourcePath = "@vendor/mattxw/yii2-datepicker/assets";

    public $css = [
        "css/yii2-datepicker.css",
    ];

    public $js = [
        "js/yii2-datepicker.js",
    ];

    public $depends = [
        DatePickerAssets::class,
    ];

    public $publishOptions = [
        'forceCopy' => true,
    ];
}