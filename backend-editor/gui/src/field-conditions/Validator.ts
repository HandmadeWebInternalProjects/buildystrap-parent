import Converter from "./Converter.js"
import { KEYS } from "./Constants.js"

const NUMBER_SPECIFIC_COMPARISONS = [">", ">=", "<", "<="]

export const data_get = (
  obj: { [key: string]: any },
  path: string[] | string,
  fallback = null
) => {
  // Source: https://stackoverflow.com/a/22129960
  const properties: any = Array.isArray(path) ? path : path.split(".")
  const value = properties.reduce(
    (prev: { [key: string]: any }, curr: string) => prev && prev[curr],
    obj
  )
  return value !== undefined ? value : fallback
}

export default class {
  field: { [key: string]: any }
  values: { [key: string]: any }
  store: { [key: string]: any }
  storeName: string
  passOnAny: boolean
  showOnPass: boolean
  converter: any

  constructor(
    field: { [key: string]: any },
    values: { [key: string]: any },
    store: { [key: string]: any },
    storeName: string
  ) {
    this.field = field
    this.values = values
    this.store = store
    this.storeName = storeName
    this.passOnAny = false
    this.showOnPass = true
    this.converter = new Converter()
  }

  passesConditions() {
    let conditions: { [key: string]: any }[] = this.getConditions()

    if (conditions === undefined) {
      return true
    } else if (typeof conditions === "string") {
      return this.passesCustomCondition(this.prepareCondition(conditions))
    }

    conditions = this.converter.fromBlueprint(conditions, this.field.prefix)

    const passes: boolean = this.passOnAny
      ? this.passesAnyConditions(conditions)
      : this.passesAllConditions(conditions)

    return this.showOnPass ? passes : !passes
  }

  getConditions() {
    const key: string = KEYS.filter((key) => this.field[key])[0]

    if (!key) {
      return undefined
    }

    if (key.includes("any")) {
      this.passOnAny = true
    }

    if (key.includes("unless") || key.includes("hide_when")) {
      this.showOnPass = false
    }

    return this.field[key]
  }

  passesAllConditions(conditions: { [key: string]: any }[]) {
    return conditions
      .map((condition) => {
        return this.prepareCondition(condition)
      })
      .every((condition) => {
        return this.passesCondition(condition)
      })
  }

  passesAnyConditions(conditions: { [key: string]: any }[]) {
    return conditions
      .map((condition) => {
        return this.prepareCondition(condition)
      })
      .some((condition) => {
        return this.passesCondition(condition)
      })
  }

  prepareCondition(condition: { [key: string]: any }) {
    if (typeof condition === "string" || condition.operator === "custom") {
      return this.prepareCustomCondition(condition)
    }

    const operator: string = this.prepareOperator(condition.operator)
    const lhs: string = this.prepareLhs(condition.field, operator)
    const rhs: string | number | boolean | null = this.prepareRhs(
      condition.value,
      operator
    )

    return { lhs, operator, rhs }
  }

  prepareOperator(operator: string) {
    switch (operator) {
      case null:
      case "":
      case "is":
      case "equals":
        return "=="
      case "isnt":
      case "not":
      case "¯\\_(ツ)_/¯":
        return "!="
      case "includes":
      case "contains":
        return "includes"
      case "includes_any":
      case "contains_any":
        return "includes_any"
    }

    return operator
  }

  prepareLhs(field: string, operator: string) {
    let lhs = this.getFieldValue(field)

    // When performing a number comparison, cast to number.
    if (NUMBER_SPECIFIC_COMPARISONS.includes(operator)) {
      return Number(lhs)
    }

    // When performing lhs.includes(), if lhs is not an object or array, cast to string.
    if (operator === "includes" && typeof lhs !== "object") {
      return lhs ? lhs.toString() : ""
    }

    // When lhs is an empty string, cast to null.
    if (typeof lhs === "string" && !lhs) {
      lhs = null
    }

    // Prepare for eval() and return.
    return typeof lhs === "string" ? JSON.stringify(lhs.trim()) : lhs
  }

  prepareRhs(rhs: string, operator: string) {
    // When comparing against null, true, false, cast to literals.
    switch (rhs) {
      case "null":
        return null
      case "true":
        return true
      case "false":
        return false
    }

    // When performing a number comparison, cast to number.
    if (NUMBER_SPECIFIC_COMPARISONS.includes(operator)) {
      return Number(rhs)
    }

    // When performing a comparison that cannot be eval()'d, return rhs as is.
    if (
      rhs === "empty" ||
      operator === "includes" ||
      operator === "includes_any"
    ) {
      return rhs
    }

    // Prepare for eval() and return.
    return typeof rhs === "string" ? JSON.stringify(rhs.trim()) : rhs
  }

  prepareCustomCondition(condition: { [key: string]: any }) {
    const functionName = this.prepareFunctionName(condition.value || condition)
    const params = this.prepareParams(condition.value || condition)

    const target = condition.field ? this.getFieldValue(condition.field) : null

    return { functionName, params, target }
  }

  prepareFunctionName(condition: string) {
    return condition.replace(new RegExp("^custom "), "").split(":")[0]
  }

  prepareParams(condition: string) {
    const params = condition.split(":")[1]

    return params ? params.split(",").map((string) => string.trim()) : []
  }

  getFieldValue(field: string[] | string) {
    return data_get(this.values, field)
  }

  passesCondition(condition: { [key: string]: any }) {
    if (condition.functionName) {
      return this.passesCustomCondition(condition)
    }

    if (condition.operator === "includes") {
      return this.passesIncludesCondition(condition)
    }

    if (condition.operator === "includes_any") {
      return this.passesIncludesAnyCondition(condition)
    }

    if (condition.rhs === "empty") {
      condition.lhs = !condition.lhs
      condition.rhs = true
    }

    if (typeof condition.lhs === "object") {
      return false
    }

    return eval(`${condition.lhs} ${condition.operator} ${condition.rhs}`)
  }

  passesIncludesCondition(condition: { [key: string]: any }) {
    return condition.lhs.includes(condition.rhs)
  }

  passesIncludesAnyCondition(condition: { [key: string]: any }) {
    const values: string[] = condition.rhs
      .split(",")
      .map((string: string) => string.trim())

    if (Array.isArray(condition.lhs)) {
      return [...condition.lhs, ...values].length
    }

    return new RegExp(values.join("|")).test(condition.lhs)
  }

  passesCustomCondition(condition: { [key: string]: any }) {
    const customFunction: any = data_get(
      this.store.state.statamic.conditions,
      condition.functionName
    )

    if (typeof customFunction !== "function") {
      console.error(
        `Statamic field condition [${condition.functionName}] was not properly defined.`
      )
      return false
    }

    const passes: boolean = customFunction({
      params: condition.params,
      target: condition.target,
      values: this.values,
      store: this.store,
      storeName: this.storeName,
    })

    return this.showOnPass ? passes : !passes
  }
}
