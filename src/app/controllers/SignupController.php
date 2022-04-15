<?php

use Phalcon\Mvc\Controller;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;

class SignupController extends Controller
{

    public function IndexAction()
    {
        if ($this->request->isPost()) {
            $postData = $this->request->getPost();

            $name = $postData["name"];
            $email = $postData["email"];
            $password = $postData["password"];

            $validation = new Validation();
            $validation->add(
                [
                    'name',
                    'email',
                    'password'
                ],
                new PresenceOf(
                    [
                        'message' => [
                            "name" => 'name is required',
                            "email" => 'email is required',
                            "password" => 'password is required',
                        ]
                    ]
                )
            );
            $validation->add(
                "email",
                new Email(
                    [
                        "message" => "The e-mail is not valid",
                    ]
                )
            );
            $validation->add(
                "name_last",
                new StringLength(
                    [
                        "max"             => 50,
                        "min"             => 2,
                        "messageMaximum"  => "Name too long",
                        "messageMinimum"  => "Name too short",
                        "includedMaximum" => true,
                        "includedMinimum" => true,
                    ]
                )
            );
            $messages = $validation->validate($_POST);
            if (count($messages)) {
                foreach ($messages as $message) {
                    echo $message, '<br>';
                }
            }
            die;
        }
    }
}
