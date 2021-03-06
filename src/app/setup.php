<?php

/**
 * Theme setup.
 */

namespace App;

use Exception;

use function Roots\asset;

/**
 * Register the theme assets.
 *
 * @return void
 */
add_action('wp_enqueue_scripts', function () {
    wp_enqueue_script('sage/vendor.js', asset('scripts/vendor.js')->uri(), ['jquery'], null, true);
    wp_enqueue_script('sage/app.js', asset('scripts/app.js')->uri(), ['sage/vendor.js'], null, true);

    wp_add_inline_script('sage/vendor.js', asset('scripts/manifest.js')->contents(), 'before');

    if (is_single() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }

    wp_enqueue_style('sage/app.css', asset('styles/app.css')->uri(), false, null);
    wp_enqueue_style('fontello', asset('fonts/fontello/css/fontello.css')->uri(), false, null);
}, 100);

/**
 * Register the theme assets with the block editor.
 *
 * @return void
 */
add_action('enqueue_block_editor_assets', function () {
    if ($manifest = asset('scripts/manifest.asset.php')->load()) {
        wp_enqueue_script('sage/vendor.js', asset('scripts/vendor.js')->uri(), ...array_values($manifest));
        wp_enqueue_script('sage/editor.js', asset('scripts/editor.js')->uri(), ['sage/vendor.js'], null, true);

        wp_add_inline_script('sage/vendor.js', asset('scripts/manifest.js')->contents(), 'before');
    }

    wp_enqueue_style('sage/editor.css', asset('styles/editor.css')->uri(), false, null);
}, 100);

/**
 * Register the initial theme setup.
 *
 * @return void
 */
add_action('after_setup_theme', function () {
    /**
     * Enable features from the Soil plugin if activated.
     * @link https://roots.io/plugins/soil/
     */
    add_theme_support('soil', [
        'clean-up',
        'nav-walker',
        'nice-search',
        'relative-urls'
    ]);

    /**
     * Disable full-site editing support.
     *
     * @link https://wptavern.com/gutenberg-10-5-embeds-pdfs-adds-verse-block-color-options-and-introduces-new-patterns
     */
    remove_theme_support('block-templates');

    /**
     * Register the navigation menus.
     * @link https://developer.wordpress.org/reference/functions/register_nav_menus/
     */
    register_nav_menus([
        'primary_navigation' => __('Primary Navigation', 'sage')
    ]);

    /**
     * Register the editor color palette.
     * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#block-color-palettes
     */
    add_theme_support('editor-color-palette', []);

    /**
     * Register the editor color gradient presets.
     * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#block-gradient-presets
     */
    add_theme_support('editor-gradient-presets', []);

    /**
     * Register the editor font sizes.
     * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#block-font-sizes
     */
    add_theme_support('editor-font-sizes', []);

    /**
     * Register relative length units in the editor.
     * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#support-custom-units
     */
    add_theme_support('custom-units');

    /**
     * Enable support for custom line heights in the editor.
     * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#supporting-custom-line-heights
     */
    add_theme_support('custom-line-height');

    /**
     * Enable support for custom block spacing control in the editor.
     * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#spacing-control
     */
    add_theme_support('custom-spacing');

    /**
     * Disable custom colors in the editor.
     * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#disabling-custom-colors-in-block-color-palettes
     */
    add_theme_support('disable-custom-colors');

    /**
     * Disable custom color gradients in the editor.
     * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#disabling-custom-gradients
     */
    add_theme_support('disable-custom-gradients');

    /**
     * Disable custom font sizes in the editor.
     * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#disabling-custom-font-sizes
     */
    add_theme_support('disable-custom-font-sizes');

    /**
     * Disable the default block patterns.
     * @link https://developer.wordpress.org/block-editor/developers/themes/theme-support/#disabling-the-default-block-patterns
     */
    remove_theme_support('core-block-patterns');

    /**
     * Enable plugins to manage the document title.
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#title-tag
     */
    add_theme_support('title-tag');

    /**
     * Enable post thumbnail support.
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support('post-thumbnails');

    /**
     * Enable wide alignment support.
     * @link https://wordpress.org/gutenberg/handbook/designers-developers/developers/themes/theme-support/#wide-alignment
     */
    add_theme_support('align-wide');

    /**
     * Enable responsive embed support.
     * @link https://wordpress.org/gutenberg/handbook/designers-developers/developers/themes/theme-support/#responsive-embedded-content
     */
    add_theme_support('responsive-embeds');

    /**
     * Enable HTML5 markup support.
     * @link https://developer.wordpress.org/reference/functions/add_theme_support/#html5
     */
    add_theme_support('html5', [
        'caption',
        'comment-form',
        'comment-list',
        'gallery',
        'search-form',
        'script',
        'style'
    ]);

    /**
     * Enable selective refresh for widgets in customizer.
     * @link https://developer.wordpress.org/themes/advanced-topics/customizer-api/#theme-support-in-sidebars
     */
    add_theme_support('customize-selective-refresh-widgets');
}, 20);

