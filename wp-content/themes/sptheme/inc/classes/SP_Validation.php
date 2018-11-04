<?php if (!defined('ABSPATH')) exit('No direct script access allowed');

/**
 * @SimplePAVE
 * https://t.me/SimplePAVE
 * info@simplepave.ru
 */

if (!class_exists('SP_Validation')) :

class SP_Validation {

    private $validate;
    private $get_name, $get_value, $get_key, $get_params = [];
    private $errors = [];
    private $fields = [];

    public $status = true;

    /**
     *
     */

    public function __construct()
    {
        $this->validate = [
            'required'    => ['param' => false, 'value' => 'Обязательное поле.'],
            'accepted'    => ['param' => 0, 'value' => 'Обязательное поле.'],

            'max'         => ['param' => 1, 'value' => 'Больше чем %s симв.', 'def' => [255]],
            'min'         => ['param' => 1, 'value' => 'Минимум %s симв.', 'def' => [3]],
            'numeric'     => ['param' => 0, 'value' => 'Не число.'],
            'string'      => ['param' => 0, 'value' => 'Не строка.'],
            'regex'       => ['param' => 1, 'value' => 'Ошибочный формат.', 'def' => '//'],
            'date'        => ['param' => 0, 'value' => 'Не является датой.'],
            'date_format' => ['param' => 1, 'value' => 'Формат: %s', 'def' => ['Y-m-d H:i:s']],
            'confirmed'   => ['param' => 2, 'value' => 'Не совпадает с %s.'],

            'email'       => ['param' => 1, 'value' => 'Не электронный адрес.', 'def' => ['/.+@.+\..+/i']],
            'phone'       => ['param' => 1, 'value' => 'Не телефон.', 'def' => ['/^([+]?[0-9\s-\(\)]{3,25})*$/i']],
        ];
    }

    /**
     *
     */

    public function validation($data = false)
    {
        if (is_array($data)) {
            foreach ($data as $name => $items) {
                $this->get_value = $this->name_isset($name);
                $this->get_name = $name;
                $variable = explode('|', $items);

                if (!is_bool($this->get_value) || in_array('accepted', $variable)) {
                    if (in_array('required', $variable)) {
                        $this->get_key = 'required';
                        $this->validate_required();
                    }
                    elseif (in_array('nullable', $variable) && empty($this->get_value)) continue;

                    foreach ($variable as $val) {
                        if (in_array('bail', $variable) && isset($this->errors[$this->get_name])) break;
                        $validate = explode(':', $val, 2);
                        $this->get_key = $validate[0];

                        if (array_key_exists($this->get_key, $this->validate)) {
                            $param = $this->validate[$this->get_key]['param'];
                            if (is_bool($param)) continue;

                            if ($param > 0) {
                                $this->get_params = [];
                                if (isset($validate[1])) {
                                    $params = explode(',', $validate[1], $param);
                                    if (count($params) == $param)
                                        $this->get_params = $params;
                                }
                                if (!$this->get_params && isset($this->validate[$this->get_key]['def']))
                                    $this->get_params = $this->validate[$this->get_key]['def'];
                            }
                            $this->{'validate_' . $this->get_key}();
                        }
                    }
                }
            }
        }
    }

    /**
     *
     */

    public function get_errors()
    {
        return $this->errors;
    }

    public function get_fields()
    {
        return $this->status? $this->fields: false;
    }

    /**
     *
     */

    private function name_isset($name)
    {
        $field = isset($_POST[$name])? trim($_POST[$name]): false;
        $this->fields[$name] = $field;

        return $field;
    }

    private function errors($value)
    {
        $this->errors[$this->get_name][$this->get_key] = $value;
        $this->status = false;
    }

    /**
     * Required
     */

    private function validate_required()
    {
        if (empty($this->get_value))
            $this->errors($this->validate[$this->get_key]['value']);
    }

    /**
     * Numeric
     */

    private function validate_numeric()
    {
        if (!is_numeric($this->get_value))
            $this->errors($this->validate[$this->get_key]['value']);
    }

    /**
     * String
     */

    private function validate_string()
    {
        if (!is_string($this->get_value))
            $this->errors($this->validate[$this->get_key]['value']);
    }

    /**
     * Regex:(regex)
     */

    private function validate_regex($value = false)
    {
        if (!preg_match($this->get_params[0], $this->get_value)) {
            $value = $value?: $this->validate[$this->get_key]['value'];
            $this->errors($value);
        }
    }

    /**
     * Phone:([regex])
     */

    private function validate_phone()
    {
        $this->validate_regex($this->validate[$this->get_key]['value']);
    }

    /**
     * E-mail:([regex])
     */

    private function validate_email()
    {
        $this->validate_regex($this->validate[$this->get_key]['value']);
    }

    /**
     * Max:([int])
     */

    private function validate_max()
    {
        if (mb_strlen($this->get_value) > $this->get_params[0])
            $this->errors(sprintf($this->validate[$this->get_key]['value'], $this->get_params[0]));
    }

    /**
     * Min:([int])
     */

    private function validate_min()
    {
        if (mb_strlen($this->get_value) < $this->get_params[0])
            $this->errors(sprintf($this->validate[$this->get_key]['value'], $this->get_params[0]));
    }

    /**
     * Date
     */

    private function validate_date()
    {
        if (!is_numeric(strtotime($this->get_value)))
            $this->errors($this->validate[$this->get_key]['value']);
    }

    /**
     * Date Format:([format])
     */

    private function validate_date_format()
    {
        $dateTime = DateTime::createFromFormat('!'.$this->get_params[0], $this->get_value);

        if (!$dateTime || $dateTime->format($this->get_params[0]) != $this->get_value) {
            $date = new DateTime();
            $this->errors(sprintf($this->validate[$this->get_key]['value'], $date->format($this->get_params[0])));
        }
    }

    /**
     * Accepted
     */

    public function validate_accepted()
    {
        $acceptable = ['yes', 'on', '1', 1, true, 'true'];

        if (!in_array($this->get_value, $acceptable, true))
            $this->errors($this->validate[$this->get_key]['value']);
    }

    /**
     * Confirmed:(name)
     */

    public function validate_confirmed()
    {
        $confirm = $this->name_isset($this->get_params[0]);

        if ($confirm != $this->get_value) {
            $param = isset($this->get_params[1])? $this->get_params[1]: $this->get_params[0];
            $this->errors(sprintf($this->validate[$this->get_key]['value'], $param));
        }
    }
}

endif;