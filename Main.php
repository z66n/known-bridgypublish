<?php

namespace IdnoPlugins\BridgyPublish {

    use Idno\Common\Entity;
    use Idno\Common\Plugin;
    use Idno\Core\Webservice;

    class Main extends Plugin
    {

        function registerTranslations()
        {

            \Idno\Core\Idno::site()->language()->register(
                new \Idno\Core\GetTextTranslation(
                    'bridgypublish', dirname(__FILE__) . '/languages/'
                )
            );
        }

        function registerPages()
        {

            \Idno\Core\Idno::site()->routes()->addRoute('admin/bridgypublish/?', 'IdnoPlugins\BridgyPublish\Pages\Admin');

            \Idno\Core\Idno::site()->template()->extendTemplate('admin/menu/items', 'bridgypublish/admin/menu');

        }

        function registerEventHooks()
        {
            \Idno\Core\Idno::site()->syndication()->registerService('bridgypublish', function() {
                return $this->hasBridgyPublishTargets();
            }, array('article', 'bookmark', 'image', 'media', 'place'));

            if ($this->hasBridgyPublishTargets()) {
                if (!empty(\Idno\Core\Idno::site()->config()->bridgypublish_syndication)) {
                    foreach(\Idno\Core\Idno::site()->config()->bridgypublish_syndication as $target) {
                        if (!empty($target['url']))
                            \Idno\Core\Idno::site()->syndication()->registerServiceAccount('bridgypublish', $target['url'], $target['title']);
                    }
                }
                if (\Idno\Core\Idno::site()->session()->isLoggedIn()) {
                    if (!empty(\Idno\Core\Idno::site()->session()->currentUser()->bridgypublish_syndication)) {
                        foreach(\Idno\Core\Idno::site()->session()->currentUser()->bridgypublish_syndication as $target) {
                            if (!empty($target['url']))
                                \Idno\Core\Idno::site()->syndication()->registerServiceAccount('bridgypublish', $target['url'], $target['title']);
                        }
                    }
                }
            }

            $append_function = function(\Idno\Core\Event $event) {
                $eventdata = $event->data();
                if ($this->hasBridgyPublishTargets()) {
                    $object = $eventdata['object'];
                    if ($object instanceof Entity) {
                        // If a specific syndication account is provided, add a targeted link
                        if (!empty($eventdata['syndication_account'])) {
                            $target_url = $eventdata['syndication_account'];
                            $content_type = $object->getActivityStreamsObjectType();
                            if ($content_type === 'bookmark') {
                                $object->description .= "\n\n<a href=\"" . htmlspecialchars($target_url) . "\"></a>";
                            } else {
                                $object->body .= "\n\n<a href=\"" . htmlspecialchars($target_url) . "\"></a>";
                            }
                        }

                        $object->save();
                    }
                }
            };
                
            // Content type with html support
            \Idno\Core\Idno::site()->events()->addListener('post/article/bridgypublish', $append_function);
            \Idno\Core\Idno::site()->events()->addListener('post/bookmark/bridgypublish', $append_function);
            \Idno\Core\Idno::site()->events()->addListener('post/image/bridgypublish', $append_function);
            \Idno\Core\Idno::site()->events()->addListener('post/media/bridgypublish', $append_function);
            \Idno\Core\Idno::site()->events()->addListener('post/place/bridgypublish', $append_function);

        }

        /**
         * Have Bridgy Publish webmention targets been registered in the system?
         * @return bool
         */
        function hasBridgyPublishTargets()
        {
            if (!empty(\Idno\Core\Idno::site()->config()->bridgypublish_syndication) ||
                (\Idno\Core\Idno::site()->session()->isLoggedIn() && !empty(\Idno\Core\Idno::site()->session()->currentUser()->bridgypublish_syndication))) {
                return true;
            }
            return false;
        }

    }

}
