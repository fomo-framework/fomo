<?php

namespace Core;

use Core\Validation\Rules;

class Validation
{
    use Rules;

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

                $message = $this->errorDefaultMessage['message'][$item] ? str_replace(":attribute" , $this->errorDefaultMessage['attribute'][$ruleName] ?? $ruleName , $this->errorDefaultMessage['message'][$item]) : null;

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

    public function getMessages(): array
    {
        return $this->messages;
    }
}