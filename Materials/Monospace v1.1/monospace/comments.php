<?php
	// Do not delete these lines
	
	if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))die ('Please do not load this page directly. Thanks!');
	
	if ( post_password_required() ) {
		?>
<p class="nocomments"><?php  _e('This post is password protected. Enter the password to view comments.','mythemeshop'); ?></p>
<?php
 return;} ?>
<!-- You can start editing here. -->
<?php  if ( have_comments() ) : ?>
	<div id="comments">
		<div class="total-comments"><?php  comments_number(__('No Comments','mythemeshop'), __('One Comment','mythemeshop'),  __('% Comments','mythemeshop') ); ?></div>
		<hr />
		<div class="commentlist-wrap">
			<ol class="commentlist">
				<div class="navigation">
					<div class="alignleft"><?php  previous_comments_link()  ?></div>
					<div class="alignright"><?php  next_comments_link()  ?></div>
				</div>
				<?php  wp_list_comments('type=comment&callback=mts_comments'); ?>
				<div class="navigation">
					<div class="alignleft"><?php  previous_comments_link()  ?></div>
					<div class="alignright"><?php  next_comments_link()  ?></div>
				</div>
			</ol>
		</div>
	</div>
<?php  else :// this is displayed if there are no comments so far  ?>
<?php  if ('open' == $post->comment_status) : ?>
<!-- If comments are open, but there are no comments. -->
<?php  else :// comments are closed  ?>
<!-- If comments are closed. -->
<p class="nocomments"></p>
<?php  endif; ?>
<?php  endif; ?>
<?php  if ('open' == $post->comment_status) : ?>
	<div id="commentsAdd">
		<div id="respond" class="box m-t-6">
			<h3 class="mts-comments-title"><?php  _e('Leave a reply','mythemeshop'); ?></h3><hr />
			<?php 
	global $aria_req;
	$comments_args = array('title_reply'=>__('','mythemeshop'),'comment_notes_after' => '','label_submit' => 'Post Comment','comment_field' => '<div class="comments-content-wrapper"><p class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p></div>','fields' => apply_filters( 'comment_form_default_fields',array('author' => '<div class="comments-content-wrapper"><p class="comment-form-author">'.'<label style="display:none" for="author">'. __( 'Name', 'mythemeshop' ).'<span class="required"></span></label>'.( $req ? '' :
	'' ).'<input id="author" name="author" type="text" placeholder="'.__('Name','mythemeshop').'" value="'.esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></p></div>','email' => '<div class="comments-content-wrapper"><p class="comment-form-email"><label style="display:none" for="email">' . __( 'Email', 'mythemeshop' ) . '<span class="required"></span></label>'.($req ? '' :
	'' ) . '<input id="email" name="email" type="text" placeholder="'.__('Email','mythemeshop').'" value="' . esc_attr(  $commenter['comment_author_email'] ).'" size="30"'.$aria_req.' /></p></div>','url' => '<div class="comments-content-wrapper"><p class="comment-form-url"><label style="display:none" for="url">' . __( 'Website', 'mythemeshop' ).'</label>' . '<input id="url" name="url" type="text" placeholder="'.__('Website','mythemeshop').'" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p></div>') ));
	?>
			<?php  comment_form($comments_args); ?>
		</div>
	</div>
<?php  endif;// if you delete this the sky will fall on your head  ?>