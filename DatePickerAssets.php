<?php
/**
 * Created by PhpStorm.
 * User: Matthew
 * Date: 02/06/2018
 * Time: 15:56
 */

namespace mattxw\datepicker;


use yii\bootstrap4\BootstrapAsset;
use yii\bootstrap4\BootstrapPluginAsset;
use yii\web\AssetBundle;

class DatePickerAssets extends AssetBundle
{
    public $sourcePath = "@npm/bootstrap-datepicker/dist";

    public $css = [
        "css/bootstrap-datepicker.css",
    ];

    public $js = [
        "js/bootstrap-datepicker.js",
    ];

    public $depends = [
        BootstrapAsset::class,
        BootstrapPluginAsset::class,
    ];
}