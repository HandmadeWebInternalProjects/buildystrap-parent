import { OPERATORS, ALIASES } from "./Constants.js"

export default class {
  fromBlueprint(conditions: { [key: string]: any }, prefix = "") {
    return Object.entries(conditions).map(([field, condition]) =>
      this.splitRhs(field, condition, prefix)
    )
  }

  toBlueprint(conditions: { [key: string]: any }[]) {
    const converted: { [key: string]: any } = {}

    conditions.forEach((condition) => {
      converted[condition.field] = this.combineRhs(condition)
    })

    return converted
  }

  splitRhs(field: string, condition: { [key: string]: any }, prefix = "") {
    return {
      field: this.getScopedFieldHandle(field, prefix),
      operator: this.getOperatorFromRhs(condition),
      value: this.getValueFromRhs(condition),
    }
  }

  getScopedFieldHandle(field: string, prefix: string) {
    if (field.startsWith("root.") || !prefix) {
      return field
    }

    return prefix + field
  }

  getOperatorFromRhs(condition: { [key: string]: any }) {
    let operator = "=="

    this.getOperatorsAndAliases()
      .filter((value) =>
        new RegExp(`^${value} [^=]`).test(condition.toString())
      )
      .forEach((value) => {
        operator = value
      })

    return this.normalizeOperator(operator)
  }

  normalizeOperator(operator: string) {
    return ALIASES[operator] ? ALIASES[operator] : operator
  }

  getValueFromRhs(condition: { [key: string]: any }) {
    let rhs = condition.toString()

    this.getOperatorsAndAliases()
      .filter((value) => new RegExp(`^${value} [^=]`).test(rhs))
      .forEach((value) => (rhs = rhs.replace(new RegExp(`^${value}[ ]*`), "")))

    return rhs
  }

  combineRhs(condition: { [key: string]: any }) {
    const operator = condition.operator ? condition.operator.trim() : ""
    const value = condition.value.trim()

    return `${operator} ${value}`.trim()
  }

  getOperatorsAndAliases() {
    return OPERATORS.concat(Object.keys(ALIASES))
  }
}
