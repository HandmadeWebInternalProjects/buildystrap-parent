const Module = function (
  this: any,
  {
    ADMIN_LABEL,
    CONFIG = {},
    TYPE = "",
    META = {},
    VALUE,
    UUID,
  }: {
    ADMIN_LABEL: string
    CONFIG: { [key: string]: any }
    TYPE: string
    META: { [key: string]: any }
    VALUE: any
    UUID: string
  }
) {
  this.uuid = `${UUID}`
  this.type = TYPE
  this.config = {
    enabled: true,
  }
  this.meta = META
  this.values = VALUE || {}
  this.attributes = {}
  this.inline = {}
}

export { Module }
