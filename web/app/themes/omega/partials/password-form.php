<?php
/**
 * Password protected form for password protected posts / pages
 *
 * @package Omega
 * @subpackage Admin
 *
 * @copyright (c) 2014 Oxygenna.com
 * @license **LICENSE**
 * @version 1.18.12
 * @author Oxygenna.com
 */
?>
<div class="container">
    <div class="row element-normal-top element-normal-bottom">
        <div class="col-md-8 col-md-push-2 text-default small-screen-default">
            <h3><?php _e('To view this protected post, enter the password below:', 'omega-td'); ?></h3>

            <form action="<?php echo esc_url(site_url('wp-login.php?action=postpass', 'login_post')); ?>" method="post">
                <div class="form-group">
                    <input style="background: #EBE7E7;" class="form-control" name="post_password" id="<?php echo $label; ?>" type="password" size="20" maxlength="20" />
                </div>
                <input class="btn btn-primary" type="submit" name="Submit" value="<?php echo esc_attr_e('Submit', 'omega-td'); ?>" />
            </form>
        </div>
    </div>
</div>