/**
 * Register the theme sidebars.
 *
 * @return void
 */
add_action('widgets_init', function () {
    $config = [
        'before_widget' => '<section class="widget %1$s %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h3>',
        'after_title' => '</h3>'
    ];

    register_sidebar([
        'name' => __('Primary', 'sage'),
        'id' => 'sidebar-primary'
    ] + $config);

    register_sidebar([
        'name' => __('Footer', 'sage'),
        'id' => 'sidebar-footer'
    ] + $config);
});

add_action('wp_login_failed', function () {
    $login_page  = home_url('/login/');
    wp_redirect($login_page . '?login=failed');
    exit;
});

add_action('wp_logout', function () {
    $login_page  = home_url('/login/');
    wp_redirect($login_page . "?login=false");
    exit;
});


/**
 * Create Report
 *
 * @author       Hansanghyeon
 * @copyright    Hansanghyeon <999@hyeon.pro>
 **/

add_action('wp_loaded', function () {
    try {
        if ($_SERVER['REQUEST_URI'] === '/create-report/' && is_user_logged_in() || $_SERVER['REQUEST_URI'] === '/create-report' && is_user_logged_in()) {
            // Check that the nonce was set and valid
            if (isset($_POST['_wpnonce']) && !wp_verify_nonce($_POST['_wpnonce'], 'wps-frontend-post')) {
                // echo '????????? ????????? ????????? ??? ????????? ????????? ????????? ???????????? ???????????????. ???????????????';
                return;
            }

            // Stop running function if form wasn't submitted
            if (!isset($_POST['title'])) {
                // echo '????????? ?????????????????? ??????';
                return;
            }

            // Do some minor form validation to make sure there is content
            if (strlen($_POST['title']) < 3) {
                // echo '????????? ??????????????????. ????????? ????????? 3 ??? ????????????????????????.';
                return;
            }

            // Add the content of the form to $post as an array
            $post = array(
                'post_title'    => $_POST['title'],
                'post_content'  => $_POST['content'],
                'post_status'   => 'private',   // Could be: publish
                'post_type'   => 'report' // Could be: `page` or your CPT
            );
            $new_post = wp_insert_post($post);

            if ($_FILES) {
                if (!function_exists('wp_generate_attachment_metadata')) {
                    require_once(ABSPATH . "wp-admin" . '/includes/image.php');
                    require_once(ABSPATH . "wp-admin" . '/includes/file.php');
                    require_once(ABSPATH . "wp-admin" . '/includes/media.php');
                }

                foreach ($_FILES as $file => $array) {
                    if ($_FILES[$file]['error'] !== UPLOAD_ERR_OK) {
                        return "upload error : " . $_FILES[$file]['error'];
                    }
                    $attach_id = media_handle_upload($file, $new_post);

                    // Please use field key instead of field name
                    $field_key = 'field_61b1a87048bc5';

                    // Get the field value first if it's available
                    $repeater_value = get_field('attached-files', $new_post);

                    // Add the row to the repeater
                    if (is_array($repeater_value)) {
                        array_push($repeater_value, array('file' => $attach_id));
                    } else {
                        $repeater_value[] = array('file' => $attach_id);
                    }

                    // Update the repeater field
                    update_field($field_key, $repeater_value, $new_post);
                }
            }

            // default status ?????????
            update_field('status', 'waiting', $new_post);

            $link = get_the_permalink($new_post);

            // ??????????????? ??????????????? ?????? ?????????
            $nt = get_field('notification_targets', 'options');
            if ($nt) {
                $targets = array_map(function ($user) {
                    $user = $user['user'];
                    return $user->user_email;
                }, $nt);
                wp_mail(
                    $targets,
                    '[??????????????????] ????????? ???????????? ?????? ??????',
                    <<<EOD
            ?????????????????? ?????? ??????????????????.
            ????????? ???????????? ????????? ??????????????? ?????????????????????.
            ?????? ????????????.

            ????????? ???????????? - $link
EOD
                );
            }
            $redirect = get_home_url() . '/create-report?posting=done&postlink=' . $link;
            wp_redirect($redirect);
            exit;
        }

        if ($_SERVER['REQUEST_URI'] === '/create-report/' && !is_user_logged_in()) {
            $redirect = get_home_url() . '/signup?title=????????????';
            wp_redirect($redirect);
            exit;
        }
    } catch (\Throwable $th) {
        wp_mail( 'x-aaaae3fezbrhkq7mr7ob6xnosa@peteroseainc.slack.com', '[ERROR] Create Report', $th->getMessage() );
        echo $th->getMessage();
    }
});

