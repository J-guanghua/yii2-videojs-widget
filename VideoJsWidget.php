<?php

namespace xutl\videojs;

use yii\base\Widget;
use yii\helpers\Json;
use yii\helpers\Html;
use yii\base\InvalidConfigException;

class VideoJsWidget extends Widget
{
    /**
     * @var array the HTML attributes for the input tag.
     * @see \yii\helpers\Html::renderTagAttributes() for details on how attributes are being rendered.
     */
    public $options = [];

    /**
     * @var array
     */
    public $clientOptions = [];

    /**
     * @var array
     */
    public $tags = [];

    /**
     * Initializes the widget.
     */
    public function init()
    {
        parent::init();
        $this->initOptions();
        $this->registerAssets();
    }

    /**
     * Initializes the widget options
     */
    protected function initOptions()
    {
        if (!isset($this->options['id'])) {
            $this->options['id'] = 'video-' . $this->getId();
        }
        if (!isset($this->options['class'])) {
            $this->options['class'] = 'video-js vjs-default-skin vjs-big-play-centered';
        }
    }

    /**
     * Registers the needed assets
     */
    public function registerAssets()
    {
        $view = $this->getView();
        $asset = VideoJsAsset::register($view);
        $view->registerJs('videojs.options.flash.swf = "' . $asset->baseUrl . '/video-js.swf";');
        echo Html::beginTag('video', $this->options);
        if (!empty($this->tags) && is_array($this->tags)) {
            foreach ($this->tags as $tagName => $tags) {
                if (is_array($this->tags[$tagName])) {
                    foreach ($tags as $tagOptions) {
                        $tagContent = '';
                        if (isset($tagOptions['content'])) {
                            $tagContent = $tagOptions['content'];
                            unset($tagOptions['content']);
                        }
                        echo Html::tag($tagName, $tagContent, $tagOptions);
                    }
                } else {
                    throw new InvalidConfigException("Invalid config for 'tags' property.");
                }
            }
        }
        echo Html::endTag('video');
        if (!empty($this->clientOptions)) {
            $clientOptions = Json::encode($this->clientOptions);
            $view->registerJs('videojs("#' . $this->options['id'] . '").ready(' . $clientOptions . ');');
        }
    }
}