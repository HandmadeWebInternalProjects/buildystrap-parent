const GlobalSection = function (
  this: any,
  {
    ADMIN_LABEL,
    CONFIG = {},
    META = {},
    VALUE,
    UUID,
  }: {
    ADMIN_LABEL: string
    CONFIG: { [key: string]: any }
    META: { [key: string]: any }
    VALUE: any
    UUID: string
  }
) {
  this.uuid = `${UUID}`
  this.type = "global-section"
  this.config = {
    enabled: true,
    adminLabel: ADMIN_LABEL || this.type,
    boxed_layout: true,
  }
  this.rows = []
  this.attributes = {}
  this.inline = {}
}

export { GlobalSection }
