<div>
  <div class="buildy acf-field acf-field-true-false" data-name="active" data-type="true_false">
    <div class="acf-input">
    <div class="acf-true-false">
      <label>
        <input type="hidden" name="_buildy_enabled" value="0">
        <input type="checkbox" id="_buildy_enabled" name="_buildy_enabled" value="1" class="acf-switch-input" autocomplete="off" {{ $enabled ? 'checked="checked"' : null }}>
        <div class="acf-switch {{ $enabled ? '-on' : null }}"><span class="acf-switch-on">Enabled</span><span class="acf-switch-off">Disabled</span><div class="acf-switch-slider"></div></div>
      </label>
    </div>
    </div>
  </div>
</div>

<style> 
  .buildy.acf-field:last-child {
    margin-bottom: 0;
  }
  .buildy.acf-field .acf-switch {
    box-sizing: initial;
  }
  .buildy.acf-field .acf-switch.-on {
    background: var(--bs-indigo, #0d99d5);
    border-color: var(--bs-indigo, #007cba);
  }
  .buildy.acf-field .acf-switch .acf-switch-on {
    text-shadow: var(--bs-indigo,#007cba) 0 1px 0;
  }
  .buildy.acf-field .acf-switch.-on .acf-switch-slider {
    border-color: var(--bs-indigo, #007cba);
  }
</style>