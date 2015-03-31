<?php
/**
 *
 */
class itOptionGenerator {
	
	private $saved_options;
	private $saved_internal;
	private $saved_sidebars;	
	
	function __construct( $options ) {
		
		$this->saved_options();
		
		$out = '<div id="it_admin_panel">';
		$out .= '<form name="it_admin_form" method="post" action="options.php" id="it_admin_form">';
		
		$out .= $this->settings_fields();
		$out .= '<input type="hidden" name="it_full_submit" value="0" id="it_full_submit" />';
		$out .= '<input type="hidden" name="it_admin_wpnonce" value="' . wp_create_nonce( IT_SETTINGS . '_wpnonce' ) . '" />';
		
		$out .= '<div id="it_header">';
		
		$out .= '<div id="it_logo"><img src="' . ( !empty( $this->saved_options['admin_logo_url'] ) ? esc_url( $this->saved_options['admin_logo_url'] ) :
		esc_url( THEME_ADMIN_ASSETS_URI ) . '/images/logo.png' ) . '" alt="" /></div>';
		
		$out .= '<div id="header_links">';
		$out .= '<span>' . THEME_NAME . ' ' . THEME_VERSION . '</span>';
		$out .= '<a href="' . DOCUMENTATION_URL . '" target="_blank">' . __( 'Documentation', IT_TEXTDOMAIN ) . '</a>';
		$out .= '<a href="' . SUPPORT_URL . '" target="_blank">' . __( 'Support Portal', IT_TEXTDOMAIN ) . '</a>';
		$out .= '<a href="' . CREDITS_URL . '" target="_blank">' . __( 'Credits', IT_TEXTDOMAIN ) . '</a>';
		$out .= '</div><!-- #header_links -->';
		$out .= '</div><!-- #it_header -->';
		
		$out .= '<div id="it_body">';
		
		foreach( $options as $option )
			$out .= $this->$option['type']( $option );

		$out .= '</div><!-- #it_tab_content -->';
		$out .= '<div class="clear"></div>';
		$out .= '</div><!-- #it_body -->';
		
		$out .= '<div id="it_footer">';
		
		$out .= '<input type="submit" name="' . IT_SETTINGS . '[reset]" value="' . esc_attr__( 'Reset' , IT_TEXTDOMAIN ) . '" class="button-primary it_reset_button" />';
		$out .= '<input type="submit" name="' . IT_SETTINGS . '[load_demo]" value="' . esc_attr__( 'Load Demo Settings' , IT_TEXTDOMAIN ) . '" class="button-primary it_demo_button" />';
		#$out .= '<input type="submit" name="submit" value="' . esc_attr__( 'Save' , IT_TEXTDOMAIN ) . '" class="button-primary it_footer_submit" />';
		
		$out .= '</div><!-- #it_footer -->';
		
		$out .= '</form><!-- #it_admin_form -->';
		
		$out .= '</div><!-- #it_admin_panel -->';
		
		echo $out;
	}
	
	/**
	 *
	 */
	function saved_options() {
		$this->saved_options = get_option( IT_SETTINGS );
		$this->saved_internal = get_option( IT_INTERNAL_SETTINGS );
		$this->saved_sidebars = get_option( IT_SIDEBARS );
	}
	
	/**
	 *
	 */
	function messages() {
		$message = '';
		
		if( isset( $_GET['reset'] ) )
			$message = __( 'All options and widgets successfully restored to default.', IT_TEXTDOMAIN );
			
		if( isset( $_GET['demo'] ) )
			$message = __( 'All demo options, widgets, and menus successfully imported.', IT_TEXTDOMAIN );
			
		if( isset( $_GET['settings-updated'] ) )
			$message = __( 'Settings Saved.', IT_TEXTDOMAIN );
			
		if( isset( $_GET['import'] ) && $_GET['import'] == 'true' )
			$message = __( 'Custom Options Import Successful.', IT_TEXTDOMAIN );
			
		if( isset( $_GET['import'] ) && $_GET['import'] == 'false' )
			$message = __( 'There was an error importing your options, please try again.', IT_TEXTDOMAIN );
			
		$style = ( !$message ) ? ' style="display:none;"' : '';
		
		$out = '<div id="message" class="error fade below-h2"' . $style . '>' . $message . '</div>';
		$out .= '<div id="ajax-feedback"><span class="theme-icon-spin2"></span></div>';
		
		return $out;
	}
	
	/**
	 * 
	 */
	function settings_fields() {
		ob_start(); settings_fields( IT_SETTINGS ); $out = ob_get_clean();
		return $out;
	}
	
	/**
	 * 
	 */
	function navigation( $value ) {
		$out = '<div id="it_admin_tabs">';
		$out .= '<ul>';
		
		foreach( $value['name'] as $key => $name ) {
			$out .= '<li>';
				$out .= '<a title="' . $name[0] . '" href="#' . $key . '">';
					$out .= '<span class="theme-icon-' . $name[1] . '"></span>';						
				$out .= '</a>';			
			$out .= '</li>';
		}
		$out .= '</ul>';
		$out .= '</div><!-- #it_admin_tabs -->';
		$out .= '<div id="it_tab_content">';
		
		$out .= $this->messages();
		
		$out .= '<div class="it_admin_save"><input type="submit" name="submit" value="' . esc_attr__( 'Save' , IT_TEXTDOMAIN ) . '" class="button-primary" /></div>';
		
		#$out .= '<div class="it_admin_save"><a href=""><span class="theme-icon-floppy"></span></a></div>';
		
		return $out;
	}
	
	/**
	 * 
	 */
	function tab_start( $value ) {
		foreach( $value['name'] as $key => $name ) {
			$out = '<div id="' . $key . '" class="it_tab">';
			$out .= '<div>';
			$out .= '<h2><span class="theme-icon-' . $name[$key][1] . '"></span>' . $name[$key][0] . '</h2>';
			$out .= '</div>';
		}
		
		return $out;
	}
	
	/**
	 * 
	 */
	function tab_end( $value ) {
		$out = '</div>';
		
		return $out;
	}
	
	/**
	 * 
	 */
	function option_start( $value ) {
		$out = '';
		
		if( $value['name'] ) {
			$out .= '<div class="it_option_header">' . $value['name'] . '</div>';
		}
		
		$out .= '<div class="it_option">';
		
		return $out;
	}
	
	/**
	 * 
	 */
	function option_end( $value ) {
		$out = '</div><!-- it_option -->';
		
		if( !empty( $value['desc'] ) ) {
			$out .= '<div class="it_option_help">';
			$out .= '<a href="#"><span class="theme-icon-help-circled"></span></a>';
			$out .= '<div class="it_help_tooltip">' . $value['desc'] . '</div>';
			$out .= '</div>';
		}

		$out .= '<div class="clear"></div>';
		
		return $out;
	}
	
	/**
	 * 
	 */
	function toggle_start( $value ) {
		$toggle_class = ( !empty( $value['toggle_class'] ) ) ? $value['toggle_class'] . ' ' : '';
		
		$out = '<div class="it_option_set toggle_option_set">';
		$out .= '<h3 class="option_toggle ' . $toggle_class . 'trigger"><a href="#">' . str_replace( ' ~', '', $value['name'] ) . ' <span>[+]</span></a></h3>';
		$out .= '<div class="toggle_container" style="display:none;">';
		
		return $out;
	}
	
	/**
	 * 
	 */
	function toggle_end ($value ) {
		$out = '</div></div>';
		
		return $out;
	}
	
	/**
	 * 
	 */
	function heading( $value ) {
		$out = '<h3 class="it_theme_options">'.$value['name'].'</h3>';		
		
		if( !empty( $value['desc'] ) ) {			
			$out .= '<div class="desc it_theme_options">' . $value['desc'] . '</div>';			
		}
		
		return $out;
	}
	
	/**
	 *
	 */
	function text( $value ) {
		$size = isset( $value['size'] ) ? $value['size'] : '10';
		$toggle_class = ( !empty( $value['toggle_class'] ) ) ? $value['toggle_class'] . ' ' : '';
		
		$out = '<div class="' . $toggle_class . 'it_option_set text_option_set">';
		
		$out .= $this->option_start( $value );
		
		$out .= '<input type="text" name="' . IT_SETTINGS . '[' . $value['id'] . ']" id="' . $value['id'] . '" class="it_textfield" value="' .
		( isset( $this->saved_options[$value['id']] ) && isset( $value['htmlentities'] )
		? stripslashes(htmlentities( $this->saved_options[$value['id']], ENT_QUOTES, 'UTF-8' ) ) : ( isset( $this->saved_options[$value['id']] ) && isset( $value['htmlspecialchars'] )
		? stripslashes(htmlspecialchars( $this->saved_options[$value['id']] ) )
		: ( isset( $this->saved_options[$value['id']] ) ? stripslashes( $this->saved_options[$value['id']] ) : ( isset( $value['default'] ) ? $value['default'] : '' ) ) ) ) . '" />';
		
		$out .= $this->option_end( $value );
		
		$out .= '</div><!-- .text_option_set -->';
		
		return $out;
	}
	
	/**
	 *
	 */
	function textarea( $value ) {
		$toggle_class = ( !empty( $value['toggle_class'] ) ) ? $value['toggle_class'] . ' ' : '';
		
		$out = '<div class="' . $toggle_class . 'it_option_set textarea_option_set">';
		
		$out .= $this->option_start( $value );
		
		$out .= '<textarea rows="8" cols="8" name="' . IT_SETTINGS . '[' . $value['id'] . ']" id="' . $value['id'] . '" class="it_textarea">' .
		( isset( $this->saved_options[$value['id']] )
		? stripslashes( $this->saved_options[$value['id']] )
		: ( isset( $value['default'] ) ? $value['default'] : '' ) ) . '</textarea><br />';
		$out .= $this->option_end( $value );
		
		$out .= '</div><!-- .textarea_option_set -->';
		
		return $out;
	}
	
	/**
	 *
	 */
	function select( $value ) {
		$toggle_class = ( !empty( $value['toggle_class'] ) ) ? $value['toggle_class'] . ' ' : '';
		$toggle = ( !empty( $value['toggle'] ) ) ? $value['toggle'] . ' ' : '';
		
		$out = '<div class="' . $toggle_class . 'it_option_set select_option_set">';
		
		$out .= $this->option_start( $value );
		
		$nodisable = '';
		if(array_key_exists('nodisable',$value)) $nodisable = $value['nodisable'];
		
		$target = '';
		if(array_key_exists('target',$value)) $target = $value['target'];
		
		if( isset( $target ) ) {
			if( isset( $value['options'] ) ) {
				$value['options'] = $value['options'] + $this->select_target_options( $target, $nodisable );
			} else {
				$value['options'] = $this->select_target_options( $target, $nodisable );
			}
		}
		
		$out .= '<select name="' . IT_SETTINGS . '[' . $value['id'] . ']" id="' . $value['id'] . '" class="' . $toggle . 'it_select">';
		
		$out .= '<option value="">' . __( 'Choose one...', IT_TEXTDOMAIN ) . '</option>';
		
		if(is_array($value)) {
			if(array_key_exists('options',$value)) {
				foreach( (array)$value['options'] as $key => $option ) {
					if($target=='fonts') {
						$out .= '<option value="' . esc_attr( $key ) . '"';
					} else {
						$out .= '<option value="' . $key . '"';
					}
					if( isset( $this->saved_options[$value['id']] ) ) {
						if($target=='fonts') {
							if( stripslashes($this->saved_options[$value['id']]) == $key ) {
								$out .= ' selected="selected"';
							}
						} else {
							if( $this->saved_options[$value['id']] == $key ) {
								$out .= ' selected="selected"';
							}
						}
						
					} elseif( isset( $value['default'] ) ) {
						if( $value['default'] == $key ) {
							$out .= ' selected="selected"';
						}
					}
					
					$out .= '>' . esc_attr( $option ) . '</option>';
				}
			}
		}
		
		$out .= '</select>';
		
		$out .= $this->option_end( $value );
		
		$out .= '</div><!-- .select_option_set -->';
		
		return $out;
	}
	
	/**
	 *
	 */
	function multidropdown( $value ) {
		$toggle_class = ( !empty( $value['toggle_class'] ) ) ? $value['toggle_class'] . ' ' : '';
		
		$wrapper = isset($value['wrapper']) ? $value['wrapper'] : true;
		
		if($wrapper) $out = '<div class="' . $toggle_class . 'it_option_set multidropdown_option_set">';
		
		$out .= $this->option_start( $value );
		
		if( isset( $value['target'] ) ) {
			if( isset( $value['options'] ) ) {
				$value['options'] = $value['options'] + $this->select_target_options( $value['target'] );
			} else {
				$value['options'] = $this->select_target_options( $value['target'] );
			}
		}

		$selected_keys = ( isset( $this->saved_options[$value['id']] ) ) ? $this->saved_options[$value['id']] : array();
		
		$postid = isset($value['postid']) ? $value['postid'] : '';
		
		$label = isset($value['label']) ? $value['label'] : __('Choose one...', IT_TEXTDOMAIN);
		
		$meta = get_post_meta( $postid, $value['id'], true );
			
		if(unserialize($meta)) $selected_keys = unserialize($meta);
		
		$out .= '<div id="' . IT_SETTINGS . '[' . $value['id'] . ']" class="multidropdown">';
		
		$i = 0;
		foreach( $selected_keys as $selected ) {			
			$out .= '<select name="' . $value['id'] . '_' . $i . '" id="' . $value['id'] . '_' . $i . '" class="it_select multi_select">';
			$out .= '<option value=""> ' . $label . '</option>';
			foreach( $value['options'] as $key => $option ) {
				$out .= '<option value="' . $key . '"';
				if( $selected == $key ) {
					$out .= ' selected="selected"';
				}
				$out .= '>' . esc_attr( $option ) . '</option>';
			}
			$i++;
			$out .= '</select>';
		}
		
		$out .= '<select name="' . $value['id'] . '_' . $i . '" id="' . $value['id'] . '_' . $i . '" class="it_select">';
		$out .= '<option value="">' . $label . '</option>';
		foreach( $value['options'] as $key => $option ) {
			$out .= '<option value="' . $key . '">' . $option . '</option>';
		}
		$out .= '</select></div>';
		
		$out .= $this->option_end( $value );
	
		if($wrapper) $out .= '</div><!-- .multidropdown_option_set -->';
		
		return $out;
	}
	
