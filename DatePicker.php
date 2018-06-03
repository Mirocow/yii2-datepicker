<?php

namespace mattxw\datepicker;

use yii\base\Model;
use yii\bootstrap4\Html;
use yii\bootstrap4\Widget;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;

/**
 * Class DatePicker
 * @package mattxw\datepicker
 * @property Model $model
 * @property  string|array $attribute
 * @property  array $jsOptions Options for BS Datepicker JavaScript
 * @property  array $inputOptions Options for input element
 * @property  array $containerOptions Options for input(s) container
 */
class DatePicker extends Widget
{
    public $model, $attribute;
    public $jsOptions = [];
    public $inputOptions = [];
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
            if (is_array($this->attribute))
                $class[] = 'input-daterange';
        }

        $input = "";
        $errors = "";

        // Enclose in an array for easier render
        if (is_array($this->attribute)) {
            // Generate input field for each attribute
            foreach ($this->attribute as $key => $attr) {
                $input .= Html::activeInput("text", $this->model, $attr, ArrayHelper::merge([
                    'value' => $this->model->{$attr},
                ], $this->inputOptions));

                // Add connector if not the last element in array
                if ($key < count($this->attribute) - 1)
                    $input .= Html::tag('div', @$this->inputOptions['separator'] ?: "", ['class' => 'input-group-text']);
            }

            // Enclose in a container so it can be displayed in a linear block
            $input = Html::tag('div', $input, ArrayHelper::merge([
                'id' => $this->id,
                'class' => implode(" ", $class),
            ], $this->containerOptions));
        } else
            // Just generate it with id on the input
            $input .= Html::activeInput("text", $this->model, $this->attribute, ArrayHelper::merge([
                'id' => $this->id,
                'value' => $this->model->{$this->attribute},
            ], $this->inputOptions));

        // Generate errors for each attribute
        foreach (is_array($this->attribute) ? $this->attribute : [$this->attribute] as $attr) {
            foreach ($this->model->getErrors($attr) as $error) {
                $errors .= Html::tag('div', $error, ['class' => 'text-danger']);
            }
        }

        // Register assets
        DatePickerOwnAssets::register($this->view);

        // Register custom Javascript to initiate widgets
        $this->view->registerJs(new JsExpression($this->renderJs()));

        // Return HTMLs
        return
            Html::tag('div',
                // write label if exists
                (isset($this->containerOptions['label']) ? Html::label($this->containerOptions['label'], null, ['class' => 'd-block w-100']) : "") .
                $input .
                Html::tag('div', $errors, ['class' => 'w-100']));
    }

    /**
     * @return string
     */
    private function renderJs()
    {
        $options = json_encode($this->jsOptions);
        if (is_array($this->attribute))
            return "
            $('#{$this->id}').each(function(i, o) {
                $(o).datepicker({$options});
            });
        ";
        else
            return "$('#{$this->id}').datepicker({$options});";
    }
}