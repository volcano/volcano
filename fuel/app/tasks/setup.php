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
		// Migrate all.
		\Migrate::latest();
		
		\Cli::write('Migration Complete', 'green');
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
