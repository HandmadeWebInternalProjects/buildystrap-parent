import { generateID } from "../../utils/id"

import { Section } from "./section"
// import { GlobalSection } from "./global-section"
import { Row } from "./row"
import { Column } from "./column"
import { Module } from "./module"
import { GlobalModule } from "./global-module"

export type ModuleType = {
  handle: string
  type: string
  config: { [key: string]: any }
  meta: { [key: string]: any }
  value?: { [key: string]: any }
  uuid: string
  attributes: { [key: string]: any }
  inline: { [key: string]: any }
}

const el = <{ [key: string]: any }>{
  Section,
  // GlobalSection: GlobalSection,
  Row,
  Column,
  Module,
  GlobalModule,
}

const createModule = function (
  type: string,
  attributes?: { [key: string]: any }
): ModuleType {
  const ModuleType = el[type] || el.Module
  return new ModuleType({
    UUID: generateID(),
    ...attributes,
  })
}

export { createModule }
