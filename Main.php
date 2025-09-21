<?php

namespace IdnoPlugins\Webmentions {

    use Idno\Common\Entity;
    use Idno\Common\Plugin;
    use Idno\Core\Webservice;

    class Main extends Plugin
    {

        function registerTranslations()
        {

            \Idno\Core\Idno::site()->language()->register(
                new \Idno\Core\GetTextTranslation(
                    'webmentions', dirname(__FILE__) . '/languages/'
                )
            );
        }

        function registerPages()
        {

            \Idno\Core\Idno::site()->routes()->addRoute('admin/webmentions/?', 'IdnoPlugins\Webmentions\Pages\Admin');

            \Idno\Core\Idno::site()->template()->extendTemplate('admin/menu/items', 'webmentions/admin/menu');

        }

        function registerEventHooks()
        {
            \Idno\Core\Idno::site()->syndication()->registerService('webmentions', function() {
                return $this->hasWebmentions();
            }, array('article', 'bookmark', 'image', 'media', 'place'));

            if ($this->hasWebmentions()) {
                if (!empty(\Idno\Core\Idno::site()->config()->webmention_syndication)) {
                    foreach(\Idno\Core\Idno::site()->config()->webmention_syndication as $hook) {
                        if (!empty($hook['url']))
                            \Idno\Core\Idno::site()->syndication()->registerServiceAccount('webmentions', $hook['url'], $hook['title']);
                    }
                }
                if (\Idno\Core\Idno::site()->session()->isLoggedIn()) {
                    if (!empty(\Idno\Core\Idno::site()->session()->currentUser()->webmention_syndication)) {
                        foreach(\Idno\Core\Idno::site()->session()->currentUser()->webmention_syndication as $hook) {
                            if (!empty($hook['url']))
                                \Idno\Core\Idno::site()->syndication()->registerServiceAccount('webmentions', $hook['url'], $hook['title']);
                        }
                    }
                }
            }

            $hook_function = function(\Idno\Core\Event $event) {
                $eventdata = $event->data();
                if ($this->hasWebmentions()) {
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
            \Idno\Core\Idno::site()->events()->addListener('post/article/webmentions', $hook_function);
            \Idno\Core\Idno::site()->events()->addListener('post/bookmark/webmentions', $hook_function);
            \Idno\Core\Idno::site()->events()->addListener('post/image/webmentions', $hook_function);
            \Idno\Core\Idno::site()->events()->addListener('post/media/webmentions', $hook_function);
            \Idno\Core\Idno::site()->events()->addListener('post/place/webmentions', $hook_function);

        }

        /**
         * Have webmentions been registered in the system?
         * @return bool
         */
        function hasWebmentions()
        {
            if (!empty(\Idno\Core\Idno::site()->config()->webmention_syndication) ||
                (\Idno\Core\Idno::site()->session()->isLoggedIn() && !empty(\Idno\Core\Idno::site()->session()->currentUser()->webmention_syndication))) {
                return true;
            }
            return false;
        }

    }

}

