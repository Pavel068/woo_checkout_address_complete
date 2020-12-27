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

add_action('wp_footer', 'init_woo_checkout_address_complete');

function init_woo_checkout_address_complete()
{
    ?>
    <script src="<?php echo plugins_url("src/js/main.js", __FILE__)?>?v=<?= rand(0, 999999) ?>"></script>
    <script defer src="https://maps.googleapis.com/maps/api/js?v=3.exp&key={key}&libraries=places&callback=initialize"></script>
    <?php
}