/**
 * register ?????? ????????????
 *
 * @author       Hansanghyeon
 * @copyright    Hansanghyeon <999@hyeon.pro>
 **/

add_action('template_redirect', function () {
    if (!is_user_logged_in() && isset($_GET['do']) && $_GET['do'] == 'register' && isset($_POST['user']) && isset($_POST['password'])) :
        $errors = array();

        if (empty($_POST['password']) || strlen($_POST['password']) <= 4) {
            $errors[] = '??????????????? ?????? ????????????. 4?????????????????? ??????????????????';
        }

        if (empty($_POST['user'])) $errors[] = '????????? ??? ???????????? ??????????????????';

        $user_login = esc_attr($_POST['user']);
        $user_email = esc_attr($_POST['email']);
        $user_password = esc_attr($_POST['password']);
        require_once(ABSPATH . WPINC . '/registration.php');

        $sanitized_user_login = sanitize_user($user_login);
        $user_email = apply_filters('user_registration_email', $user_email);

        if (empty($_POST['email'])) :
            $user_email = wp_generate_password(8) . '@auto.mate';
        else :
            if (!is_email($user_email)) $errors[] = '????????? ?????????';
            elseif (email_exists($user_email)) $errors[] = '??? ???????????? ?????? ?????????????????????.';
        endif;

        if (empty($sanitized_user_login) || !validate_username($user_login)) $errors[] = '????????? ????????? ??????';
        elseif (username_exists($sanitized_user_login)) $errors[] = '????????? ????????? ?????? ???????????????';

        if (empty($errors)) :
            $user_id = wp_create_user($sanitized_user_login, $user_password, $user_email);

            if (!$user_id) :
                $errors[] = '?????? ??????';
            else :
                // custom field update
                if (!empty($contact = $_POST['contact'])) {
                    update_field('contact', $contact, 'user_' . $user_id);
                }
                if (!empty($name = $_POST['last_name'])) {
                    wp_update_user(array(
                        'ID' => $user_id,
                        'last_name' => $name
                    ));
                }
            endif;
        endif;


        if (!empty($errors)) define('REGISTRATION_ERROR', serialize($errors));
        else {
            define('REGISTERED_A_USER', $user_email);
            wp_signon(array(
                'user_login' => $sanitized_user_login,
                'user_password' => $user_password,
            ));
        }
    endif;
});

/**
 * ???????????? ???????????? ?????? ????????? ??? ????????????
 *
 * @author       Hansanghyeon
 * @copyright    Hansanghyeon <999@hyeon.pro>
 **/

