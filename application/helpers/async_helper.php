<?php defined('BASEPATH') || exit('No direct script access allowed');
/**
 * Helper for running CodeIgniter CLI commands asynchronousy on the server.
 *
 * @author Cosmin Pascu <csmnpsc@gmail.com>
 */
abstract class Async
{
	/**
	 * Runs a background job of the CI instance with a specific cli route.
	 *
	 * @param  string  $path   The CI route to execute.
	 * @param  mixed   $data   The parameters to pass to the route.
	 * @param  boolean $encode Wether to encode the parameters or not, if array or contains special characters.
	 *
	 * @return boolean         False if did not run command.
	 */
	static public function run($path, $data, $encode = false)
	{
		if (empty($path))
		{
			log_message('error', __METHOD__ . ': Empty CI path.');
			return false;
		}

		if (false === strpos($path, 'cli'))
		{
			log_message('error', __METHOD__ . ': Can only run cli routes.');
			return false;
		}

		if ($encode)
		{
			$data = !empty($data) ? urlencode(json_encode($data)) : '';
		}
		else
		{
			$data = !empty($data) ? $data : '';
		}

		
		$command = 'php ' . dirname(__FILE__) . "/../../index.php {$path}/{$data} > /dev/null 2>/dev/null &";

		log_message('info', __METHOD__ . ": Queue async command: {$path}/{$data}");
		
		// command will run as background job, all output piped to /dev/null
		exec($command);
	}	
}
?>