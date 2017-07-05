<?php

// exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit;


// check if class already exists
if( !class_exists('acf_field_button') ) :


class acf_field_button extends acf_field {
	
	
	/*
	*  __construct
	*
	*  This function will setup the field type data
	*
	*  @type	function
	*  @date	5/09/2016
	*  @since	5.0.0
	*
	*  @param	n/a
	*  @return	n/a
	*/
	
	function __construct( $settings ) {
		
		/*
		*  name (string) Single word, no spaces. Underscores allowed
		*/
		
		$this->name = 'button';
		
		
		/*
		*  label (string) Multiple words, can include spaces, visible when selecting a field type
		*/
		
		$this->label = __('Button', 'acf-button');
		
		
		/*
		*  category (string) basic | content | choice | relational | jquery | layout | CUSTOM GROUP NAME
		*/
		
		$this->category = 'basic';
		
		
		/*
		*  defaults (array) Array of default settings which are merged into the field object. These are used later in settings
		*/
		
		$this->defaults = array(
			'default_text'	=> '',
			'default_url'	=> '',
			'allow_advanced'=> array(
				'type', 'target', 'color'
			),
			'default_target'=> '',
			'default_color'	=> 'primary',
			'default_size'	=> '',
			'default_style'	=> '',
			'default_type'	=> 'page'
		);
		
		
		/*
		*  l10n (array) Array of strings that are used in JavaScript. This allows JS strings to be translated in PHP and loaded via:
		*  var message = acf._e('button', 'error');
		*/
		
		$this->l10n = array(
			'error'	=> __('Error! Please enter a higher value', 'acf-button'),
		);
		
		
		/*
		*  settings (array) Store plugin settings (url, path, version) as a reference for later use with assets
		*/
		
		$this->settings = $settings;
		

		// do not delete!
    	parent::__construct();
    	
	}
	
	
	/*
	*  render_field_settings()
	*
	*  Create extra settings for your field. These are visible when editing a field
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$field (array) the $field being edited
	*  @return	n/a
	*/
	
	function render_field_settings( $field ) {
		
		/*
		*  acf_render_field_setting
		*
		*  This function will create a setting for your field. Simply pass the $field parameter and an array of field settings.
		*  The array of settings does not require a `value` or `prefix`; These settings are found from the $field array.
		*
		*  More than one setting can be added by copy/paste the above code.
		*  Please note that you must also have a matching $defaults value for the field name (font_size)
		*/
		
		acf_render_field_setting( $field, array(
			'label'			=> __('Allow Advanced Options','acf-button'),
			'instructions'	=> __('Display advanced button options (size, color, style and target)','acf-button'),
			'type'			=> 'checkbox',
			'name'			=> 'allow_advanced',
			'choices'		=> array(
				'type'		=> __("Type",'acf-button'),
				'target'	=> __("Target",'acf-button'),
				'color'		=> __("Color",'acf-button'),
				'size'		=> __("Size",'acf-button'),
				'style'		=> __("Style",'acf-button'),
				'class'		=> __("Class",'acf-button'),
			)
		));
		
		acf_render_field_setting( $field, array(
			'label'			=> __('Default Button Text','acf-button'),
			// 'instructions'	=> __('Set default button text when creating a new button','acf-button'),
			'type'			=> 'text',
			'name'			=> 'default_text'
		));
		
		acf_render_field_setting( $field, array(
			'label'			=> __('Default Button URL','acf-button'),
			// 'instructions'	=> __('Appears when creating a new button','acf-button'),
			'type'			=> 'url',
			'name'			=> 'default_url'
		));

		acf_render_field_setting( $field, array(
			'label'			=> __('Set default target','acf-button'),
			// 'instructions'	=> __('Set default button target when creating a new button.','acf-button'),
			'type'			=> 'select',
			'name'			=> 'default_target',
			'choices'		=> array(
				''				=> __("Same Window",'acf-button'),
				'_blank'		=> __("New Window",'acf-button'),
			)
		));

		acf_render_field_setting( $field, array(
			'label'			=> __('Default Color','acf-button'),
			// 'instructions'	=> __('Set the default button color when creating a new button.','acf-button'),
			'type'			=> 'select',
			'name'			=> 'default_color',
			'choices'		=> array(
				'primary'		=> __("Primary",'acf-button'),
				'secondary'		=> __("Secondary",'acf-button'),
				'success'		=> __("Success",'acf-button'),
				'alert'			=> __("Alert",'acf-button'),
				'warning'		=> __("Warning",'acf-button'),
				'info'			=> __("Info",'acf-button'),
				'disabled'		=> __("Disabled",'acf-button'),
			)
		));

		acf_render_field_setting( $field, array(
			'label'			=> __('Default Size','acf-button'),
			// 'instructions'	=> __('Set the default size when creating a new button.','acf-button'),
			'type'			=> 'select',
			'name'			=> 'default_size',
			'choices'		=> array(
				'tiny'		=> __("Tiny",'acf-button'),
				'small'		=> __("Small",'acf-button'),
				''			=> __("Normal",'acf-button'),
				'large'		=> __("Large",'acf-button'),
				'huge'		=> __("Huge",'acf-button'),
			)
		));

		acf_render_field_setting( $field, array(
			'label'			=> __('Default Style','acf-button'),
			// 'instructions'	=> __('Set the default size when creating a new button.','acf-button'),
			'type'			=> 'select',
			'name'			=> 'default_style',
			'choices'		=> array(
				''			=> __("Normal",'acf-button'),
				'expanded'	=> __("Expanded",'acf-button'),
				'hollow'	=> __("Hollow",'acf-button'),
				'round'		=> __("Round",'acf-button'),
				'radius'	=> __("Radius",'acf-button')
			)
		));

		$type_choices = array(
				'custom'	=> __("Custom URL",'acf-button'),
				'page'		=> __("Page",'acf-button'),
				'post'		=> __("Post",'acf-button')
		);
		$args = array(
		   'public'   => true,
		   '_builtin' => false
		);
		$ignore = array(
			'page',
			'post',
			'attachment',
			'acf-field', 
			'acf-field-group'
		);
		$cpts = get_post_types($args, 'objects');
		if ( $cpts ) { 
			foreach($cpts as $cpt) {
				$name = $cpt->name;
				$label = $cpt->label;
				$type_choices[$name] = $label;
			}
		}

		acf_render_field_setting( $field, array(
			'label'			=> __('Default Type','acf-button'),
			// 'instructions'	=> __('Set the default size when creating a new button.','acf-button'),
			'type'			=> 'select',
			'name'			=> 'default_type',
			'choices'		=> $type_choices
		));

	}
	
	
	
