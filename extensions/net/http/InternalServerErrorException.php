<?php

namespace cms_core\extensions\net\http;

class InternalServerErrorException extends \RuntimeException {

	protected $code = 500;
}

?>