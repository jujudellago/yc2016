<?php
/**
 * One Click System Check
 *
 * @package One Click Installer
 * @subpackage Admin
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license **LICENSE**
 * @version 1.18.14
 * @author Oxygenna.com
 */

abstract class OxygennaSystemCheck
{
    protected $label;
    protected $value;
    protected $ok;
    protected $info;
    protected $type;

    public function __construct($label, $type = 'blocker')
    {
        $this->label = $label;
        $this->ok    = false;
        $this->value = '';
        $this->info  = '';
        $this->type = $type;
    }

    public function label()
    {
        echo $this->label;
    }

    public function value()
    {
        echo $this->value;
    }

    public function ok()
    {
        return $this->ok;
    }

    public function icon()
    {
        switch($this->type)
        {
            case 'warning':
                return $this->ok ? 'yes' : 'info';
            break;
            case 'blocker':
            default:
                return $this->ok ? 'yes' : 'no';
            break;
        }
    }

    public function resultClass()
    {
        switch($this->type)
        {
            case 'warning':
                return $this->ok ? 'ok' : 'warning';
            break;
            case 'blocker':
            default:
                return $this->ok ? 'ok' : 'fail';
            break;
        }
    }

    public function info()
    {
        echo $this->info;
    }

    public function type()
    {
        return $this->type;
    }

    protected function condition($var1, $op, $var2)
    {
        switch ($op) {
            case '=':
                return $var1 == $var2;
            case '!=':
                return $var1 != $var2;
            case '>=':
                return $var1 >= $var2;
            case '<=':
                return $var1 <= $var2;
            case '>':
                return $var1 >  $var2;
            case '<':
                return $var1 <  $var2;
            default:
                return true;
        }
    }

    /**
     * ini_to_num function.
     *
     * This function transforms the php.ini notation for numbers (like '2M') to an integer.
     *
     * @access public
     * @param $size
     * @return int
     */
    protected function ini_to_num($size)
    {
        $l      = substr($size, -1);
        $ret    = substr($size, 0, -1);
        switch (strtoupper($l)) {
            case 'P':
                $ret *= 1024;
                // fall through
            case 'T':
                $ret *= 1024;
                // fall through
            case 'G':
                $ret *= 1024;
                // fall through
            case 'M':
                $ret *= 1024;
                // fall through
            case 'K':
                $ret *= 1024;
                // fall through
        }

        return $ret;
    }

    abstract public function check();
}
