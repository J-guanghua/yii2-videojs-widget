<?php 
namespace xutl\videojs;
/**
 * Asset bundle for videojs Widget
 */
class VideoJsAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@xutl/videojs/assets';

    /**
     * @var array list of CSS files that this bundle contains. Each CSS file can be specified
     * in one of the three formats as explained in [[js]].
     */
    public $css = [
        'video-js.min.css',
    ];

    public $js = [
        'ie8/videojs-ie8.min.js',
        'video.min.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset'
    ];


}