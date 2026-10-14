<?php
/**
 * Plugin Name: Sum Master 3000
 * Description: A simple sum calculator plugin.
 * Version: 1.0.0
 * Author: Minhaj
 */

// Prevent WordPress from trying to update this plugin
add_filter('plugins_api', function ($res, $action, $args) {
    if ($args->slug === 'simple-calculator') {
        return new WP_Error('invalid_request', 'This is a custom plugin.');
    }
    return $res;
}, 10, 3);

// Remove update notice for this plugin
add_filter('site_transient_update_plugins', function ($transient) {
    if (isset($transient->response['simple-calculator/simple-calculator.php'])) {
        unset($transient->response['simple-calculator/simple-calculator.php']);
    }
    return $transient;
});

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Add admin menu
add_action('admin_menu', function () {
    add_menu_page(
        'Simple Calculator',
        'Calculator',
        'manage_options',
        'simple-calculator',
        'simple_calculator_page'
    );
});

// Render admin page
function simple_calculator_page()
{
    $result = '';
    if (isset($_POST['num1']) && isset($_POST['num2'])) {
        $result = floatval($_POST['num1']) + floatval($_POST['num2']);
    }
    ?>
    <div class="wrap">
        <h1>Simple Sum Calculator</h1>
        <form method="post">
            <table class="form-table">
                <tr>
                    <th><label for="num1">Number 1</label></th>
                    <td><input type="number" step="any" name="num1" id="num1" value="<?php echo esc_attr($_POST['num1'] ?? ''); ?>" required /></td>
                </tr>
                <tr>
                    <th><label for="num2">Number 2</label></th>
                    <td><input type="number" step="any" name="num2" id="num2" value="<?php echo esc_attr($_POST['num2'] ?? ''); ?>" required /></td>
                </tr>
            </table>
            <?php submit_button('Calculate'); ?>
        </form>
        <?php if ($result !== ''): ?>
            <div class="notice notice-success"><p><strong>Result:</strong> <?php echo esc_html($result); ?></p></div>
        <?php endif; ?>
    </div>
    <?php
}

// Frontend shortcode: [simple_calculator]
add_shortcode('simple_calculator', function () {
    $result = '';
    if (isset($_POST['num1']) && isset($_POST['num2'])) {
        $result = floatval($_POST['num1']) + floatval($_POST['num2']);
    }
    ob_start();
    ?>
    <div style="max-width:400px;margin:20px auto;padding:20px;border:2px solid #333;border-radius:10px;background:#f9f9f9;">
        <h2 style="margin-top:0;">🧮 Sum Calculator</h2>
        <form method="post">
            <p>
                <label>Number 1:<br>
                <input type="number" step="any" name="num1" value="<?php echo esc_attr($_POST['num1'] ?? ''); ?>" required style="width:100%;padding:8px;" />
                </label>
            </p>
            <p>
                <label>Number 2:<br>
                <input type="number" step="any" name="num2" value="<?php echo esc_attr($_POST['num2'] ?? ''); ?>" required style="width:100%;padding:8px;" />
                </label>
            </p>
            <button type="submit" style="padding:10px 20px;background:#333;color:#fff;border:none;border-radius:5px;cursor:pointer;">
                Calculate Sum
            </button>
        </form>
        <?php if ($result !== ''): ?>
            <div style="margin-top:15px;padding:15px;background:#d4edda;border:1px solid #c3e6cb;border-radius:5px;">
                <strong>Result: <?php echo esc_html($result); ?></strong>
            </div>
        <?php endif; ?>
    </div>
    <?php
    return ob_get_clean();
});