	/*
	*  render_field()
	*
	*  Create the HTML interface for your field
	*
	*  @param	$field (array) the $field being rendered
	*
	*  @type	action
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$field (array) the $field being edited
	*  @return	n/a
	*/
	
	function render_field( $field ) {
		
		$field = array_merge($this->defaults, $field); 


		/*
		*  Review the data of $field.
		*  This will show what data is available
		*/
		
		// echo '<pre>';
		// 	print_r( $field );
		// echo '</pre>';
		
		
		//set defaults if values do not yet exist
		if ( !isset( $field['value']['text'] ) ) {
			if ( isset( $field['default_text'] ) ) {
				$field['value']['text'] = $field['default_text'];
			} else {
				$field['value']['text'] = '';
			}
		}
		if ( !isset( $field['value']['page'] ) ) {
			$field['value']['page'] = '';
		}
		if ( !isset( $field['value']['post'] ) ) {
			$field['value']['post'] = '';
		}
		if ( !isset( $field['value']['media'] ) ) {
			$field['value']['media'] = '';
		}
		if ( !isset( $field['value']['url'] ) ) {
			if ( isset( $field['default_url'] ) ) {
				$field['value']['url'] = $field['default_url'];
			} else {
				$field['value']['url'] = '';
			}
		}
		if ( !isset( $field['value']['target'] ) ) {
			if ( isset( $field['default_target'] ) ) {
				$field['value']['target'] = $field['default_target'];
			} else {
				$field['value']['target'] = '';
			}
		}
		if ( !isset( $field['value']['color'] ) ) {
			if ( isset( $field['default_color'] ) ) {
				$field['value']['color'] = $field['default_color'];
			} else {
				$field['value']['color'] = '';
			}
		}
		if ( !isset( $field['value']['size'] ) ) {
			if ( isset( $field['default_size'] ) ) {
				$field['value']['size'] = $field['default_size'];
			} else {
				$field['value']['size'] = '';
			}
		}
		if ( !isset( $field['value']['style'] ) ) {
			if ( isset( $field['default_style'] ) ) {
				$field['value']['style'] = $field['default_style'];
			} else {
				$field['value']['style'] = '';
			}
		}
		if ( !isset( $field['value']['class'] ) ) {
			$field['value']['class'] = '';
		}
		if ( !isset( $field['value']['page_link'] ) ) {
			$field['value']['page_link'] = '';
		}
		if ( !isset( $field['value']['type'] ) ) {
			if ( isset( $field['default_type'] ) ) {
				$field['value']['type'] = $field['default_type'];
			} else {
				$field['value']['type'] = 'page';
			}
		}
		
		?>
		<style>
			.acf-field .acf-label label[for="acf-<?php echo esc_attr($field['key']); ?>"] { display: none; }
			.acf-field .acf-input fieldset.acf-button {
				border: 1px solid #eee;
				padding: .5rem 1rem 1rem;
			}
			.acf-button .acf-label {
				margin-bottom: 5px;
			}
			.acf-button-subfield {
				margin-top: 10px;
			}
			.acf-button .acf-input input {
				line-height: 18px;
			}
		</style>
		<fieldset class="acf-button" id="acf-<?php echo esc_attr($field['key']); ?>" data-key="<?php echo esc_attr($field['key']); ?>">
			
			<legend><?php echo esc_attr($field['label']); ?></legend>
		

		<div class="acf-button-subfield acf-button-text">
			<div class="acf-label">
				<label for="<?php echo esc_attr($field['key']); ?>_text">Text</label>
			</div>
			<div class="acf-input">
				<input  type="text" 
						name="<?php echo esc_attr($field['name']); ?>[text]"
						id="<?php echo esc_attr($field['key']); ?>_text" 
						value="<?php echo esc_attr($field['value']['text']); ?>" 
				/>
			</div>
		</div>
		
		
		<?php if ( in_array('type', $field['allow_advanced'] ) ) { ?>

		<?php } else { ?>
			<style>
				#acf-<?php echo esc_attr($field['key']); ?> .acf-button-subfield.acf-button-type {
					display: none;
				}
			</style>
		<?php } ?>

