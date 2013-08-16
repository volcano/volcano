<?php

namespace Fuel\Tasks;

/**
 * Setup task.
 *
 * @author Daniel Sposito <dsposito@static.com>
 */
class Setup
{
	/**
	 * Sets up the application database structure.
	 *
	 * @return void
	 */
	public static function run()
	{
		// Ensure all framework directories exist and are writable.
		\Oil\Refine::run('install');
		
		// Attempt to create and chmod directories.
		\Oil\Refine::run('setup:directories', array());
		
		// Create all the table structure.
		\Oil\Refine::run('migrate', array());
		
		// Create the session table.
		\Oil\Refine::run('session:create', array());
		
		\Cli::write('Migration Complete', 'green');
	}
	
	/**
	 * Sets up permissions for directories.
	 *
	 * @return void
	 */
	public static function directories()
	{
		$paths = array(
			rtrim(\Casset::$cache_path, '/'),
		);
		
		foreach ($paths as $path) {
			$path = DOCROOT . 'public' . DS . $path;
			
			if (@chmod($path, 0777)) {
				\Cli::write('Made writable: ' . $path, 'green');
			} else {
				\Cli::write('Failed to make writable: ' .  $path, 'red');
			}
		}
	}
	
	/**
	 * Flushes cached assets in the public directory.
	 *
	 * @return void
	 */
	public static function flush()
	{
		// Remove all the caches for js/css in casset cache folder.
		$types = array('js', 'css');
		
		foreach ($types as $type) {
			$files = glob(DOCROOT . 'public' . DS . \Casset::$cache_path . '*.' . $type);
			
			foreach ($files as $file) {
				unlink($file);
			}
		}
		
		\Cli::write('Flushed: cache', 'green');
		
		// Remove all the app's caches in cache folder.
		\Cache::delete_all(null, 'file');
	}
	
	/**
	 * Resets the application database structure and content.
	 *
	 * @return void
	 */
	public static function reset()
	{
		// Revert to app default (sans migrations).
		\Migrate::version(0);
		
		\Cli::write('Database Reset', 'green');
		
		$migration_config = APPPATH . DS . 'config' . DS . 'development' . DS . 'migrations.php';
		if (file_exists($migration_config)) {
			\File::delete($migration_config);
			\Cli::write('Migration Config Removed', 'green');
		}
		
		// Migrate all.
		\Migrate::latest();
		
		\Cli::write('Migration Complete', 'green');
	}
}
