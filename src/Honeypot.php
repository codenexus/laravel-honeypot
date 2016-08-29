<?php

namespace Codenexus\Honeypot;

class Honeypot
{
	public function fill($honey_name, $honey_time)
	{
		$honey_time_encrypted = $this->getEncryptedTime();

		return $html = "<input type=\"hidden\" id=\"$honey_name\" name=\"$honey_name\" value=\"\">\r\n" .
					   "<input type=\"hidden\" name=\"$honey_time\" value=\"$honey_time_encrypted\">";
	}

	public function validateHoneypot($attribute, $value, $parameters)
	{
		return ($value) ? false : true;
	}

	public function validateHoneytime($attribute, $value, $parameters)
	{
		$value = $this->decryptTime($value);

		return ( is_numeric($value) && time() > ($value + $parameters[0]) );
	}

	protected function getEncryptedTime()
	{
		return encrypt(time());
	}

	protected function decryptTime($time)
	{
        return decrypt($time);
	}
}
