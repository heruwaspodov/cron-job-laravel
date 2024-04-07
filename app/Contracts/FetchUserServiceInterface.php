<?php

namespace App\Contracts;

/**
 *
 */
interface FetchUserServiceInterface
{
    /**
     * @param int $limit
     * @return bool
     */
    public function call(int $limit): bool;
}
