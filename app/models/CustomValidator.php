<?php
use Zizaco\Confide\UserValidatorInterface;
use Zizaco\Confide\ConfideUserInterface;

class CustomValidator implements UserValidatorInterface
{
    /**
     * Validates the given user. Should check if all the fields are correctly
     * and may check other stuff too, like if the user is unique.
     * @param  ConfideUserInterface $user Instance to be tested
     * @return boolean                    True if the $user is valid
     */
    public function validate(ConfideUserInterface $user)
    {
		public static $rules = array(
			'firstname' => 'required|alpha',
			'lsatname' => 'required|alpha',
			'username' => 'required|alpha_dash|unique:users',
			'email' => 'required|email|unique:users',
			'password' => 'required|min:4|confirmed',
			'password_confirmation' => 'min:4',
		);
        unset($user->password_confirmation); // Because this column doesn't really exists.

        Log::info("Using a custom validator!");

        return true;
    }
}