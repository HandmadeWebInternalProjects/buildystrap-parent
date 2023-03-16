<template>
  <div class="module module-settings">
    <field-label
      v-if="config.label !== false"
      :label="config?.label !== undefined ? config.label : handle"
      :popover="config.popover" />
    <editor
      :init="initObj"
      v-model="content"
      api-key="no-api-key"
      :key="uuid + incrementValue"></editor>
  </div>
</template>
<script lang="ts" setup>
import { computed, reactive, inject } from "vue"
import { toRefs } from "vue"
import { useFieldType, commonProps } from "./useFieldType"
import { useBuilderStore } from "@/stores/builder"

import "../../lib/tinymce/tinymce.min.js"
import Editor from "@tinymce/tinymce-vue"
import "../../lib/tinymce/plugins/advlist/plugin.min.js"
import "../../lib/tinymce/plugins/anchor/plugin.min.js"
import "../../lib/tinymce/plugins/autolink/plugin.min.js"
import "../../lib/tinymce/plugins/autoresize/plugin.min.js"
import "../../lib/tinymce/plugins/contextmenu/plugin.min.js"
import "../../lib/tinymce/plugins/spellchecker/plugin.min.js"
import "../../lib/tinymce/plugins/searchreplace/plugin.min.js"
import "../../lib/tinymce/plugins/table/plugin.min.js"
import "../../lib/tinymce/plugins/wordcount/plugin.min.js"
import "../../lib/tinymce/plugins/print/plugin.min.js"

const props = defineProps({ ...commonProps })

const incrementValue = inject<any>("increment-value")?.incrementValue ?? 0

const { handle, config, uuid } = toRefs(props)
const content = computed({
  get() {
    return props.modelValue ? props.modelValue : ""
  },
  set(val) {
    update(val)
  },
})

const { builderConfig } = useBuilderStore()
const { theme_url } = builderConfig
const { tinymce: tinyMCEConfig } = config.value || {}

const emit = defineEmits(["update:modelValue", "updateMeta"])
const { update } = useFieldType(emit)

const initObj = reactive({
  branding: false,
  wpautop: true,
  theme: "modern",
  skin: "lightgray",
  content_css: `${theme_url}/backend-editor/gui/src/lib/tinymce/skins/wordpress/wp-content.css`,
  height: "240",
  language: "en",
  autoresize_min_height: "240",
  autoresize_bottom_margin: 1,
  formats: {
    alignleft: [
      {
        selector: "p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li",
        styles: { textAlign: "left" },
      },
      {
        selector: "img,table,dl.wp-caption",
        classes: "alignleft",
      },
    ],
    aligncenter: [
      {
        selector: "p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li",
        styles: { textAlign: "center" },
      },
      {
        selector: "img,table,dl.wp-caption",
        classes: "aligncenter",
      },
    ],
    alignright: [
      {
        selector: "p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li",
        styles: { textAlign: "right" },
      },
      {
        selector: "img,table,dl.wp-caption",
        classes: "alignright",
      },
    ],
    strikethrough: { inline: "del" },
  },
  style_formats: [
    {
      title: "Uppercase",
      inline: "span",
      styles: { textTransform: "uppercase" },
      classes: "text-uppercase",
    },
    {
      title: "Lowercase",
      inline: "span",
      styles: { textTransform: "lowercase" },
      classes: "text-lowercase",
    },
    {
      title: "Captialize",
      inline: "span",
      styles: { textTransform: "capitalize" },
      classes: "text-captialize",
    },
    {
      title: "Intro Text",
      inline: "span",
      styles: { fontSize: "1.2em" },
      classes: "text-intro",
    },
  ],
  relative_urls: false,
  remove_script_host: false,
  convert_urls: false,
  browser_spellcheck: true,
  fix_list_elements: true,
  entities: "38,amp,60,lt,62,gt",
  entity_encoding: "raw",
  keep_styles: false,
  paste_webkit_styles: "font-weight font-style color",
  preview_styles:
    "font-family font-size font-weight font-style text-decoration text-transform",
  tabfocus_elements: ":prev,:next",
  plugins:
    "advlist anchor autolink autoresize charmap code contextmenu fullscreen hr lists media print tabfocus spellchecker searchreplace table textcolor wordcount wordpress wpeditimage wpgallery wplink wpdialogs wpview",
  resize: "vertical",
  menubar: true,
  indent: false,
  toolbar1:
    "wp_add_media | uppercase | undo redo | formatselect | styleselect | link unlink | bold italic underline strikethrough | removeformat | bullist numlist | blockquote | alignleft aligncenter alignright | code | wp_adv",
  toolbar2:
    "shortcodes | forecolor backcolor | pastetext | charmap | hr fullscreen",
  toolbar3: "",
  toolbar4: "",
  contextmenu: "copy paste pastetext | link image",
  paste_retain_style_properties: "",
  body_class: "id post-type-post post-status-publish post-format-standard",
  wpeditimage_disable_captions: false,
  wpeditimage_html5_captions: true,
  setup: function (editor: any) {
    editor.addButton("shortcodes", {
      type: "menubutton",
      text: "Shortcodes",
      icon: false,
      menu: [
        {
          text: "Phone",
          onclick: function () {
            editor.insertContent("[company-phone]")
          },
        },
        {
          text: "Email",
          onclick: function () {
            editor.insertContent("[company-email]")
          },
        },
        {
          text: "Address",
          onclick: function () {
            editor.insertContent("[company-address]")
          },
        },
        {
          text: "Social Icons",
          onclick: function () {
            editor.insertContent("[social-icons]")
          },
        },
        {
          text: "Gravity Forms",
          onclick: function () {
            editor.insertContent(
              '[gravityforms id="" title="" description="" ajax=""]'
            )
          },
        },
      ],
    })
  },
  ...tinyMCEConfig,
})
</script>

