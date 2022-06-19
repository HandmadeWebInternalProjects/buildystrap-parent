interface FieldTypeInterface {
  update(value: any): void;
  updateMeta(value: any): void;
}

export interface FieldtypeProps {
  type?: any;
  uuid?: any;
  value?: any;
  config?: { handle?: string; [key: string]: any };
  handle?: string;
  meta?: { [key: string]: any };
  [key: string]: any;
}

export const withProps = (): FieldtypeProps => {
  return {
    value: "",
    config: {},
    handle: "",
    meta: {},
  };
};

export const useFieldType = (emit: any): FieldTypeInterface => {
  const update = (value: any): void => {
    emit("update", value);
  };

  const updateMeta = (value: any): void => {
    emit("updateMeta", value);
  };

  return {
    update,
    updateMeta,
  };
};
