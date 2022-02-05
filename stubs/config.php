<?php
/**
 * Author: codesinging <codesinging@gmail.com>
 * Github: https://github.com/codesinging
 */

return [
    /*
    |--------------------------------------------------------------------------
    | PinAdmin 应用中文名
    |--------------------------------------------------------------------------
    |
    | 此名字是 PinAdmin 应用的中文名称，用于显示页面上的标题等地方。
    |
    */
    'name' => env('__DUMMY_UPPER_LABEL_____DUMMY_UPPER_NAME___NAME', '__DUMMY_STUDLY_NAME__'),

    /*
    |--------------------------------------------------------------------------
    | PinAdmin 应用路由前缀
    |--------------------------------------------------------------------------
    |
    | 所有此应用的路由都以此为前缀
    |
    */
    'route_prefix' => env('__DUMMY_UPPER_LABEL_____DUMMY_UPPER_NAME___ROUTE_PREFIX', '__DUMMY_NAME__'),

    /*
    |--------------------------------------------------------------------------
    | PinAdmin 应用路由中间件
    |--------------------------------------------------------------------------
    |
    | 所有路由都会自动注册这些中间件
    |
    */
    'middlewares' => [
        'web',
        'admin.boot:__DUMMY_NAME__',
    ],

    /*
    |--------------------------------------------------------------------------
    | 需要认证授权的 PinAdmin 应用路由中间件
    |--------------------------------------------------------------------------
    |
    | 所有需要认证授权的路由都会自动注册这些中间件
    |
    */
    'auth_middlewares' => [
        'admin.auth:__DUMMY_NAME__',
    ],

    /*
    |--------------------------------------------------------------------------
    | 不需要认证授权的 PinAdmin 应用路由中间件
    |--------------------------------------------------------------------------
    |
    | 所有需要认证授权的路由都会自动注册这些中间件
    |
    */
    'guest_middlewares' => [
        'admin.guest:__DUMMY_NAME__',
    ],

    /*
    |--------------------------------------------------------------------------
    | 授权认证守卫
    |--------------------------------------------------------------------------
    |
    | 此配置会合并到系统的 auth 配置的 guards 中。
    |
    */
    'auth_guard' => [
        'driver' => 'session',
        'provider' => '__DUMMY_GUARD___users',
    ],

    /*
    |--------------------------------------------------------------------------
    | 授权认证用户提供者
    |--------------------------------------------------------------------------
    |
    | 此配置会合并到系统的 auth 配置的 providers 中。
    |
    */
    'auth_provider' => [
        'driver' => 'eloquent',
        'model' => __DUMMY_NAMESPACE__\Models\__DUMMY_STUDLY_NAME__User::class,
    ],

];