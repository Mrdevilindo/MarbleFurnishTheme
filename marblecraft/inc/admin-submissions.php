<?php
/**
 * Admin Submissions Page for MarbleCraft Contact Form
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add admin menu page for contact form submissions
 */
function marblecraft_add_submissions_menu() {
    add_menu_page(
        __('Form Submissions', 'marblecraft'),
        __('Form Submissions', 'marblecraft'),
        'manage_options',
        'marblecraft-submissions',
        'marblecraft_submissions_page',
        'dashicons-feedback',
        30
    );
}
add_action('admin_menu', 'marblecraft_add_submissions_menu');

/**
 * Render submissions page
 */
function marblecraft_submissions_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'marblecraft_submissions';
    
    // Check if table exists
    if ($wpdb->get_var("SHOW TABLES LIKE '$table_name'") != $table_name) {
        echo '<div class="notice notice-error"><p>' . __('Submissions table does not exist. Please deactivate and reactivate the theme.', 'marblecraft') . '</p></div>';
        return;
    }
    
    // Handle bulk actions
    if (isset($_POST['action']) && $_POST['action'] === 'delete' && isset($_POST['submissions']) && is_array($_POST['submissions'])) {
        // Verify nonce
        check_admin_referer('marblecraft_submissions_bulk_action');
        
        $submissions = array_map('intval', $_POST['submissions']);
        $placeholders = implode(',', array_fill(0, count($submissions), '%d'));
        
        $wpdb->query($wpdb->prepare(
            "DELETE FROM $table_name WHERE id IN ($placeholders)",
            $submissions
        ));
        
        echo '<div class="notice notice-success"><p>' . __('Selected submissions deleted successfully.', 'marblecraft') . '</p></div>';
    }
    
    // Handle export action
    if (isset($_GET['action']) && $_GET['action'] === 'export') {
        marblecraft_export_submissions();
    }
    
    // Get submissions from database
    $submissions = $wpdb->get_results(
        "SELECT * FROM $table_name ORDER BY submission_date DESC",
        ARRAY_A
    );
    
    ?>
    <div class="wrap">
        <h1><?php esc_html_e('Contact Form Submissions', 'marblecraft'); ?></h1>
        
        <div class="tablenav top">
            <div class="alignleft actions">
                <a href="<?php echo esc_url(add_query_arg('action', 'export')); ?>" class="button action"><?php esc_html_e('Export to CSV', 'marblecraft'); ?></a>
            </div>
            <br class="clear">
        </div>
        
        <form method="post">
            <?php wp_nonce_field('marblecraft_submissions_bulk_action'); ?>
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <td id="cb" class="manage-column column-cb check-column">
                            <input id="cb-select-all-1" type="checkbox">
                        </td>
                        <th scope="col" class="manage-column column-date"><?php esc_html_e('Date', 'marblecraft'); ?></th>
                        <th scope="col" class="manage-column column-name"><?php esc_html_e('Name', 'marblecraft'); ?></th>
                        <th scope="col" class="manage-column column-email"><?php esc_html_e('Email', 'marblecraft'); ?></th>
                        <th scope="col" class="manage-column column-country"><?php esc_html_e('Country', 'marblecraft'); ?></th>
                        <th scope="col" class="manage-column column-message"><?php esc_html_e('Message', 'marblecraft'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($submissions)) : ?>
                        <tr>
                            <td colspan="6"><?php esc_html_e('No submissions found.', 'marblecraft'); ?></td>
                        </tr>
                    <?php else : ?>
                        <?php foreach ($submissions as $submission) : ?>
                            <tr>
                                <th scope="row" class="check-column">
                                    <input type="checkbox" name="submissions[]" value="<?php echo esc_attr($submission['id']); ?>">
                                </th>
                                <td><?php echo esc_html(date_i18n(get_option('date_format') . ' ' . get_option('time_format'), strtotime($submission['submission_date']))); ?></td>
                                <td><?php echo esc_html($submission['name']); ?></td>
                                <td><?php echo esc_html($submission['email']); ?></td>
                                <td><?php echo esc_html($submission['country']); ?></td>
                                <td><?php echo esc_html(wp_trim_words($submission['message'], 10)); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
            
            <div class="tablenav bottom">
                <div class="alignleft actions bulkactions">
                    <label for="bulk-action-selector-bottom" class="screen-reader-text"><?php esc_html_e('Select bulk action', 'marblecraft'); ?></label>
                    <select name="action" id="bulk-action-selector-bottom">
                        <option value="-1"><?php esc_html_e('Bulk Actions', 'marblecraft'); ?></option>
                        <option value="delete"><?php esc_html_e('Delete', 'marblecraft'); ?></option>
                    </select>
                    <input type="submit" class="button action" value="<?php esc_attr_e('Apply', 'marblecraft'); ?>">
                </div>
                <br class="clear">
            </div>
        </form>
    </div>
    <?php
}

/**
 * Export submissions to CSV
 */
function marblecraft_export_submissions() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'marblecraft_submissions';
    
    $submissions = $wpdb->get_results(
        "SELECT * FROM $table_name ORDER BY submission_date DESC",
        ARRAY_A
    );
    
    // Set headers for CSV download
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=marblecraft-submissions-' . date('Y-m-d') . '.csv');
    
    $output = fopen('php://output', 'w');
    
    // Add CSV headers
    fputcsv($output, array(
        __('ID', 'marblecraft'),
        __('Date', 'marblecraft'),
        __('Name', 'marblecraft'),
        __('Email', 'marblecraft'),
        __('Country', 'marblecraft'),
        __('Message', 'marblecraft'),
    ));
    
    // Add submissions data
    foreach ($submissions as $submission) {
        fputcsv($output, array(
            $submission['id'],
            $submission['submission_date'],
            $submission['name'],
            $submission['email'],
            $submission['country'],
            $submission['message'],
        ));
    }
    
    fclose($output);
    exit;
}
