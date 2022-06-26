const GlobalSection = function ({ UUID, ADMIN_LABEL, VALUE }) {
  this.uuid = `${UUID}`
  this.type = "global-section"
  this.useSettings = "section"
  this.config = {
    enabled: true,
    buildamic_settings: {
      adminLabel: ADMIN_LABEL || this.type,
    },
  }
  this.value = VALUE
}

export { GlobalSection }
