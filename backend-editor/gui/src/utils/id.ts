import { v4 as uuidv4 } from "uuid";

export function generateID(): string {
  return uuidv4();
}

export const generateModuleID = (type: string) => {
  return type.replace("module", "") + generateID();
};

export const recursifyID = (item: any) => {
  if (item.uuid || item.uuid === "") {
    item.uuid = generateModuleID(item.type);
  }
  const items =
    ((Array.isArray(item) && item) ||
      item?.rows ||
      item?.columns ||
      item?.modules) ??
    [];
  if (!Array.isArray(items)) {
    return false;
  }
  items.forEach((el: any) => {
    if (el.uuid || el.uuid === "") {
      el.uuid = generateModuleID(el.type);
    }
    const items =
      (Array.isArray(el) || el?.rows || el?.columns || el?.modules) ?? [];
    if (!Array.isArray(items)) {
      return false;
    } else {
      recursifyID(el);
    }
  });
};