		<div class="acf-button-subfield acf-button-type">
			<div class="acf-label">
				<label for="<?php echo esc_attr($field['key']); ?>_type">Link Type</label>
				<p class="description">What type of link will be attached to the button? Either a custom url (used for external links) or an internal url where a content type needs to be declared.</p>
			</div>
			<div class="acf-input">
				<?php 

					$selected = $field['value']['type'];
					$args = array(
					   'public'   => true,
					   // '_builtin' => false
					);
					$ignore = array(
						'page',
						'post',
						'attachment',
						'acf-field', 
						'acf-field-group'
					);
					$cpts = get_post_types($args, 'objects');
					if ( $cpts ) { ?>
						<select 
							name="<?php echo esc_attr($field['name']); ?>[type]"
							id="<?php echo esc_attr($field['key']); ?>_type"
						>
							<option value="post" <?php if ( $selected == 'post' ) echo 'selected'; ?>>Post</option>
							<option value="custom" <?php if ( $selected == 'custom' ) echo 'selected'; ?>>External/Custom URL</option>
							<option value="post" <?php if ( $selected != 'custom' ) echo 'selected'; ?>>Select Internal Post</option>
							<optgroup label="Custom Post Types">
							<?php foreach($cpts as $cpt) {
								if ( !in_array( $cpt->name, $ignore ) ) { //exclude the field type of ACF ?>
									<option value="<?php echo $cpt->name; ?>" <?php if ($selected == $cpt->name) echo 'selected'; ?>><?php echo $cpt->label; ?></option>
								<?php }
							}?>
							</optgroup>
						</select>
					<?php } ?>
			</div>
		</div>

		<div class="acf-button-subfield acf-button-post acf-button-link">
			<div class="acf-label">
				<label for="<?php echo esc_attr($field['key']); ?>_post">Post Link</label>
			</div>
			<div class="acf-input">
				<?php 
				$selected = esc_attr($field['value']['post']);

				// query arguments
				$args = array (
					'post_type'              => 'post',
					'posts_per_page'         => '-1',
					'order'                  => 'ASC',
					'orderby'                => 'title',
				);
				$posts = get_posts( $args );

