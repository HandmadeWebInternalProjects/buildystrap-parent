import type { InjectionKey } from "vue";
import type { BuildyInterface } from "../components/Buildy";
export const $buildy = Symbol() as InjectionKey<BuildyInterface>;
