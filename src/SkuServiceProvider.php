<?php

namespace JadeKun\Sku;

use Encore\Admin\Admin;
use Encore\Admin\Assets;
use Encore\Admin\Form;
use Illuminate\Support\ServiceProvider;

class SkuServiceProvider extends ServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function boot(Sku $extension)
    {
        if (! Sku::boot()) {
            return ;
        }

        if ($views = $extension->views()) {
            $this->loadViewsFrom($views, 'sku');
        }

        if ($this->app->runningInConsole() && $assets = $extension->assets()) {
            $this->publishes(
                [$assets => public_path('vendor/jadekun/sku')],
                'sku'
            );
        }

        Assets::define('sku', [
            'js'     => public_path('vendor/jadekun/sku/sku.js'),
            'css'     => public_path('vendor/jadekun/sku/sku.css'),
            'export' => 'sku',
        ]);

        Admin::booting(function () {
            Form::extend('sku', SkuField::class);
        });
    }
}
