<div class="row">

    <div class="col-md-10 col-md-offset-1">
                <?php echo $this->draw('admin/menu');?>

        <h1><?php echo \Idno\Core\Idno::site()->language()->_('Webmentions'); ?></h1>

        <p class="explanation">
            <?php echo \Idno\Core\Idno::site()->language()->_('Webmentions let you syndicate content to external applications in a simple way. When you publish a post, the content can be sent to an external service using a Webmention.'); ?>
        </p>
        <p class="explanation">
            <?php echo \Idno\Core\Idno::site()->language()->_('Services like'); ?>
            <a href="https://brid.gy/about#publishing"><?php echo \Idno\Core\Idno::site()->language()->_('Bridgy Publish'); ?></a>
            <?php echo \Idno\Core\Idno::site()->language()->_('make this easy by connecting your site to platforms such as Bluesky, Mastodon, and others. When syndication is enabled in your post, the plugin automatically inserts a hidden link (for example,'); ?>
            <code><?php echo htmlspecialchars('<a href="https://brid.gy/publish/bluesky"></a>'); ?></code>
            <?php echo \Idno\Core\Idno::site()->language()->_(') that Bridgy detects and uses to publish your content to the selected site.'); ?>
        </p>
        <p class="explanation">
            <?php echo \Idno\Core\Idno::site()->language()->_('To learn more about Webmentions and what they can be used for, read the');?> <a href="https://indieweb.org/Webmention"><?php echo \Idno\Core\Idno::site()->language()->_('IndieWeb Webmention page'); ?></a>.
        </p>

    </div>

</div>
<div class="row">
    <div class="col-md-10 col-md-offset-1">

        <h3><?php echo \Idno\Core\Idno::site()->language()->_('Create a new Webmention'); ?></h3>

        <form action="" method="post">

            <?php

            if (!empty(\Idno\Core\Idno::site()->config()->webmention_syndication)) {
                foreach(\Idno\Core\Idno::site()->config()->webmention_syndication as $webmention) {
                    if (!empty($webmention['title']) && !empty($webmention['url'])) {

                        ?>
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" name="titles[]" value="<?php echo htmlspecialchars($webmention['title'])?>" placeholder="<?php echo \Idno\Core\Idno::site()->language()->_('Name of this webmention'); ?>" class="form-control">
                    </div>
                    <div class="col-md-5">
                        <input type="text" name="webmentions[]" value="<?php echo htmlspecialchars($webmention['url'])?>" placeholder="<?php echo \Idno\Core\Idno::site()->language()->_('Webmention URL'); ?>" class="form-control">
                    </div>
                    <div class="col-md-3" style="margin-top: 0.75em">
                        <small><a href="#" onclick="$(this).closest('.row').remove(); return false;"><i class="fa fa-times"></i> <?php echo \Idno\Core\Idno::site()->language()->_('Remove this Webmention'); ?></a></small>
                    </div>
                </div>
                        <?php
                    }

                }
            }

            ?>
            <div class="row">
                <div class="col-md-4">
                    <input type="text" value="" name="titles[]" placeholder="<?php echo \Idno\Core\Idno::site()->language()->_('Name of this webmention'); ?>" class="form-control">
                </div>
                <div class="col-md-5">
                    <input type="text" value="" name="webmentions[]" placeholder="<?php echo \Idno\Core\Idno::site()->language()->_('Webmention URL'); ?>" class="form-control">
                </div>
                <div class="col-md-3" style="margin-top: 0.75em">
                    <small><a href="#" onclick="$(this).closest('.row').remove(); return false;"><i class="fa fa-times"></i> <?php echo \Idno\Core\Idno::site()->language()->_('Remove this Webmention'); ?></a></small>
                </div>
            </div>
            <div id="morefields"></div>
            
                <p style="margin-top:1em; margin-bottom:1.5em">
                    <a href="#" onclick="$('#morefields').append($('#field_template').html());"><i class="fa fa-plus"></i> <?php echo \Idno\Core\Idno::site()->language()->_('Add another Webmention'); ?></a>
                </p>
            <p>
                <?php echo \Idno\Core\Idno::site()->actions()->signForm('/admin/webmentions/') ?>
                <input class="btn btn-primary" value="<?php echo \Idno\Core\Idno::site()->language()->_('Save Webmentions'); ?>" type="submit">
            </p>

        </form>
        <div id="field_template" style="display:none">
            <div class="row">
                <div class="col-md-4">
		    <input type="text" value="" name="titles[]" placeholder="<?php echo \Idno\Core\Idno::site()->language()->_('Name of this webmention'); ?>" class="form-control">
		</div>
                <div class="col-md-5">
		    <input type="text" value="" name="webmentions[]" placeholder="<?php echo \Idno\Core\Idno::site()->language()->_('Webmention URL'); ?>"  class="form-control">
		</div>
                <div class="col-md-3" style="margin-top: 0.75em">
		    <small><a href="#" onclick="$(this).closest('.row').remove(); return false;"><i class="fa fa-times"></i> <?php echo \Idno\Core\Idno::site()->language()->_('Remove this Webmention'); ?></a></small>
		</div>
            </div>
        </div>

    </div>
</div>