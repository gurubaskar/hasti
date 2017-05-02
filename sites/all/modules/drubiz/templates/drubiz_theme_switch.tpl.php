<?php global $drubiz_demo_theme_options; ?>
<?php if (drubiz_user_is_demo_administrator() && !empty($drubiz_demo_theme_options)): ?>
  <li>
    <label for="drubiz-demo-admin-change-theme"><?php echo t('Change Theme') ?>: </label>
    <select id="drubiz-demo-admin-change-theme">
      <?php foreach ($drubiz_demo_theme_options as $theme_option_key => $theme_option_value): ?>
        <option <?php echo $GLOBALS['theme'] == $theme_option_value['theme'] ? 'selected="selected"' : '' ?> value="<?php echo $theme_option_key ?>"><?php echo t($theme_option_value['name']) ?></option>
      <?php endforeach; ?>
    </select>
  </li>
<?php endif; ?>
