<?php

class RegisterValidator implements UserValidatorInterface
{

    public function validate(ConfideUserInterface $user)
    {
        unset($user->password_confirmation);
        return true; // If the user valid
    }
}