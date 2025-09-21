<?php

namespace IdnoPlugins\Webmentions\Pages
{

    use Idno\Common\Page;

    class Admin extends Page
    {

        function getContent()
        {

            $this->adminGatekeeper();
            $t = \Idno\Core\Idno::site()->template();
            $body = $t->draw('webmentions/admin/home');
            $t->__(array('title' => \Idno\Core\Idno::site()->language()->_('Webmentions'), 'body' => $body))->drawPage();

        }

        function postContent()
        {

            $this->adminGatekeeper();
            $hooks = $this->getInput('webmentions');
            $titles = $this->getInput('titles');
            $webmention_syndication = array();
            if (is_array($hooks) && !empty($hooks)) {
                foreach($hooks as $key => $hook) {

                    $hook = trim($hook);
                    if (!empty($hook)) {
                        if (filter_var($hook, FILTER_VALIDATE_URL)) {
                            if (!empty($titles[$key])) {
                                $title = $titles[$key];
                            } else {
                                $title = parse_url($hook, PHP_URL_HOST);
                            }
                            $webmention_syndication[] = array('url' => $hook, 'title' => $title);
                        } else {
                            \Idno\Core\Idno::site()->session()->addErrorMessage(\Idno\Core\Idno::site()->language()->esc_("%s doesn't seem to be a valid URL.", [$hook]));
                        }
                    }
                }
            }
            \Idno\Core\Idno::site()->config()->webmention_syndication = $webmention_syndication;
            \Idno\Core\Idno::site()->config()->save();
            $this->forward(\Idno\Core\Idno::site()->config()->getDisplayURL() . 'admin/webmentions/');

        }

    }

}

