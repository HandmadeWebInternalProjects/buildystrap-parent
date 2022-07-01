const GlobalModule = function (
  this: any,
  {
    TITLE,
    GLOBAL_ID,
    UUID,
  }: {
    TITLE: string
    GLOBAL_ID: string
    UUID: string
  }
) {
  this.uuid = UUID
  this.global_id = GLOBAL_ID
  this.type = "global-module"
  this.config = {
    enabled: true,
    adminLabel: TITLE,
  }
  // this.attributes = {}
  // this.inline = {}
}

export { GlobalModule }
