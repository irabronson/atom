<?php

function atom_register_artists() {
	$labels = array(
    'name' => 'Artists',
    'singular_name' => 'Artist',
    'add_new' => 'Add New',
    'add_new_item' => 'Add New Artist',
    'edit_item' => 'Edit Artist',
    'new_item' => 'New Artist',
    'all_items' => 'All Artists',
    'view_item' => 'View Artist',
    'search_items' => 'Search Artists',
    'not_found' =>  'No artists found',
    'not_found_in_trash' => 'No artists found in Trash', 
    'parent_item_colon' => '',
    'menu_name' => 'Artists'
  );

  $args = array(
    'labels' => $labels,
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true, 
    'show_in_menu' => true, 
    'query_var' => true,
    'rewrite' => array( 'slug' => 'artist' ),
    'capability_type' => 'post',
    'has_archive' => true, 
    'hierarchical' => false,
    'menu_position' => null,
    'supports' => array( 'title', 'editor', 'author', 'thumbnail' )
  ); 

    register_post_type( 'artist', $args );
}
add_action( 'init', 'atom_register_artists' );

//ADD CUSTOM FIELDS TO ARTISTS
add_action('admin_init', 'atom_admin_init');
add_action('save_post', 'atom_save_artist_fields');

function atom_admin_init(){
	add_meta_box('artist-fields', 'Artist Fields', 'atom_meta_options', 'artist', 'normal', 'high');
	add_meta_box('homepage-fields', 'Special Fields', 'atom_meta_options', 'page', 'normal', 'high');
}

function atom_get_artist_social_links() {
	$mediaTypes = array(
					'Facebook'
					, 'Twitter'
					, 'Instagram'
					, 'Bandcamp'
					, 'YouTube'
					, 'Last.fm'
				);
	return $mediaTypes;
}

function atom_meta_options(){
	global $post;
	if(get_post_type($post) == 'page') {
		if(get_the_title($post) == 'Home') {
			$custom = get_post_custom($post->ID);
			$tagline = $custom['tagline'][0];
			?>
			<strong>Tagline:</strong> <input name="tagline" value="<?php if(isset($tagline)) { echo $tagline; } ; ?>" style="width:600px;"/>
			<?php
		}
		elseif(get_the_title($post) == 'About') {
			$custom = get_post_custom($post->ID);
			$intro = $custom['intro'][0];
			?>
			<strong>Intro:</strong> <textarea name="intro" style="width:600px;"><?php if(isset($intro)) { echo $intro; } ; ?></textarea>
			<?php
		}
		else {
			echo "nothing to see here";
		}
	}

	if(get_post_type($post) == 'artist') {

	$mediaTypes = atom_get_artist_social_links();
	$custom = get_post_custom($post->ID);
	foreach($custom as $k => $v) {
		$$k = $custom[$k][0];
	}

?>
	<p><label>On Tour?</label> <input type="checkbox" name="on_tour" <?php if( $on_tour == true ) { ?>checked="checked"<?php } ?> />

	<p><strong>Social Media Links:</strong> for URLs, always include "http://"
	<?php foreach($mediaTypes as $type): ?>
		<br><label><strong><?php echo $type; ?>:</strong></label> <input name="<?php echo $type; ?>" value="<?php if(isset($custom[$type][0])) { echo $custom[$type][0]; } ; ?>" />
	<?php endforeach; ?>

	<p><strong>Official Site:</strong> <input name="official_site" value="<?php if(isset($official_site)) { echo $official_site; } ; ?>" />

	<p><strong>Press Clips:</strong>

	<p>Clip 1:
	<br>Clip 1 Quote: <textarea name="clip_1_body"><?php if(isset($clip_1_body)) { echo $clip_1_body; } ; ?></textarea>
	<br>Clip 1 Source Name: <input name="clip_1_source" value="<?php if(isset($clip_1_source)) { echo $clip_1_source; } ; ?>" />
	<br>Clip 1 Source Link: <input name="clip_1_link" value="<?php if(isset($clip_1_link)) { echo $clip_1_link; } ; ?>" />

	<p>Clip 2:
	<br>Clip 1 Quote: <textarea name="clip_2_body"><?php if(isset($clip_2_body)) { echo $clip_2_body; } ; ?></textarea>
	<br>Clip 1 Source Name: <input name="clip_2_source" value="<?php if(isset($clip_2_source)) { echo $clip_2_source; } ; ?>" />
	<br>Clip 1 Source Link: <input name="clip_2_link" value="<?php if(isset($clip_2_link)) { echo $clip_2_link; } ; ?>" />

	<p>Clip 3:
	<br>Clip 1 Quote: <textarea name="clip_3_body"><?php if(isset($clip_3_body)) { echo $clip_3_body; } ; ?></textarea>
	<br>Clip 1 Source Name: <input name="clip_3_source" value="<?php if(isset($clip_3_source)) { echo $clip_3_source; } ; ?>" />
	<br>Clip 1 Source Link: <input name="clip_3_link" value="<?php if(isset($clip_3_link)) { echo $clip_3_link; } ; ?>" />

<?php
	}
}

function atom_save_artist_fields(){
	global $post;
	foreach($_POST as $k => $v) {
		update_post_meta($post->ID, $k, $v);
	}
}