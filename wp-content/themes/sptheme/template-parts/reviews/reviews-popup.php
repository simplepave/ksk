<?php

/**
 *
 */

?>
    <div class="main_order">
        <a class="rev_button popup" href="#reviews_popup">Написать отзыв</a>
    </div>
    <div id="reviews_popup" class="reviews_popup">
        <div class="head_credit_history">Оставить отзыв</div>
        <form action="<?php echo esc_url(home_url('wp-comments-post.php')); ?>" method="post">
            <input name="author" class="input_popup" type="text" placeholder="Ваше имя" required="required">
            <textarea name="comment" class="textarea_popup" placeholder="Текст отзыва" required="required"></textarea>
            <input class="submit_reviews" type="submit" value="Оствить отзыв">
            <input type='hidden' name='comment_post_ID' value='<?php echo $post->ID; ?>' id='comment_post_ID' />
            <input type='hidden' name='comment_parent' id='comment_parent' value='0' />
        </form>
    </div>