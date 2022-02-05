<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace CodeSinging\PinAdmin\Console\Commands;

use CodeSinging\PinAdmin\Console\ArrayHelpers;
use CodeSinging\PinAdmin\Console\Command;
use CodeSinging\PinAdmin\Kernel\Admin;
use CodeSinging\PinAdmin\Kernel\Application;
use CodeSinging\PinAdmin\Kernel\PinAdmin;
use CodeSinging\PinAdmin\Kernel\PinAdminServiceProvider;
use Illuminate\Support\Str;

class CreateCommand extends Command
{
    use ArrayHelpers;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = PinAdmin::LABEL . ':create {name} {--D|directory=} {--G|guard=}';

    /**
     * The console command description.
     *
     * @var string|null
     */
    protected $description = 'Create a PinAdmin application';

    /**
     * The application name.
     *
     * @var string
     */
    protected string $applicationName;

    /**
     * The application guard.
     *
     * @var string
     */
    protected string $applicationGuard;

    /**
     * The application directory.
     *
     * @var string
     */
    protected string $applicationDirectory;

    /**
     * The application.
     *
     * @var Application
     */
    protected Application $application;

    /**
     * The applications.
     *
     * @var array
     */
    protected array $indexes = [];

    /**
     * The application structure directories
     *
     * @var array
     */
    protected array $directories = [
        'Controllers',
        'Models',
        'Middleware',
        'Requests',
        'Database',
        'Migrations',
    ];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if ($this->verify()) {
            $this->init();

            if ($this->existed()) {
                $this->error(sprintf('Application [%s] already exists', $this->applicationName));
            } else {
                $this->createDirectories();
                $this->createRoutes();
                $this->createConfig();
                $this->createControllers();
                $this->createModels();
                $this->createMigrations();
                $this->publishConfiguration();
                $this->updateIndexes();
            }
        } else {
            $this->error(sprintf('Application name [%s] is invalid', $this->applicationName));
        }
    }

    /**
     * Initialize the application.
     */
    private function init(): void
    {
        $this->indexes = Admin::indexes();
        $this->applicationGuard = $this->option('guard')?: $this->applicationName;
        $this->applicationDirectory = $this->option('directory') ?: Str::studly($this->applicationName);
        $this->application = new Application($this->applicationName, ['directory' => $this->applicationDirectory]);
    }

    /**
     * Verify if the application name is valid.
     *
     * @return bool
     */
    private function verify(): bool
    {
        $this->applicationName = Str::snake($this->argument('name'));
        return !empty($this->applicationName) && preg_match('/^[a-zA-Z]+\w*$/', $this->applicationName) === 1;
    }

    /**
     * Determine if the application existed.
     *
     * @return bool
     */
    private function existed(): bool
    {
        return array_key_exists($this->applicationName, $this->indexes);
    }

    /**
     * Create application's directories.
     */
    private function createDirectories(): void
    {
        $this->title('Creating application directories');

        $this->makeDirectory($this->application->path());

        foreach ($this->directories as $directory) {
            $this->makeDirectory($this->application->path($directory));
        }
    }

    /**
     * Create application routes.
     */
    private function createRoutes(): void
    {
        $this->title('Create application routes');
        $this->copyFile(
            Admin::packagePath('stubs', 'routes.php'),
            $this->application->path('routes.php'),
            $this->replaces()
        );
    }

    /**
     * Create application config file.
     */
    private function createConfig(): void
    {
        $this->title('Create application config file');
        $this->copyFile(
            Admin::packagePath('stubs', 'config.php'),
            $this->application->path('config.php'),
            $this->replaces()
        );
    }

    /**
     * Create default application controllers.
     */
    private function createControllers(): void
    {
        $this->title('Create application controllers');
        $this->copyFiles(
            Admin::packagePath('stubs/controllers'),
            $this->application->path('Controllers'),
            $this->replaces()
        );
    }

    /**
     * Create default application models.
     */
    private function createModels(): void
    {
        $this->title('Create application models');
        $this->copyFiles(
            Admin::packagePath('stubs/models'),
            $this->application->path('Models'),
            $this->replaces(),
            $this->replaces()
        );
    }

    /**
     * Create default application migrations.
     */
    private function createMigrations(): void
    {
        $this->title('Create application migrations');
        $this->copyFiles(
            Admin::packagePath('stubs/migrations'),
            database_path('migrations'),
            $this->replaces(),
            $this->replaces()
        );
    }

    /**
     * Publish configuration file.
     * @return void
     */
    private function publishConfiguration()
    {
        $this->title('Publishing configuration file');

        if (file_exists($file = config_path(Admin::label('php', '.')))){
            $this->warn(sprintf('Configuration file [%s] already exists', $file));
        } else {
            $this->call('vendor:publish', [
                '--provider' => PinAdminServiceProvider::class,
                '--tag' => Admin::label('config', '-')
            ]);
        }
    }

    /**
     * Update application indexes.
     */
    private function updateIndexes(): void
    {
        $this->title('Update application indexes');
        $this->indexes[$this->applicationName] = [
            'name' => $this->applicationName,
            'guard' => $this->applicationGuard,
            'directory' => $this->applicationDirectory,
            'status' => true,
        ];
        $this->copyFile(
            Admin::packagePath('stubs', 'indexes.php'),
            Admin::basePath('indexes.php'),
            ['__DUMMY_INDEXES__' => $this->varExport($this->indexes, true)]
        );
    }

    /**
     * 所有需要替换的标记
     * @return array
     */
    private function replaces(): array
    {
        return [
            '__DUMMY_UPPER_LABEL__' => Str::upper(Admin::label()),
            '__DUMMY_UPPER_NAME__' => Str::upper($this->applicationName),
            '__DUMMY_NAME__' => $this->applicationName,
            '__DUMMY_STUDLY_NAME__' => Str::studly($this->applicationName),
            '__DUMMY_CAMEL_NAME__' => Str::camel($this->applicationName),
            '__DUMMY_GUARD__' => $this->applicationGuard,
            '__DUMMY_NAMESPACE__' => $this->application->getNamespace(),
        ];
    }
}