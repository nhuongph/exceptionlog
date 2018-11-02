<?php

namespace NhuongPH\ExceptionLog\Models;

use BaoPham\DynamoDb\DynamoDbModel;
use App\Repository\Traits\PrefixTable;

class ExceptionLog extends DynamoDbModel
{
    use PrefixTable;
    
    /**
     * Type exception log admin
     */
    const TYPE_ADMIN = 1;

    /**
     * Type exception log company
     */
    const TYPE_COMPANY = 2;
    
    /**
     * Type exception log employee
     */
    const TYPE_EMPLOYEE = 3;
    
    /**
     * Type exception log garake
     */
    const TYPE_GARAKE = 4;

    /**
     * Default Date format
     * ISO 8601 Compliant
     */
    protected $dateFormat = 'Y-m-d H:i:s';

    /**
     * List exception log type.
     *
     * @var array
     */
    public static $typeExceptionLog = [
        self::TYPE_ADMIN => "Admin",
        self::TYPE_COMPANY => "Company",
        self::TYPE_EMPLOYEE => "Employee",
        self::TYPE_GARAKE => "Garake",
    ];
    
    /**
     * User type exception log enigma admin
     */
    const USER_TYPE_ENIGMA_ADMIN = 1;

    /**
     * User type exception log company admin
     */
    const USER_TYPE_COMPANY_ADMIN = 2;
    
    /**
     * User type exception log manager branch
     */
    const USER_TYPE_MANAGER_BRANCH = 3;
    
    /**
     * User type exception log employee
     */
    const USER_TYPE_EMPLOYEE = 4;
    
    /**
     * User type exception log garake
     */
    const USER_TYPE_GARAKE = 5;

    /**
     * List exception log user type.
     *
     * @var array
     */
    public static $userTypeExceptionLog = [
        self::USER_TYPE_ENIGMA_ADMIN => "Enigma admin",
        self::USER_TYPE_COMPANY_ADMIN => "Company admin",
        self::USER_TYPE_MANAGER_BRANCH => "Manager branch",
        self::USER_TYPE_EMPLOYEE => "Employee",
        self::USER_TYPE_GARAKE => "Employee",
    ];
    
    /**
     * Level exception log error
     */
    const LEVEL_ERROR = 1;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'type',
        'company_code',
        'user_code',
        'created_at',
    ];

    /**
     * Constructor.
     *
     * @param array $attributes Attributes
     *
     * @return void
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->setTable($this->getPrefixTable() . "exception_logs");
    }

    /**
     * The dynamodb index key.
     *
     * @var array
     */
    protected $dynamoDbIndexKeys = [
        'CompanyCodeIndex' => [
            'hash' => 'company_code',
            'range' => 'created_at',
        ],
        'UserCodeIndex' => [
            'hash' => 'user_code',
            'range' => 'created_at',
        ],
    ];
}