	/**
	 * 
	 */
	function checkbox( $value ) {
		$toggle_class = ( !empty( $value['toggle_class'] ) ) ? $value['toggle_class'] . ' ' : '';
		$toggle = ( !empty( $value['toggle'] ) ) ? ' class="' . $value['toggle'] . '"' : '';
		
		$out = '<div class="' . $toggle_class . 'it_option_set checkbox_option_set">';
		
		$out .= $this->option_start( $value );
		
		if( isset( $value['target'] ) ) {
			if( isset( $value['options'] ) ) {
				$value['options'] = $value['options'] + $this->select_target_options( $value['target'] );
			} else {
				$value['options'] = $this->select_target_options( $value['target'] );
			}
		}
		
		$i = 0;
		foreach( $value['options'] as $key => $option ) {
			$i++;
			$checked = '';
			if( isset( $this->saved_options[$value['id']] ) ) {
				if( is_array( $this->saved_options[$value['id']] ) ) {
					if( in_array( $key, $this->saved_options[$value['id']] ) ) {
						$checked = ' checked="checked"';
					}
				}
				
			} elseif ( isset( $value['default'] ) ){
				if( is_array( $value['default'] ) ) {
					if( in_array( $key, $value['default'] ) ) {
						$checked = ' checked="checked"';
					}
				}
			}
			
			$out .= '<input type="checkbox" name="' . IT_SETTINGS . '[' . $value['id'] . '][]" value="' . $key . '" id="' . $value['id'] . '-' . $i . '"' . $checked . $toggle . ' />';
			$out .= '<label for="' . $value['id'] . '-' . $i . '">' . esc_html( $option ) . '</label><br />';
		}
		
		$out .= $this->option_end( $value );
		
		$out .= '</div><!-- .checkbox_option_set -->';
		
		return $out;
	}
	
	/**
	 *
	 */
	function awards_meta($value) {
		$out = '';
		
		if( isset( $value['target'] ) ) {
			if( isset( $value['options'] ) ) {
				$value['options'] = $value['options'] + $this->select_target_options( $value['target'] );
			} else {
				$value['options'] = $this->select_target_options( $value['target'] );
			}
		}
		
		$i = 0;
		foreach( $value['options'] as $key => $option ) {
			$i++;
			$checked = '';
			$key = it_get_slug($key,$key);
			if( isset( $this->saved_options[$value['id']] ) ) {
				if( is_array( $this->saved_options[$value['id']] ) ) {
					if( in_array( $key, $this->saved_options[$value['id']] ) ) {
						$checked = ' checked="checked"';
					}
				}
				
			} elseif ( isset( $value['default'] ) ){
				if( is_array( $value['default'] ) ) {
					if( in_array( $key, $value['default'] ) ) {
						$checked = ' checked="checked"';
					}
				}
			}
			
			$out .= '<input type="checkbox" name="' . IT_SETTINGS . '[' . $value['id'] . '][]" value="' . $key . '" id="' . $value['id'] . '-' . $i . '"' . $checked . ' />';
			$out .= '<label for="' . $value['id'] . '-' . $i . '"><span style="width:16px;height:16px;display:inline-block;padding:0px 10px 0px 14px;position:relative;top:4px;"><img src="' . $option['icon'] . '" /></span>' . esc_html( $option['name'] ) . '</label><br />';
		}
		
		return $out;
	}
	
	/**
	 *
	 */
	function reactions_meta($value) {
		$out = '';
		
		if( isset( $value['target'] ) ) {
			if( isset( $value['options'] ) ) {
				$value['options'] = $value['options'] + $this->select_target_options( $value['target'] );
			} else {
				$value['options'] = $this->select_target_options( $value['target'] );
			}
		}
		
		$i = 0;
		foreach( $value['options'] as $key => $option ) {
			$i++;
			$checked = '';
			$key = it_get_slug($key,$key);
			if( isset( $this->saved_options[$value['id']] ) ) {
				if( is_array( $this->saved_options[$value['id']] ) ) {
					if( in_array( $key, $this->saved_options[$value['id']] ) ) {
						$checked = ' checked="checked"';
					}
				}
				
			} elseif ( isset( $value['default'] ) ){
				if( is_array( $value['default'] ) ) {
					if( in_array( $key, $value['default'] ) ) {
						$checked = ' checked="checked"';
					}
				}
			}
			
			$out .= '<input type="checkbox" name="' . IT_SETTINGS . '[' . $value['id'] . '][]" value="' . $key . '" id="' . $value['id'] . '-' . $i . '"' . $checked . ' />';
			$out .= '<label for="' . $value['id'] . '-' . $i . '">' . $option['icon'] . '&nbsp;' . esc_html( stripslashes($option['name']) ) . '</label><br />';
		}
		
		return $out;
	}	
	
	/**
	 * 
	 */
	function radio( $value ) {
		$toggle_class = ( !empty( $value['toggle_class'] ) ) ? $value['toggle_class'] . ' ' : '';
		$toggle = ( !empty( $value['toggle'] ) ) ? ' class="' . $value['toggle'] . '"' : '';
		
		$out = '<div class="' . $toggle_class . 'it_option_set radio_option_set">';
		
		$out .= $this->option_start( $value );
		
		$checked_key = ( isset( $this->saved_options[$value['id']] ) ? $this->saved_options[$value['id']] : ( isset( $value['default'] ) ? $value['default'] : '' ) );
			
		$i = 0;
		foreach( $value['options'] as $key => $option ) {
			$i++;
			$checked = ( $key == $checked_key ) ? ' checked="checked"' : '';
			
			$out .= '<input type="radio" name="' . IT_SETTINGS . '[' . $value['id'] . ']" value="' . $key . '" ' . $checked . ' id="' . $value['id'] . '_' . $i . '"' . $toggle .' />';
			$out .= '<label for="' . $value['id'] . '_' . $i . '">' . $option . '</label><br />';
		}
		
		$out .= $this->option_end( $value );
		
		$out .= '</div><!-- .radio_option_set -->';
		
		return $out;
	}
	
	/**
	 * 
	 */
	function upload( $value ) {
		$out = '<div class="it_option_set upload_option_set">';
		
		$out .= $this->option_start( $value );
		
		$out .= '<input type="text" name="' . IT_SETTINGS . '[' . $value['id'] . ']" value="' . ( isset( $this->saved_options[$value['id']] )
		? esc_url(stripslashes( $this->saved_options[$value['id']] ) )
		: ( isset( $value['default'] ) ? $value['default'] : '' ) ) . '" id="' . $value['id'] . '" class="it_upload" />';
		
		$out .= '<input type="button" value="' . esc_attr__( 'Choose' , IT_TEXTDOMAIN ) . '" class="upload_button button-secondary" id="' . $value['id'] . '_button" name="' . $value['id'] . '_button" /><br />';
		
		$out .= $this->option_end( $value );
		
		$out .= '</div><!-- .upload_option_set -->';
		
		return $out;
	}
	
	/**
	 * 
	 */
	function editor( $value ) {
		global $wp_version, $post, $post_type;
		
		$out = '';
		
		if( !isset( $value['no_header'] ) && isset( $value['name'] ) ) {
			$out .= '<h3 class="editor_option_header">' . $value['name'] . '</h3>';
			$value['name'] = '';
		}
		
		$out .= '<div class="it_option_set editor_option_set">';
		
		$out .= $this->option_start( $value );

		$content = ( isset( $this->saved_options[$value['id']] ) ? stripslashes( $this->saved_options[$value['id']] )
		: ( isset( $value['default'] ) ? $value['default'] : '' ) );
		
		$content_id = IT_SETTINGS . '[' . $value['id'] .']';
		
		if( version_compare( $wp_version, '3.3', '>=' ) ) {
			
			ob_start();
			$args = array("textarea_name" => $content_id, "textarea_rows" => 10);
			wp_editor( $content, $content_id, $args );
			$editor = ob_get_contents();
			ob_end_clean();

			$out .= $editor;
		}
		else
		{
			$out .= '<div id="poststuff"><div id="post-body"><div id="post-body-content"><div class="postarea" id="postdivrich">';
			
			ob_start();
			wp_editor( $content, $content_id );
			$editor = ob_get_contents();
			ob_end_clean();

			$content_replace = IT_SETTINGS . '_' . $value['id'];

			$editor = str_replace( $content_id, $content_replace, $editor );
			$out .= str_replace( 'name=\'' . $content_replace . '\'', 'name=\'' . $content_id . '\'', $editor );
			
			$out .= '</div></div></div></div>';
		}
		
		$out .= $this->option_end( $value );
		
		$out .= '</div><!-- .editor_option_set -->';

		return $out;
	}
	
	/**
	 * 
	 */
	function layout( $value ) {
		$out = '<div class="it_option_set layout_option_set">';
		
		$out .= $this->option_start( $value );
		
		foreach( $value['options'] as $rel => $image ) {
			$out .= '<a href="#" rel="' . $rel . '"><img src="' . esc_url( $image ) . '" alt="" /></a>';
		}
		
		$out .= '<input type="hidden" name="' . IT_SETTINGS . '[' . $value['id'] . ']" id="' . $value['id'] . '" value="' . ( isset( $this->saved_options[$value['id']] )
		? stripslashes( $this->saved_options[$value['id']] )
		: ( isset( $value['default'] ) ? $value['default'] : '' ) ) . '" />';
		
		$out .= $this->option_end( $value );
		
		$out .= '</div><!-- .layout_option_set -->';
		
		return $out;
	}
	
	/**
	 *
	 */
	function color($value) {
		$out = '<div class="it_option_set color_option_set">';
		
		$out .= $this->option_start($value);
		
		$val = ( isset( $this->saved_options[$value['id']] )
		? stripslashes( $this->saved_options[$value['id']] )
		: ( isset( $value['default'] )
		? $value['default'][0]
		: '' ) );
		
		$default = isset($value['default']) ? $value['default'] : '';
		
		$out .= '<input type="text" id="' .$value['id']. '" name="' . IT_SETTINGS . '['.$value['id'].']" value="' .$val. '" class="wp-color-picker" data-default-color="#' . $default . '" />';
		$out .= $this->option_end($value);		
		
		$out .= '</div><!-- color_option_set -->';
		
		return $out;
	}
	
	/**
	 *
	 */
	function export_options( $value ) {
		$toggle_class = ( !empty( $value['toggle_class'] ) ) ? $value['toggle_class'] . ' ' : '';
		
		$out = '<div class="' . $toggle_class . 'it_option_set textarea_option_set">';
		
		$out .= $this->option_start( $value );
		
		$options = $this->saved_options;
		
		$export_options = array();
		if( !empty( $options ) ) {
			foreach( $options as $key => $option ) {
				if( is_string( $option ) )
					$export_options[$key] = preg_replace( "/(\r\n|\r|\n)\s*/i", '<br /><br />', stripslashes( $option ) );
				else
					$export_options[$key] = $option;
			}
		}
		
		if( !empty( $export_options ) ) {
			$export_options = array_merge( $export_options, array( 'it_options_export' => true ) );
			$export_options = it_encode( $export_options, $serialize = true );
		}
					
		$out .= '<textarea rows="8" cols="8" name="' . IT_SETTINGS . '[' . $value['id'] . ']" id="' . $value['id'] . '" class="it_textarea">' . $export_options . '</textarea><br />';
		
		$out .= $this->option_end( $value );
		
		$out .= '</div><!-- .textarea_option_set -->';
		
		return $out;
	}
	
	/**
	 *
	 */
	function sidebar( $value ) {
		$out = '<div class="it_option_set sidebar_option_set">';
		
		$out .= $this->option_start( $value );
		
		$out .= '<input type="text" name="' . $value['id'] . '" id="' . $value['id'] . '" class="sidebar-text" onkeyup="itAdmin.fixField(this);" value="" />';
		
		$out .= '<div class="add_sidebar">';
		$out .= '<span class="button it_add_sidebar">' . __( 'Add Sidebar', IT_TEXTDOMAIN ) . '</span>';
		$out .= '</div><!-- .add_sidebar -->';
		
		$out .= $this->option_end( $value );
		
		$init = ( !empty( $this->saved_sidebars ) ) ? false : true;
		
		$out .= '<div class="clear menu_clear"' . ( $init ? ' style="display:none;"' : '' ) . '></div>';
		
		$out .= '<ul id="sidebar-to-edit" class="menu"' . ( $init ? ' style="display:none;"' : '' ) . '>';
		
		if( !$init ){
			foreach( $this->saved_sidebars as $key => $sidebar ){
				$out .= '<li class="menu-item" id="sidebar-item-' . $key . '">';
				$out .= '<dl class="menu-item-bar">';
				$out .= '<dt class="menu-item-handle">';
				$out .= '<span class="sidebar-title">' . $sidebar . '</span>';
				$out .= '<span class="item-controls"><a href="#" class="item-type delete_sidebar" rel="sidebar-item-' . $key . '">' . __( 'Delete', IT_TEXTDOMAIN ) . '</a></span>';
				$out .= '</dt>';
				$out .= '</dl>';
				$out .= '</li>';
			}
			
		} elseif( $init ) {
			$out .= '<li></li>';
		}
		$out .= '</ul><!-- #sidebar-to-edit -->';
		
		$out .= '<ul id="sample-sidebar-item" class="menu" style="display:none;"> ';
		$out .= '<li class="menu-item" id="sidebar-item-:">';
		$out .= '<dl class="menu-item-bar">';
		$out .= '<dt class="menu-item-handle">';
		$out .= '<span class="sidebar-title">:</span>';
		$out .= '<span class="item-controls"><a href="#" class="item-type delete_sidebar" rel="sidebar-item-:">' . __( 'Delete', IT_TEXTDOMAIN ) . '</a></span>';
		$out .= '</dt>';
		$out .= '</dl>';
		$out .= '</li>';
		$out .= '</ul><!-- #sample-sidebar-item -->';
		
		$out .= '</div><!-- .sidebar_option_set -->';
		
		return $out;
	}
		
