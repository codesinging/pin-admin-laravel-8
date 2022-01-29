<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace CodeSinging\PinAdmin\Console\Commands;

use CodeSinging\PinAdmin\Console\Command;
use CodeSinging\PinAdmin\Kernel\Admin;
use CodeSinging\PinAdmin\Kernel\PinAdmin;

class ApplicationsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = PinAdmin::LABEL . ':applications';

    /**
     * The console command description.
     *
     * @var string|null
     */
    protected $description = 'List all PinAdmin applications';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->listApplications();
    }

    /**
     * List all applications.
     */
    private function listApplications(): void
    {
        $this->title('All the PinAdmin applications');
        $indexes = Admin::indexes();
        $data = [];
        foreach ($indexes as $application) {
            $data[] = [
                count($data) + 1,
                $application['name'],
                $application['prefix'],
                $application['status'] ? 'true' : 'false'
            ];
        }
        $this->table(['Index', 'Name', 'Prefix', 'Status'], $data);
    }
}