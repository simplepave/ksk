<?php

/**
 *
 */

if ($vimeo = get_option('vimeo', '')) :
?>
    <div class="video">
        <div class="container">
            <div class="row no-gutters">
                <div class="video_block">
                    <div style="padding:56.25% 0 0 0;position:relative;"><iframe src="<?php echo $vimeo; ?>" style="position:absolute;top:0;left:0;width:100%;height:100%;" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe></div><script src="https://player.vimeo.com/api/player.js"></script>
                </div>
            </div>
        </div>
    </div>
<?php endif;