				?>
				<select 
						name="<?php echo esc_attr($field['name']) ?>[post]"
						id="<?php echo esc_attr($field['key']) ?>_post"
				>
				<?php	foreach ( $posts as $post ) {
						setup_postdata( $post );
						
						$this_id = get_the_id();
						$this_title = get_the_title();
						?>
						<option value="<?php echo $this_id; ?>" <?php if ( $field['value']['post'] == $this_id ) echo 'selected'; ?>><?php echo $this_title; ?></option>
						<?php
					} ?>

				</select>
			</div>
		</div>
		
		<div class="acf-button-subfield acf-button-page acf-button-link">
			<div class="acf-label">
				<label for="<?php echo esc_attr($field['key']) ?>_page">Page Link</label>
			</div>
			<div class="acf-input">
				<?php 
					$selected = esc_attr($field['value']['page']);
					wp_dropdown_pages( array(
							'name'	=> esc_attr($field['name']).'[page]',
							'id'	=> esc_attr($field['key']).'_page',
							'selected' => $selected,
						    'post_type' => 'page',
						    // 'show_option_none' => '-- Custom -- Enter URL',
						)
					); ?>
			</div>
		</div>

		<?php 
		//loop through cpts and print out a select to link to content.
		if ( $cpts ) {
			foreach($cpts as $cpt) {
				if ( !in_array( $cpt->name, $ignore ) ) { //exclude the field type of ACF
					if ( !isset($field['value'][$cpt->name]) ) {
						$field['value'][$cpt->name] = '';
					} ?>
					<div class="acf-button-subfield acf-button-link acf-button-cpt acf-button-<?php echo $cpt->name; ?>">
						<div class="acf-label">
							<label for="<?php echo esc_attr($field['key']) ?>_<?php echo $cpt->name; ?>"><?php echo $cpt->label; ?> Link</label>
						</div>
						<div class="acf-input">
							<?php 
							$selected = $field['value'][$cpt->name];

							// query arguments
							$args = array (
								'post_type'              => $cpt->name,
								'posts_per_page'         => '-1',
								'order'                  => 'ASC',
								'orderby'                => 'title',
							);

							// The Query
							$posts = get_posts( $args );
							?>
							<select 
									name="<?php echo esc_attr($field['name']) ?>[<?php echo $cpt->name; ?>]"
									id="<?php echo esc_attr($field['key']) ?>_<?php echo $cpt->name; ?>"
							>
								<?php foreach ( $posts as $post ) {
									setup_postdata( $post );
									$this_id = get_the_id();
									$this_title = get_the_title();
									?>
									<option value="<?php echo $this_id; ?>" <?php if ( $field['value'][$cpt->name] == $this_id ) echo 'selected'; ?>><?php echo $this_title; ?></option>
									<?php
								} ?>
							</select>
						</div>
					</div><?php
				}
			}
		}
		?>

		<div class="acf-button-subfield acf-button-link acf-button-url">
			<div class="acf-label">
				<label for="<?php echo esc_attr($field['key']) ?>_url">URL</label>
			</div>
			<div class="acf-input">
				<input  type="url" 
					name="<?php echo esc_attr($field['name']) ?>[url]" 
					id="<?php echo esc_attr($field['key']) ?>_url" 
					value="<?php echo esc_attr($field['value']['url']) ?>" 
				/>
			</div>
		</div>

