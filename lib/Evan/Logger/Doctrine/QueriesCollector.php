<?php 

namespace Evan\Logger\Doctrine;



class QueriesCollector {
	
	protected $queries;
	protected $cursor = 0;

	public function getQueries()
	{
		return $this->queries;
	}

	public function storeNewQuery($sql, array $params = null, array $types = null) {
		$this->queries[$this->cursor] = array(
			'sql' => $sql,
			'params' => $params,
			'types' => $types,
			'start' => microtime()
			);
	}

	public function storeEndofQuery()
	{
		$this->queries[$this->cursor]['end'] = microtime();
		$this->queries[$this->cursor]['time'] = $this->queries[$this->cursor]['end'] - $this->queries[$this->cursor]['start'];
		$this->cursor++;
	}
}