	/**
	 *
	 */
	function sociable( $value ) {
		$options = ( isset( $this->saved_options[$value['id']] ) ) ? $this->saved_options[$value['id']] : array( 'keys' => '#' );
		
		$init = false;
		
		if( $options['keys'] == '#' )
			$init = true;
		
		$sociable_keys = explode(',', $options['keys'] );
		
		$key_count = count( $sociable_keys );
					
		$out = '<div class="it_option_set sociable_option_set">';
		$out .= '<div class="add_menu"><span class="button it_add_menu">' . __( 'Add New Social Link', IT_TEXTDOMAIN ) . '</span></div>';
		
		$out .= '<div class="clear menu_clear"' . ( $init == true ? ' style="display:none;"' : '' ) . '></div>';
		
		if( $init == true )
			$out .= '<ul class="menu-to-edit menu" style="display:none;"><li></li></ul><!-- .menu-to-edit -->';
		
		$i=1;
		foreach( $sociable_keys as $key ) {
			if( ( $i == 1 ) && ( $init == false ) )
				$out .= '<ul class="menu-to-edit menu">';

			if ( $i == $key_count )
				$out .= '<ul class="sample-to-edit menu" style="display:none;">';
			
			$id = $key;
			$val = ( ( $id != '#' ) && ( isset( $options[$key] ) ) ) ? $options[$key] : '';
			
			$name = IT_SETTINGS . '[sociable][' . $id . ']';
			$custom = ( !empty( $val['custom'] ) ) ? esc_url(stripslashes( $val['custom'] ) ) : '';
			$link = ( !empty( $val['link'] ) ) ? esc_url(stripslashes( $val['link'] ) ) : '';
			$hover = ( !empty( $val['hover'] ) ) ? $val['hover'] : '';
			$icon = ( !empty( $val['icon'] ) ) ? $val['icon'] : '';
			
			if( !empty( $icon ) ) {				
				$icon_title = ucwords( $icon );
			}
						
			$out .= '<li id="sociable-menu-item-' . $id . '" class="menu-item menu-item-edit-inactive">';
			
			# menu handle
			$out .= '<dl class="menu-item-bar">';
			$out .= '<dt class="menu-item-handle">';
			$out .= '<span class="item-title">' . ( $custom || $id == '#' || empty( $icon ) ? sprintf( __( 'Social Link %1$s', IT_TEXTDOMAIN ), $i ) : $icon_title ) . '</span>';
			$out .= '<span class="item-controls">';
			$out .= '<a href="sociable-menu-item-settings-' . $id .'" title="Edit Menu Item" id="sociable-menu-edit-' . $id . '" class="item-edit">' . __( 'Edit Social Link', IT_TEXTDOMAIN ) . '</a>';
			$out .= '</span>';
			$out .= '</dt>';
			$out .= '</dl>';
			
			# menu settings
			$out .= '<div id="sociable-menu-item-settings-' . $id . '" class="menu-item-settings clearfix" style="display:none;">';
			
			# sociable icon
			$out .= '<p class="field-link-target description description-thin"><label for="edit-menu-sociable-icon-' . $id . '">' . __( 'Preset Icon', IT_TEXTDOMAIN ) . '<br />';
			$out .= '<select id="edit-menu-sociable-icon-' . $id . '" class="widefat" name="' . $name . '[icon]">';
			
			$sociables_icons = it_sociable_option();
			foreach ( $sociables_icons['sociables'] as $key => $val ) {
				
				$selected = ( $icon == $key ) ? ' selected="selected"' : '' ;
				$out .= '<option' . $selected. ' value="' . $key . '">' . $val . '</option>';
			}
			$out .= '</select>';
			$out .= '</label>';
			$out .= '</p>';			
			
			# sociable url
			$out .= '<p class="description description-thin"><label for="edit-sociable-menu-url-' . $id . '">' . __( 'Custom Icon', IT_TEXTDOMAIN ) . '<br />';
			$out .= '<input type="text" value="' . $custom . '" name="' . $name . '[custom]" id="edit-sociable-menu-url-' . $id . '" class="widefat sociable_custom" />';
			$out .= '&nbsp;<input type="button" value="' . esc_attr__( 'Upload' , IT_TEXTDOMAIN ) . '" class="upload_button button-secondary" /><br />';
			$out .= '</label>';
			$out .= '</p>';
			
			# sociable link
			$out .= '<p class="description description-thin"><label for="edit-sociable-menu-link-' .$id. '">' . __( 'Social Link URL', IT_TEXTDOMAIN ) . '<br />';
			$out .= '<input type="text" value="' . $link . '" name="' . $name . '[link]" id="edit-sociable-menu-link-' . $id . '" class="widefat" />';
			$out .= '</label>';
			$out .= '</p>';
			
			# custom hover text
			$out .= '<p class="description description-thin"><label for="edit-sociable-menu-hover-' .$id. '">' . __( 'Custom Hover Text', IT_TEXTDOMAIN ) . '<br />';
			$out .= '<input type="text" value="' . $hover . '" name="' . $name . '[hover]" id="edit-sociable-menu-hover-' . $id . '" class="widefat" />';
			$out .= '</label>';
			$out .= '</p>';
			
			# menu item actions
			$out .= '<div class="menu-item-actions description-wide submitbox">';
			$out .= '<a href="" id="delete-sociable-menu-item-' . $id . '" class="submitdelete slider_deletion">' . __( 'Remove', IT_TEXTDOMAIN ) . '</a> ';
			$out .= '<span class="meta-sep"> | </span> <a href="sociable-menu-item-settings-' . $id .'" class="slider_cancel submitcancel">' . __( 'Cancel', IT_TEXTDOMAIN ) . '</a>';
			$out .= '</div>';
			
			
			$out .= '</div><!-- #sociable-menu-item-settings-## -->';
			$out .= '</li>';
			
			if( $i == $key_count-1 )
				$out .= '</ul><!-- .menu-to-edit -->';
			
			if( $i == $key_count )
				$out .= '</ul><!-- .sample-to-edit -->';
			
			$i++;
		}
		
		$out .= '<input type="hidden" name="' . IT_SETTINGS . '[sociable][keys]" value="' . $options['keys'] . '" class="menu-keys" />';
		$out .= '</div><!-- .sociable_option_set -->';
		
		return $out;
	}
	
	
	function signoff( $value ) {
		error_reporting(E_ALL);
		$options = ( isset( $this->saved_options[$value['id']] ) ) ? $this->saved_options[$value['id']] : array( 'keys' => '#' );
		
		$init = false;
		
		if( $options['keys'] == '#' )
			$init = true;
		
		$signoff_keys = explode(',', $options['keys'] );
		
		$key_count = count( $signoff_keys );
		
		$out = '<div class="it_option_set signoff_option_set">';
		$out .= '<div class="it_option_heading">' . $value['name'] . '</div>';
		$out .= '<div class="add_menu"><span class="button it_add_menu">' . __( 'Add New Signoff', IT_TEXTDOMAIN ) . '</span></div>';		
		
		$out .= '<div class="clear menu_clear"' . ( $init == true ? ' style="display:none;"' : '' ) . '></div>';
		
		if( $init == true )
			$out .= '<ul class="menu-to-edit menu" style="display:none;"><li></li></ul><!-- .menu-to-edit -->';
		
		$i=1;
		foreach( $signoff_keys as $key ) {
			if( ( $i == 1 ) && ( $init == false ) )
				$out .= '<ul class="menu-to-edit menu">';

			if ( $i == $key_count )
				$out .= '<ul class="sample-to-edit menu" style="display:none;">';
			
			$id = $key;
			$val = ( ( $id != '#' ) && ( isset( $options[$key] ) ) ) ? $options[$key] : '';
			
			$name = IT_SETTINGS . '[signoff][' . $id . ']';
			$signoff_name = ( !empty( $val['name'] ) ) ? stripslashes($val['name'])  : '';
			$signoff_content = ( !empty( $val['content'] ) ) ? stripslashes($val['content'])  : '';
			$custom = '';
			
			$out .= '<li id="signoff-menu-item-' . $id . '" class="menu-item menu-item-edit-inactive">';
			
			# menu handle
			$out .= '<dl class="menu-item-bar">';
			$out .= '<dt class="menu-item-handle">';
			$out .= '<span class="item-title">' .( empty($signoff_name) || $id == '#' ? __( 'New Signoff', IT_TEXTDOMAIN ) : $signoff_name ). '</span>';
			$out .= '<span class="item-controls">';
			$out .= '<a href="signoff-menu-item-settings-' . $id .'" title="Edit Signoff" id="signoff-menu-edit-' . $id . '" class="item-edit">' . __( 'Edit Signoff', IT_TEXTDOMAIN ) . '</a>';
			$out .= '</span>';
			$out .= '</dt>';
			$out .= '</dl>';
			
			# menu settings
			$out .= '<div id="signoff-menu-item-settings-' . $id . '" class="menu-item-settings clearfix" style="display:none;">';
			
			# signoff name
			$out .= '<p class="description description-thin"><label for="edit-signoff-menu-name-' .$id. '">' . __( 'Name', IT_TEXTDOMAIN ) . '<br />';
			$out .= '<input type="text" value="' . $signoff_name . '" name="' . $name . '[name]" id="edit-signoff-menu-name-' . $id . '" class="widefat" />';
			$out .= '</label>';			
			$out .= '</p>';	
			
			# signoff content
			$out .= '<p class="description description-wide"><label for="edit-signoff-menu-content-' .$id. '">' . __( 'Content', IT_TEXTDOMAIN ) . '<br />';
			$out .= '<textarea cols="20" rows="7" name="' . $name . '[content]" id="edit-signoff-menu-content-' . $id . '" class="widefat">' . $signoff_content . '</textarea>';
			$out .= '</label>';			
			$out .= '</p>';	
			
			# menu item actions
			$out .= '<div class="menu-item-actions description-wide submitbox">';
			$out .= '<a href="" id="delete-signoff-menu-item-' . $id . '" class="submitdelete slider_deletion">' . __( 'Remove', IT_TEXTDOMAIN ) . '</a> ';
			$out .= '<span class="meta-sep"> | </span> <a href="signoff-menu-item-settings-' . $id .'" class="slider_cancel submitcancel">' . __( 'Cancel', IT_TEXTDOMAIN ) . '</a>';
			$out .= '</div>';
			
			
			$out .= '</div><!-- #signoff-menu-item-settings-## -->';
			$out .= '</li>';
			
			if( $i == $key_count-1 )
				$out .= '</ul><!-- .menu-to-edit -->';
			
			if( $i == $key_count )
				$out .= '</ul><!-- .sample-to-edit -->';
			
			$i++;
		}			
		$out .= '<input type="hidden" name="' . IT_SETTINGS . '[signoff][keys]" value="' . $options['keys'] . '" class="menu-keys" />';
		$out .= '</div><!-- .signoff_option_set -->';
		
		return $out;
	}
	
	function details( $value ) {
		error_reporting(E_ALL);
		$options = ( isset( $this->saved_options[$value['id']] ) ) ? $this->saved_options[$value['id']] : array( 'keys' => '#' );
		
		$init = false;
		
		if( $options['keys'] == '#' )
			$init = true;
		
		$details_keys = explode(',', $options['keys'] );
				
		$key_count = count( $details_keys );
		
		$out = '<div class="it_option_set details_option_set distinct_option_set">';
		$out .= '<div class="it_option_heading">' . $value['name'] . '</div>';
		$out .= '<div class="add_menu"><span class="button it_add_menu">' . __( 'Add New Detail', IT_TEXTDOMAIN ) . '</span></div>';	
		
		if( $init == true )
			$out .= '<ul class="menu-to-edit menu" style="display:none;"><li></li></ul><!-- .menu-to-edit -->';
		
		$i=1;
		foreach( $details_keys as $id ) {
			if( ( $i == 1 ) && ( $init == false ) )
				$out .= '<ul class="menu-to-edit menu">';

			if ( $i == $key_count )
				$out .= '<ul class="sample-to-edit menu" style="display:none;">';			
			
			$val = ( ( $id != '#' ) && ( isset( $options[$id] ) ) ) ? $options[$id] : '';
			
			$name = IT_SETTINGS . '[review_details][' . $id . ']';
			$details_name = ( !empty( $val['name'] ) ) ? stripslashes($val['name'])  : '';
			$slug = '';
			if(is_array($val)) 
				if(array_key_exists('slug',$val)) $slug = $val['slug'];
			$details_slug = it_get_slug($slug, $details_name);
			$custom = '';
			
			$out .= '<li id="details-menu-item-' . $id . '" class="menu-item menu-item-edit-inactive">';
			
			# menu handle
			$out .= '<dl class="menu-item-bar">';
			$out .= '<dt class="menu-item-handle">';
			$out .= '<span class="item-title">' .( empty($details_name) || $id == '#' ? __( 'New Detail', IT_TEXTDOMAIN ) : $details_name ). '</span>';
			$out .= '<span class="item-controls">';
			$out .= '<a href="details-menu-item-settings-' . $id .'" title="Edit Menu Item" id="details-menu-edit-' . $id . '" class="item-edit">' . __( 'Edit Detail', IT_TEXTDOMAIN ) . '</a>';
			$out .= '</span>';
			$out .= '</dt>';
			$out .= '</dl>';
			
			# menu settings
			$out .= '<div id="details-menu-item-settings-' . $id . '" class="menu-item-settings clearfix" style="display:none;">';
			
			# details name
			$out .= '<div class="sub-wrapper">';
			$out .= '<p class="description description-thin"><label for="edit-details-menu-name-' .$id. '">' . __( 'Name', IT_TEXTDOMAIN ) . '<br />';			
			$out .= '<input type="text" value="' . $details_name . '" name="' . $name . '[name]" id="edit-details-menu-name-' . $id . '" class="widefat" />';
			$out .= '</label>';			
			$out .= '</p>';
			$out .= '<div class="it_option_help">';
			$out .= '<a href="#"><span class="theme-icon-help-circled"></span></a>';
			$out .= '<div class="it_help_tooltip">' . __( 'The name of the detail field. This is a way of further describing the article.', IT_TEXTDOMAIN ) . '</div>';
			$out .= '</div>';	
			$out .= '</div>';			
			
			# menu item actions
			$out .= '<div class="menu-item-actions description-wide submitbox">';
			$out .= '<a href="" id="delete-details-menu-item-' . $id . '" class="submitdelete slider_deletion">' . __( 'Remove', IT_TEXTDOMAIN ) . '</a> ';
			$out .= '<span class="meta-sep"> | </span> <a href="details-menu-item-settings-' . $id .'" class="slider_cancel submitcancel">' . __( 'Cancel', IT_TEXTDOMAIN ) . '</a>';
			$out .= '</div>';
			
			
			$out .= '</div><!-- #details-menu-item-settings-## -->';
			$out .= '</li>';
			
			if( $i == $key_count-1 )
				$out .= '</ul><!-- .menu-to-edit -->';
			
			if( $i == $key_count )
				$out .= '</ul><!-- .sample-to-edit -->';
			
			$i++;
		}		
		$out .= '<input type="hidden" name="' . IT_SETTINGS . '[review_details][keys]" value="' . $options['keys'] . '" class="menu-keys" />';
		$out .= '</div><!-- .details_option_set -->';
		
		return $out;
	}
	
