<?php

 /* theme options */

/**
 * Theme Option Page Example
 */
function sg_theme_menu()
{
  add_theme_page( 'Theme Option', 'Theme Options', 'manage_options', 'sg_theme_options.php', 'sg_theme_page');
}
add_action('admin_menu', 'sg_theme_menu');

/**
 * Callback function to the add_theme_page
 * Will display the theme options page
 */
function sg_theme_page()
{
?>
<div class="section panel">
<h1>Custom Theme Options</h1>
<form method="post" enctype="multipart/form-data" action="options.php">
        <?php
          settings_fields('sg_theme_options'); 
          do_settings_sections('sg_theme_options.php');
        ?>
<p class="submit">
                <input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
            
</form>

</div>
    <?php
}

/**
 * Register the settings to use on the theme options page
 */
add_action( 'admin_init', 'sg_register_settings' );
/**
 * Function to register the settings
 */
function sg_register_settings()
{
    // Register the settings with Validation callback
    register_setting( 'sg_theme_options', 'sg_theme_options', 'sg_validate_settings' );
    // Add settings section
    add_settings_section( 'sg_text_section', 'Text box Title', 'sg_display_section', 'sg_theme_options.php' );
    // Create textbox field
    $field_args = array(
      'type'      => 'text',
      'id'        => 'sg_textbox',
      'name'      => 'sg_textbox',
      'desc'      => 'Example of textbox description',
      'std'       => '',
      'label_for' => 'sg_textbox',
      'class'     => 'css_class'
    );
    add_settings_field( 'example_textbox', 'Example Textbox', 'sg_display_setting', 'sg_theme_options.php', 'sg_text_section', $field_args );
}

/**
 * Function to display the settings on the page
 * This is setup to be expandable by using a switch on the type variable.
 * In future you can add multiple types to be display from this function,
 * Such as checkboxes, select boxes, file upload boxes etc.
 */
function sg_display_setting($args)
{
    extract( $args );
    $option_name = 'sg_theme_options';
    $options = get_option( $option_name );
    switch ( $type ) {
          case 'text':
              $options[$id] = stripslashes($options[$id]);
              $options[$id] = esc_attr( $options[$id]);
              echo "<input class='regular-text$class' type='text' id='$id' name='" . $option_name . "[$id]' value='$options[$id]' />";
              echo ($desc != '') ? "<span class='description'>$desc</span>" : "";
          break;
    }
}

/**
 * Callback function to the register_settings function will pass through an input variable
 * You can then validate the values and the return variable will be the values stored in the database.
 */
function sg_validate_settings($input)
{
  foreach($input as $k => $v)
  {
    $newinput[$k] = trim($v);
    // Check the input is a letter or a number
    if(!preg_match('/^[A-Z0-9 _]*$/i', $v)) {
      $newinput[$k] = '';
    }
  }
  return $newinput;
}
