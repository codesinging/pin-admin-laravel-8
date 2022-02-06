<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace CodeSinging\PinAdmin\Console;

use CodeSinging\PinAdmin\Support\PackageJson;

trait PackageHelpers
{
    /**
     * 为 package.json 添加命令
     * @param array $scripts
     *
     * @return void
     */
    protected function addPackageScripts(array $scripts)
    {
        $packageJson = new PackageJson();;

        if ($packageJson->merge('scripts', $scripts)->save()) {
            $this->info("Added scripts in file [{$packageJson->file()}]");
        } else {
            $this->warn("Failed to add scripts in file [{$packageJson->file()}]");
        }
    }

    /**
     * 为 package.json 添加开发依赖
     * @param array $dependencies
     *
     * @return void
     */
    protected function addDevDependencies(array $dependencies)
    {
        $packageJson = new PackageJson();;

        if ($packageJson->merge('devDependencies', $dependencies)->save()) {
            $this->info("Added dev dependencies in file [{$packageJson->file()}]");
        } else {
            $this->warn("Failed to add dev dependencies in file [{$packageJson->file()}]");
        }
    }

    /**
     * 为 package.json 添加依赖
     * @param array $dependencies
     *
     * @return void
     */
    protected function addDependencies(array $dependencies)
    {
        $packageJson = new PackageJson();;

        if ($packageJson->merge('dependencies', $dependencies)->save()) {
            $this->info("Added dependencies in file [{$packageJson->file()}]");
        } else {
            $this->warn("Failed to add dependencies in file [{$packageJson->file()}]");
        }
    }
}