	function criteria( $value ) {
		error_reporting(E_ALL);
		$options = ( isset( $this->saved_options[$value['id']] ) ) ? $this->saved_options[$value['id']] : array( 'keys' => '#' );
		
		$init = false;
		
		if( $options['keys'] == '#' )
			$init = true;
		
		$criteria_keys = explode(',', $options['keys'] );
			
		$key_count = count( $criteria_keys );
		
		$out = '<div class="it_option_set criteria_option_set distinct_option_set">';
		$out .= '<div class="it_option_heading">' . $value['name'] . '</div>';
		$out .= '<div class="add_menu"><span class="button it_add_menu">' . __( 'Add New Criteria', IT_TEXTDOMAIN ) . '</span></div>';
		
		if( $init == true )
			$out .= '<ul class="menu-to-edit menu" style="display:none;"><li></li></ul><!-- .menu-to-edit -->';
		
		$i=1;
		foreach( $criteria_keys as $id ) {
			if( ( $i == 1 ) && ( $init == false ) )
				$out .= '<ul class="menu-to-edit menu">';

			if ( $i == $key_count )
				$out .= '<ul class="sample-to-edit menu" style="display:none;">';
			
			$val = ( ( $id != '#' ) && ( isset( $options[$id] ) ) ) ? $options[$id] : '';
			
			$name = IT_SETTINGS . '[review_criteria][' . $id . ']';
			$criteria_name = ( !empty( $val['name'] ) ) ? stripslashes($val['name'])  : '';		
			$criteria_weight = ( !empty( $val['weight'] ) ) ? stripslashes($val['weight'])  : '';
			$custom = '';
			
			$out .= '<li id="criteria-menu-item-' . $id . '" class="menu-item menu-item-edit-inactive">';
			
			# menu handle
			$out .= '<dl class="menu-item-bar">';
			$out .= '<dt class="menu-item-handle">';
			$out .= '<span class="item-title">' .( empty($criteria_name) || $id == '#' ? __( 'New Criteria', IT_TEXTDOMAIN ) : $criteria_name ). '</span>';
			$out .= '<span class="item-controls">';
			$out .= '<a href="criteria-menu-item-settings-' . $id .'" title="Edit Menu Item" id="criteria-menu-edit-' . $id . '" class="item-edit">' . __( 'Edit Criteria', IT_TEXTDOMAIN ) . '</a>';
			$out .= '</span>';
			$out .= '</dt>';
			$out .= '</dl>';
			
			# menu settings
			$out .= '<div id="criteria-menu-item-settings-' . $id . '" class="menu-item-settings clearfix" style="display:none;">';
			
			# criteria name
			$out .= '<p class="description description-thin"><label for="edit-criteria-menu-name-' .$id. '">' . __( 'Name', IT_TEXTDOMAIN ) . '<br />';
			$out .= '<input type="text" value="' . $criteria_name . '" name="' . $name . '[name]" id="edit-criteria-menu-name-' . $id . '" class="widefat" />';
			$out .= '</label>';			
			$out .= '</p>';
			
			# criteria weight
			$out .= '<div class="sub-wrapper">';
			$out .= '<p class="description description-thin"><label for="edit-criteria-menu-slug-' .$id. '">' . __( 'Weight', IT_TEXTDOMAIN ) . '<br />';
			$out .= '<input type="text" value="' . $criteria_weight . '" name="' . $name . '[weight]" id="edit-criteria-menu-slug-' . $id . '" class="criteria_weight" />';
			$out .= '</label>';			
			$out .= '</p>';
			$out .= '<div class="it_option_help">';
			$out .= '<a href="#"><span class="theme-icon-help-circled"></span></a>';
			$out .= '<div class="it_help_tooltip">' . __( 'You can assign weight to your rating criteria to make them more important during the averaging of the total score. You can use any scale you want, such as assigning 1 to regular criteria and 2 to more important criteria, or 100 to regular criteria and 80 to less important criteria. The values can be anything you want because they are relative only to each other. You can leave this field blank to keep all the weights the same.', IT_TEXTDOMAIN ) . '</div>';
			$out .= '</div>';
			$out .= '</div>';
			
			# menu item actions
			$out .= '<div class="menu-item-actions description-wide submitbox">';
			$out .= '<a href="" id="delete-criteria-menu-item-' . $id . '" class="submitdelete slider_deletion">' . __( 'Remove', IT_TEXTDOMAIN ) . '</a> ';
			$out .= '<span class="meta-sep"> | </span> <a href="criteria-menu-item-settings-' . $id .'" class="slider_cancel submitcancel">' . __( 'Cancel', IT_TEXTDOMAIN ) . '</a>';
			$out .= '</div>';
			
			
			$out .= '</div><!-- #criteria-menu-item-settings-## -->';
			$out .= '</li>';
			
			if( $i == $key_count-1 )
				$out .= '</ul><!-- .menu-to-edit -->';
			
			if( $i == $key_count )
				$out .= '</ul><!-- .sample-to-edit -->';
			
			$i++;
		}				
		$out .= '<input type="hidden" name="' . IT_SETTINGS . '[review_criteria][keys]" value="' . $options['keys'] . '" class="menu-keys" />';
		$out .= '</div><!-- .criteria_option_set -->';
		
		return $out;
	}
	
	function awards( $value ) {
		error_reporting(E_ALL);
		$options = ( isset( $this->saved_options[$value['id']] ) ) ? $this->saved_options[$value['id']] : array( 'keys' => '#' );
		
		$init = false;
		
		if( $options['keys'] == '#' )
			$init = true;
		
		$awards_keys = explode(',', $options['keys'] );
			
		$key_count = count( $awards_keys );
		
		$out = '<div class="it_option_set awards_option_set distinct_option_set">';
		$out .= '<div class="it_option_heading">' . $value['name'] . '</div>';
		$out .= '<div class="add_menu"><span class="button it_add_menu">' . __( 'Add New Award', IT_TEXTDOMAIN ) . '</span></div>';
		
		if( $init == true )
			$out .= '<ul class="menu-to-edit menu" style="display:none;"><li></li></ul><!-- .menu-to-edit -->';
		
		$i=1;
		foreach( $awards_keys as $id ) {
			if( ( $i == 1 ) && ( $init == false ) )
				$out .= '<ul class="menu-to-edit menu">';

			if ( $i == $key_count )
				$out .= '<ul class="sample-to-edit menu" style="display:none;">';
				
			$val = ( ( $id != '#' ) && ( isset( $options[$id] ) ) ) ? $options[$id] : '';
			
			$name = IT_SETTINGS . '[review_awards][' . $id . ']';
			$awards_name = ( !empty( $val['name'] ) ) ? stripslashes($val['name'])  : '';
			$slug = '';
			if(!empty($val['slug'])) $slug = $val['slug'];
			$awards_slug = it_get_slug($slug, $awards_name);
			$awards_badge = ( !empty( $val['badge'] ) ) ? stripslashes($val['badge'])  : '';
			$awards_icon = ( !empty( $val['icon'] ) ) ? stripslashes($val['icon'])  : '';
			$awards_iconhd = ( !empty( $val['iconhd'] ) ) ? stripslashes($val['iconhd'])  : '';
			$awards_iconwhite = ( !empty( $val['iconwhite'] ) ) ? stripslashes($val['iconwhite'])  : '';
			$awards_iconhdwhite = ( !empty( $val['iconhdwhite'] ) ) ? stripslashes($val['iconhdwhite'])  : '';
			$badge_checked = ( $awards_badge ) ? ' checked="checked"' : '';
			$custom = '';
			
			$out .= '<li id="awards-menu-item-' . $id . '" class="menu-item menu-item-edit-inactive">';
			
			# menu handle
			$out .= '<dl class="menu-item-bar">';
			$out .= '<dt class="menu-item-handle">';
			$out .= '<span class="item-title">' .( empty($awards_name) || $id == '#' ? __( 'New Award', IT_TEXTDOMAIN ) : $awards_name ). '</span>';
			$out .= '<span class="item-controls">';
			$out .= '<a href="awards-menu-item-settings-' . $id .'" title="Edit Menu Item" id="awards-menu-edit-' . $id . '" class="item-edit">' . __( 'Edit Award/Badge', IT_TEXTDOMAIN ) . '</a>';
			$out .= '</span>';
			$out .= '</dt>';
			$out .= '</dl>';
			
			# menu settings
			$out .= '<div id="awards-menu-item-settings-' . $id . '" class="menu-item-settings clearfix" style="display:none;">';
			
			# awards name
			$out .= '<p class="description description-thin"><label for="edit-awards-menu-name-' .$id. '">' . __( 'Name', IT_TEXTDOMAIN ) . '<br />';
			$out .= '<input type="text" value="' . $awards_name . '" name="' . $name . '[name]" id="edit-awards-menu-name-' . $id . '" class="widefat" />';
			$out .= '</label>';			
			$out .= '</p>';
			
			# awards slug
			$out .= '<div class="sub-wrapper">';
			$out .= '<p class="description description-thin"><label for="edit-awards-menu-slug-' .$id. '">' . __( 'Slug', IT_TEXTDOMAIN ) . '<br />';
			$out .= '<input type="text" value="' . $awards_slug . '" name="' . $name . '[slug]" id="edit-awards-menu-slug-' . $id . '" class="widefat" />';
			$out .= '</label>';			
			$out .= '</p>';
			$out .= '<div class="it_option_help">';
			$out .= '<a href="#"><span class="theme-icon-help-circled"></span></a>';
			$out .= '<div class="it_help_tooltip">' . __( 'Leave this blank unless you need to specifically manually enter a slug, such as if you want to use non-UTF-8 characters in the name of the award. For detailed information please reference the theme documentation. The slug will be created automatically based on the name of the award if you leave this field blank (recommended). Slugs must only contain lower-case letters and underscores, and cannot contain any other types of characters or spaces. WARNING: if you change the slug after you create the award you will have to re-assign the award to your posts.', IT_TEXTDOMAIN ) . '</div>';
			$out .= '</div>';
			$out .= '</div>';
			
			# awards image
			$out .= '<div class="sub-wrapper">';
			$out .= '<p class="description description-thin"><label for="edit-awards-menu-icon-' .$id. '">' . __( 'Icon (16px)', IT_TEXTDOMAIN ) . '<br />';
			$out .= '<input type="text" class="upload-text" name="' . $name . '[icon]" value="' . $awards_icon . '" id="edit-awards-menu-icon-' . $id . '" class="it_upload" />';			
			$out .= '<input type="button" value="' . esc_attr__( 'Choose' , IT_TEXTDOMAIN ) . '" class="upload_button button-secondary" id="edit-awards-menu-icon-' . $id . '_button" name="edit-awards-menu-icon-' . $id . '_button" />';
			$out .= '</label>';	
			$out .= '</p>';
			$out .= '<div class="it_option_help">';
			$out .= '<a href="#"><span class="theme-icon-help-circled"></span></a>';
			$out .= '<div class="it_help_tooltip">' . __( 'Image size should be 16px by 16px square.', IT_TEXTDOMAIN ) . '</div>';
			$out .= '</div>';
			$out .= '</div>';
			
			# awards image HD
			$out .= '<div class="sub-wrapper">';
			$out .= '<p class="description description-thin"><label for="edit-awards-menu-iconhd-' .$id. '">' . __( 'HD Icon (32px)', IT_TEXTDOMAIN ) . '<br />';
			$out .= '<input type="text" class="upload-text" name="' . $name . '[iconhd]" value="' . $awards_iconhd . '" id="edit-awards-menu-iconhd-' . $id . '" class="it_upload" />';			
			$out .= '<input type="button" value="' . esc_attr__( 'Choose' , IT_TEXTDOMAIN ) . '" class="upload_button button-secondary" id="edit-awards-menu-iconhd-' . $id . '_button" name="edit-awards-menu-iconhd-' . $id . '_button" />';
			$out .= '</label>';	
			$out .= '</p>';
			$out .= '<div class="it_option_help">';
			$out .= '<a href="#"><span class="theme-icon-help-circled"></span></a>';
			$out .= '<div class="it_help_tooltip">' . __( 'Choose a separate image for use in HD (hiDPI/retina) displays. Image should be 32px by 32px square.', IT_TEXTDOMAIN ) . '</div>';
			$out .= '</div>';
			$out .= '</div>';
			
			# awards image white
			$out .= '<div class="sub-wrapper">';
			$out .= '<p class="description description-thin"><label for="edit-awards-menu-iconwhite-' .$id. '">' . __( 'Optional White Icon (16px)', IT_TEXTDOMAIN ) . '<br />';
			$out .= '<input type="text" class="upload-text" name="' . $name . '[iconwhite]" value="' . $awards_iconwhite . '" id="edit-awards-menu-iconwhite-' . $id . '" class="it_upload" />';			
			$out .= '<input type="button" value="' . esc_attr__( 'Choose' , IT_TEXTDOMAIN ) . '" class="upload_button button-secondary" id="edit-awards-menu-iconwhite-' . $id . '_button" name="edit-awards-menu-iconwhite-' . $id . '_button" />';
			$out .= '</label>';	
			$out .= '</p>';
			$out .= '<div class="it_option_help">';
			$out .= '<a href="#"><span class="theme-icon-help-circled"></span></a>';
			$out .= '<div class="it_help_tooltip">' . __( 'Optional white version of the 16px icon for use in places with a dark background such as the featured slider. If you leave this blank the icon above will be used', IT_TEXTDOMAIN ) . '</div>';
			$out .= '</div>';
			$out .= '</div>';
			
			# awards image HD white
			$out .= '<div class="sub-wrapper">';
			$out .= '<p class="description description-thin"><label for="edit-awards-menu-iconhdwhite-' .$id. '">' . __( 'Optional White HD Icon (32px)', IT_TEXTDOMAIN ) . '<br />';
			$out .= '<input type="text" class="upload-text" name="' . $name . '[iconhdwhite]" value="' . $awards_iconhdwhite . '" id="edit-awards-menu-iconhdwhite-' . $id . '" class="it_upload" />';			
			$out .= '<input type="button" value="' . esc_attr__( 'Choose' , IT_TEXTDOMAIN ) . '" class="upload_button button-secondary" id="edit-awards-menu-iconhdwhite-' . $id . '_button" name="edit-awards-menu-iconhdwhite-' . $id . '_button" />';
			$out .= '</label>';	
			$out .= '</p>';
			$out .= '<div class="it_option_help">';
			$out .= '<a href="#"><span class="theme-icon-help-circled"></span></a>';
			$out .= '<div class="it_help_tooltip">' . __( 'Optional white version of the 32px icon for use in places with a dark background cush as the featured slider. If you leave this blank the icon above will be used.', IT_TEXTDOMAIN ) . '</div>';
			$out .= '</div>';
			$out .= '</div>';
			
			# awards badge	
			$out .= '<div class="sub-wrapper">';		
			$out .= '<div style="padding:5px 5px 5px 2px;">';
			$out .= '<input type="checkbox" name="' . $name . '[badge]" value="1" ' . $badge_checked .' id="badge_' . $id . '">';
			$out .= '<label for="badge_' . $id . '"> ' . __( 'This is a Badge', IT_TEXTDOMAIN ) . '</label>';			
			$out .= '</div>';
			$out .= '<div class="it_option_help">';
			$out .= '<a href="#"><span class="theme-icon-help-circled"></span></a>';
			$out .= '<div class="it_help_tooltip">' . __( 'Treat this item as a badge instead of an award. Badges appear as a simple icon in the badges section with the badge name in the tooltip (hover text). By contrast, Awards display in the awards section with the name of the award visible.', IT_TEXTDOMAIN ) . '</div>';
			$out .= '</div>';
			$out .= '</div>';
			
			# menu item actions
			$out .= '<div class="menu-item-actions description-wide submitbox">';
			$out .= '<a href="" id="delete-awards-menu-item-' . $id . '" class="submitdelete slider_deletion">' . __( 'Remove', IT_TEXTDOMAIN ) . '</a> ';
			$out .= '<span class="meta-sep"> | </span> <a href="awards-menu-item-settings-' . $id .'" class="slider_cancel submitcancel">' . __( 'Cancel', IT_TEXTDOMAIN ) . '</a>';
			$out .= '</div>';
			
			
			$out .= '</div><!-- #awards-menu-item-settings-## -->';
			$out .= '</li>';
			
			if( $i == $key_count-1 )
				$out .= '</ul><!-- .menu-to-edit -->';
			
			if( $i == $key_count )
				$out .= '</ul><!-- .sample-to-edit -->';
			
			$i++;
		}				
		$out .= '<input type="hidden" name="' . IT_SETTINGS . '[review_awards][keys]" value="' . $options['keys'] . '" class="menu-keys" />';
		$out .= '</div><!-- .awards_option_set -->';
		
		return $out;
	}
	
