import { generateID } from "../../functions/idHelpers";

import { Section } from "./section";
import { GlobalSection } from "./global-section";
import { Row } from "./row";
import { Column } from "./column";
import { Module } from "./module";

const el = { Section, GlobalSection, Row, Column, Module };

const createModule = function (
  type: string,
  attributes: { [key: string]: any }
) {
  const ModuleType = el[type];
  return new ModuleType({
    UUID: generateID(),
    ...attributes,
  });
};

export { createModule };
