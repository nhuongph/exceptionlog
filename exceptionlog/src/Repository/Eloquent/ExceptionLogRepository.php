<?php

namespace NhuongPH\ExceptionLog\Repository\Eloquent;

use NhuongPH\ExceptionLog\Models\ExceptionLog;
use NhuongPH\ExceptionLog\Repository\ExceptionLogRepositoryInterface;
use BaoPham\DynamoDb\DynamoDbClientInterface;
use Ramsey\Uuid\Uuid;

class ExceptionLogRepository implements ExceptionLogRepositoryInterface
{

    /**
     * DynamoDb client service
     *
     * @var \BaoPham\DynamoDb\DynamoDbClientService
     */
    protected $dynamoDb;

    /**
     * Exception log model
     *
     * @var \App\Models\ExceptionLog
     */
    protected $exceptionLog;

    /**
     * Constructor.
     *
     * @return void
     */
    public function __construct()
    {
        $this->bindDynamoDbClientInstance();
    }

    /**
     * Bind dynamodb client instance.
     *
     * @return void
     */
    protected function bindDynamoDbClientInstance()
    {
        $this->dynamoDb = app()->make(DynamoDbClientInterface::class);
        $this->exceptionLog = new ExceptionLog([]);
    }

    /**
     * Insert exception log
     *
     * @param array $data Data
     *
     * @return void
     */
    public function insertLog(array $data)
    {
        $this->exceptionLog->type = ExceptionLog::TYPE_GARAKE;
        $this->exceptionLog->id = Uuid::uuid4()->toString();
        $this->exceptionLog->level = ExceptionLog::LEVEL_ERROR;
        $this->exceptionLog = $this->fillData($data);
        $this->exceptionLog->save();
    }
    
    /**
     * Insert exception log
     *
     * @param array $data Data
     *
     * @return \App\Models\ExceptionLog
     */
    private function fillData(array $data)
    {
        foreach ($data as $key => $value) {
            $this->exceptionLog->$key = $value;
        }
        return $this->exceptionLog;
    }
}
