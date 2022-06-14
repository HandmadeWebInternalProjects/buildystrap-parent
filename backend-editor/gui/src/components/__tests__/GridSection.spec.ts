import { describe, it, expect } from "vitest";

import { mount } from "@vue/test-utils";
import GridSection from "../grid/GridSection.vue";

describe("GridSection", () => {
  it("renders properly", () => {
    const wrapper = mount(GridSection, {
      props: { component: { id: 1, rows: [] } },
    });
    // expect(wrapper.text()).toContain("Hello Vitest");
  });
});
