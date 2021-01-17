<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://portafolio.cotillo.tech
 * @since      1.0.0
 *
 * @package    Calc_Financiera
 * @subpackage Calc_Financiera/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<a href="<?php echo admin_url( 'admin-post.php?action=csv_export' ); ?>" class="button button-primary" target="_blank">Export CSV</a>