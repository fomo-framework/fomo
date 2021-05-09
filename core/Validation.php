<?php


namespace Core;

class Validation
{
    protected array $rules = [];
    protected array $errorDefaultMessage = [];
    protected array $messages = [];
    protected ?Request $request = null;

    public function __construct(array $rules)
    {
        $this->request = Request::getInstance();
        $this->rules = $rules;
        $this->errorDefaultMessage = include "config/errors.php";
        $this->validate();
    }

    protected function validate()
    {
        foreach ($this->rules as $ruleName => $rule){
            $rule = explode('|' , $rule);

            foreach ($rule as $item)
            {
                $itemExplode = explode(':' , $item);
                $item = $itemExplode[0];
                $itemValue = $itemExplode[1] ?? null;

                $message = $this->errorDefaultMessage['message'][$item] ? str_replace(":attribute" , $this->errorDefaultMessage['attribute'][$ruleName] , $this->errorDefaultMessage['message'][$item]) : '';

                $message = str_replace(":value" , $itemValue , $message);

                $parameters = [
                    'ruleName' => $ruleName ,
                    'value' => $itemValue ,
                    'message' => $message
                ];
                $this->$item($parameters);
            }
        }
    }

    protected function required(array $parameters)
    {
        if (! $this->request->input($parameters['ruleName']) || empty($this->request->input($parameters['ruleName']))){
            array_push($this->messages , $parameters['message']);
        }
    }

    protected function max(array $parameters)
    {
        if ($this->strlen($this->request->input($parameters['ruleName']) ) > $parameters['value']) {
            array_push($this->messages , $parameters['message']);
        }
    }

    protected function strlen($value): bool|int
    {
        if (!\function_exists('mb_detect_encoding')) {
            return \strlen($value);
        }

        if (false === $encoding = \mb_detect_encoding($value)) {
            return \strlen($value);
        }

        return \mb_strlen($value, $encoding);
    }


    public function getMessages(): array
    {
        return $this->messages;
    }
}