<?php

namespace IdnoPlugins\BridgyPublish\Pages
{

    use Idno\Common\Page;

    class Admin extends Page
    {

        function getContent()
        {

            $this->adminGatekeeper();
            $t = \Idno\Core\Idno::site()->template();
            $body = $t->draw('bridgypublish/admin/home');
            $t->__(array('title' => \Idno\Core\Idno::site()->language()->_('Bridgy Publish'), 'body' => $body))->drawPage();

        }

        function postContent()
        {

            $this->adminGatekeeper();
            $targets = $this->getInput('targets');
            $titles = $this->getInput('titles');
            $bridgypublish_syndication = array();
            if (is_array($targets) && !empty($targets)) {
                foreach($targets as $key => $target) {

                    $target = trim($target);
                    if (!empty($target)) {
                        if (filter_var($target, FILTER_VALIDATE_URL)) {
                            if (!empty($titles[$key])) {
                                $title = $titles[$key];
                            } else {
                                $title = parse_url($target, PHP_URL_HOST);
                            }
                            $bridgypublish_syndication[] = array('url' => $target, 'title' => $title);
                        } else {
                            \Idno\Core\Idno::site()->session()->addErrorMessage(\Idno\Core\Idno::site()->language()->esc_("%s doesn't seem to be a valid URL.", [$target]));
                        }
                    }
                }
            }
            \Idno\Core\Idno::site()->config()->bridgypublish_syndication = $bridgypublish_syndication;
            \Idno\Core\Idno::site()->config()->save();
            $this->forward(\Idno\Core\Idno::site()->config()->getDisplayURL() . 'admin/bridgypublish/');

        }

    }

}

