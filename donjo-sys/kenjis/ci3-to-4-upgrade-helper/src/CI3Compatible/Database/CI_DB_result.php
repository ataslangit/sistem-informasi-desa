<?php

declare(strict_types=1);

/*
 * Copyright (c) 2021 Kenji Suzuki
 *
 * For the full copyright and license information, please view
 * the LICENSE.md file that was distributed with this source code.
 *
 * @see https://github.com/kenjis/ci3-to-4-upgrade-helper
 */

namespace Kenjis\CI3Compatible\Database;

use CodeIgniter\Database\ResultInterface;

class CI_DB_result
{
    /** @var ResultInterface */
    private $result;

    public function __construct(ResultInterface $result)
    {
        $this->result = $result;
    }

    /**
     * Query result. Acts as a wrapper function for the following functions.
     *
     * @param   string $type 'object', 'array' or a custom class name
     *
     * @return  array
     */
    public function result(string $type = 'object'): array
    {
        return $this->result->getResult($type);
    }

    /**
     * Query result. "array" version.
     *
     * @return    array
     */
    public function result_array(): array
    {
        return $this->result->getResultArray();
    }

    /**
     * Returns a single result row - array version
     *
     * @return    array|null
     */
    public function row_array(int $n = 0)
    {
        return $this->result->getRowArray($n);
    }

    /**
     * Row
     *
     * A wrapper method.
     *
     * @param   mixed  $n
     * @param   string $type 'object' or 'array'
     *
     * @return  mixed
     */
    public function row($n = 0, string $type = 'object')
    {
        return $this->result->getRow($n, $type);
    }

    /**
     * Number of rows in the result set
     *
     * @return  int
     */
    public function num_rows(): int
    {
        return $this->result->getNumRows();
    }
}
