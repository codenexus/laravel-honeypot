<?php

namespace Codenexus\Honeypot;

class Honeypot
{
	/**
	 * Fill a honeypot and return the form HTML
	 *
	 * @param  string $honey_name
	 * @param  string $honey_time
	 * @return string
	 */
	public function fill($honey_name, $honey_time)
	{
		$honey_time_encrypted = $this->getEncryptedTime();

		return $html = "<input type=\"hidden\" id=\"$honey_name\" name=\"$honey_name\" value=\"\">\r\n" .
					   "<input type=\"hidden\" name=\"$honey_time\" value=\"$honey_time_encrypted\">";
	}

	/**
	 * Validate honeypot is empty
	 *
	 * @param  string $attribute
	 * @param  mixed $value
	 * @param  array $parameters
	 * @return boolean
	 */
	public function validateHoneypot($attribute, $value, $parameters)
	{
		return ($value) ? false : true;
	}

	/**
	 * Validate honey time was within the time limit
	 *
	 * @param  string $attribute
	 * @param  mixed $value
	 * @param  array $parameters
	 * @return boolean
	 */
	public function validateHoneytime($attribute, $value, $parameters)
	{
		// Get the decrypted time
		$value = $this->decryptTime($value);

		// The current time should be greater than the time the form was built + the speed option
		return ( is_numeric($value) && time() > ($value + $parameters[0]) );
	}

	/**
	 * Get the decrypted time
	 *
	 * @return string
	 */
	protected function getEncryptedTime()
	{
		return encrypt(time());
	}

	/**
	 * Decrypt the given time
	 *
	 * @param  mixed $time
	 * @return string
	 */
	protected function decryptTime($time)
	{
        return decrypt($time);
	}
}
