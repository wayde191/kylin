<?php
/**
 * @package WordPress
 * @subpackage Themolio
 */
?>
<?php global $themolio_options, $isThemolioMobile; ?>
</div> <!-- end of wrapper -->
<div id="footer">
    <div class="wrapper">
        <table class="tablayout"><tr>
            <td class="tdleft" style="width:50%;"><?php echo themolio_social_links(); ?></td>
            <td class="tdright" style="width:50%;">
                <p><?php _e('Copyright','themolio'); ?> &copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?></p>
            </td>
        </tr></table>
    </div>
</div>
<?php wp_footer(); ?>
</body>