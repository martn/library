<?php

/**
 * This file is part of the Nette Framework.
 *
 * Copyright (c) 2004, 2010 David Grudl (http://davidgrudl.com)
 *
 * This source file is subject to the "Nette license", and/or
 * GPL license. For more information please see http://nette.org
 * @package Nette\Caching
 */



/**
 * NCache file storage.
 *
 * @author     David Grudl
 */
class NFileStorage extends NObject implements ICacheStorage
{
	/**
	 * Atomic thread safe logic:
	 *
	 * 1) reading: open(r+b), lock(SH), read
	 *     - delete?: delete*, close
	 * 2) deleting: delete*
	 * 3) writing: open(r+b || wb), lock(EX), truncate*, write data, write meta, close
	 *
	 * delete* = try unlink, if fails (on NTFS) { lock(EX), truncate, close, unlink } else close (on ext3)
	 */

	/**#@+ @internal cache file structure */
	const META_HEADER_LEN = 28; // 22b signature + 6b meta-struct size + serialized meta-struct + data
	// meta structure: array of
	const META_TIME = 'time'; // timestamp
	const META_SERIALIZED = 'serialized'; // is content serialized?
	const META_EXPIRE = 'expire'; // expiration timestamp
	const META_DELTA = 'delta'; // relative (sliding) expiration
	const META_ITEMS = 'di'; // array of dependent items (file => timestamp)
	const META_CALLBACKS = 'callbacks'; // array of callbacks (function, args)
	/**#@-*/

	/**#@+ additional cache structure */
	const FILE = 'file';
	const HANDLE = 'handle';
	/**#@-*/


	/** @var float  probability that the clean() routine is started */
	public static $gcProbability = 0.001;

	/** @var bool */
	public static $useDirectories;

	/** @var string */
	private $dir;

	/** @var bool */
	private $useDirs;

	/** @var resource */
	private $db;



	public function __construct($dir)
	{
		if (self::$useDirectories === NULL) {
			// checks whether directory is writable
			$uniq = uniqid('_', TRUE);
			umask(0000);
			if (!@mkdir("$dir/$uniq", 0777)) { // @ - is escalated to exception
				throw new InvalidStateException("Unable to write to directory '$dir'. Make this directory writable.");
			}

			// tests subdirectory mode
			self::$useDirectories = !ini_get('safe_mode');
			if (!self::$useDirectories && @file_put_contents("$dir/$uniq/_", '') !== FALSE) { // @ - error is expected
				self::$useDirectories = TRUE;
				unlink("$dir/$uniq/_");
			}
			@rmdir("$dir/$uniq"); // @ - directory may not already exist
		}

		$this->dir = $dir;
		$this->useDirs = (bool) self::$useDirectories;

		if (mt_rand() / mt_getrandmax() < self::$gcProbability) {
			$this->clean(array());
		}
	}



	/**
	 * Read from cache.
	 * @param  string key
	 * @return mixed|NULL
	 */
	public function read($key)
	{
		$meta = $this->readMeta($this->getCacheFile($key), LOCK_SH);
		if ($meta && $this->verify($meta)) {
			return $this->readData($meta); // calls fclose()

		} else {
			return NULL;
		}
	}



	/**
	 * Verifies dependencies.
	 * @param  array
	 * @return bool
	 */
	private function verify($meta)
	{
		do {
			if (!empty($meta[self::META_DELTA])) {
				// meta[file] was added by readMeta()
				if (filemtime($meta[self::FILE]) + $meta[self::META_DELTA] < time()) break;
				touch($meta[self::FILE]);

			} elseif (!empty($meta[self::META_EXPIRE]) && $meta[self::META_EXPIRE] < time()) {
				break;
			}

			if (!empty($meta[self::META_CALLBACKS]) && !NCache::checkCallbacks($meta[self::META_CALLBACKS])) {
				break;
			}

			if (!empty($meta[self::META_ITEMS])) {
				foreach ($meta[self::META_ITEMS] as $depFile => $time) {
					$m = $this->readMeta($depFile, LOCK_SH);
					if ($m[self::META_TIME] !== $time) break 2;
					if ($m && !$this->verify($m)) break 2;
				}
			}

			return TRUE;
		} while (FALSE);

		$this->delete($meta[self::FILE], $meta[self::HANDLE]); // meta[handle] & meta[file] was added by readMeta()
		return FALSE;
	}



