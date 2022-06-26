import { createModule } from "./moduleFactory"

const Row = function (
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
  // We are including a column by default
  const column = createModule("Column", {})

  this.uuid = `${UUID}`
  this.type = "row"
  this.config = {
    enabled: true,
    adminLabel: ADMIN_LABEL || this.type,
    columnCount: 12,
  }
  this.columns = [column]
  this.attributes = {}
  this.inline = {}
}

export { Row }
