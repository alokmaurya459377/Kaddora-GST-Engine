<div class="gst-wrap">

  <div class="gst-page-head">
    <div>
      <h1>GST Engine Settings</h1>
      <p class="gst-page-subtitle">Configure business identity, invoice rules, and plugin behavior from one clean control panel.</p>
    </div>
  </div>

  <?php if (!gst_is_pro_active()) : ?>
    <div class="gst-inline-notice">
      <strong>Upgrade to Pro</strong>
      <p><?php echo esc_html(gst_get_upgrade_message()); ?></p>
      <a href="<?php echo esc_url(admin_url('admin.php?page=gst-upgrade')); ?>" class="button button-primary">Upgrade Now</a>
    </div>
  <?php endif; ?>

  <form method="post" action="options.php">

    <?php settings_fields('gst_settings_group'); ?>

    <div class="gst-settings-grid">
      <div class="gst-card gst-settings-card">
        <div class="gst-section-head gst-section-head-stack">
          <div>
            <h2>Business Details</h2>
            <p class="gst-section-subtitle">These details appear in GST workflows and help determine compliance status.</p>
          </div>
        </div>

        <div class="gst-form-grid">
          <div class="gst-field">
            <label class="gst-label" for="gst_gstin">GSTIN</label>
            <input id="gst_gstin" type="text" name="gst_gstin"
              value="<?php echo esc_attr(get_option('gst_gstin')); ?>" class="gst-input">
          </div>

          <div class="gst-field">
            <label class="gst-label" for="gst_store_state">Store State</label>
            <input id="gst_store_state" type="text" name="gst_store_state"
              value="<?php echo esc_attr(get_option('gst_store_state')); ?>" class="gst-input">
          </div>
        </div>
      </div>

      <div class="gst-card gst-settings-card">
        <div class="gst-section-head gst-section-head-stack">
          <div>
            <h2>Invoice Settings</h2>
            <p class="gst-section-subtitle">Control numbering, automation, and access to Pro-only behavior.</p>
          </div>
        </div>

        <div class="gst-form-grid">
          <div class="gst-field">
            <label class="gst-label" for="gst_invoice_prefix">Invoice Prefix</label>
            <input id="gst_invoice_prefix" type="text" name="gst_invoice_prefix"
              value="<?php echo esc_attr(get_option('gst_invoice_prefix', 'GST')); ?>" class="gst-input gst-input-small">
          </div>

          <div class="gst-toggle-list">
            <label class="gst-toggle-row">
              <span>
                <strong>Auto Generate Invoice</strong>
                <small>Create invoices automatically when WooCommerce orders reach the configured status.</small>
              </span>
              <input type="checkbox" name="gst_enable_auto_invoice" value="1"
                <?php checked(get_option('gst_enable_auto_invoice', 1), 1); ?>>
            </label>

            <label class="gst-toggle-row">
              <span>
                <strong>Pro License Status</strong>
                <small>Enable only if a valid Pro license or future license connector is active.</small>
              </span>
              <input type="checkbox" name="gst_pro_active" value="1"
                <?php checked(get_option('gst_pro_active'), 1); ?>>
            </label>
          </div>
        </div>
      </div>
    </div>

    <?php submit_button(); ?>

  </form>

</div>