	function reactions( $value ) {
		error_reporting(E_ALL);
		$options = ( isset( $this->saved_options[$value['id']] ) ) ? $this->saved_options[$value['id']] : array( 'keys' => '#' );
		
		$init = false;
		
		if( $options['keys'] == '#' )
			$init = true;
		
		$reactions_keys = explode(',', $options['keys'] );
			
		$key_count = count( $reactions_keys );
		
		$out = '<div class="it_option_set reactions_option_set distinct_option_set">';
		$out .= '<div class="it_option_heading">' . $value['name'] . '</div>';
		$out .= '<div class="add_menu"><span class="button it_add_menu">' . __( 'Add New Reaction', IT_TEXTDOMAIN ) . '</span></div>';
		
		if( $init == true )
			$out .= '<ul class="menu-to-edit menu" style="display:none;"><li></li></ul><!-- .menu-to-edit -->';
		
		$i=1;
		foreach( $reactions_keys as $id ) {
			if( ( $i == 1 ) && ( $init == false ) )
				$out .= '<ul class="menu-to-edit menu">';

			if ( $i == $key_count )
				$out .= '<ul class="sample-to-edit menu" style="display:none;">';
				
			$val = ( ( $id != '#' ) && ( isset( $options[$id] ) ) ) ? $options[$id] : '';
			
			$name = IT_SETTINGS . '[reactions][' . $id . ']';
			$reactions_name = ( !empty( $val['name'] ) ) ? stripslashes($val['name'])  : '';
			$reactions_slug = ( !empty( $val['slug'] ) ) ? stripslashes($val['slug'])  : '';
			$reactions_slug = it_get_slug($reactions_slug, $reactions_name);
			$reactions_badge = ( !empty( $val['badge'] ) ) ? stripslashes($val['badge'])  : '';
			$reactions_icon = ( !empty( $val['icon'] ) ) ? stripslashes($val['icon'])  : '';
			$reactions_iconhd = ( !empty( $val['iconhd'] ) ) ? stripslashes($val['iconhd'])  : '';
			$reactions_preset = ( !empty( $val['preset'] ) ) ? stripslashes($val['preset'])  : '';
			$custom = '';
			
			$out .= '<li id="reactions-menu-item-' . $id . '" class="menu-item menu-item-edit-inactive">';
			
			# menu handle
			$out .= '<dl class="menu-item-bar">';
			$out .= '<dt class="menu-item-handle">';
			$out .= '<span class="item-title">' .( empty($reactions_name) || $id == '#' ? __( 'New Reaction', IT_TEXTDOMAIN ) : $reactions_name ). '</span>';
			$out .= '<span class="item-controls">';
			$out .= '<a href="reactions-menu-item-settings-' . $id .'" title="Edit Menu Item" id="reactions-menu-edit-' . $id . '" class="item-edit">' . __( 'Edit Reaction/Badge', IT_TEXTDOMAIN ) . '</a>';
			$out .= '</span>';
			$out .= '</dt>';
			$out .= '</dl>';
			
			# menu settings
			$out .= '<div id="reactions-menu-item-settings-' . $id . '" class="menu-item-settings clearfix" style="display:none;">';
			
			# reactions name
			$out .= '<p class="description description-thin"><label for="edit-reactions-menu-name-' .$id. '">' . __( 'Name', IT_TEXTDOMAIN ) . '<br />';
			$out .= '<input type="text" value="' . $reactions_name . '" name="' . $name . '[name]" id="edit-reactions-menu-name-' . $id . '" class="widefat" />';
			$out .= '</label>';			
			$out .= '</p>';
			
			# reactions slug
			$out .= '<div class="sub-wrapper">';
			$out .= '<p class="description description-thin"><label for="edit-reactions-menu-slug-' .$id. '">' . __( 'Slug', IT_TEXTDOMAIN ) . '<br />';
			$out .= '<input type="text" value="' . $reactions_slug . '" name="' . $name . '[slug]" id="edit-reactions-menu-slug-' . $id . '" class="widefat" />';
			$out .= '</label>';			
			$out .= '</p>';
			$out .= '<div class="it_option_help">';
			$out .= '<a href="#"><span class="theme-icon-help-circled"></span></a>';
			$out .= '<div class="it_help_tooltip">' . __( 'Leave this blank unless you need to specifically manually enter a slug, such as if you want to use non-UTF-8 characters in the name of the reaction. For detailed information please reference the theme documentation. The slug will be created automatically based on the name of the reaction if you leave this field blank (recommended). Slugs must only contain lower-case letters and underscores, and cannot contain any other types of characters or spaces. WARNING: if you change the slug after you create the reaction you will have to re-adjust excluded reactions in all of your posts (if any are excluded).', IT_TEXTDOMAIN ) . '</div>';
			$out .= '</div>';
			$out .= '</div>';
			
			# preset image
			$out .= '<p class="field-link-target description description-thin"><label for="edit-menu-reactions-icon-' . $id . '">' . __( 'Preset Image', IT_TEXTDOMAIN ) . '<br />';
			$out .= '<select id="edit-menu-reactions-icon-' . $id . '" class="widefat" name="' . $name . '[preset]">';
			
			$reactions_icons = it_reactions_option();
			foreach ( $reactions_icons['reactions'] as $key => $val ) {
				
				$selected = ( $reactions_preset == $key ) ? ' selected="selected"' : '' ;
				$out .= '<option' . $selected. ' value="' . $key . '">' . $val . '</option>';
			}
			$out .= '</select>';
			$out .= '</label>';
			$out .= '</p>';	
			
			# reactions image
			$out .= '<div class="sub-wrapper">';
			$out .= '<p class="description description-thin"><label for="edit-reactions-menu-icon-' .$id. '">' . __( 'Custom Icon (16px)', IT_TEXTDOMAIN ) . '<br />';
			$out .= '<input type="text" class="upload-text" name="' . $name . '[icon]" value="' . $reactions_icon . '" id="edit-reactions-menu-icon-' . $id . '" class="it_upload" />';			
			$out .= '<input type="button" value="' . esc_attr__( 'Choose' , IT_TEXTDOMAIN ) . '" class="upload_button button-secondary" id="edit-reactions-menu-icon-' . $id . '_button" name="edit-reactions-menu-icon-' . $id . '_button" />';
			$out .= '</label>';	
			$out .= '</p>';
			$out .= '<div class="it_option_help">';
			$out .= '<a href="#"><span class="theme-icon-help-circled"></span></a>';
			$out .= '<div class="it_help_tooltip">' . __( 'Image size should be 16px by 16px square.', IT_TEXTDOMAIN ) . '</div>';
			$out .= '</div>';
			$out .= '</div>';
			
			# reactions image HD
			$out .= '<div class="sub-wrapper">';
			$out .= '<p class="description description-thin"><label for="edit-reactions-menu-iconhd-' .$id. '">' . __( 'Custom HD Icon (32px)', IT_TEXTDOMAIN ) . '<br />';
			$out .= '<input type="text" class="upload-text" name="' . $name . '[iconhd]" value="' . $reactions_iconhd . '" id="edit-reactions-menu-iconhd-' . $id . '" class="it_upload" />';			
			$out .= '<input type="button" value="' . esc_attr__( 'Choose' , IT_TEXTDOMAIN ) . '" class="upload_button button-secondary" id="edit-reactions-menu-iconhd-' . $id . '_button" name="edit-reactions-menu-iconhd-' . $id . '_button" />';
			$out .= '</label>';	
			$out .= '</p>';
			$out .= '<div class="it_option_help">';
			$out .= '<a href="#"><span class="theme-icon-help-circled"></span></a>';
			$out .= '<div class="it_help_tooltip">' . __( 'Choose a separate image for use in HD (hiDPI/retina) displays. Image should be 32px by 32px square.', IT_TEXTDOMAIN ) . '</div>';
			$out .= '</div>';
			$out .= '</div>';
			
			# menu item actions
			$out .= '<div class="menu-item-actions description-wide submitbox">';
			$out .= '<a href="" id="delete-reactions-menu-item-' . $id . '" class="submitdelete slider_deletion">' . __( 'Remove', IT_TEXTDOMAIN ) . '</a> ';
			$out .= '<span class="meta-sep"> | </span> <a href="reactions-menu-item-settings-' . $id .'" class="slider_cancel submitcancel">' . __( 'Cancel', IT_TEXTDOMAIN ) . '</a>';
			$out .= '</div>';
			
			
			$out .= '</div><!-- #reactions-menu-item-settings-## -->';
			$out .= '</li>';
			
			if( $i == $key_count-1 )
				$out .= '</ul><!-- .menu-to-edit -->';
			
			if( $i == $key_count )
				$out .= '</ul><!-- .sample-to-edit -->';
			
			$i++;
		}				
		$out .= '<input type="hidden" name="' . IT_SETTINGS . '[reactions][keys]" value="' . $options['keys'] . '" class="menu-keys" />';
		$out .= '</div><!-- .reactions_option_set -->';
		
		return $out;
	}
	
