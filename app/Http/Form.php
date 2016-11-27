<?php
/**
 * @author Rizart Dokollari <r.dokollari@gmail.com>
 * @since  11/13/16
 */

namespace App\Http;

use App\Socialike\Model\Model;
use Core\flash\Flash;
use Core\Request;
use Core\Session;

class Form
{
    /**
     * @var Model
     */
    protected $model;

    /**
     * Create a form input field.
     *
     * @param             $name
     * @param null|string $value
     * @param array       $options
     *
     * @return string
     */
    public function text ($name, $value = '', $options = [])
    {
        return $this->input('text', $name, $value, $options);
    }

    /**
     * Create a form input field.
     *
     * @param             $type
     * @param             $name
     * @param null|string $value
     * @param array       $options
     *
     * @return string
     */
    public function input ($type, $name, $value = '', $options = [])
    {
        $attributes = $this->generateKeyValues($options);

        if (Session::has($name))
        {
            $value = Session::extract($name);
        }

        if ($this->model && property_exists($this->model, $name))
        {
            $value = $this->model->$name;
        }

        $alert = $this->generateFormError($name);

        return "<input type='$type' name='$name' value='$value' $attributes/>" . $alert;
    }

    /**
     * @param $options
     *
     * @return string
     */
    private function generateKeyValues ($options)
    {
        $attributes = [];

        foreach ($options as $name => $option)
        {
            $attributes[] = "$name='$option'";
        }

        return implode(' ', $attributes);
    }

    /**
     * @param $name
     *
     * @return array|string
     */
    private function generateFormError ($name):string
    {
        if ( ! Flash::hasFormError($name))
        {
            return '';
        }

        $error = Flash::getFormError($name);

        $type = $error['type'];

        $message = $error['message'];

        $alert = '<div class="alert ' . $type . ' alert-dismissible fade in" role="alert">';

        $alert .= $message;

        $alert .= '</div>';

        return $alert;
    }

    /**
     * Create a form number field.
     *
     * @param             $name
     * @param null|string $value
     * @param array       $options
     *
     * @return string
     */
    public function number ($name, $value = '', $options = [])
    {
        return $this->input('number', $name, $value, $options);
    }

    public function select ($name, $list = [], $selected = null, $options = [])
    {
        $options['name'] = $name;

        $options = $this->generateKeyValues($options);


        if (!$selected && $this->model && property_exists($this->model, $name))
        {
            $selected = $this->model->$name;
        }

        foreach ($list as $value => $display)
        {
            $currentSelected = $selected == $value ? " selected='selected'" : '';

            $list[] = "<option$currentSelected value='$value'>$display</option>";
        }

        $list = implode('', $list);

        $alert = $this->generateFormError($name);

        return "<select {$options}>{$list}</select>" . $alert;
    }

    public function close ()
    {
        return '</form>';
    }

    public function model (Model $model, array $options)
    {
        $this->model = $model;

        return $this->open($options);
    }

    public function open (array $options = [])
    {
        $attributes['method'] = array_key_exists('method', $options) ? $options['method'] : 'POST';

        $attributes['action'] = array_key_exists('action', $options) ? $options['action'] : Request::uri();

        $attributes['class'] = array_key_exists('class', $options) ? $options['class'] : '';

        $attributes['accept-charset'] = 'UTF-8';

        if (isset($options['files']) && $options['files'])
        {
            $attributes['enctype'] = 'multipart/form-data';
        }

        $attributes = $this->generateKeyValues($attributes);

        return "<form $attributes>";
    }

    public function submit ($value = null, $options = [])
    {
        return $this->input('submit', null, $value, $options);
    }

    public function hidden ($name, $value = null, $options = [])
    {
        return $this->input('hidden', $name, $value, $options);
    }
}