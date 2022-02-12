<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

namespace CodeSinging\PinAdmin\Support;

class PackageJson
{
    protected string $file;

    protected array $data;

    /**
     * @param string|null $filename
     */
    public function __construct(string $filename = null)
    {
        $this->file = $filename ?: base_path('package.json');

        if (file_exists($this->file)) {
            $this->data = json_decode(file_get_contents($this->file), true);
        } else {
            $this->data = [];
        }
    }

    /**
     * 获取节点值
     *
     * @param string $key
     * @param mixed $default
     *
     * @return mixed
     */
    public function get(string $key, $default)
    {
        return $this->data[$key] ?? $default;
    }

    /**
     * 设置节点值
     *
     * @param string $key
     * @param mixed $value
     *
     * @return $this
     */
    public function set(string $key, $value): PackageJson
    {
        $this->data[$key] = $value;
        return $this;
    }

    /**
     * 合并节点值，如果有同名键存在，则不合并
     *
     * @param string $key
     * @param array $value
     *
     * @return $this
     */
    public function merge(string $key, array $value): PackageJson
    {
        return $this->set($key, array_merge($this->get($key, []), $value));
    }

    /**
     * 保存文件
     *
     * @return false|int
     */
    public function save()
    {
        return file_put_contents($this->file, json_encode($this->data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) . PHP_EOL);
    }

    /**
     * 返回全部数据
     *
     * @return array
     */
    public function data(): array
    {
        return $this->data;
    }

    /**
     * 返回文件名
     *
     * @return string
     */
    public function file(): string
    {
        return $this->file;
    }
}