		<?php if ( in_array('color', $field['allow_advanced'] ) ) { ?>

			<div class="acf-button-subfield acf-button-color">
				<div class="acf-label">
					<label for="<?php echo esc_attr($field['key']) ?>_color">Color</label>
				</div>
				<div class="acf-input">
					<select 
							name="<?php echo esc_attr($field['name']) ?>[color]"
							id="<?php echo esc_attr($field['key']) ?>_color"
					>
						<option value="primary" <?php if ( $field['value']['color'] == 'primary' ) echo 'selected'; 
							?>>Primary</option>
						<option value="secondary" <?php if ( $field['value']['color'] == 'secondary' ) echo 'selected'; 
							?>>Secondary</option>
						<option value="success" <?php if ( $field['value']['color'] == 'success' ) echo 'selected'; 
							?>>Success</option>
						<option value="alert" <?php if ( $field['value']['color'] == 'alert' ) echo 'selected'; 
							?>>Alert</option>
						<option value="info" <?php if ( $field['value']['color'] == 'info' ) echo 'selected'; 
							?>>Info</option>
						<option value="warning" <?php if ( $field['value']['color'] == 'warning' ) echo 'selected'; 
							?>>Warning</option>
						<option value="disabled" <?php if ( $field['value']['color'] == 'disabled' ) echo 'selected'; 
							?>>Disabled</option>
					</select>
				</div>
			</div>

		<?php } else { ?>
			<input type="hidden" name="<?php echo esc_attr($field['name']) ?>[color]" value="<?php echo esc_attr($field['value']['color']); ?>" />

		<?php } if ( in_array('size', $field['allow_advanced'] ) ) { ?>

			<div class="acf-button-subfield acf-button-size">
				<div class="acf-label">
					<label for="<?php echo esc_attr($field['name']) ?>[size]">Size</label>
				</div>
				<div class="acf-input">
					<select 
							name="<?php echo esc_attr($field['name']) ?>[size]"
							id="<?php echo esc_attr($field['name']) ?>[size]"
					>
						<option value="tiny" <?php if ( $field['value']['size'] == 'tiny' ) echo 'selected'; 
							?>>Tiny</option>
						<option value="small" <?php if ( $field['value']['size'] == 'small' ) echo 'selected'; 
							?>>Small</option>
						<option value="" <?php if ( $field['value']['size'] == '' ) echo 'selected'; 
							?>>Normal</option>
						<option value="large" <?php if ( $field['value']['size'] == 'large' ) echo 'selected'; 
							?>>Large</option>
						<option value="huge" <?php if ( $field['value']['size'] == 'huge' ) echo 'selected'; 
							?>>Huge</option>
					</select>
				</div>
			</div>

		<?php } else { ?>
			<input type="hidden" name="<?php echo esc_attr($field['name']) ?>[size]" value="<?php echo esc_attr($field['value']['size']); ?>" />

		<?php } if ( in_array('style', $field['allow_advanced'] ) ) { ?>

			<div class="acf-button-subfield acf-button-style">
				<div class="acf-label">
					<label for="<?php echo esc_attr($field['name']) ?>[style]">Style</label>
				</div>
				<div class="acf-input">
					<select
							name="<?php echo esc_attr($field['name']) ?>[style]"
							id="<?php echo esc_attr($field['name']) ?>[style]"
					>
						<option value="" <?php if ( $field['value']['style'] == '' ) echo 'selected'; 
							?>>Normal</option>
						<option value="extended" <?php if ( $field['value']['style'] == 'extended' ) echo 'selected'; 
							?>>Extended</option>
						<option value="hollow" <?php if ( $field['value']['style'] == 'hollow' ) echo 'selected'; 
							?>>Hollow</option>
						<option value="round" <?php if ( $field['value']['style'] == 'round' ) echo 'selected'; 
							?>>Round</option>
						<option value="radius" <?php if ( $field['value']['style'] == 'radius' ) echo 'selected'; 
							?>>Radius</option>
					</select>
				</div>
			</div>

		<?php } else { ?>
			<input type="hidden" name="<?php echo esc_attr($field['name']) ?>[style]" value="<?php echo esc_attr($field['value']['style']); ?>" />

		<?php } if ( in_array('target', $field['allow_advanced'] ) ) { ?>
			
			<div class="acf-button-subfield acf-button-target">
				<div class="acf-label">
					<label for="<?php echo esc_attr($field['name']) ?>[target]">Target</label>
					<p class="description">Open this button link in the same window (tab) or open a new one? Internal links usually open in the same window, while external links externally.</p>
				</div>
				<div class="acf-input">
					<select 
							name="<?php echo esc_attr($field['name']) ?>[target]"
							id="<?php echo esc_attr($field['name']) ?>[target]"
					>
						<option value="">Open in same window</option>
						<option value="_blank" <?php if ( $field['value']['target'] == '_blank' ) echo 'selected'; 
							?>>Open in new window (target="_blank")</option>
					</select>
				</div>

			</div>

		<?php } else { ?>
			<input type="hidden" name="<?php echo esc_attr($field['name']) ?>[target]" value="<?php echo esc_attr($field['value']['target']); ?>" />
		
		<?php } if ( in_array('class', $field['allow_advanced'] ) ) { ?>

			<div class="acf-button-subfield acf-button-class">
				<div class="acf-label">
					<label for="<?php echo esc_attr($field['name']) ?>[class]">Custom Class(es)</label>
				</div>
				<div class="acf-input">
					<input  type="text" 
							name="<?php echo esc_attr($field['name']) ?>[class]" 
							id="<?php echo esc_attr($field['name']) ?>[class]" 
							value="<?php echo esc_attr($field['value']['class']) ?>" 
					/>
				</div>
			</div>

		<?php } ?>

