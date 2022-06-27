<template>
  <div class="module module-settings">
    <field-label :label="config.display || handle" />
    <textarea :id="editorID" cols="30" rows="10" v-model="content"></textarea>
  </div>
</template>
<script lang="ts" setup>
import { ref, nextTick, onMounted, onUnmounted } from "vue"
import { toRefs } from "vue"
import { useFieldType, commonProps } from "./useFieldType"
const props = defineProps({ ...commonProps })

const { handle, config, uuid } = toRefs(props)
const content = ref(props.modelValue ? props.modelValue : "")

const emit = defineEmits(["update:modelValue", "updateMeta"])
const { update } = useFieldType(emit)

const editorID = uuid.value
  ? `${uuid.value}_tiny_mce`
  : `${handle?.value}_tiny_mce`

const editorInit = (): void => {
  window?.wp?.oldEditor.initialize(editorID, {
    tinymce: {
      wpautop: true,
      theme: "modern",
      skin: "lightgray",
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
        "charmap,hr,media,paste,tabfocus,lists,textcolor,fullscreen,wordpress,wpeditimage,wpgallery,wplink,wpdialogs,wpview",
      resize: "vertical",
      menubar: false,
      indent: false,
      toolbar1:
        "bold,italic,strikethrough,bullist,numlist,blockquote,hr,alignleft,aligncenter,alignright,link,unlink,wp_more,spellchecker,fullscreen,wp_adv",
      toolbar2:
        "formatselect,underline,alignjustify,forecolor,pastetext,removeformat,charmap,,undo,redo,wp_help",
      toolbar3: "",
      toolbar4: "",
      body_class: "id post-type-post post-status-publish post-format-standard",
      wpeditimage_disable_captions: false,
      wpeditimage_html5_captions: true,
    },
    mediaButtons: true,
    quicktags: true,
  })

  window.tinymce.activeEditor.on("change", (e: any) => {
    update(e.level.content)
  })

  // window.tinymce.activeEditor.on("PreProcess", (e) => {
  //   console.log(e)
  // })
}
onMounted(async () => {
  await Promise.resolve(nextTick())
  editorInit()
})
onUnmounted(() => {
  window?.wp?.oldEditor.remove(editorID)
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
