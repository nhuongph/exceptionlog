<?php

namespace NhuongPH\ExceptionLog\Repository;

interface ExceptionLogRepositoryInterface
{

    /**
     * Insert exception log
     *
     * @param array $data Data
     *
     * @return Colection
     */
    public function insertLog(array $data);
}
