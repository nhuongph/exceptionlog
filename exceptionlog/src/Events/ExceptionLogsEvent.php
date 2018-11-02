<?php

namespace NhuongPH\ExceptionLog\Events;

use NhuongPH\ExceptionLog\Models\ExceptionLog;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class ExceptionLogsEvent
{
    use SerializesModels;
    /**
     * Exception log data
     */
    public $data;

    /**
     * Exception log data
     */
    public $exclusionData = [
        'password',
        'manager_password',
        'manager_password_confirmation',
        'bank_account_number',
        'bank_account_holder_kana',
        'current_password',
        'password_confirmation',
        'employee_password',
        'employee_password_confirmation',
        'token',
        '_token',
    ];

    /**
     * Constructor.
     *
     * @param mixed $ex Exception
     *
     * @return void
     */
    public function __construct($ex)
    {
        $data['request'] = $this->getResquestData();
        $data['message'] = $ex->getMessage();
        $data['context'] = $this->getExceptionContex($ex);
        $this->data = array_merge($data, $this->getUserData());
    }

    /**
     * Get the user data.
     *
     * @return array
     */
    private function getUserData()
    {
        $data = [];
        if (!empty(Auth::user())) {
            $user = Auth::user();
            $data['user_type'] = ExceptionLog::USER_TYPE_GARAKE;
            $data['user_code'] = $user->code;
            $user->load('company');
            $data['company_code'] = $user->company->code;
        }
        return $data;
    }

    /**
     * Get the exception context.
     *
     * @param mixed $ex Exception
     *
     * @return array
     */
    private function getExceptionContex($ex)
    {
        $context = [
            "line" => $ex->getLine(),
            "file" => $ex->getFile(),
            "class" => get_class($ex),
            "trace" => $ex->getTraceAsString()
        ];
        return json_encode($context);
    }

    /**
     * Get the request data.
     *
     * @return array
     */
    private function getResquestData()
    {
        $request = request();

        $requestData = array();
        $requestData['url'] = $request->getUri();
        $requestData['httpMethod'] = $request->getMethod();
        $requestData['params'] = $request->all();
        foreach ($this->exclusionData as $val) {
            if (isset($requestData['params'][$val])) {
                $requestData['params'][$val] = '**********';
            }
        }
        $requestData['clientIp'] = $request->ip();
        $requestData['userAgent'] = $request->header('user-agent');
        $requestData['headers'] = $this->getRequestHeaders();

        return json_encode($requestData);
    }

    /**
     * Get the request headers.
     *
     * @return array
     */
    private function getRequestHeaders()
    {
        $headers = array();

        foreach ($_SERVER as $name => $value) {
            if (substr($name, 0, 5) == 'HTTP_'
                && $name != 'HTTP_AUTHORIZATION'
                && $name != 'HTTP_COOKIE'
                && $name != 'HTTP_X_CSRF_TOKEN') {
                $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
            }
        }

        return $headers;
    }
}
