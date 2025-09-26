<div class="row">

    <div class="col-md-10 col-md-offset-1">
                <?php echo $this->draw('admin/menu');?>

        <h1><?php echo \Idno\Core\Idno::site()->language()->_('Bridgy Publish'); ?></h1>

        <p class="explanation">
            <?php echo \Idno\Core\Idno::site()->language()->_('Bridgy Publish lets you syndicate content to external applications using Webmentions.'); ?>
        </p>
        <p class="explanation">
            <a href="https://brid.gy/about#publishing"><?php echo \Idno\Core\Idno::site()->language()->_('Bridgy Publish'); ?></a>
            <?php echo \Idno\Core\Idno::site()->language()->_('connects your site to platforms such as Bluesky, Mastodon, and others. When syndication is enabled in your post, the plugin automatically inserts hidden links (for example,'); ?>
            <code><?php echo htmlspecialchars('<a href="https://brid.gy/publish/bluesky"></a>'); ?></code>
            <?php echo \Idno\Core\Idno::site()->language()->_(') that Bridgy detects and uses to publish your content to the selected site.'); ?>
        </p>
        <p class="explanation">
            <?php echo \Idno\Core\Idno::site()->language()->_('To learn more about Bridgy Publish with Webmentions, read the');?> <a href="https://brid.gy/about#webmentions"><?php echo \Idno\Core\Idno::site()->language()->_('Bridgy Help Page'); ?></a>.
        </p>

    </div>

</div>
<div class="row">
    <div class="col-md-10 col-md-offset-1">

        <h3><?php echo \Idno\Core\Idno::site()->language()->_('Create a new Webmention Target'); ?></h3>

        <form action="" method="post">

            <?php

            if (!empty(\Idno\Core\Idno::site()->config()->bridgypublish_syndication)) {
                foreach(\Idno\Core\Idno::site()->config()->bridgypublish_syndication as $bridgypublish) {
                    if (!empty($bridgypublish['title']) && !empty($bridgypublish['url'])) {

                        ?>
                <div class="row">
                    <div class="col-md-4">
                        <input type="text" name="titles[]" value="<?php echo htmlspecialchars($bridgypublish['title'])?>" placeholder="<?php echo \Idno\Core\Idno::site()->language()->_('Name of this Webmention Target'); ?>" class="form-control">
                    </div>
                    <div class="col-md-5">
                        <input type="text" name="targets[]" value="<?php echo htmlspecialchars($bridgypublish['url'])?>" placeholder="<?php echo \Idno\Core\Idno::site()->language()->_('Webmention Target URL'); ?>" class="form-control">
                    </div>
                    <div class="col-md-3" style="margin-top: 0.75em">
                        <small><a href="#" onclick="$(this).closest('.row').remove(); return false;"><i class="fa fa-times"></i> <?php echo \Idno\Core\Idno::site()->language()->_('Remove this Webmention Target'); ?></a></small>
                    </div>
                </div>
                        <?php
                    }

                }
            }

            ?>
            <div class="row">
                <div class="col-md-4">
                    <input type="text" value="" name="titles[]" placeholder="<?php echo \Idno\Core\Idno::site()->language()->_('Name of this Webmention Target'); ?>" class="form-control">
                </div>
                <div class="col-md-5">
                    <input type="text" value="" name="targets[]" placeholder="<?php echo \Idno\Core\Idno::site()->language()->_('Webmention Target URL'); ?>" class="form-control">
                </div>
                <div class="col-md-3" style="margin-top: 0.75em">
                    <small><a href="#" onclick="$(this).closest('.row').remove(); return false;"><i class="fa fa-times"></i> <?php echo \Idno\Core\Idno::site()->language()->_('Remove this Webmention Target'); ?></a></small>
                </div>
            </div>
            <div id="morefields"></div>
            
                <p style="margin-top:1em; margin-bottom:1.5em">
                    <a href="#" onclick="$('#morefields').append($('#field_template').html());"><i class="fa fa-plus"></i> <?php echo \Idno\Core\Idno::site()->language()->_('Add another Webmention Target'); ?></a>
                </p>
            <p>
                <?php echo \Idno\Core\Idno::site()->actions()->signForm('/admin/bridgypublish/') ?>
                <input class="btn btn-primary" value="<?php echo \Idno\Core\Idno::site()->language()->_('Save Webmention Targets'); ?>" type="submit">
            </p>

        </form>
        <div id="field_template" style="display:none">
            <div class="row">
                <div class="col-md-4">
		    <input type="text" value="" name="titles[]" placeholder="<?php echo \Idno\Core\Idno::site()->language()->_('Name of this Webmention Target'); ?>" class="form-control">
		</div>
                <div class="col-md-5">
		    <input type="text" value="" name="targets[]" placeholder="<?php echo \Idno\Core\Idno::site()->language()->_('Webmention Target URL'); ?>"  class="form-control">
		</div>
                <div class="col-md-3" style="margin-top: 0.75em">
		    <small><a href="#" onclick="$(this).closest('.row').remove(); return false;"><i class="fa fa-times"></i> <?php echo \Idno\Core\Idno::site()->language()->_('Remove this Webmention Target'); ?></a></small>
		</div>
            </div>
        </div>

    </div>
</div>