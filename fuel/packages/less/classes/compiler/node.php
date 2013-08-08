<?php
/**
 * FuelPHP LessCSS package implementation.
 *
 * @author     Kriansa
 * @version    2.0
 * @package    Fuel
 * @subpackage Less
 */
namespace Less;

class Compiler_Node
{
	/**
	 * Store the current escaped path to node bin
	 * @var string
	 */
	protected static $_node_bin = null;

	/**
	 * Store the current escaped path to node compiler script
	 * @var string
	 */
	protected static $_node_script = null;

	/**
	 * Init the class
	 */
	public static function _init()
	{
		$node_bin = array(
			'Windows NT' => PKGPATH.'less'.DS.'vendor'.DS.'node'.DS.'win32'.DS.'node.exe',
			'Linux' => PKGPATH.'less'.DS.'vendor'.DS.'node'.DS.'linux'.DS.'node',
			'Darwin' => PKGPATH.'less'.DS.'vendor'.DS.'node'.DS.'mac'.DS.'node',
		);

		static::$_node_bin = escapeshellarg($node_bin[php_uname('s')]);
		static::$_node_script = escapeshellarg(PKGPATH.'less'.DS.'vendor'.DS.'node'.DS.'compiler.js');
	}

	/**
	 * Compile the Less file in $origin to the CSS $destination file
	 *
	 * @param string $origin Input Less path
	 * @param string $destination Output CSS path
	 * @throws \ErrorException
	 * @throws \Exception
	 */
	public static function compile($origin, $destination)
	{
		$descriptorspec = array(
			0 => array("pipe", "r"), 	// stdin is a pipe that the child will read from
			1 => array("pipe", "w"),	// stdout is a pipe that the child will write to
			2 => array("pipe", "w"),	// stderr is a pipe that the child will write to
		);

		$command = static::$_node_bin . ' ' . static::$_node_script . ' ' . escapeshellarg($origin) . ' ' . escapeshellarg($destination);
		$process = proc_open($command, $descriptorspec, $pipes, getcwd(), null, array('bypass_shell' => true));

		if (is_resource($process))
		{
			// $pipes now looks like this:
			// 0 => writeable handle connected to child stdin
			// 1 => readable handle connected to child stdout
			// 2 => readable handle connected to child stderr

			fclose($pipes[0]);

			$raw_css = stream_get_contents($pipes[1]);
			fclose($pipes[1]);

			$errors = stream_get_contents($pipes[2]);
			fclose($pipes[2]);

			proc_close($process);

			if ($errors)
			{
				$json = json_decode(trim($errors));
				if (isset($json->message, $json->filename, $json->line))
				{
					throw new \ErrorException($json->message, 0, E_ERROR, $json->filename, $json->line);
				}
				else
				{
					throw new \Exception('Error while trying to compile with nodejs: ' . $errors);
				}
			}

			$destination = pathinfo($destination);
			\File::update($destination['dirname'], $destination['basename'], $raw_css);

		}
		else
		{
			throw new \Exception('Could not open nodejs instance!');
		}
	}
}