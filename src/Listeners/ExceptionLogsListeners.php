<?php

namespace NhuongPH\ExceptionLog\Listeners;

use NhuongPH\ExceptionLog\Events\ExceptionLogsEvent;
use NhuongPH\ExceptionLog\Repository\ExceptionLogRepositoryInterface;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Log;

class ExceptionLogsListeners implements ShouldQueue
{
    use InteractsWithQueue,
        Queueable,
        SerializesModels;
    /**
     * ExceptionLogRepositoryInterface
     *
     * @var \App\Repository\ExceptionLogRepositoryInterface
     */
    protected $exceptionLog;

    /**
     * Create the event listener.
     *
     * @param ExceptionLogRepositoryInterface $exceptionLog ExceptionLogRepositoryInterface
     *
     * @return void
     */
    public function __construct(ExceptionLogRepositoryInterface $exceptionLog)
    {
        $this->exceptionLog = $exceptionLog;
    }

    /**
     * Handle the event.
     *
     * @param ExceptionLogsEvent $event ExceptionLogsEvent
     *
     * @return void
     */
    public function handle(ExceptionLogsEvent $event)
    {
        try {
            $data = $event->data;
            $this->exceptionLog->insertLog($data);
        } catch (Exception $ex) {
            Log::error($ex->getMessage());
        }
    }
}
