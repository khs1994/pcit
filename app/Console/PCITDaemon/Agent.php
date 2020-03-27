<?php

declare(strict_types=1);

namespace App\Console\PCITDaemon;

use App\Events\UpdateBuildStatus;
use App\Job;
use PCIT\Framework\Support\Subject;
use PCIT\Log\LogHandler;
use PCIT\Support\CI;

/**
 * TODO.
 *
 * 与数据库交互的操作全部移到 Server 节点，Agent 节点严禁与数据库直接交互
 *
 * Agent run job, need docker.
 * 1. 取出一个 job,包括 job config, build key id
 */
class Agent extends Kernel
{
    private $subject;

    public function __construct()
    {
        $this->subject = new Subject();

        parent::__construct();
    }

    /**
     * @throws \Exception
     */
    public function handle(): void
    {
        \Log::debug('Docker connect ...');

        try {
            $this->pcit->docker->system->ping(1);
        } catch (\Throwable $e) {
            // content docker error
            \Log::debug($e->getMessage());

            return;
        }

        \Log::debug('Docker container start ...');

        // 取出一个 job,包括 job config, build key id
        $job_data = $this->getJob();

        if (!$job_data) {
            return;
        }

        ['id' => $job_id, 'build_id' => $build_key_id] = $job_data;

        \Log::emergency('====== Run job '.$job_id.' ======', ['job_id' => $job_id]);

        $this->subject
            // TODO update build status in progress
            ->register(new UpdateBuildStatus(
                (int) $job_id, (int) $build_key_id, CI::GITHUB_CHECK_SUITE_STATUS_IN_PROGRESS))
            ->handle();

        try {
            $this->pcit->runner_agent_docker->handle((int) $job_id);
        } catch (\Throwable $e) {
            \Log::emergency('Handle job success '.$job_id, [
                'job_id' => $job_id,
                'message' => $e->getMessage(),
                'error' => $e->__toString(),
                ]);

            $this->updateJobFinishedAt((int) $job_id);

            try {
                // TODO
                $this->subject
                    ->register(new LogHandler((int) $job_id))
                    ->register(new UpdateBuildStatus((int) $job_id, (int) $build_key_id, $e->getMessage()))
                    ->handle();
            } catch (\Throwable $e) {
                // catch curl error (timeout,etc)
                \Log::emergency($e->getMessage(), []);
            }
        }
    }

    public function updateJobFinishedAt(int $job_id): void
    {
        Job::updateFinishedAt($job_id, time());
    }

    /**
     * TODO 从服务端获取待执行 job.
     */
    public function getJob()
    {
        return Job::getQueuedJob()[0] ?? null;
    }
}
