<?php

namespace Core\Validation;

use DateTime;

trait Rules
{
    protected function required(array $parameters)
    {
        if (! $this->request->input($parameters['ruleName']) || empty($this->request->input($parameters['ruleName'])) || is_null($this->request->input($parameters['ruleName'])))
            array_push($this->messages , $parameters['message']);
    }

    protected function string(array $parameters)
    {
        if (!\is_string($this->request->input($parameters['ruleName'])))
            array_push($this->messages , $parameters['message']);
    }

    protected function integer(array $parameters)
    {
        if (!\is_int($this->request->input($parameters['ruleName'])))
            array_push($this->messages , $parameters['message']);
    }

    protected function boolean(array $parameters)
    {
        if (!\is_bool($this->request->input($parameters['ruleName'])))
            array_push($this->messages , $parameters['message']);
    }

    protected function array(array $parameters)
    {
        if (!\is_array($this->request->input($parameters['ruleName'])))
            array_push($this->messages , $parameters['message']);
    }

    protected function email(array $parameters)
    {
        if (false === \filter_var($this->request->input($parameters['ruleName']), FILTER_VALIDATE_EMAIL))
            array_push($this->messages , $parameters['message']);
    }

    protected function regex(array $parameters)
    {
        if (!\preg_match($parameters['value'], $this->request->input($parameters['ruleName'])))
            array_push($this->messages , $parameters['message']);
    }

    protected function max(array $parameters)
    {
        if ($this->strlen($this->request->input($parameters['ruleName'])) > $parameters['value'])
            array_push($this->messages , $parameters['message']);
    }

    protected function min(array $parameters)
    {
        if ($this->strlen($this->request->input($parameters['ruleName'])) < $parameters['value'])
            array_push($this->messages , $parameters['message']);
    }

    protected function size(array $parameters)
    {
        if ($this->strlen($this->request->input($parameters['ruleName'])) != $parameters['value'])
            array_push($this->messages , $parameters['message']);
    }

    protected function date(array $parameters)
    {
        $dateArray  = explode('-', $this->request->input($parameters['ruleName']));
        if (count($dateArray) == 3){
            if (! checkdate((int) $dateArray[1], (int) $dateArray[2], (int) $dateArray[0]))
                array_push($this->messages , $parameters['message']);

            return;
        }

        array_push($this->messages , $parameters['message']);
    }

    protected function in(array $parameters)
    {
        $array = explode(',' , $parameters['value']);

        if (! in_array($this->request->input($parameters['ruleName']) , $array))
            array_push($this->messages , $parameters['message']);
    }

    protected function nationalCode(array $parameters)
    {
        if(! preg_match('/^[0-9]{10}$/' , $this->request->input($parameters['ruleName']))){
            array_push($this->messages , $parameters['message']);
            return;
        }

        for($i = 0; $i < 10; $i++)
            if(preg_match('/^'.$i.'{10}$/' , $this->request->input($parameters['ruleName']))){
                array_push($this->messages , $parameters['message']);
                return;
            }

        for($i = 0, $sum = 0; $i < 9; $i++)
            $sum += ((10-$i) * intval(substr($this->request->input($parameters['ruleName']) , $i ,1)));

        $ret = $sum % 11;

        $parity = intval(substr($this->request->input($parameters['ruleName']), 9,1));

        if(($ret < 2 && $ret == $parity) || ($ret >= 2 && $ret == 11 - $parity))
            return;

        array_push($this->messages , $parameters['message']);
    }


    protected function strlen($value): bool|int
    {
        if (!\function_exists('mb_detect_encoding'))
            return \strlen($value);

        if (false === $encoding = \mb_detect_encoding($value))
            return \strlen($value);

        return \mb_strlen($value, $encoding);
    }
}