<?php

namespace Siaoynli\LaravelAliOSS;

use Siaoynli\LaravelAliOSS\Adapter\AliossAdapter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use League\Flysystem\Filesystem;
use OSS\Core\OssException;
use OSS\OssClient;

class AliossServiceProvider extends ServiceProvider
{

    private $ossClient;

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        //自定义文件系统 extend 方法的第一个参数是驱动程序的名称，第二个参数是接收 $app 及 $config 变量的闭包。该解析闭包必须返回 League\Flysystem\Filesystem 的实例。$config 变量包含了特定磁盘在 config/filesystems.php 中定义的值。
        Storage::extend('alioss', function ($app, $config) {
            return new Filesystem(new AliossAdapter($this->ossClient, $config['bucket']));
        });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/alioss.php',
            'alioss'
        );

        $config = $this->app['config'];

        $arr = [
            "alioss" => array_merge(['driver' => 'alioss'], config("alioss"))
        ];

        $config->set("filesystems.disks", array_merge($config->get("filesystems.disks"), $arr));

        try {
            $ossConfig = config("alioss");

            $bucket = $ossConfig['bucket'];
            // 创建OSS客户端
            $this->ossClient = new OssClient($ossConfig['key'], $ossConfig['secret'], $ossConfig['region']);

            if (!$this->ossClient) {
                throw new OssException("Oss Client is Null");
            }
            // 单例绑定服务
            $this->app->singleton('alioss', function ($app) use ($bucket) {
                return new Alioss($this->ossClient, $bucket);
            });
        } catch (OssException $e) {
            throw new OssException($e->getMessage());
        }
    }
}
