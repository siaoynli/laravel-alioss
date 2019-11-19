# alioss
基于aliyuncs/oss-sdk-php项目上对Laravel框架的扩展

## 使用
    composer require siaoynli/laravel-alioss

## 配置
在 config/app.php 的 providers 中添加
```php
 Siaoynli\LaravelAliOSS\AliossServiceProvider::class,
``` 
在 aliases 配置别名
```php
'Alioss' => Siaoynli\LaravelAliOSS\Facades\Alioss::class
``` 
先在 config/filesystems.php 中的 disks 中添加以下配置：
```php
'alioss' => [
    'driver' => 'alioss',
'key' => env('ACCESS_KEY_ID'),
    'secret' => env('ACCESS_KEY_SECRET'),
     'region' => env('OSS_ENDPOINT'),
     'bucket' => env('OSS_BUCKET'),
      'url' => env('OSS_BUCKET_HOST'),
],
```

## 使用
有两种使用方法，第一种是调用 Laravel 的 Filesystem 组件进行操作阿里云OSS上的对象，第二种是直接使用本扩展所提供的方法。

### 使用 Filesystem 组件
使用以下方式进行调用：
```php
Storage::disk('alioss')->write('/test/text', '这是一段测试文字！');
Storage::disk('alioss')->update('/test/text', '这是一段修改后的测试文字！');
Storage::disk('alioss')->writeStream('/test/file', fopen('/text.txt', 'r'));
Storage::disk('alioss')->updateStream('/test/file', fopen('/newtext.txt', 'r'));
Storage::disk('alioss')->rename('/test/text', '/test/newtext');
Storage::disk('alioss')->copy('/test/newtext', '/test/text');
Storage::disk('alioss')->delete('/test/text');
Storage::disk('alioss')->deleteDir('/test');
Storage::disk('alioss')->has('/test/text');
Storage::disk('alioss')->read('/test/text');
Storage::disk('alioss')->readStream('/test/text');
Storage::disk('alioss')->listContents('/test');
Storage::disk('alioss')->getMetadata('/test/text');
Storage::disk('alioss')->getSize('/test/text');
Storage::disk('alioss')->getMimetype('/test/text');
Storage::disk('alioss')->getTimestamp('/test/text');
Storage::disk('alioss')->getVisibility('/test/text');
```
### 使用扩展方法
配置了别名后，可以直接使用以下语法调用：
```php
Alioss::write('test/text', '这是一段测试文字！');
Alioss::has('test/text');
Alioss::getSize('test/text');
```
