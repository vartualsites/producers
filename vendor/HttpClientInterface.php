<?php

namespace Isystems\Vendor;

/**
 * This interface ensure exists functions for children classes
 *
 * Interface HttpClientInterface
 * @package Isystems\Vendor
 */
interface HttpClientInterface {

	public function init();
	
	public function exec();
	
	public function close();
}