	/**
	 * Writes item into the cache.
	 * @param  string key
	 * @param  mixed  data
	 * @param  array  dependencies
	 * @return void
	 */
	public function write($key, $data, array $dp)
	{
		$meta = array(
			self::META_TIME => microtime(),
		);

		if (isset($dp[NCache::EXPIRATION])) {
			if (empty($dp[NCache::SLIDING])) {
				$meta[self::META_EXPIRE] = $dp[NCache::EXPIRATION] + time(); // absolute time
			} else {
				$meta[self::META_DELTA] = (int) $dp[NCache::EXPIRATION]; // sliding time
			}
		}

		if (isset($dp[NCache::ITEMS])) {
			foreach ((array) $dp[NCache::ITEMS] as $item) {
				$depFile = $this->getCacheFile($item);
				$m = $this->readMeta($depFile, LOCK_SH);
				$meta[self::META_ITEMS][$depFile] = $m[self::META_TIME];
				unset($m);
			}
		}

		if (isset($dp[NCache::CALLBACKS])) {
			$meta[self::META_CALLBACKS] = $dp[NCache::CALLBACKS];
		}

		$cacheFile = $this->getCacheFile($key);
		if ($this->useDirs && !is_dir($dir = dirname($cacheFile))) {
			umask(0000);
			if (!mkdir($dir, 0777)) {
				return;
			}
		}
		$handle = @fopen($cacheFile, 'r+b'); // @ - file may not exist
		if (!$handle) {
			$handle = fopen($cacheFile, 'wb');
			if (!$handle) {
				return;
			}
		}

		if (isset($dp[NCache::TAGS]) || isset($dp[NCache::PRIORITY])) {
			$db = $this->getDb();
			$dbFile = sqlite_escape_string($cacheFile);
			$query = '';
			if (!empty($dp[NCache::TAGS])) {
				foreach ((array) $dp[NCache::TAGS] as $tag) {
					$query .= "INSERT INTO cache (file, tag) VALUES ('$dbFile', '" . sqlite_escape_string($tag) . "');";
				}
			}
			if (isset($dp[NCache::PRIORITY])) {
				$query .= "INSERT INTO cache (file, priority) VALUES ('$dbFile', '" . (int) $dp[NCache::PRIORITY] . "');";
			}
			if (!sqlite_exec($db, "BEGIN; DELETE FROM cache WHERE file = '$dbFile'; $query COMMIT;")) {
				sqlite_exec($db, "ROLLBACK");
				return;
			}
		}

		flock($handle, LOCK_EX);
		ftruncate($handle, 0);

		if (!is_string($data)) {
			$data = serialize($data);
			$meta[self::META_SERIALIZED] = TRUE;
		}

		$head = serialize($meta) . '?>';
		$head = '<?php //netteCache[01]' . str_pad((string) strlen($head), 6, '0', STR_PAD_LEFT) . $head;
		$headLen = strlen($head);
		$dataLen = strlen($data);

		do {
			if (fwrite($handle, str_repeat("\x00", $headLen), $headLen) !== $headLen) {
				break;
			}

			if (fwrite($handle, $data, $dataLen) !== $dataLen) {
				break;
			}

			fseek($handle, 0);
			if (fwrite($handle, $head, $headLen) !== $headLen) {
				break;
			}

			flock($handle, LOCK_UN);
			fclose($handle);
			return TRUE;
		} while (FALSE);

		$this->delete($cacheFile, $handle);
	}



	/**
	 * Removes item from the cache.
	 * @param  string key
	 * @return void
	 */
	public function remove($key)
	{
		$this->delete($this->getCacheFile($key));
	}



	/**
	 * Removes items from the cache by conditions & garbage collector.
	 * @param  array  conditions
	 * @return void
	 */
	public function clean(array $conds)
	{
		$all = !empty($conds[NCache::ALL]);
		$collector = empty($conds);

		// cleaning using file iterator
		if ($all || $collector) {
			$now = time();
			$base = $this->dir . DIRECTORY_SEPARATOR . 'c';
			$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($this->dir), RecursiveIteratorIterator::CHILD_FIRST);
			foreach ($iterator as $entry) {
				$path = (string) $entry;
				if (strncmp($path, $base, strlen($base))) { // skip files out of cache
					continue;
				}
				if ($entry->isDir()) { // collector: remove empty dirs
					@rmdir($path); // @ - removing dirs is not necessary
					continue;
				}
				if ($all) {
					$this->delete($path);

				} else { // collector
					$meta = $this->readMeta($path, LOCK_SH);
					if (!$meta) continue;

					if (!empty($meta[self::META_EXPIRE]) && $meta[self::META_EXPIRE] < $now) {
						$this->delete($path, $meta[self::HANDLE]);
						continue;
					}

					flock($meta[self::HANDLE], LOCK_UN);
					fclose($meta[self::HANDLE]);
				}
			}

			if ($all && extension_loaded('sqlite')) {
				sqlite_exec("DELETE FROM cache", $this->getDb());
			}
			return;
		}

