<?php 

namespace app\assets;

use yii\web\AssetBundle;

class AppAssetLogin extends AssetBundle
{
    //public $basePath = '@webroot';
    //public $baseUrl = '@web';
    public $sourcePath = '@vendor/bower/AdminLTE/';
    public $css = [
        'bootstrap/css/bootstrap.min.css',
        'plugins/font-awesome/css/font-awesome.min.css',
        'dist/css/AdminLTE.min.css',
        'plugins/iCheck/square/blue.css',
    ];
    public $js = [
            'plugins/jQuery/jQuery-2.1.4.min.js',
            'bootstrap/js/bootstrap.min.js',
            'plugins/iCheck/icheck.min.js',
            'dist/js/satusoftware_icheck.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}