<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace CodeSinging\PinAdmin\Console\Commands;

use CodeSinging\PinAdmin\Console\ArrayHelpers;
use CodeSinging\PinAdmin\Console\Command;
use CodeSinging\PinAdmin\Console\PackageHelpers;
use CodeSinging\PinAdmin\Kernel\Admin;
use CodeSinging\PinAdmin\Kernel\Application;
use CodeSinging\PinAdmin\Kernel\PinAdmin;
use CodeSinging\PinAdmin\Kernel\PinAdminServiceProvider;
use Illuminate\Support\Str;

class CreateCommand extends Command
{
    use ArrayHelpers;
    use PackageHelpers;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = PinAdmin::LABEL . ':create {name}';

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
    protected string $appName;

    /**
     * The application.
     *
     * @var Application
     */
    protected Application $app;

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
    ];

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if ($this->verify()) {
            $this->init();

            if ($this->existed()) {
                $this->error(sprintf('Application [%s] already exists', $this->appName));
            } else {
                $this->createDirectories();
                $this->createRoutes();
                $this->createConfig();
                $this->createControllers();
                $this->createModels();
                $this->createMigrations();
                $this->publishConfiguration();
                $this->publishResources();
                $this->updateIndexes();
            }
        } else {
            $this->error(sprintf('Application name [%s] is invalid', $this->appName));
        }
    }

    /**
     * Initialize the application.
     */
    private function init(): void
    {
        $this->indexes = Admin::indexes();
        $this->app = new Application($this->appName);
    }

    /**
     * Verify if the application name is valid.
     *
     * @return bool
     */
    private function verify(): bool
    {
        $this->appName = Str::snake($this->argument('name'));
        return !empty($this->appName) && preg_match('/^[a-zA-Z]+\w*$/', $this->appName) === 1;
    }

    /**
     * Determine if the application existed.
     *
     * @return bool
     */
    private function existed(): bool
    {
        return array_key_exists($this->appName, $this->indexes);
    }

    /**
     * Create application's directories.
     */
    private function createDirectories(): void
    {
        $this->title('Creating application directories');

        $this->makeDirectory($this->app->path());
        $this->makeDirectory($this->app->appPath());
        $this->makeDirectory($this->app->publicPath());

        foreach ($this->directories as $directory) {
            $this->makeDirectory($this->app->appPath($directory));
        }
    }

    /**
     * Create application routes.
     */
    private function createRoutes(): void
    {
        $this->title('Create application routes');
        $this->copyFiles(
            Admin::packagePath('stubs', 'routes'),
            $this->app->path('routes'),
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
            Admin::packagePath('stubs', 'config', 'app.php'),
            $this->app->path('config', 'app.php'),
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
            $this->app->appPath('Controllers'),
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
            $this->app->appPath('Models'),
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
     *
     * @return void
     */
    private function publishConfiguration()
    {
        $this->title('Publishing configuration file');

        if (file_exists($file = config_path(Admin::label('php', '.')))) {
            $this->warn(sprintf('Configuration file [%s] already exists', $file));
        } else {
            $this->call('vendor:publish', [
                '--provider' => PinAdminServiceProvider::class,
                '--tag' => Admin::label('config', '-')
            ]);
        }
    }

    /**
     * Publish application images.
     *
     * @return void
     */
    private function publishResources()
    {
        $this->title('Publishing application static resources');

        $this->copyFile(
            Admin::packagePath('stubs/assets/config.js'),
            $this->app->path('assets/build/config.js'),
            [
                '__DUMMY_DIST_PATH__' => 'public/' . $this->app->publicDirectory(),
                '__DUMMY_SRC_PATH__' => $this->app->directory('assets'),
            ]
        );

        $this->copyDirectory(Admin::packagePath('resources/images'), $this->app->assetPath('images'));

        $this->copyDirectory(Admin::packagePath('resources/assets'), $this->app->resourcePath());

        $this->addPackageScripts([
            Admin::label('dev', '-') . ':' . $this->app->name() => sprintf('mix --mix-config=resources/%s/webpack.mix.js', $this->app->resourceDirectory()),
            Admin::label('watch', '-') . ':' . $this->app->name() => sprintf('mix watch --mix-config=resources/%s/webpack.mix.js', $this->app->resourceDirectory()),
            Admin::label('prod', '-') . ':' . $this->app->name() => sprintf('mix --production --mix-config=resources/%s/webpack.mix.js', $this->app->resourceDirectory()),
        ]);

        $this->addDependencies([
            'vue' => '^3.2.29',
        ]);

        $this->addDevDependencies([
            'vue-loader' => '^16.2.0'
        ]);
    }

    /**
     * Update application indexes.
     */
    private function updateIndexes(): void
    {
        $this->title('Update application indexes');
        $this->indexes[$this->appName] = [
            'name' => $this->appName,
            'guard' => $this->app->guard(),
            'directory' => $this->app->directory(),
            'appDirectory' => $this->app->appDirectory(),
            'publicDirectory' => $this->app->publicDirectory(),
            'status' => true,
        ];
        $this->copyFile(
            Admin::packagePath('stubs', 'indexes.php'),
            Admin::baseAppPath('indexes.php'),
            ['__DUMMY_INDEXES__' => $this->varExport($this->indexes, true)]
        );
    }

    /**
     * 所有需要替换的标记
     *
     * @return array
     */
    private function replaces(): array
    {
        return [
            '__DUMMY_UPPER_LABEL__' => Str::upper(Admin::label()),
            '__DUMMY_UPPER_NAME__' => Str::upper($this->appName),
            '__DUMMY_NAME__' => $this->appName,
            '__DUMMY_STUDLY_NAME__' => Str::studly($this->appName),
            '__DUMMY_CAMEL_NAME__' => Str::camel($this->appName),
            '__DUMMY_GUARD__' => $this->app->guard(),
            '__DUMMY_NAMESPACE__' => $this->app->getNamespace(),
        ];
    }
}