const Module = function (
  this: any,
  {
    ADMIN_LABEL,
    CONFIG = {},
    META = {},
    HANDLE,
    VALUE,
    UUID,
  }: {
    ADMIN_LABEL: string;
    CONFIG: { [key: string]: any };
    META: { [key: string]: any };
    HANDLE: string;
    VALUE: any;
    UUID: string;
  }
) {
  this.uuid = `${UUID}`;
  this.type = "module";
  this.config = {
    handle: HANDLE,
    enabled: true,
    admin_label: ADMIN_LABEL || CONFIG.DISPLAY || HANDLE,
  };
  this.meta = META;
  this.value = VALUE.reduce((acc: any, cur: any) => {
    acc[cur.handle] = cur.value;
    return acc;
  }, {});
};

export { Module };