	function categories( $value ) {
		error_reporting(E_ALL);
		$options = ( isset( $this->saved_options[$value['id']] ) ) ? $this->saved_options[$value['id']] : array( 'keys' => '#' );
		$toggle = ( !empty( $value['toggle'] ) ) ? $value['toggle'] . ' ' : '';
		$init = false;
		$value_local = array();
		if( $options['keys'] == '#' )
			$init = true;
		
		$categories_keys = explode(',', $options['keys'] );
			
		$key_count = count( $categories_keys );
		
		$out = '<div class="it_option_set categories_option_set distinct_option_set">';
		$out .= '<div class="it_option_heading">' . $value['name'] . '</div>';
		$out .= '<div class="add_menu"><span class="button it_add_menu">' . __( 'Manage A Category', IT_TEXTDOMAIN ) . '</span></div>';
		
		if( $init == true )
			$out .= '<ul class="menu-to-edit menu" style="display:none;"><li></li></ul><!-- .menu-to-edit -->';
		
		$i=1;
		foreach( $categories_keys as $id ) {
			if( ( $i == 1 ) && ( $init == false ) )
				$out .= '<ul class="menu-to-edit menu">';

			if ( $i == $key_count )
				$out .= '<ul class="sample-to-edit menu" style="display:none;">';
				
			$val = ( ( $id != '#' ) && ( isset( $options[$id] ) ) ) ? $options[$id] : '';
			
			$name = IT_SETTINGS . '[categories][' . $id . ']';
			$categories_id = ( !empty( $val['id'] ) ) ? stripslashes($val['id'])  : '';
			$categories_color = ( !empty( $val['color'] ) ) ? stripslashes($val['color'])  : '';
			$categories_icon = ( !empty( $val['icon'] ) ) ? stripslashes($val['icon'])  : '';
			$categories_iconhd = ( !empty( $val['iconhd'] ) ) ? stripslashes($val['iconhd'])  : '';
			$categories_iconwhite = ( !empty( $val['iconwhite'] ) ) ? stripslashes($val['iconwhite'])  : '';
			$categories_iconhdwhite = ( !empty( $val['iconhdwhite'] ) ) ? stripslashes($val['iconhdwhite'])  : '';
			$categories_logo = ( !empty( $val['logo'] ) ) ? stripslashes($val['logo'])  : '';
			$categories_logowidth = ( !empty( $val['logowidth'] ) ) ? stripslashes($val['logowidth'])  : '';
			$categories_logoheight = ( !empty( $val['logoheight'] ) ) ? stripslashes($val['logoheight'])  : '';
			$categories_logohd = ( !empty( $val['logohd'] ) ) ? stripslashes($val['logohd'])  : '';
			$categories_logo_mobile = ( !empty( $val['logo_mobile'] ) ) ? stripslashes($val['logo_mobile'])  : '';
			$categories_logowidth_mobile = ( !empty( $val['logowidth_mobile'] ) ) ? stripslashes($val['logowidth_mobile'])  : '';
			$categories_logoheight_mobile = ( !empty( $val['logoheight_mobile'] ) ) ? stripslashes($val['logoheight_mobile'])  : '';
			$categories_logohd_mobile = ( !empty( $val['logohd_mobile'] ) ) ? stripslashes($val['logohd_mobile'])  : '';
			$categories_tagline_disable = ( !empty( $val['tagline_disable'] ) ) ? stripslashes($val['tagline_disable'])  : '';	
			/*		
			$categories_bg_color = ( !empty( $val['bg_color'] ) ) ? stripslashes($val['bg_color'])  : '';			
			$categories_bg_image = ( !empty( $val['bg_image'] ) ) ? stripslashes($val['bg_image'])  : '';
			$categories_bg_position = ( !empty( $val['bg_position'] ) ) ? stripslashes($val['bg_position'])  : '';
			$categories_bg_repeat = ( !empty( $val['bg_repeat'] ) ) ? stripslashes($val['bg_repeat'])  : '';
			$categories_bg_attachment = ( !empty( $val['bg_attachment'] ) ) ? stripslashes($val['bg_attachment'])  : '';
			*/
			
			#setup pass through value					
			$value_local['option'] = $name;			
			
			# get category name from id
			$categories_name = get_cat_name($categories_id);
			
			$out .= '<li id="categories-menu-item-' . $id . '" class="menu-item menu-item-edit-inactive">';
			
			# menu handle
			$out .= '<dl class="menu-item-bar">';
			$out .= '<dt class="menu-item-handle">';
			$out .= '<span class="item-title">' .( empty($categories_name) || $id == '#' ? __( 'Category', IT_TEXTDOMAIN ) : $categories_name ). '</span>';
			$out .= '<span class="item-controls">';
			$out .= '<a href="categories-menu-item-settings-' . $id .'" title="Edit Menu Item" id="categories-menu-edit-' . $id . '" class="item-edit">' . __( 'Edit Category', IT_TEXTDOMAIN ) . '</a>';
			$out .= '</span>';
			$out .= '</dt>';
			$out .= '</dl>';
			
			# menu settings
			$out .= '<div id="categories-menu-item-settings-' . $id . '" class="menu-item-settings clearfix" style="display:none;">';
			
			# categories name
			$value_local['name'] = __('Choose An Existing Category',IT_TEXTDOMAIN);
			$value_local['setting'] = 'id';
			$value_local['value'] = $categories_id;
			$value_local['id'] = 'edit-categories-menu-name-' . $id;
			$value_local['toggle'] = $toggle;
			$value_local['target'] = 'cat';
			$out .= $this->select_nested( $value_local );
						
			# categories image
			$value_local['name'] = __('Icon (16px)',IT_TEXTDOMAIN);
			$value_local['setting'] = 'icon';
			$value_local['value'] = $categories_icon;
			$value_local['id'] = 'edit-categories-menu-icon-' . $id;
			$out .= $this->upload_nested( $value_local );			
			
			# categories image HD
			$value_local['name'] = __('HD Icon (32px)',IT_TEXTDOMAIN);
			$value_local['setting'] = 'iconhd';
			$value_local['value'] = $categories_iconhd;
			$value_local['id'] = 'edit-categories-menu-iconhd-' . $id;
			$out .= $this->upload_nested( $value_local );
						
			# categories image white
			$value_local['name'] = __('Optional White Icon (16px)',IT_TEXTDOMAIN);
			$value_local['setting'] = 'iconwhite';
			$value_local['value'] = $categories_iconwhite;
			$value_local['id'] = 'edit-categories-menu-iconwhite-' . $id;
			$out .= $this->upload_nested( $value_local );
						
			# categories image HD white
			$value_local['name'] = __('Optional White HD Icon (32px)',IT_TEXTDOMAIN);
			$value_local['setting'] = 'iconhdwhite';
			$value_local['value'] = $categories_iconhdwhite;
			$value_local['id'] = 'edit-categories-menu-iconhdwhite-' . $id;
			$out .= $this->upload_nested( $value_local );
						
			# categories color
			$value_local['name'] = __('Category Color',IT_TEXTDOMAIN);
			$value_local['setting'] = 'color';
			$value_local['value'] = $categories_color;
			$value_local['id'] = 'edit-categories-menu-color-' . $id;
			$value_local['default'] = '#FF2654';
			$out .= $this->color_nested( $value_local );
						
			# categories logo
			$value_local['name'] = __('Custom Logo',IT_TEXTDOMAIN);
			$value_local['setting'] = 'logo';
			$value_local['value'] = $categories_logo;
			$value_local['id'] = 'edit-categories-logo-' . $id;
			$out .= $this->upload_nested( $value_local );
			
			# logo width
			$value_local['name'] = __('Logo Width (Optional)',IT_TEXTDOMAIN);
			$value_local['setting'] = 'logowidth';
			$value_local['value'] = $categories_logowidth;
			$value_local['id'] = 'edit-categories-logowidth-' . $id;
			$out .= $this->upload_nested( $value_local );
			
			# logo height
			$value_local['name'] = __('Logo Height (Optional)',IT_TEXTDOMAIN);
			$value_local['setting'] = 'logoheight';
			$value_local['value'] = $categories_logoheight;
			$value_local['id'] = 'edit-categories-logoheight-' . $id;
			$out .= $this->upload_nested( $value_local );
			
			# categories logo hd
			$value_local['name'] = __('Custom HD Logo',IT_TEXTDOMAIN);
			$value_local['setting'] = 'logohd';
			$value_local['value'] = $categories_logohd;
			$value_local['id'] = 'edit-categories-logohd-' . $id;
			$out .= $this->upload_nested( $value_local );
			
			# categories logo mobile
			$value_local['name'] = __('Mobile Logo',IT_TEXTDOMAIN);
			$value_local['setting'] = 'logo_mobile';
			$value_local['value'] = $categories_logo_mobile;
			$value_local['id'] = 'edit-categories-logo-mobile-' . $id;
			$out .= $this->upload_nested( $value_local );
			
			# logo width mobile
			$value_local['name'] = __('Mobile Logo Width (Optional)',IT_TEXTDOMAIN);
			$value_local['setting'] = 'logowidth_mobile';
			$value_local['value'] = $categories_logowidth_mobile;
			$value_local['id'] = 'edit-categories-logowidth-mobile-' . $id;
			$out .= $this->upload_nested( $value_local );
			
			# logo height mobile
			$value_local['name'] = __('Mobile Logo Height (Optional)',IT_TEXTDOMAIN);
			$value_local['setting'] = 'logoheight_mobile';
			$value_local['value'] = $categories_logoheight_mobile;
			$value_local['id'] = 'edit-categories-logoheight-mobile-' . $id;
			$out .= $this->upload_nested( $value_local );
			
			# categories logo hd mobile
			$value_local['name'] = __('Mobile HD Logo',IT_TEXTDOMAIN);
			$value_local['setting'] = 'logohd_mobile';
			$value_local['value'] = $categories_logohd_mobile;
			$value_local['id'] = 'edit-categories-logohd-mobile-' . $id;
			$out .= $this->upload_nested( $value_local );
			
			#categories tagline disable
			$value_local['name'] = __('Hide Tagline',IT_TEXTDOMAIN);
			$value_local['setting'] = 'tagline_disable';
			$value_local['value'] = $categories_tagline_disable;
			$value_local['id'] = 'edit-categories-menu-taglinedisable-' . $id;
			$value_local['target'] = '';	
			$value_local['options'] = array( 
				'true' => __( 'Hide the Site Tagline from the sticky bar', IT_TEXTDOMAIN)
			);		
			$out .= $this->checkbox_nested( $value_local );
			$value_local['options'] = array();
			
			/*
			# background background color
			$value_local['name'] = __('Background Color',IT_TEXTDOMAIN);
			$value_local['setting'] = 'bg_color';
			$value_local['value'] = $categories_bg_color;
			$value_local['id'] = 'edit-categories-menu-bgcolor-' . $id;
			$value_local['default'] = '';
			$out .= $this->color_nested( $value_local );			
			
			# categories background image			
			$value_local['name'] = __('Background Image',IT_TEXTDOMAIN);
			$value_local['setting'] = 'bg_image';
			$value_local['value'] = $categories_bg_image;
			$value_local['id'] = 'edit-categories-bgimage-' . $id;
			$out .= $this->upload_nested( $value_local );
			
			#categories background position
			$value_local['name'] = __('Background Position',IT_TEXTDOMAIN);
			$value_local['setting'] = 'bg_position';
			$value_local['value'] = $categories_bg_position;
			$value_local['id'] = 'edit-categories-menu-bgposition-' . $id;	
			$value_local['options'] = array( 
				'' => __( 'Not Set (use value from general options)', IT_TEXTDOMAIN),
				'left' => __( 'Left', IT_TEXTDOMAIN ),
				'center' => __( 'Center', IT_TEXTDOMAIN ),
				'right' => __( 'Right', IT_TEXTDOMAIN )
			);		
			$out .= $this->radio_nested( $value_local );
			
			#categories background repeat
			$value_local['name'] = __('Background Repeat',IT_TEXTDOMAIN);
			$value_local['setting'] = 'bg_repeat';
			$value_local['value'] = $categories_bg_repeat;
			$value_local['id'] = 'edit-categories-menu-bgrepeat-' . $id;	
			$value_local['options'] = array( 
				'' => __( 'Not Set (use value from general options)', IT_TEXTDOMAIN),
				'no-repeat' => __( 'No Repeat', IT_TEXTDOMAIN ),
				'repeat' => __( 'Tile', IT_TEXTDOMAIN ),
				'repeat-x' => __( 'Tile Horizontally', IT_TEXTDOMAIN ),
				'repeat-y' => __( 'Tile Vertically', IT_TEXTDOMAIN )
			);		
			$out .= $this->radio_nested( $value_local );
			
			#categories background attachment
			$value_local['name'] = __('Background Attachment',IT_TEXTDOMAIN);
			$value_local['setting'] = 'bg_attachment';
			$value_local['value'] = $categories_bg_attachment;
			$value_local['id'] = 'edit-categories-menu-bgattachment-' . $id;	
			$value_local['options'] = array( 
				'' => __( 'Not Set (use value from general options)', IT_TEXTDOMAIN),
				'scroll' => __( 'Scroll', IT_TEXTDOMAIN ),
				'fixed' => __( 'Fixed', IT_TEXTDOMAIN )
			);		
			$out .= $this->radio_nested( $value_local );
			*/
			
			# menu item actions
			$out .= '<div class="menu-item-actions description-wide submitbox">';
			$out .= '<a href="" id="delete-categories-menu-item-' . $id . '" class="submitdelete slider_deletion">' . __( 'Remove', IT_TEXTDOMAIN ) . '</a> ';
			$out .= '<span class="meta-sep"> | </span> <a href="categories-menu-item-settings-' . $id .'" class="slider_cancel submitcancel">' . __( 'Cancel', IT_TEXTDOMAIN ) . '</a>';
			$out .= '</div>';
			
			$out .= '</div><!-- #categories-menu-item-settings-## -->';
			$out .= '</li>';
			
			if( $i == $key_count-1 )
				$out .= '</ul><!-- .menu-to-edit -->';
			
			if( $i == $key_count )
				$out .= '</ul><!-- .sample-to-edit -->';
			
			$i++;
		}				
		$out .= '<input type="hidden" name="' . IT_SETTINGS . '[categories][keys]" value="' . $options['keys'] . '" class="menu-keys" />';
		$out .= '</div><!-- .categories_option_set -->';
		
		return $out;
	}
	