<style lang="scss">
.editor__content {
  max-height: 300px;
  overflow-y: scroll;
  overflow-x: hidden;
}

#buildy-root .ql-editor p {
  margin-bottom: 15px;
}

.mce-tinymce.mce-panel {
  box-shadow: none;
  border: 1px solid #cccccc;
  border-radius: 5px;
  overflow: hidden;
}
.mce-tinymce .mce-top-part::before {
  box-shadow: none;
  border-top-left-radius: 3px;
  border-top-right-radius: 3px;
}
.mce-toolbar .mce-btn-group .mce-btn.mce-listbox {
  background: transparent;
  border: none;
}
.mce-toolbar .mce-btn-group .mce-btn {
  margin: 0 1px;
}
.mce-toolbar .mce-btn button {
  padding: 4px 3px;
}
.mce-panel .mce-menubar .mce-btn button i.mce-caret {
  margin-top: 6px;
}
.mce-panel .mce-btn button i.mce-caret {
  border-top: 4px solid #b5bcc2;
  border-bottom: 0;
}
.mce-toolbar .mce-btn-group .mce-btn.mce-active:not(.mce-btn-has-text),
.mce-toolbar .mce-btn-group .mce-btn:active:not(.mce-btn-has-text),
.qt-dfw.active:not(.mce-btn-has-text) {
  background: #666;
}
.mce-menu .mce-menu-item.mce-active.mce-menu-item-preview {
  background: #eee;
}
.mce-panel .mce-btn.mce-btn-has-text button,
.mce-panel .mce-btn.mce-btn-has-text button:hover {
  color: #595959;
}
.mce-panel .mce-btn.mce-active:not(.mce-btn-has-text) button {
  color: #fff;
}
.mce-panel .mce-btn.mce-active i,
.mce-panel .mce-btn.mce-active:hover i {
  color: #fff;
}
.mce-panel .mce-btn.mce-active button i.mce-caret {
  border-top: 0;
  border-bottom: 4px solid #b5bcc2;
}
.mce-i-code:before {
  vertical-align: middle;
}
.mce-toolbar.mce-last:not(.mce-first) {
  border-top: 1px solid #b5bcc2;
}
div.mce-toolbar-grp > div.mce-container-body {
  padding: 0;
}
.mce-toolbar-grp .mce-listbox button,
.mce-toolbar-grp .mce-btn-has-text button {
  line-height: 20px;
}
.mce-toolbar .mce-btn-has-text button {
  font-size: 13px;
}
.mce-menubtn.mce-fixed-width span {
  width: 80px;
}
div.mce-statusbar .mce-container-body {
  padding-left: 5px;
}
div.mce-statusbar .mce-container-body .mce-path-item {
  line-height: 24px;
}
.mce-menubtn button,
.mce-listbox button {
  min-height: 30px;
}
</style>