		// cleaning using journal
		if (!empty($conds[NCache::TAGS])) {
			$db = $this->getDb();
			foreach ((array) $conds[NCache::TAGS] as $tag) {
				$tmp[] = "'" . sqlite_escape_string($tag) . "'";
			}
			$query[] = "tag IN (" . implode(',', $tmp) . ")";
		}

		if (isset($conds[NCache::PRIORITY])) {
			$query[] = "priority <= " . (int) $conds[NCache::PRIORITY];
		}

		if (isset($query)) {
			$db = $this->getDb();
			$query = implode(' OR ', $query);
			$files = sqlite_single_query("SELECT file FROM cache WHERE $query", $db, FALSE);
			foreach ($files as $file) {
				$this->delete($file);
			}
			sqlite_exec("DELETE FROM cache WHERE $query", $db);
		}
	}



	/**
	 * Reads cache data from disk.
	 * @param  string  file path
	 * @param  int     lock mode
	 * @return array|NULL
	 */
	protected function readMeta($file, $lock)
	{
		$handle = @fopen($file, 'r+b'); // @ - file may not exist
		if (!$handle) return NULL;

		flock($handle, $lock);

		$head = stream_get_contents($handle, self::META_HEADER_LEN);
		if ($head && strlen($head) === self::META_HEADER_LEN) {
			$size = (int) substr($head, -6);
			$meta = stream_get_contents($handle, $size, self::META_HEADER_LEN);
			$meta = @unserialize($meta); // intentionally @
			if (is_array($meta)) {
				fseek($handle, $size + self::META_HEADER_LEN); // needed by PHP < 5.2.6
				$meta[self::FILE] = $file;
				$meta[self::HANDLE] = $handle;
				return $meta;
			}
		}

		flock($handle, LOCK_UN);
		fclose($handle);
		return NULL;
	}



	/**
	 * Reads cache data from disk and closes cache file handle.
	 * @param  array
	 * @return mixed
	 */
	protected function readData($meta)
	{
		$data = stream_get_contents($meta[self::HANDLE]);
		flock($meta[self::HANDLE], LOCK_UN);
		fclose($meta[self::HANDLE]);

		if (empty($meta[self::META_SERIALIZED])) {
			return $data;
		} else {
			return @unserialize($data); // intentionally @
		}
	}



	/**
	 * Returns file name.
	 * @param  string
	 * @return string
	 */
	protected function getCacheFile($key)
	{
		if ($this->useDirs) {
			$key = explode(NCache::NAMESPACE_SEPARATOR, $key, 2);
			return $this->dir . '/c' . (isset($key[1]) ? '-' . urlencode($key[0]) . '/_' . urlencode($key[1]) : '_' . urlencode($key[0]));
		} else {
			return $this->dir . '/c_' . urlencode($key);
		}
	}



	/**
	 * Deletes and closes file.
	 * @param  string
	 * @param  resource
	 * @return void
	 */
	private static function delete($file, $handle = NULL)
	{
		if (@unlink($file)) { // @ - file may not already exist
			if ($handle) {
				flock($handle, LOCK_UN);
				fclose($handle);
			}
			return;
		}

		if (!$handle) {
			$handle = @fopen($file, 'r+'); // @ - file may not exist
		}
		if ($handle) {
			flock($handle, LOCK_EX);
			ftruncate($handle, 0);
			flock($handle, LOCK_UN);
			fclose($handle);
			@unlink($file); // @ - file may not already exist
		}
	}



	/**
	 * Returns SQLite resource.
	 * @return resource
	 */
	protected function getDb()
	{
		if ($this->db === NULL) {
			if (!extension_loaded('sqlite')) {
				throw new InvalidStateException("SQLite extension is required for storing tags and priorities.");
			}
			$this->db = sqlite_open($this->dir . '/cachejournal.sdb');
			@sqlite_exec($this->db, 'CREATE TABLE cache (file VARCHAR NOT NULL, priority, tag VARCHAR);
			CREATE INDEX IDX_FILE ON cache (file); CREATE INDEX IDX_PRI ON cache (priority); CREATE INDEX IDX_TAG ON cache (tag);'); // @ - table may already exist
		}
		return $this->db;
	}

}
