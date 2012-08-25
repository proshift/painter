<?php
class DB {
	private $host = 'localhost';
    private $username = 'root';
	private $password = '';
	private $dbname = 'content_manager';
	private $dbhandle;
	private $lastresource;

	/* Constructor overloader in case connection 
	 * settings are need to be taken from user.
	 */
	public function __construct($host, $username, $password, $dbname) {
		$this->host = $host;
		$this->username = $username;
		$this->password = $password;
		$this->dbname = $dbname;
		$this->dbhandle = mysql_connect($this->host, $this->username, $this->password);
		if( !$this->dbhandle || !mysql_select_db($this->dbname) ) {
			die();
		}
	}
	/* Destructor and database session closer
	 * Destroys the object and closes the database
	 * handler.
	 */
	public function __destruct() {
		mysql_close($this->dbhandle);
	}
	/* Query sender
	 * Receives a sql string and sends as a query.
	 * Returns resource in success, false otherwise.
	 */
	public function query($sql) {
		$this->lastresource = mysql_query($sql);
		$result = array();
		if( $this->lastresource !== FALSE) {
			while( $row = mysql_fetch_assoc($this->lastresource)) {
				$result[] = $row;
			}
		}
		return $result;
	}
	/* Insert sender
	 * gets an array and inserts
	 */
	public function insert($tablename, $arr) {
		$sql = 'INSERT INTO '.$tablename.' (';
		$cols = '';
		$vals = '';
		foreach ($arr as $key => $value) {
			$cols .= $key.',';
			$vals .= $value.',';
		}
		$sql .= $cols.') VALUES ('.$vals.');';
		$sql = $this->secure($sql);
		$this->lastresource = mysql_query($sql);
		if( $this->lastresource ) {
			return $this->lastresource;
		} else {
			return false;
		}
	}
	/* Row getter
	 * Gets a resource if provided or uses "lastresource"
	 * and returns the next row.
	 */
	public function getRow($resource = null) {
		if( is_null($resource) ) $resource = $this->lastresource;
		
		if( $row = mysql_fetch_assoc($resource) ) {
			return $row;
		} else {
			return false;
		}
	}
	/* Last resource getter
	 * Returns last query resource.
	 */
	public function getLastResource() {
		return $this->lastresource;
	}
	/* Security
	 * Secures given string to injections.
	 */
	public function secure($input) {
		return strip_tags(mysql_real_escape_string($input));
	}
	/* Error getter
	 * Returns last given error.
	 */
	public function getLastError() {
		return mysql_error();
	}
	/* Size
	 * Takes resource if provided, uses "lastresource" 
	 * otherwise and returns how many records it has.
	 */
	public function size($resource = false) {
		if( $resource == false ) $resource = $this->lastresource;
		
		return mysql_num_rows($resource);
	}
	/* Paging handler
	 * Takes number of records desired in a page, index of the
	 * page wanted, and a resource if provided. Returns records in
	 * the page in an array.
	 */
	public function getPage($pagesize, $pagenum, $resource = false) {
		if( $resource == false ) $resource = $this->lastresource;
		
		mysql_data_seek($resource, ($pagenum-1)*$pagesize);
		for($i = 0; $i < $pagesize && $row = $this->getRow($resource); $i++) {
			$res[$i] = $row;
		}
		return $res;
	}
}
?>