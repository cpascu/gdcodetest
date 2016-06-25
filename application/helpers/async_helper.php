<?php defined('BASEPATH') || exit('No direct script access allowed');
/**
 * Helper for running CodeIgniter CLI commands asynchronousy on the server.
 *
 * @author Cosmin Pascu <csmnpsc@gmail.com>
 */
abstract class Async
{
	static public function run($path, $data)
	{
		if (empty($path))
		{
			log_message('error', __METHOD__ . ': Empty cli instruction.');
			return false;
		}

		$data    = !empty($data) ? urlencode(json_encode($data)) : '';
		$command = '/Applications/MAMP/bin/php/php5.6.10/bin/php ' . dirname(__FILE__) . "/../../index.php {$path}/{$data} > /dev/null 2>/dev/null &";

		log_message('info', __METHOD__ . ": Queue async command: {$path}/{$data}");
		
		// command will run as background job, all output piped to /dev/null
		exec($command);
	}	
}
?>