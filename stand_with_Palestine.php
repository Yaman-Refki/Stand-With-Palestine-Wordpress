<?php
/**
 * Plugin Name: Stand with Palestine
 * Description: Display "We stand with Palestine" with a flag in the bottom corner of the website.
 * Version: 1.0
 * Requires PHP: 7.2
 * Author: Yaman Refki
 * Author URI: https://yaman-refki.com
 * test
 */


// Register a custom settings page
function stand_with_palestine_menu() {
    add_options_page('Stand with Palestine Settings', 'Stand with Palestine', 'manage_options', 'stand_with_palestine_settings', 'stand_with_palestine_settings_page');
}
add_action('admin_menu', 'stand_with_palestine_menu');

// Register and initialize settings
function stand_with_palestine_settings_init() {
    register_setting('stand_with_palestine_group', 'stand_with_palestine_text');
    register_setting('stand_with_palestine_group', 'stand_with_palestine_link');
    register_setting('stand_with_palestine_group', 'stand_with_palestine_position', array(
        'default' => 'right'
    ));
    // Add a setting for the theme (light or dark)
    register_setting('stand_with_palestine_group', 'stand_with_palestine_theme', array(
        'default' => 'light', // Set the default theme to 'light'
    ));
}
add_action('admin_init', 'stand_with_palestine_settings_init');

// Create the settings page
function stand_with_palestine_settings_page() {
    ?>
    <div class="wrap">
        <h2>Stand with Palestine Settings</h2>
        <form method="post" action="options.php">
            <?php settings_fields('stand_with_palestine_group'); ?>
            <?php do_settings_sections('stand_with_palestine_group'); ?>
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Box Text</th>
                    <td><input type="text" name="stand_with_palestine_text" value="<?php echo esc_attr(get_option('stand_with_palestine_text', 'We #StandWithPalestine')); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Link URL (optional)</th>
                    <td><input type="text" name="stand_with_palestine_link" value="<?php echo esc_attr(get_option('stand_with_palestine_link')); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Position</th>
                    <td>
                        <label>
                            <input type="radio" name="stand_with_palestine_position" value="right" <?php checked(get_option('stand_with_palestine_position', 'right'), 'right'); ?> />
                            Right
                        </label>
                        <br>
                        <label>
                            <input type="radio" name="stand_with_palestine_position" value="left" <?php checked(get_option('stand_with_palestine_position', 'right'), 'left'); ?> />
                            Left
                        </label>
                    </td>
                </tr>
                <tr valign="top">
                    <th scope="row">Theme</th>
                    <td>
                        <label>
                            <input type="radio" name="stand_with_palestine_theme" value="light" <?php checked(get_option('stand_with_palestine_theme', 'light'), 'light'); ?> />
                            Light
                        </label>
                        <br>
                        <label>
                            <input type="radio" name="stand_with_palestine_theme" value="dark" <?php checked(get_option('stand_with_palestine_theme', 'light'), 'dark'); ?> />
                            Dark
                        </label>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

// Add the circular box with the text and link
function add_stand_with_palestine() {
    $plugin_url = plugin_dir_url(__FILE__);
    $flag_image_url = $plugin_url . 'Flag_of_Palestine.png';
    $box_text = get_option('stand_with_palestine_text');
    $box_link = get_option('stand_with_palestine_link', '');
    $box_position = get_option('stand_with_palestine_position', 'right');
    $theme = get_option('stand_with_palestine_theme', 'light');

    if (empty($box_text)) {
        $box_text = 'We #StandWithPalestine';
    }

    $position_css = $box_position === 'left' ? 'left: 20px;' : 'right: 20px;';
    $theme_css = $theme === 'light' ? 'background: #fff; color: #0e1217;' : 'background: #0e1217; color: #fff;';

    ?>
    <style>
        #stand-with-palestine {
            position: fixed;
            bottom: 20px;
            <?php echo $position_css; ?>
            <?php echo $theme_css; ?>
            padding: 15px;
            border-radius: 50px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            z-index: 999;
        }
        
        #stand-with-palestine a {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: <?php echo $theme === 'light' ? '#000' : '#fff'; ?>;
        }

        #stand-with-palestine img {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            margin-right: 10px;
            margin-left: 10px;
        }

        #stand-with-palestine span {
            display: block;
        }

        @media (max-width: 768px) {
            #stand-with-palestine {
                border-radius: 50%;
                padding: 10px;
                height: 50px;
                width: 50px;
            }
            #stand-with-palestine img {
                margin: 0;
            }
            #stand-with-palestine span {
                display: none;
            }
        }
    </style>
    <div id="stand-with-palestine">
        <a href="<?php echo $box_link; ?>">
            <img src="<?php echo $flag_image_url; ?>" alt="Flag" />
            <span><?php echo $box_text; ?></span>
        </a>
    </div>
    <script>
        document.getElementById('stand-with-palestine').addEventListener('click', function() {
            // You can add a link or action here if needed
        });
    </script>
    <?php
}

add_action('wp_footer', 'add_stand_with_palestine');
