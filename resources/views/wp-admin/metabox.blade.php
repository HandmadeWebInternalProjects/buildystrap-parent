<div style="padding: 0.6rem;">
  <h6 style="font-size: 1.2em; margin-bottom: 0.5em; margin-top: 0;">Pagebuilder Enabled</h6>
  <label>
    <span>Yes</span>
    <input type="radio" name="_buildy_enabled" value="1" autocomplete="off" {{ $enabled ? 'checked="checked"' : null }}>
  </label>
  <label>
    <span>No</span>
    <input type="radio" name="_buildy_enabled" value="0" autocomplete="off" {{ !$enabled ? 'checked="checked"' : null }}>
  </label>
</div>