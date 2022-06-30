const Module = function (
  this: any,
  {
    ADMIN_LABEL,
    CONFIG = {},
    TYPE = "",
    META = {},
    HANDLE,
    VALUE,
    UUID,
  }: {
    ADMIN_LABEL: string
    CONFIG: { [key: string]: any }
    TYPE: string
    META: { [key: string]: any }
    HANDLE: string
    VALUE: any
    UUID: string
  }
) {
  this.uuid = `${UUID}`
  this.type = TYPE
  this.config = {
    handle: HANDLE,
    enabled: true,
    adminLabel: HANDLE,
  }
  this.meta = META
  this.values = VALUE || {}
  this.attributes = {}
  this.inline = {}
}

export { Module }