add_action('after_setup_theme', function () {
    if (!current_user_can('edit_users')) {
        show_admin_bar(false);
    }
});


/**
 * ????????? ????????? ????????? ?????? ??????
 *
 * @author       Hansanghyeon
 * @copyright    Hansanghyeon <999@hyeon.pro>
 **/

add_filter('the_title', function ($title) {
    $title = str_replace('Private: ', '', $title);
    $title = str_replace('?????????: ', '', $title);
    return $title;
});

/**
 * ????????? ?????? ?????? ??????
 *
 * @author       Hansanghyeon
 * @copyright    Hansanghyeon <999@hyeon.pro>
 **/

add_action('wp_loaded', function () {
    if (isset($_SERVER['REDIRECT_URL']) && strpos($_SERVER['REDIRECT_URL'], 'report') && !is_user_logged_in()) {
        $redirect = home_url('/login/?to=/report/');
        wp_redirect($redirect);
        exit;
    }
});

/**
 * ????????? ????????????
 *
 * @author       Hansanghyeon
 * @copyright    Hansanghyeon <999@hyeon.pro>
 **/

add_action('wp_loaded', function () {
    if (isset($_POST['action']) && is_user_logged_in() && current_user_can('moderate_comments') && $_POST['action'] === 'editedcomment') {
        if (!isset($_POST['comment_ID'])) {
            return;
        }

        if (!isset($_POST['comment'])) {
            return;
        }

        wp_update_comment(array(
            'comment_ID' => $_POST['comment_ID'],
            'comment_content' => $_POST['comment']
        ));
        wp_redirect($_POST['request']);
        exit;
    }
});


/**
 * ????????? html ??????
 *
 * @author       Hansanghyeon
 * @copyright    Hansanghyeon <999@hyeon.pro>
 **/

add_action('init', function () {
    global $allowedtags;
    $allowedtags['pre'] = array('class' => array());
    $allowedtags['p'] = array('class' => array());
    $allowedtags['code'] = array('class' => array());
    $allowedtags['strong'] = array('class' => array());
    $allowedtags['href'] = array('class' => array());
    $allowedtags['h1'] = array('class' => array());
    $allowedtags['h2'] = array('class' => array());
    $allowedtags['h3'] = array('class' => array());
    $allowedtags['h4'] = array('class' => array());
    $allowedtags['h5'] = array('class' => array());
    $allowedtags['h6'] = array('class' => array());
    $allowedtags['ul'] = array('class' => array());
    $allowedtags['li'] = array('class' => array());
}, 11);

add_action('template_redirect', function () {
    if (current_user_can('moderate_comments') && isset($_POST['status']) && isset($_POST['post_id'])) :
        $post_id = $_POST['post_id'];

        $status = match ($_POST['status']) {
            '?????????' => 'waiting',
            '?????????' => 'processing',
            '????????????' => 'remove',
        };
        if ($status === 'remove') :
            $comments = get_comments(array(
                'post_id' => $post_id,
            ));
            foreach ($comments as $comment) {
                wp_delete_comment($comment->comment_ID);
            }
            $status = 'processing';
        endif;

        update_field('status', $status, $post_id);
    endif;
});


/**
 * ????????? ????????? redirect ??????
 *
 * @author       Hansanghyeon
 * @copyright    Hansanghyeon <999@hyeon.pro>
 **/

add_filter('login_redirect', function ($redirect_to, $request, $user) {
    return $request;
}, 10, 3);

/**
 * ????????? ??????
 *
 * @author       Hansanghyeon
 * @copyright    Hansanghyeon <999@hyeon.pro>
 **/

add_action('wp_loaded', function () {
    if (!(isset($_SERVER['REDIRECT_URL']) && strpos($_SERVER['REDIRECT_URL'], 'admin_check'))) return;
    if (current_user_can('moderate_comments')) :
        exit;
    else :
        $redirect = home_url('/404');
        wp_redirect($redirect);
        exit;
    endif;
});
