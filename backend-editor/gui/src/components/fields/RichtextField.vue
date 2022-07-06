<template>
  <div class="module module-settings">
    <field-label :label="config?.label !== undefined ? config.label : handle" />
    <editor :init="initObj" v-model="content" api-key="no-api-key"></editor>
  </div>
</template>
<script lang="ts" setup>
import { computed, reactive, onBeforeMount } from "vue"
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
import "../../lib/tinymce/plugins/powerpaste/plugin.js"
import "../../lib/tinymce/plugins/powerpaste/js/wordimport.js"
import "../../lib/tinymce/plugins/print/plugin.min.js"

const props = defineProps({ ...commonProps })

const { handle, config, uuid } = toRefs(props)
const content = computed({
  get() {
    return props.modelValue ? props.modelValue : ""
  },
  set(val) {
    update(val)
  },
})

const { getBuilderConfig } = useBuilderStore()
const { theme_url } = getBuilderConfig
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
    "advlist anchor autolink autoresize charmap code contextmenu fullscreen hr lists media powerpaste print tabfocus spellchecker searchreplace table textcolor wordcount wordpress wpeditimage wpgallery wplink wpdialogs wpview",
  resize: "vertical",
  menubar: true,
  indent: false,
  toolbar1:
    "wp_add_media | undo redo | formatselect | link unlink | bold italic underline strikethrough | removeformat | bullist numlist | blockquote | alignleft aligncenter alignright | code | wp_adv",
  toolbar2:
    "shortcodes | forecolor backcolor | pastetext | charmap | hr fullscreen",
  toolbar3: "",
  toolbar4: "",
  contextmenu: "copy paste pastetext | link image",
  powerpaste_allow_local_images: true,
  powerpaste_word_import: "clean",
  powerpaste_html_import: "clean",
  paste_retain_style_properties: "",
  body_class: "id post-type-post post-status-publish post-format-standard",
  wpeditimage_disable_captions: false,
  wpeditimage_html5_captions: true,
  setup: function (editor) {
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
</style>