	function builder( $value ) {
		error_reporting(E_ALL);
		$options = ( isset( $this->saved_options[$value['id']] ) ) ? $this->saved_options[$value['id']] : array( 'keys' => '#' );
		$toggle = ( !empty( $value['toggle'] ) ) ? $value['toggle'] . ' ' : '';
		$init = false;
		$value_local = array();
		if( $options['keys'] == '#' )
			$init = true;
		
		$builder_keys = explode(',', $options['keys'] );
			
		$key_count = count( $builder_keys );
		
		$out = '<div class="it_option_set builder_option_set distinct_option_set">';
		$out .= '<div class="add_menu"><span class="button it_add_menu">' . __( 'Add Panel', IT_TEXTDOMAIN ) . '</span></div>';
		
		if( $init == true )
			$out .= '<ul class="menu-to-edit menu" style="display:none;"><li></li></ul><!-- .menu-to-edit -->';
		
		$i=1;
		foreach( $builder_keys as $id ) {
			if( ( $i == 1 ) && ( $init == false ) )
				$out .= '<ul class="menu-to-edit menu">';

			if ( $i == $key_count )
				$out .= '<ul class="sample-to-edit menu" style="display:none;">';
				
			$val = ( ( $id != '#' ) && ( isset( $options[$id] ) ) ) ? $options[$id] : '';
			
			$name = IT_SETTINGS . '[' . $value['id'] . '][' . $id . ']';
			$builder_id = ( !empty( $val['id'] ) ) ? stripslashes($val['id'])  : '';
			$included_categories = ( isset( $val['included_categories'] ) ) ? $val['included_categories'] : array();	
			$included_tags = ( isset( $val['included_tags'] ) ) ? $val['included_tags'] : array();	
			$excluded_categories = ( isset( $val['excluded_categories'] ) ) ? $val['excluded_categories'] : array();	
			$excluded_tags = ( isset( $val['excluded_tags'] ) ) ? $val['excluded_tags'] : array();	
			$loading = ( !empty( $val['loading'] ) ) ? stripslashes($val['loading'])  : '';	
			$title = ( !empty( $val['title'] ) ) ? stripslashes($val['title'])  : '';	
			$icon = ( !empty( $val['icon'] ) ) ? stripslashes($val['icon'])  : '';
			$subtitle = ( !empty( $val['subtitle'] ) ) ? stripslashes($val['subtitle'])  : '';
			#$disabled_filters = ( isset( $val['disabled_filters'] ) ) ? $val['disabled_filters'] : array();
			$rows = ( !empty( $val['rows'] ) ) ? stripslashes($val['rows'])  : '';	
			$increment = ( !empty( $val['increment'] ) ) ? stripslashes($val['increment'])  : '';
			$start = ( !empty( $val['start'] ) ) ? stripslashes($val['start'])  : '';
			$disable_ads = ( !empty( $val['disable_ads'] ) ) ? stripslashes($val['disable_ads'])  : '';	
			$disable_excerpt = ( !empty( $val['disable_excerpt'] ) ) ? stripslashes($val['disable_excerpt'])  : '';	
			$disable_authorship = ( !empty( $val['disable_authorship'] ) ) ? stripslashes($val['disable_authorship'])  : '';
			$targeted = ( !empty( $val['targeted'] ) ) ? stripslashes($val['targeted'])  : '';
			$timeperiod = ( !empty( $val['timeperiod'] ) ) ? stripslashes($val['timeperiod'])  : '';
			$html = ( !empty( $val['html'] ) ) ? stripslashes($val['html'])  : '';					
			
			#setup pass through value					
			$value_local['option'] = $name;	
			$value_local['desc'] = '';
			
			# get category name from id
			$builder_array = $this->select_target_options('builder');
			$builder_name = array_key_exists($builder_id, $builder_array) ? $builder_array[$builder_id] : '';			
			
			$out .= '<li id="' . $value['id'] . '-menu-item-' . $id . '" class="menu-item menu-item-edit-inactive">';
			
			# menu handle
			$out .= '<dl class="menu-item-bar">';
			$out .= '<dt class="menu-item-handle">';
			$out .= '<span class="item-title">' .( empty($builder_name) || $id == '#' ? __( 'Builder Panel', IT_TEXTDOMAIN ) : $builder_name ). '</span>';
			$out .= '<span class="item-controls">';
			$out .= '<a href="' . $value['id'] . '-menu-item-settings-' . $id .'" title="Edit Menu Item" id="' . $value['id'] . '-menu-edit-' . $id . '" class="item-edit">' . __( 'Edit Panel', IT_TEXTDOMAIN ) . '</a>';
			$out .= '</span>';
			$out .= '</dt>';
			$out .= '</dl>';
			
			# menu settings
			$out .= '<div id="' . $value['id'] . '-menu-item-settings-' . $id . '" class="menu-item-settings clearfix" style="display:none;">';
			
			# builder panel
			$value_local['name'] = __('Type',IT_TEXTDOMAIN);
			$value_local['setting'] = 'id';
			$value_local['value'] = $builder_id;
			$value_local['id'] = 'edit-' . $value['id'] . '-type-' . $id;
			$value_local['toggle'] = $toggle;
			$value_local['target'] = 'builder';
			$value_local['toggle_class'] = 'builder_selector';
			$out .= $this->select_nested( $value_local );
			
			# included categories
			$value_local['name'] = __('Included Categories',IT_TEXTDOMAIN);
			$value_local['setting'] = 'included_categories';
			$value_local['value'] = $included_categories;
			$value_local['id'] = 'edit-' . $value['id'] . '-included-categories-' . $id;
			$value_local['toggle'] = $toggle;
			$value_local['target'] = 'cat';
			$value_local['toggle_class'] = 'grid blog headliner topten trending scroller';
			$out .= $this->multidropdown_nested( $value_local );
			
			# included tags
			$value_local['name'] = __('Included Tags',IT_TEXTDOMAIN);
			$value_local['setting'] = 'included_tags';
			$value_local['value'] = $included_tags;
			$value_local['id'] = 'edit-' . $value['id'] . '-included-tags-' . $id;
			$value_local['toggle'] = $toggle;
			$value_local['target'] = 'tag';
			$value_local['toggle_class'] = 'grid blog headliner topten trending scroller';
			$out .= $this->multidropdown_nested( $value_local );
			
			# excluded categories
			$value_local['name'] = __('Excluded Categories',IT_TEXTDOMAIN);
			$value_local['setting'] = 'excluded_categories';
			$value_local['value'] = $excluded_categories;
			$value_local['id'] = 'edit-' . $value['id'] . '-excluded-categories-' . $id;
			$value_local['toggle'] = $toggle;
			$value_local['target'] = 'cat';
			$value_local['toggle_class'] = 'grid blog headliner topten trending scroller';
			$out .= $this->multidropdown_nested( $value_local );
			
			# excluded tags
			$value_local['name'] = __('Excluded Tags',IT_TEXTDOMAIN);
			$value_local['setting'] = 'excluded_tags';
			$value_local['value'] = $excluded_tags;
			$value_local['id'] = 'edit-' . $value['id'] . '-excluded-tags-' . $id;
			$value_local['toggle'] = $toggle;
			$value_local['target'] = 'tag';
			$value_local['toggle_class'] = 'grid blog headliner topten trending scroller';
			$out .= $this->multidropdown_nested( $value_local );
			
			# title
			$value_local['name'] = __('Title',IT_TEXTDOMAIN);
			$value_local['setting'] = 'title';
			$value_local['value'] = $title;
			$value_local['id'] = 'edit-' . $value['id'] . '-title-' . $id;
			$value_local['toggle'] = $toggle;
			$value_local['toggle_class'] = 'grid blog headliner topten trending scroller menu connect';
			$out .= $this->text_nested( $value_local );	
			
			# icon
			$value_local['name'] = __('Icon',IT_TEXTDOMAIN);
			$value_local['setting'] = 'icon';
			$value_local['value'] = $icon;
			$value_local['id'] = 'edit-' . $value['id'] . '-icon-' . $id;
			$value_local['toggle'] = $toggle;
			$value_local['target'] = 'icons';
			$value_local['toggle_class'] = 'grid blog headliner topten trending scroller menu connect';
			$out .= $this->select_nested( $value_local );
			
			# subtitle
			$value_local['name'] = __('Sub-Title',IT_TEXTDOMAIN);
			$value_local['setting'] = 'subtitle';
			$value_local['value'] = $subtitle;
			$value_local['id'] = 'edit-' . $value['id'] . '-subtitle-' . $id;
			$value_local['toggle'] = $toggle;
			$value_local['toggle_class'] = 'topten trending';
			$out .= $this->text_nested( $value_local );	
			
			# Custom Content
			$value_local['name'] = __('Custom Content',IT_TEXTDOMAIN);
			$value_local['desc'] = __('Put any custom content you want here and it will display above this builder panel. Shortcode and HTML/CSS/Javascript enabled. For the Custom Content builder panel use this field to insert your content.',IT_TEXTDOMAIN);
			$value_local['setting'] = 'html';
			$value_local['value'] = $html;
			$value_local['id'] = 'edit-' . $value['id'] . '-html-' . $id;
			$value_local['toggle'] = $toggle;
			$value_local['toggle_class'] = 'all';
			$out .= $this->textarea_nested( $value_local );	
			
			# disabled filters
			/* ### having trouble getting nested checkboxes to collect/save arrays of selected values rather than single values
			$value_local['name'] = __('Disable Filter Buttons',IT_TEXTDOMAIN);
			$value_local['setting'] = 'disabled_filters';
			$value_local['value'] = $disabled_filters;
			$value_local['id'] = 'edit-' . $value['id'] . '-disabled-filters-' . $id;
			$value_local['target'] = '';	
			$value_local['options'] = array( 
				'liked' => __('Liked',IT_TEXTDOMAIN),
				'viewed' => __('Viewed',IT_TEXTDOMAIN),
				'reviewed' => __('Reviewed',IT_TEXTDOMAIN),
				'rated' => __('Rated',IT_TEXTDOMAIN),
				'commented' => __('Commented',IT_TEXTDOMAIN),
				'awarded' => __('Awarded',IT_TEXTDOMAIN),
				'title' => __('Alphabetical',IT_TEXTDOMAIN)
			);		
			$out .= $this->checkbox_nested( $value_local );
			*/
			
			# post loading
			$value_local['name'] = __('Post Loading',IT_TEXTDOMAIN);
			$value_local['setting'] = 'loading';
			$value_local['value'] = $loading;
			$value_local['id'] = 'edit-' . $value['id'] . '-loading-' . $id;	
			$value_local['options'] = array( 				
				'paged' => __( 'Paged', IT_TEXTDOMAIN ),
				'infinite' => __( 'Infinite', IT_TEXTDOMAIN ),
				'' => __( 'None', IT_TEXTDOMAIN)
			);	
			$value_local['toggle_class'] = 'grid blog';	
			$out .= $this->radio_nested( $value_local );
			$value_local['options'] = array();
			
			# rows
			$value_local['name'] = __('Rows/Posts Per Page',IT_TEXTDOMAIN);
			$value_local['desc'] = __('For Grid, this setting determines how many total rows of posts are displayed (not necessarily how many total posts are displayed). For Blog, this setting determines how many total posts are displayed.',IT_TEXTDOMAIN);
			$value_local['setting'] = 'rows';
			$value_local['value'] = $rows;
			$value_local['id'] = 'edit-' . $value['id'] . '-rows-' . $id;
			$value_local['toggle'] = $toggle;
			$value_local['target'] = 'range_number';
			$value_local['toggle_class'] = 'grid blog';
			$out .= $this->select_nested( $value_local );
			$value_local['desc'] = '';
			
			# start
			$value_local['name'] = __('Wide Post Start Position',IT_TEXTDOMAIN);
			$value_local['setting'] = 'start';
			$value_local['value'] = $start;
			$value_local['id'] = 'edit-' . $value['id'] . '-start-' . $id;
			$value_local['toggle'] = $toggle;
			$value_local['target'] = 'ad_number';
			$value_local['nodisable'] = true;
			$value_local['toggle_class'] = 'grid';
			$out .= $this->select_nested( $value_local );
			
			# increment
			$value_local['name'] = __('Wide Post Frequency',IT_TEXTDOMAIN);
			$value_local['setting'] = 'increment';
			$value_local['value'] = $increment;
			$value_local['id'] = 'edit-' . $value['id'] . '-increment-' . $id;
			$value_local['toggle'] = $toggle;
			$value_local['target'] = 'grid_increment';
			$value_local['toggle_class'] = 'grid';
			$out .= $this->select_nested( $value_local );
			
			# disable ads
			$value_local['name'] = __('Disable Ads',IT_TEXTDOMAIN);
			$value_local['setting'] = 'disable_ads';
			$value_local['value'] = $disable_ads;
			$value_local['id'] = 'edit-' . $value['id'] . '-disable-ads-' . $id;
			$value_local['target'] = '';	
			$value_local['options'] = array( 
				'true' => __( 'Do not display ads within this loop', IT_TEXTDOMAIN)
			);	
			$value_local['toggle_class'] = 'grid blog';	
			$out .= $this->checkbox_nested( $value_local );
			$value_local['options'] = array();
			
			# disable excerpt
			$value_local['name'] = __('Disable Excerpt',IT_TEXTDOMAIN);
			$value_local['setting'] = 'disable_excerpt';
			$value_local['value'] = $disable_excerpt;
			$value_local['id'] = 'edit-' . $value['id'] . '-disable-excerpt-' . $id;
			$value_local['target'] = '';	
			$value_local['options'] = array( 
				'true' => __( 'Do not display post excerpts within this loop', IT_TEXTDOMAIN)
			);	
			$value_local['toggle_class'] = 'blog';	
			$out .= $this->checkbox_nested( $value_local );
			$value_local['options'] = array();
			
			# disable authorship
			$value_local['name'] = __('Disable Authorship',IT_TEXTDOMAIN);
			$value_local['setting'] = 'disable_authorship';
			$value_local['value'] = $disable_authorship;
			$value_local['id'] = 'edit-' . $value['id'] . '-disable-authorship-' . $id;
			$value_local['target'] = '';	
			$value_local['options'] = array( 
				'true' => __( 'Do not display authorship within this loop', IT_TEXTDOMAIN)
			);	
			$value_local['toggle_class'] = 'blog';	
			$out .= $this->checkbox_nested( $value_local );
			$value_local['options'] = array();
			
			# targeted
			$value_local['name'] = __('Targeted',IT_TEXTDOMAIN);
			$value_local['setting'] = 'targeted';
			$value_local['value'] = $targeted;
			$value_local['id'] = 'edit-' . $value['id'] . '-targeted-' . $id;
			$value_local['target'] = '';	
			$value_local['options'] = array( 
				'true' => __( 'Aware of currently displayed category section', IT_TEXTDOMAIN)
			);	
			$value_local['toggle_class'] = 'headliner topten trending scroller';	
			$out .= $this->checkbox_nested( $value_local );
			$value_local['options'] = array();
			
			# time period
			$value_local['name'] = __('Time Period',IT_TEXTDOMAIN);
			$value_local['setting'] = 'timeperiod';
			$value_local['value'] = $timeperiod;
			$value_local['id'] = 'edit-' . $value['id'] . '-timeperiod-' . $id;
			$value_local['toggle'] = $toggle;
			$value_local['target'] = 'timeperiod';
			$value_local['toggle_class'] = 'topten trending';
			$out .= $this->select_nested( $value_local );
			
			# menu item actions
			$out .= '<div class="menu-item-actions description-wide submitbox">';
			$out .= '<a href="" id="delete-' . $value['id'] . '-menu-item-' . $id . '" class="submitdelete slider_deletion">' . __( 'Remove', IT_TEXTDOMAIN ) . '</a> ';
			$out .= '<span class="meta-sep"> | </span> <a href="' . $value['id'] . '-menu-item-settings-' . $id .'" class="slider_cancel submitcancel">' . __( 'Cancel', IT_TEXTDOMAIN ) . '</a>';
			$out .= '</div>';
			
			$out .= '</div><!-- #builder-menu-item-settings-## -->';
			$out .= '</li>';
			
			if( $i == $key_count-1 )
				$out .= '</ul><!-- .menu-to-edit -->';
			
			if( $i == $key_count )
				$out .= '</ul><!-- .sample-to-edit -->';
			
			$i++;
		}				
		$out .= '<input type="hidden" name="' . IT_SETTINGS . '[' . $value['id'] . '][keys]" value="' . $options['keys'] . '" class="menu-keys" />';
		$out .= '</div><!-- .builder_option_set -->';
		
		return $out;
	}
	
	/**
	 * 
	 */
	function upload_nested( $value ) {
		$out = '<div class="it_option_set upload_option_set">';
		
		$out .= $this->option_start( $value );
		
		$out .= '<input type="text" name="' . $value['option'] . '[' . $value['setting'] . ']" value="' . $value['value'] . '" id="' . $value['id'] . '" class="it_upload" />';
		
		$out .= '<input type="button" value="' . esc_attr__( 'Choose' , IT_TEXTDOMAIN ) . '" class="upload_button button-secondary" id="' . $value['id'] . '_button" name="' . $value['id'] . '_button" /><br />';
		
		$out .= $this->option_end( $value );
		
		$out .= '</div><!-- .upload_option_set -->';
		
		return $out;
	}
	
	/**
	 *
	 */
	function color_nested($value) {
		$out = '<div class="it_option_set color_option_set">';
		
		$out .= $this->option_start($value);		
		
		$default = isset($value['default']) ? $value['default'] : '';
		
		$out .= '<input type="text" id="' .$value['id']. '" name="' . $value['option'] . '[' . $value['setting'] . ']" value="' .$value['value']. '" class="wp-color-picker" data-default-color="#' . $default . '" />';
		$out .= $this->option_end($value);		
		
		$out .= '</div><!-- color_option_set -->';
		
		return $out;
	}
	
	/**
	 *
	 */
	function text_nested( $value ) {
		$size = isset( $value['size'] ) ? $value['size'] : '10';
		$toggle_class = ( !empty( $value['toggle_class'] ) ) ? $value['toggle_class'] . ' ' : '';
		
		$out = '<div class="' . $toggle_class . 'it_option_set text_option_set">';
		
		$out .= $this->option_start( $value );
		
		$out .= '<input type="text" name="' . $value['option'] . '[' . $value['setting'] . ']" id="' . $value['id'] . '" class="it_textfield" value="' .
		( isset( $value['value'] ) && isset( $value['htmlentities'] )
		? stripslashes(htmlentities( $value['value'], ENT_QUOTES, 'UTF-8' ) ) : ( isset( $value['value'] ) && isset( $value['htmlspecialchars'] )
		? stripslashes(htmlspecialchars( $value['value'] ) )
		: ( isset( $value['value'] ) ? stripslashes( $value['value'] ) : ( isset( $value['default'] ) ? $value['default'] : '' ) ) ) ) . '" />';
		
		$out .= $this->option_end( $value );
		
		$out .= '</div><!-- .text_option_set -->';
		
		return $out;
	}
	
	/**
	 *
	 */
	function textarea_nested( $value ) {
		$toggle_class = ( !empty( $value['toggle_class'] ) ) ? $value['toggle_class'] . ' ' : '';
		
		$out = '<div class="' . $toggle_class . 'it_option_set textarea_option_set">';
		
		$out .= $this->option_start( $value );
		
		$out .= '<textarea rows="8" cols="8" name="' . $value['option'] . '[' . $value['setting'] . ']" id="' . $value['id'] . '" class="it_textarea">' .
		( isset( $value['value'] )
		? stripslashes( $value['value'] )
		: ( isset( $value['default'] ) ? $value['default'] : '' ) ) . '</textarea><br />';
		$out .= $this->option_end( $value );
		
		$out .= '</div><!-- .textarea_option_set -->';
		
		return $out;
	}
	
	/**
	 * 
	 */
	function radio_nested( $value ) {
		$toggle_class = ( !empty( $value['toggle_class'] ) ) ? $value['toggle_class'] . ' ' : '';
		$toggle = ( !empty( $value['toggle'] ) ) ? ' class="' . $value['toggle'] . '"' : '';
		
		$out = '<div class="' . $toggle_class . 'it_option_set radio_option_set">';
		
		$out .= $this->option_start( $value );
			
		$i = 0;
		foreach( $value['options'] as $key => $option ) {
			$i++;
			$checked = ( $value['value'] == $key ) ? ' checked="checked"' : '';
			
			$out .= '<input type="radio" name="' . $value['option'] . '[' . $value['setting'] . ']" value="' . $key . '" ' . $checked . ' id="' . $value['id'] . '_' . $i . '"' . $toggle .' />';
			$out .= '<label for="' . $value['id'] . '_' . $i . '">' . $option . '</label><br />';
		}
		
		$out .= $this->option_end( $value );
		
		$out .= '</div><!-- .radio_option_set -->';
		
		return $out;
	}
	
