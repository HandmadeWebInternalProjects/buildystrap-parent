const GlobalSection = function (
  this: any,
  {
    ADMIN_LABEL,
    VALUE,
    UUID,
  }: {
    ADMIN_LABEL: string
    VALUE: any
    UUID: string
  }
) {
  this.uuid = `${UUID}`
  this.type = "global-section"
  this.config = {
    enabled: true,
    adminLabel: ADMIN_LABEL || this.type,
  }
  this.global_id = VALUE
  this.attributes = {}
  this.inline = {}
}

export { GlobalSection }
