<?php

namespace mattxw\datepicker;

use yii\base\Model;
use yii\bootstrap4\Html;
use yii\bootstrap4\Widget;
use yii\helpers\ArrayHelper;
use yii\helpers\StringHelper;
use yii\web\JsExpression;

/**
 * Class DatePicker
 * @package mattxw\datepicker
 */
class DatePicker extends Widget
{
    /**
     * @var Model $model
     * @var string|array $attribute
     */
    public $model, $attribute;

    /**
     * @var array $jsOptions Options for BS Datepicker JavaScript
     */
    public $jsOptions = [];
    /**
     * @var array $inputOptions Options for input element
     */
    public $inputOptions = [];
    /**
     * @var array $containerOptions Options for input(s) container
     */
    public $containerOptions = [];

    /**
     * init()
     * Initialize all variables with default value
     */
    public function init()
    {
        // Default options
        $this->inputOptions = ArrayHelper::merge([
            'class' => 'form-control',
        ], $this->inputOptions);

        $this->jsOptions = ArrayHelper::merge([
            'format' => 'mm/dd/yyyy',
        ], $this->jsOptions);
    }

    /**
     * @return string
     */
    public function run()
    {
        parent::run();
        return $this->renderWidget();
    }

    /**
     * @return string Render results
     */
    private function renderWidget()
    {
        $class = ['input-group'];

        // Use user's class if mentioned
        if (isset($this->containerOptions['class']))
            $class = $this->containerOptions['class'];
        else {
            // Decide whether to use daterange or datepicker
            if (is_array($this->attribute))
                $class[] = 'input-daterange';
            else
                $class[] = 'input-datepicker';

        }

        // Enclose in an array for easier render
        if (!is_array($this->attribute))
            $attrArray = [$this->attribute];
        else
            $attrArray = $this->attribute;

        // Render input for each attribute(s)
        $input = "";
        foreach ($attrArray as $key => $attr) {
            $input .= Html::activeInput("text", $this->model, $attr, ArrayHelper::merge([
                'value' => $this->model->{$attr},
            ], $this->inputOptions));

            // Add connector if not the last element in array
            if ($key < count($attrArray) - 1)
                $input .= Html::tag('div', @$this->inputOptions['separator'] ?: "", ['class' => 'input-group-text']);
        }

        $errors = "";
        foreach ($attrArray as $attr) {
            foreach ($this->model->getErrors($attr) as $error) {
                $errors .= Html::tag('div', $error, ['class' => 'text-danger']);
            }
        }

        // Register assets
        DatePickerOwnAssets::register($this->view);

        // Register custom Javascript to initiate widgets
        $this->view->registerJs(new JsExpression($this->renderJs()));

        // Return HTMLs
        return Html::tag('div',
            // write label if exists
            (isset($this->containerOptions['label']) ? Html::label($this->containerOptions['label'], null, ['class' => 'd-block w-100']) : "") .
            $input .
            Html::tag('div', $errors, ['class' => 'w-100'])
            , ArrayHelper::merge([
                'id' => $this->id,
                'class' => implode(" ", $class),
            ], $this->containerOptions));
    }

    /**
     * @return string
     */
    private function renderJs()
    {
        $options = json_encode($this->jsOptions);
        var_dump(date('d/m/Y'));
        return "
            $('#{$this->id}').each(function(i, o) {
                $(o).datepicker({$options});
            });
        ";
    }
}