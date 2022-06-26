const Column = function (
  this: any,
  {
    ADMIN_LABEL,
    CONFIG = {},
    META = {},
    HANDLE,
    VALUE,
    UUID,
  }: {
    ADMIN_LABEL: string
    CONFIG: { [key: string]: any }
    META: { [key: string]: any }
    HANDLE: string
    VALUE: any
    UUID: string
  }
) {
  this.uuid = `${UUID}`
  this.type = "column"
  this.config = {
    enabled: true,
    adminLabel: ADMIN_LABEL || this.type,
    columnSizes: {
      lg: 12,
    },
  }
  this.modules = []
}

export { Column }
