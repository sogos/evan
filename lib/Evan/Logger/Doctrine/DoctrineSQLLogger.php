<?php

namespace Evan\Logger\Doctrine;

use Doctrine\DBAL\Logging\SQLLogger;
use Evan\Container\ContainerAccess;


class DoctrineSQLLogger extends ContainerAccess implements SQLLogger
{	


	 /**
     * Logs a SQL statement somewhere.
     *
     * @param string $sql The SQL to be executed.
     * @param array $params The SQL parameters.
     * @param array $types The SQL parameter types.
     * @return void
     */
    public function startQuery($sql, array $params = null, array $types = null) {
        $this->get('queries_collector')->storeNewQuery($sql, $params, $types);
    }

    /**
     * Mark the last started query as stopped. This can be used for timing of queries.
     *
     * @return void
     */
    public function stopQuery() {
    	$this->get('queries_collector')->storeEndofQuery();
    }
}