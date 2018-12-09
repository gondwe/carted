<?php 

namespace Fin\Validation;

use Fin\Validation\Support\ValidationInterface;
use Psr\Http\Message\RequestInterface;
use Respect\Validation\Exceptions\NestedValidationException;


class Validator implements ValidationInterface
{

    protected $errors = [];

    public function validate(RequestInterface $req, $rules)
    {

        foreach($rules as $field=>$rule){
            try {
                $rule->setName(ucfirst($field))->assert($req->getParam($field));
            } catch (NestedValidationException $e) {
                $this->errors[$field] = $e->getMessages();
            }
        }

        $_SESSION["errors"] = $this->errors;

        return $this;
    }

    public function fails()
    {
        return !empty($this->errors);
    }
}