		</fieldset>
		<?php


	}
	
		
	/*
	*  input_admin_enqueue_scripts()
	*
	*  This action is called in the admin_enqueue_scripts action on the edit screen where your field is created.
	*  Use this action to add CSS + JavaScript to assist your render_field() action.
	*
	*  @type	action (admin_enqueue_scripts)
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	n/a
	*  @return	n/a
	*/

	
	
	function input_admin_enqueue_scripts() {
		
		// vars
		$url = $this->settings['url'];
		$version = $this->settings['version'];
		
		
		// register & include JS
		wp_register_script( 'acf-input-button', "{$url}assets/js/input.js", array('acf-input'), $version );
		wp_enqueue_script('acf-input-button');
		
		
		// register & include CSS
		wp_register_style( 'acf-input-button', "{$url}assets/css/input.css", array('acf-input'), $version );
		wp_enqueue_style('acf-input-button');
		
	}
	
	
	
	
	/*
	*  input_admin_head()
	*
	*  This action is called in the admin_head action on the edit screen where your field is created.
	*  Use this action to add CSS and JavaScript to assist your render_field() action.
	*
	*  @type	action (admin_head)
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	n/a
	*  @return	n/a
	*/

	/*
		
	function input_admin_head() {
	
		
		
	}
	
	*/
	
	
	/*
   	*  input_form_data()
   	*
   	*  This function is called once on the 'input' page between the head and footer
   	*  There are 2 situations where ACF did not load during the 'acf/input_admin_enqueue_scripts' and 
   	*  'acf/input_admin_head' actions because ACF did not know it was going to be used. These situations are
   	*  seen on comments / user edit forms on the front end. This function will always be called, and includes
   	*  $args that related to the current screen such as $args['post_id']
   	*
   	*  @type	function
   	*  @date	6/03/2014
   	*  @since	5.0.0
   	*
   	*  @param	$args (array)
   	*  @return	n/a
   	*/
   	
   	/*
   	
   	function input_form_data( $args ) {
	   	
		
	
   	}
   	
   	*/
	
	
	/*
	*  input_admin_footer()
	*
	*  This action is called in the admin_footer action on the edit screen where your field is created.
	*  Use this action to add CSS and JavaScript to assist your render_field() action.
	*
	*  @type	action (admin_footer)
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	n/a
	*  @return	n/a
	*/

	/*
		
	function input_admin_footer() {
	
		
		
	}
	
	*/
	
	
	/*
	*  field_group_admin_enqueue_scripts()
	*
	*  This action is called in the admin_enqueue_scripts action on the edit screen where your field is edited.
	*  Use this action to add CSS + JavaScript to assist your render_field_options() action.
	*
	*  @type	action (admin_enqueue_scripts)
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	n/a
	*  @return	n/a
	*/

	/*
	
	function field_group_admin_enqueue_scripts() {
		
	}
	
	*/

	
	/*
	*  field_group_admin_head()
	*
	*  This action is called in the admin_head action on the edit screen where your field is edited.
	*  Use this action to add CSS and JavaScript to assist your render_field_options() action.
	*
	*  @type	action (admin_head)
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	n/a
	*  @return	n/a
	*/

	/*
	
	function field_group_admin_head() {
	
	}
	
	*/


	/*
	*  load_value()
	*
	*  This filter is applied to the $value after it is loaded from the db
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value (mixed) the value found in the database
	*  @param	$post_id (mixed) the $post_id from which the value was loaded
	*  @param	$field (array) the field array holding all the field options
	*  @return	$value
	*/
	
	/*
	
	function load_value( $value, $post_id, $field ) {
		
		return $value;
		
	}
	
	*/
	
	
	/*
	*  update_value()
	*
	*  This filter is applied to the $value before it is saved in the db
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value (mixed) the value found in the database
	*  @param	$post_id (mixed) the $post_id from which the value was loaded
	*  @param	$field (array) the field array holding all the field options
	*  @return	$value
	*/
	
	/*
	
	function update_value( $value, $post_id, $field ) {
		
		return $value;
		
	}
	
	*/
	
	
	/*
	*  format_value()
	*
	*  This filter is appied to the $value after it is loaded from the db and before it is returned to the template
	*
	*  @type	filter
	*  @since	3.6
	*  @date	23/01/13
	*
	*  @param	$value (mixed) the value which was loaded from the database
	*  @param	$post_id (mixed) the $post_id from which the value was loaded
	*  @param	$field (array) the field array holding all the field options
	*
	*  @return	$value (mixed) the modified value
	*/
		
	
	function format_value( $value, $post_id, $field ) {
		
		// bail early if no value
		if( empty($value) || 
			$value['text'] === '' ) {
		
			return;
		}
		
		//set defaults
		$url = '';
		$target = '';
		$class = 'button';
		//get url - if url exists use it, if not use the page id to get permalink.
		if ( $value['type'] == 'custom' ) {
			$url = $value['url'];
		} else {
			$type = $value['type'];
			$url = get_permalink( $value[$type] );
		} 

		//get target
		if ( isset($value['target']) &&
			$value['target'] === '_blank' ) {
			$target = ' target="_blank" ';
		}

		//append size classes
		if ( isset($value['size']) ) {
			$class .= ' ' . $value['size'];
		}

		//append color classes
		if ( isset($value['color']) ) {
			$class .= ' ' . $value['color'];
		}

		//append style classes
		if ( isset($value['style']) ) {
			$class .= ' ' . $value['style'];
		}

		//append custom classes
		if ( isset($value['class']) ) {
			$class .= ' ' . $value['class'];
		}
		
		$value = '<a href="' . $url . '" class="' . $class . '"' . $target . '>' . $value['text'] . '</a>';
		
		
		
		// return
		return $value;
	}
	
	
	
	/*
	*  validate_value()
	*
	*  This filter is used to perform validation on the value prior to saving.
	*  All values are validated regardless of the field's required setting. This allows you to validate and return
	*  messages to the user if the value is not correct
	*
	*  @type	filter
	*  @date	11/02/2014
	*  @since	5.0.0
	*
	*  @param	$valid (boolean) validation status based on the value and the field's required setting
	*  @param	$value (mixed) the $_POST value
	*  @param	$field (array) the field array holding all the field options
	*  @param	$input (string) the corresponding input name for $_POST value
	*  @return	$valid
	*/
	
	/*
	
	function validate_value( $valid, $value, $field, $input ){
		
		// Basic usage
		if( $value < $field['custom_minimum_setting'] )
		{
			$valid = false;
		}
		
		
		// Advanced usage
		if( $value < $field['custom_minimum_setting'] )
		{
			$valid = __('The value is too little!','acf-button'),
		}
		
		
		// return
		return $valid;
		
	}
	
	*/
	
	
	/*
	*  delete_value()
	*
	*  This action is fired after a value has been deleted from the db.
	*  Please note that saving a blank value is treated as an update, not a delete
	*
	*  @type	action
	*  @date	6/03/2014
	*  @since	5.0.0
	*
	*  @param	$post_id (mixed) the $post_id from which the value was deleted
	*  @param	$key (string) the $meta_key which the value was deleted
	*  @return	n/a
	*/
	
	/*
	
	function delete_value( $post_id, $key ) {
		
		
		
	}
	
	*/
	
	
	/*
	*  load_field()
	*
	*  This filter is applied to the $field after it is loaded from the database
	*
	*  @type	filter
	*  @date	23/01/2013
	*  @since	3.6.0	
	*
	*  @param	$field (array) the field array holding all the field options
	*  @return	$field
	*/
	
	/*
	
	function load_field( $field ) {
		
		return $field;
		
	}	
	
	*/
	
	
	/*
	*  update_field()
	*
	*  This filter is applied to the $field before it is saved to the database
	*
	*  @type	filter
	*  @date	23/01/2013
	*  @since	3.6.0
	*
	*  @param	$field (array) the field array holding all the field options
	*  @return	$field
	*/
	
	/*
	
	function update_field( $field ) {
		
		return $field;
		
	}	
	
	*/
	
	
	/*
	*  delete_field()
	*
	*  This action is fired after a field is deleted from the database
	*
	*  @type	action
	*  @date	11/02/2014
	*  @since	5.0.0
	*
	*  @param	$field (array) the field array holding all the field options
	*  @return	n/a
	*/
	
	/*
	
	function delete_field( $field ) {
		
		
		
	}	
	
	*/
	
	
}


// initialize
new acf_field_button( $this->settings );


// class_exists check
endif;

?>