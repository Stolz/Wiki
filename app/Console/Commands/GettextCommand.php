<?php namespace App\Console\Commands;

use File;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\View\Compilers\BladeCompiler;

class GettextCommand extends Command
{
	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'gettext';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Compiles Blade templates into PHP for GNU gettext to be able to parse them';

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire()
	{
		// Set directories
		$inputPath = base_path('resources/views');
		$outputPath = storage_path('gettext');

		// Create $outputPath or empty it if already exists
		if (File::isDirectory($outputPath))
			File::cleanDirectory($outputPath);
		else
			File::makeDirectory($outputPath);

		// Configure BladeCompiler to use our own custom storage subfolder
		$compiler = new BladeCompiler(new Filesystem, $outputPath);
		$compiled = 0;

		// Get all view files
		$allFiles = File::allFiles($inputPath);
		foreach ($allFiles as $f)
		{
			// Skip not blade templates
			$file = $f->getPathName();
			if ('.blade.php' !== substr($file, -10))
				continue;

			// Compile the view
			$compiler->compile($file);
			$compiled++;

			// Rename to human friendly
			$human = str_replace(DIRECTORY_SEPARATOR, '-', ltrim($f->getRelativePathname(), DIRECTORY_SEPARATOR));
			File::move($outputPath . DIRECTORY_SEPARATOR . md5($file), $outputPath . DIRECTORY_SEPARATOR . $human . '.php');
		}

		if ($compiled)
			$this->info("$compiled files compiled.");
		else
			$this->error('No .blade.php files found in '.$inputPath);
	}
}
