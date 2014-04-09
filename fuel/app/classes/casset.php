<?php

/**
 * Casset class.
 */
class Casset extends \Less\Casset
{
	public static function less($sheet, $sheet_min = false, $group = 'global')
	{
		$sheet = (array) $sheet;
		
		\Less::compile($sheet);
		
		foreach ($sheet as $sheet_file) {
			if (!\Config::get('less.keep_dir', true)) {
				$sheet_hash = md5($sheet_file);
				$sheet_file = 'cache/' . pathinfo($sheet_file, PATHINFO_FILENAME);
				
				if (\Config::get('less.hash_filename', true)) {
					$sheet_file .= '-'.$sheet_hash;
				}
				
				$sheet_file .= '.css';
			}
			
			static::css($sheet_file, $sheet_min, $group);
		}
	}
	
	protected static function combine($type, $file_group, $minify, $inline)
	{
		// Get the last modified time of all of the component files
		$last_mod = 0;
		foreach ($file_group as $file)
		{
			// If it's a remote file just assume it isn't modified, otherwise
			// we're stuck making a ton of HTTP requests
			if (strpos($file['file'], '//') !== false)
				continue;
			
			$mod = filemtime(DOCROOT.$file['file']);
			if ($mod > $last_mod)
				$last_mod = $mod;
		}
		
		$filename = md5(implode('', array_map(function($a) {
			return $a['file'];
		}, $file_group)).($minify ? 'min' : '').$last_mod).'.'.$type;
		
		$filepath = DOCROOT.static::$cache_path.'/'.$filename;
		$needs_update = (!file_exists($filepath));
		
		if ($needs_update)
		{
			$content = '';
			foreach ($file_group as $file)
			{
				if (static::$show_files_inline)
					$content .= PHP_EOL.'/* '.$file['file'].' */'.PHP_EOL.PHP_EOL;
				if ($file['minified'] || !$minify)
					$content .= static::load_file($file['file'], $type, $file_group).PHP_EOL;
				else
				{
					$file_content = static::load_file($file['file'], $type, $file_group);
					if ($file_content === false)
						throw new Casset_Exception("Couldn't not open file {$file['file']}");
					if ($type == 'js')
					{
						$content .= Casset_JSMin::minify($file_content).PHP_EOL;
					}
					elseif ($type == 'css')
					{
						$content .= Casset_Csscompressor::process($file_content).PHP_EOL;
					}
				}
			}
			\File::update(DOCROOT.static::$cache_path, $filename, $content);
			$mtime = time();
		}
		
		return $filename;
	}
}