	/**
	 * 
	 */
	function checkbox_nested( $value ) {
		$toggle_class = ( !empty( $value['toggle_class'] ) ) ? $value['toggle_class'] . ' ' : '';
		$toggle = ( !empty( $value['toggle'] ) ) ? ' class="' . $value['toggle'] . '"' : '';
		
		$out = '<div class="' . $toggle_class . 'it_option_set checkbox_option_set">';
		
		$out .= $this->option_start( $value );
		
		if( isset( $value['target'] ) ) {
			if( isset( $value['options'] ) ) {
				$value['options'] = $value['options'] + $this->select_target_options( $value['target'] );
			} else {
				$value['options'] = $this->select_target_options( $value['target'] );
			}
		}
		
		$selected_keys = explode(',',$value['value']);
		
		$i = 0;
		foreach( $value['options'] as $key => $option ) {
			$i++;
			$checked = '';
			
			if( isset( $selected_keys ) ) {
				if( is_array( $selected_keys ) ) {
					if( in_array( $key, $selected_keys ) ) {
						$checked = ' checked="checked"';
					}
				}
			} elseif( isset( $value['default'] ) ) {
				if( is_array( $value['default'] ) ) {
					if( in_array( $key, $value['default'] ) ) {
						$checked = ' checked="checked"';
					}
				}
			}
			
			$out .= '<input type="checkbox" name="' . $value['option'] . '[' . $value['setting'] . ']" value="' . $key . '" id="' . $value['id'] . '_' . $i . '"' . $checked . $toggle . ' />';
			$out .= '<label for="' . $value['id'] . '_' . $i . '">' . esc_html( $option ) . '</label><br />';
		}
		
		$out .= $this->option_end( $value );
		
		$out .= '</div><!-- .checkbox_option_set -->';
		
		return $out;
	}
	
	/**
	 *
	 */
	function select_nested( $value ) {
		$toggle_class = ( !empty( $value['toggle_class'] ) ) ? $value['toggle_class'] . ' ' : '';
		$toggle = ( !empty( $value['toggle'] ) ) ? $value['toggle'] . ' ' : '';
		
		$out = '<div class="' . $toggle_class . 'it_option_set select_option_set">';
		
		$out .= $this->option_start( $value );
		
		$nodisable = '';
		if(array_key_exists('nodisable',$value)) $nodisable = $value['nodisable'];
		
		$target = '';
		if(array_key_exists('target',$value)) $target = $value['target'];
		
		if( isset( $target ) ) {
			if( isset( $value['options'] ) ) {
				$value['options'] = $value['options'] + $this->select_target_options( $target, $nodisable );
			} else {
				$value['options'] = $this->select_target_options( $target, $nodisable );
			}
		}
		
		$out .= '<select name="' . $value['option'] . '[' . $value['setting'] . ']" id="' . $value['id'] . '" class="' . $toggle . 'it_select">';
		
		$out .= '<option value="">' . __( 'Choose one...', IT_TEXTDOMAIN ) . '</option>';
		
		if(is_array($value)) {
			if(array_key_exists('options',$value)) {
				foreach( (array)$value['options'] as $key => $option ) {
					if($target=='fonts') {
						$out .= '<option value="' . esc_attr( $key ) . '"';
					} else {
						$out .= '<option value="' . $key . '"';
					}
					if( isset( $value['value'] ) ) {
						if($target=='fonts') {
							if( stripslashes($value['value']) == $key ) {
								$out .= ' selected="selected"';
							}
						} else {
							if( $value['value'] == $key ) {
								$out .= ' selected="selected"';
							}
						}
						
					} elseif( isset( $value['default'] ) ) {
						if( $value['default'] == $key ) {
							$out .= ' selected="selected"';
						}
					}
					
					$out .= '>' . esc_attr( $option ) . '</option>';
				}
			}
		}
		
		$out .= '</select>';
		
		$out .= $this->option_end( $value );
		
		$out .= '</div><!-- .select_option_set -->';
		
		return $out;
	}
	
	/**
	 *
	 */
	function multidropdown_nested( $value ) {
		$toggle_class = ( !empty( $value['toggle_class'] ) ) ? $value['toggle_class'] . ' ' : '';
		
		$wrapper = isset($value['wrapper']) ? $value['wrapper'] : true;
		
		if($wrapper) $out = '<div class="' . $toggle_class . 'it_option_set multidropdown_option_set">';
		
		$out .= $this->option_start( $value );
		
		if( isset( $value['target'] ) ) {
			if( isset( $value['options'] ) ) {
				$value['options'] = $value['options'] + $this->select_target_options( $value['target'] );
			} else {
				$value['options'] = $this->select_target_options( $value['target'] );
			}
		}

		$selected_keys = ( isset( $value['value'] ) ) ? $value['value'] : array();		
		
		$label = isset($value['label']) ? $value['label'] : __('Choose one...', IT_TEXTDOMAIN);			
		
		$out .= '<div id="' . $value['option'] . '[' . $value['setting'] . ']" class="multidropdown">';
		
		$i = 0;
		foreach( $selected_keys as $selected ) {			
			$out .= '<select name="' . $value['id'] . '_' . $i . '" id="' . $value['id'] . '_' . $i . '" class="it_select multi_select">';
			$out .= '<option value=""> ' . $label . '</option>';
			foreach( $value['options'] as $key => $option ) {
				$out .= '<option value="' . $key . '"';
				if( $selected == $key ) {
					$out .= ' selected="selected"';
				}
				$out .= '>' . esc_attr( $option ) . '</option>';
			}
			$i++;
			$out .= '</select>';
		}
		
		$out .= '<select name="' . $value['id'] . '_' . $i . '" id="' . $value['id'] . '_' . $i . '" class="it_select">';
		$out .= '<option value="">' . $label . '</option>';
		foreach( $value['options'] as $key => $option ) {
			$out .= '<option value="' . $key . '">' . $option . '</option>';
		}
		$out .= '</select></div>';
		
		$out .= $this->option_end( $value );
	
		if($wrapper) $out .= '</div><!-- .multidropdown_option_set -->';
		
		return $out;
	}
		
	/**
	 *
	 */
	function select_target_options( $type, $nodisable = false ) {
		$options = array();
		$letters = explode(',', IT_LETTER_ARRAY);
		switch( $type ) {
			
			case 'seconds':				
				if(!$nodisable) $options[0] = 'Disable Auto-Scrolling';
				for($i=1;$i<=25;$i++) {					
					if($i==1) {
						$options[$i] = $i . " second";
					} else {
						$options[$i] = $i . " seconds";
					}
				}
				break;
			case 'seconds_decimal':
				if(!$nodisable) $options[0] = 'Disable';
				for($i=1;$i<=50;$i+=1) {
					if($i==10) {
						$options[$i] = $i/10 . " second";
					} else {
						$options[$i] = $i/10 . " seconds";
					}
				}				
				break;	
			case 'thousand':
				for($i=1;$i<=1000;$i++) {
					if($i<=30 || ($i>30 && $i<300 && $i % 10==0) || ($i>=300 && $i % 50==0))
						$options[$i] = $i;				
				}				
				break;	
			case 'icon_size':
				for($i=10;$i<=500;$i++) {
					if($i<=100 || ($i>100 && $i % 10==0))
						$options[$i] = $i . "px";				
				}				
				break;	
			case 'font_size':
				for($i=6;$i<=200;$i++) {
					$options[$i] = $i . "px";				
				}				
				break;	
			case 'percentage':
				for($i=1;$i<=100;$i++) {
					$options[$i] = $i . "%";				
				}				
				break;	
			case 'seconds_twitter':
				for($i=10;$i<=600;$i+=10) {
					$options[$i] = $i . " seconds";				
				}				
				break;			
			case 'trending_number':
				$options[-1] = 'Show All';
				for($i=4;$i<=80;$i+=4) {						
					$options[$i] = $i;					
				}
				break;
			case 'new_number':
				for($i=2;$i<=36;$i+=2) {						
					$options[$i] = $i;					
				}
				break;
			case 'recommended_number':
				for($i=1;$i<=30;$i++) {						
					$options[$i] = $i;					
				}
				break;
			case 'recommended_filters_number':
				for($i=1;$i<=20;$i++) {				
					$options[$i] = $i;					
				}
				break;
			case 'sizzlin_number':				
				$options[-1] = 'Show All';
				for($i=1;$i<=20;$i++) {				
					$options[$i] = $i;					
				}
				break;
			case 'steam_number':
				for($i=5;$i<=40;$i++) {				
					$options[$i] = $i;					
				}
				break;
			case 'twitter_number':
				for($i=1;$i<=10;$i++) {				
					$options[$i] = $i;					
				}
				break;
			case 'ad_number':
				if(!$nodisable) $options[0] = 'Disable';
				for($i=1;$i<=10;$i++) {				
					$options[$i] = $i;					
				}
				break;
			case 'flickr_number':
				for($i=1;$i<=30;$i++) {				
					$options[$i] = $i;					
				}
				break;
			case 'range_number':
				for($i=1;$i<=100;$i++) {				
					$options[$i] = $i;					
				}
				break;
			case 'grid_increment':
				if(!$nodisable) $options[0] = 'Disable';
				$options[1] = __('Every row',IT_TEXTDOMAIN);
				for($i=2;$i<=20;$i++) {				
					$options[$i] = __('Every',IT_TEXTDOMAIN) . '&nbsp;' . $i . '&nbsp;' . __('rows',IT_TEXTDOMAIN);					
				}
				break;
			case 'rating_stars':
				if(!$nodisable) $options['none'] = __('No Rating', IT_TEXTDOMAIN);
				if(!$nodisable) $options['user'] = __('Users can rate (no editor rating)', IT_TEXTDOMAIN);
				for($i=5;$i>0;$i-=.5) {
					$options["$i"] = $i;
				}
				break;
			case 'rating_letter':
				if(!$nodisable) $options['none'] = __('No Rating', IT_TEXTDOMAIN);
				if(!$nodisable) $options['user'] = __('Users can rate (no editor rating)', IT_TEXTDOMAIN);
				foreach($letters as $letter) {
					$options[$letter] = $letter;
				}
				break;
			case 'rating_number':
				if(!$nodisable) $options['none'] = __('No Rating', IT_TEXTDOMAIN);
				if(!$nodisable) $options['user'] = __('Users can rate (no editor rating)', IT_TEXTDOMAIN);
				for($i=10;$i>0;$i-=.1) {
					$val = round($i, 1);
					if($val > 0) $options["$val"] = $val;
				}
				break;
			case 'rating_percentage':
				if(!$nodisable) $options['none'] = __('No Rating', IT_TEXTDOMAIN);
				if(!$nodisable) $options['user'] = __('Users can rate (no editor rating)', IT_TEXTDOMAIN);
				for($i=100;$i>0;$i--) {
					$options[$i] = $i;
				}
				break;
			case 'page':
				$entries = get_pages( 'title_li=&orderby=name' );
				foreach( $entries as $key => $entry ) {
					$options[$entry->ID] = $entry->post_title;
				}
				break;
			case 'cat':
				$entries = get_categories( 'orderby=name&hide_empty=0' );
				foreach( $entries as $key => $entry ) {
					$options[$entry->term_id] = $entry->name;
				}
				break;
			case 'tag':
				$entries = get_tags( 'orderby=name&hide_empty=0' );
				foreach( $entries as $key => $entry ) {
					$options[$entry->term_id] = $entry->name;
				}
				break;		
			case 'custom_sidebars':
				$custom_sidebars = ( get_option( IT_SIDEBARS ) ) ? get_option( IT_SIDEBARS ) : array();
				foreach( $custom_sidebars as $key => $value ) {
					$options[$value] = $value;
				}
				break;
			case 'awards':
				$options = it_awards_meta();
				break;
			case 'badges':
				$options = it_badges_meta();
				break;
			case 'reactions':
				$options = it_reactions_meta();
				break;
			case 'fonts':
				$options = it_fonts();
				break;
			case 'signoff':
				$options = it_signoffs();
				break;
			case 'icons':
				$options = it_icons();
				break;
			case 'timeperiod':
				$effects = array( 'This Week' => __('This Week',IT_TEXTDOMAIN), 'This Month' => __('This Month',IT_TEXTDOMAIN), 'This Year' => __('This Year',IT_TEXTDOMAIN), '-7 days' => __('Within Past Week',IT_TEXTDOMAIN), '-30 days' => __('Within Past Month',IT_TEXTDOMAIN), '-60 days' => __('Within Past 2 Months',IT_TEXTDOMAIN), '-90 days' => __('Within Past 3 Months',IT_TEXTDOMAIN), '-180 days' => __('Within Past 6 Months',IT_TEXTDOMAIN), '-365 days' => __('Within Past Year',IT_TEXTDOMAIN), 'all' => __('All Time',IT_TEXTDOMAIN) );
				foreach( $effects as $key => $value ) {
					$options[$key] = $value;
				}
				break;
			case 'new_timeperiod':
				$effects = array( 'Today' => __('Today',IT_TEXTDOMAIN), 'This Week' => __('This Week',IT_TEXTDOMAIN), 'This Month' => __('This Month',IT_TEXTDOMAIN), 'This Year' => __('This Year',IT_TEXTDOMAIN), 'all' => __('Total Articles',IT_TEXTDOMAIN) );
				foreach( $effects as $key => $value ) {
					$options[$key] = $value;
				}
				break;
			case 'author_role':
				$effects = array( 'all' => __('All Roles',IT_TEXTDOMAIN), 'nonsubscriber' => __('All Roles Above Subscriber',IT_TEXTDOMAIN), 'subscriber' => __('Subscribers',IT_TEXTDOMAIN), 'contributor' => __('Contributors',IT_TEXTDOMAIN), 'author' => __('Authors',IT_TEXTDOMAIN), 'editor' => __('Editors',IT_TEXTDOMAIN), 'administrator' => __('Admins',IT_TEXTDOMAIN) );
				foreach( $effects as $key => $value ) {
					$options[$key] = $value;
				}
				break;
			case 'author_order':
				$effects = array( 'nicename' => __('Nice Name',IT_TEXTDOMAIN), 'email' => __('Email',IT_TEXTDOMAIN), 'url' => __('URL',IT_TEXTDOMAIN), 'registered' => __('Registered',IT_TEXTDOMAIN), 'display_name' => __('Display Name',IT_TEXTDOMAIN), 'post_count' => __('Post Count',IT_TEXTDOMAIN) );
				foreach( $effects as $key => $value ) {
					$options[$key] = $value;
				}
				break;
			case 'builder':
				$effects = array( 'page-content' => __('Page/Post Content',IT_TEXTDOMAIN), 'headliner' => __('Headliner',IT_TEXTDOMAIN), 'topten' => __('Top Ten',IT_TEXTDOMAIN), 'trending' => __('Trending',IT_TEXTDOMAIN), 'grid' => __('Grid',IT_TEXTDOMAIN), 'blog' => __('Blog',IT_TEXTDOMAIN), 'scroller' => __('Horizontal Scroller',IT_TEXTDOMAIN), 'widgets' => __('Widgets',IT_TEXTDOMAIN), 'connect' => __('Connect',IT_TEXTDOMAIN), 'menu' => __('Utility Menu',IT_TEXTDOMAIN), 'html' => __('Custom Content',IT_TEXTDOMAIN) );
				foreach( $effects as $key => $value ) {
					$options[$key] = $value;
				}
				break;
		}
		
		return $options;
	}
	
}

?>
