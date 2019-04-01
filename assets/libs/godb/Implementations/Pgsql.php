<?php
/**
 * @package go\DB
 */

namespace go\DB\Implementations;

/**
 * The adapter for php_pgsql
 *
 * @author Alex Polev
 */
final class Pgsql extends Base
{
    /**
     * {@inheritdoc}
     */
    public function connect(array $params, &$errorInfo = null, &$errorCode = null)
    {
        if (isset($params['host'])) {
            $host = explode(':', $params['host'], 2);
            if (!empty($host[1])) {
                $params['host'] = $host[0];
                $params['port'] = $host[1];
            }
        }
        $connection = @pg_connect($this->generateConnectString($params), PGSQL_CONNECT_FORCE_NEW);
        if (!$connection) {
            $errorData = error_get_last();
            $errorInfo = !empty($errorData['message'])
                ? $errorData['message']
                : 'Unknown connection error.'
            ;

            return false;
        }
        pg_set_error_verbosity($connection, PGSQL_ERRORS_VERBOSE);
        return $connection;
    }

    /**
     * {@inheritdoc}
     */
    public function close($connection)
    {
        return @pg_close($connection);
    }

    /**
     * {@inheritdoc}
     */
    public function query($connection, $query)
    {
        return @pg_query($connection, $query);
    }

    /**
     * {@inheritdoc}
     */
    public function getInsertId($connection, $cursor = null)
    {
        $result = @pg_query($connection, 'SELECT lastval()');
        if (!$result) {
            return false;
        }
        $row = pg_fetch_row($result);
        return $row[0];
    }

    /**
     * {@inheritdoc}
     */
    public function getAffectedRows($connection, $cursor = null)
    {
        return pg_affected_rows($cursor);
    }

    /**
     * {@inheritdoc}
     */
    public function getErrorInfo($connection, $cursor = null)
    {
        return pg_last_error($connection);
    }

    /**
     * {@inheritdoc}
     */
    public function getErrorCode($connection, $cursor = null)
    {
        $error = pg_last_error($connection);
        if (preg_match("#\A[^:]+\:\s+([0-9A-Z]{5})\:#i", $error, $m)) {
            return $m[1];
        }
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getNumRows($connection, $cursor)
    {
        return pg_numrows($cursor);
    }

    /**
     * {@inheritdoc}
     */
    public function fetchRow($connection, $cursor)
    {
        return pg_fetch_row($cursor);
    }

    /**
     * {@inheritdoc}
     */
    public function fetchAssoc($connection, $cursor)
    {
        return pg_fetch_assoc($cursor);
    }

    /**
     * {@inheritdoc}
     */
    public function fetchObject($connection, $cursor)
    {
        return pg_fetch_object($cursor);
    }

    /**
     * {@inheritdoc}
     */
    public function freeCursor($connection, $cursor)
    {
        return pg_free_result($cursor);
    }

    /**
     * {@inheritdoc}
     */
    public function escapeString($connection, $value)
    {
        return pg_escape_string($connection, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function reprString($connection, $value)
    {
        return '\'' . $this->escapeString($connection, $value) . '\'';
    }

    /**
     * {@inheritdoc}
     */
    public function reprBool($connection, $value)
    {
        return $value ? 'true' : 'false';
    }

    /**
     * {@inheritdoc}
     */
    protected function reprField($connection, $value)
    {
        return '"' . str_replace('"', '""', $value) . '"';
    }

    /**
     * {@inheritdoc}
     */
    public function rewindCursor($connection, $cursor)
    {
        return pg_result_seek($cursor, 0);
    }

    /**
     * {@inheritdoc}
     */
    private function generateConnectString($params)
    {
        $connString = '';
        if ($params) {
            foreach ($params as $key => $value) {
                if (!$value) {
                    continue;
                }
                switch ($key) {
                    case 'username':
                        $connString .= 'user=' . $value;
                        break;
                    case 'charset':
                        $connString .= 'options=\'--client_encoding=' . $value . '\'';
                        break;
                    default:
                        $connString .= $key . '=' . $value;
                        break;
                }
                $connString .= ' ';
            }
        }
        return rtrim($connString);
    }

    /**
     * {@inheritdoc}
     */
    protected $paramsReq = array();

    /**
     * {@inheritdoc}
     */
    protected $paramsDefault = array(
        'username' => null,
        'password' => null,
        'dbname' => null,
        'charset' => null,
        'host' => null,
        'port' => null,
        'hostaddr' => null,
        'connect_timeout' => null,
        'options' => null,
        'sslmode' => null,
        'service' => null,
    );

    /**
     * {@inheritdoc}
     */
    protected $depsPhpExts = 'pgsql';
}
