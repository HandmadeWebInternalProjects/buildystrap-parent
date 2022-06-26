import { createModule } from "./moduleFactory"

const Section = function (
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
  const row = createModule("Row")

  this.uuid = `${UUID}`
  this.type = "section"
  this.config = {
    enabled: true,
    adminLabel: ADMIN_LABEL || this.type,
    boxed_layout: true,
  }
  this.rows = [row]
  this.attributes = {}
  this.inline = {}
}

export { Section }
