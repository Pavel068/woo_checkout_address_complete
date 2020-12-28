<?php
/*
 * Plugin Name: WooCommerce Checkout Address Autocomplete
 * Author URI: https://github.com/Pavel068
 * Description: Autocomplete checkout form fields
 * Version: 1.0.0
 * Author: Pavel Trefilov
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: woo_checkout_address_complete
 * */

/* Init autocomplete */
add_action('woocommerce_after_checkout_form', 'init_woo_checkout_address_complete');
add_action('woocommerce_after_checkout_form', 'init_country_hide');

/* Add options (API, variables) */
add_option('google_maps_api_key', '');
add_option('is_country_hidden', '1');

/* Init admin menu */
add_action('admin_menu', 'init_admin_menu');

/* Autocomplete function */
function init_woo_checkout_address_complete()
{
    $api_key = get_option('google_maps_api_key');

    ?>
    <script src="<?php echo plugins_url("src/js/main.js", __FILE__) ?>?v=<?= rand(0, 999999) ?>"></script>
    <script defer
            src="https://maps.googleapis.com/maps/api/js?v=3.exp&key=<?= $api_key ?>&libraries=places&callback=initialize"></script>
    <?php
}

/* Hide country in checkout */
function init_country_hide()
{
    $is_country_hidden = get_option('is_country_hidden');

    ?>
    <script>
        <?php if ($is_country_hidden) : ?>
            document.querySelector('#billing_country_field').style.display = 'none';
        <?php endif; ?>
    </script>

    <?php
}

/* Init administrator menu function */
function init_admin_menu()
{
    add_options_page('WooCommerce Autocomplete - Settings', 'WC Autocomplete', 8, basename(__FILE__), 'settings_page');
}

/* Settings page */
function settings_page()
{
    if (isset($_POST['submit'])) {
        $new_api_key = $_POST['api_key'];
        $new_is_country_hidden = $_POST['is_country_hidden'] ? '1' : '0';
        update_option('google_maps_api_key', $new_api_key);
        update_option('is_country_hidden', $new_is_country_hidden);
    }

    $api_key = get_option('google_maps_api_key');
    $is_country_hidden = get_option('is_country_hidden');

    ?>

    <form action="" method="POST">
        <div class="field">
            <label for="api_ley">API KEY: </label>
            <input type="text" name="api_key" id="api_ley" value="<?= $api_key ?>">
        </div>
        <br>
        <div class="field">
            <label for="is_country_hidden">Hide country: </label>
            <input type="checkbox" name="is_country_hidden" id="is_country_hidden" <?= (bool)intval($is_country_hidden) ? 'checked' : ''?>>
        </div>
        <br/>
        <button name="submit">Save</button>
    </form>

    <?php
}