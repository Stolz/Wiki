<?php namespace App\Console\Commands;

use File;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;

class DatabaseBackupCommand extends Command
{
	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'db:backup';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Backup and restore database.';

	/**
	 * Execute the console command.
	 *
	 * @return void
	 */
	public function fire()
	{
		// Create destination dir if it does not exist
		$this->destination = base_path('database/backups');
		if( ! File::exists($this->destination))
			File::makeDirectory($this->destination);

		// Show list
		if($this->option('list'))
			return $this->showListOfBackups();

		// Get database connection to use
		if( ! $this->getConnection($this->option('connection')))
			return;

		// Either restore ...
		if($this->option('restore'))
			return ($this->restore($this->option('restore'), $this->option('force'))) ? $this->info('OK') : $this->error('Unable to restore');

		// ... or backup
		return ($this->backup()) ? $this->info('OK') : $this->error('Unable to backup');
	}

	/**
	 * Show a list of exisisting backups.
	 *
	 * @return void
	 */
	protected function showListOfBackups()
	{
		if( ! $files = File::files($this->destination))
			return $this->error('No backup files found');

		foreach($files as $key => $file)
		{
			$date = Carbon::createFromTimeStamp(File::lastModified($file));

			$files[$key] = [
				basename($file),
				$date->toDateTimeString(),
				$date->diffForHumans(),
				$this->bytesToHuman(File::size($file)),
			];
		}

		$this->table(['File', 'Date', 'Age', 'Size'], $files);
	}

	/**
	 * Get the database connection.
	 *
	 * @param  string $name
	 * @return array|string
	 */
	protected function getConnection($name)
	{
		// Make sure connection exists
		if( ! $connection = config("database.connections.$name"))
		{
			$this->error("Unknown connection '$name'");

			return false;
		}

		// Make sure the connection is MySQL
		if($connection['driver'] !== 'mysql')
		{
			$this->error("Unsupported connection type '{$connection['driver']}'. Only 'mysql' connections are supported");

			return false;
		}

		$this->connection = $connection;

		return true;
	}

	/**
	 * Create a backup.
	 *
	 * @return bool
	 */
	protected function backup()
	{
		$date = Carbon::now()->toDateTimeString();
		$file = $this->destination . DIRECTORY_SEPARATOR . $date . ' ' . $this->connection['database'] . '.sql';

		// Build backup command
		$command = sprintf(
			'mysqldump --host=%s --user=%s --password=%s %s > %s',
			escapeshellarg($this->connection['host']),
			escapeshellarg($this->connection['username']),
			escapeshellarg($this->connection['password']),
			escapeshellarg($this->connection['database']),
			escapeshellarg(str_replace([' ', ':'], ['_', '.'], $file))
		);

		// Exec backup command
		exec($command, $output, $returnValue);

		return ($returnValue === 0);
	}

	/**
	 * Restore a backup.
	 *
	 * @param  string $file  File to restore
	 * @param  bool   $force Do not prompt for confirmation
	 * @return bool
	 */
	protected function restore($file, $force = false)
	{
		// Check if file exist
		$file = $this->destination . DIRECTORY_SEPARATOR . $file;
		if( ! File::exists($file))
		{
			$this->error("File not found '$file'");

			return false;
		}

		// Promt for confirmation
		if( ! $force and ! $this->confirm('This could delete existing data. Do you wish to continue?', false))
		{
			$this->comment('Cancelled by user');

			return false;
		}

		// Build restore command
		$command = sprintf(
			'mysql --host=%s --user=%s --password=%s %s < %s',
			escapeshellarg($this->connection['host']),
			escapeshellarg($this->connection['username']),
			escapeshellarg($this->connection['password']),
			escapeshellarg($this->connection['database']),
			escapeshellarg($file)
		);

		// Exec restore command
		exec($command, $output, $returnValue);

		return ($returnValue === 0);
	}

	/**
	 * Convert bytes to human friendly unit.
	 *
	 * @param  integer $bytes
	 * @param  integer $decimals
	 * @return string
	 */
	protected function bytesToHuman($bytes, $decimals = 2)
	{
		$size   = array('B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
		$factor = floor((strlen($bytes) - 1) / 3);

		return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [
			['list', 'l', InputOption::VALUE_NONE, 'List saved backups'],
			['restore', 'r', InputOption::VALUE_REQUIRED, 'Restore a backup'],
			['force', 'f', InputOption::VALUE_NONE, 'Do not prompt for confimation when restoring a backup'],
			['connection', 'c', InputOption::VALUE_REQUIRED, 'Database connection name', config('database.default')],
		];
	}
}
