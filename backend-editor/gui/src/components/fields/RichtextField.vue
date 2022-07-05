<template>
  <div class="module module-settings">
    <field-label :label="config.label || handle" />
    <editor :init="initObj" v-model="content" api-key="no-api-key"></editor>
  </div>
</template>
<script lang="ts" setup>
import { computed, reactive } from "vue"
import { toRefs } from "vue"
import { useFieldType, commonProps } from "./useFieldType"
import Editor from "@tinymce/tinymce-vue"
import "../../lib/tinymce/plugins/advlist/plugin.min.js"
import "../../lib/tinymce/plugins/table/plugin.min.js"

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

const { tinymce: tinyMCEConfig } = config.value || {}

console.log({ tinyMCEConfig })

const emit = defineEmits(["update:modelValue", "updateMeta"])
const { update } = useFieldType(emit)

const initObj = reactive({
  branding: false,
  wpautop: true,
  theme: "modern",
  skin: "lightgray",
  height: "240",
  language: "en",
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
    "charmap,hr,media,paste,tabfocus,lists,textcolor,fullscreen,wordpress,wpeditimage,wpgallery,wplink,wpdialogs,wpview, table, advlist",
  resize: "vertical",
  menubar: true,
  indent: false,
  toolbar1:
    "undo redo | wp_add_media | table | format bold italic strikethrough | bullist | numlist | blockquote | fontawesome | hr | alignleft | aligncenter | alignright | link | unlink ",
  toolbar2:
    "formatselect,underline,alignjustify,forecolor,pastetext,removeformat,charmap,,undo,redo,wp_help",
  toolbar3: "",
  toolbar4: "",
  body_class: "id post-type-post post-status-publish post-format-standard",
  wpeditimage_disable_captions: false,
  wpeditimage_html5_captions: true,
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
