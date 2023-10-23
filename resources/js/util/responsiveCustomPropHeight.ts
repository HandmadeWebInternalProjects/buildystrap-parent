/**
 * Set a custom property with the combined height of multiple elements and update it anytime the height changes.
 * @param {HTMLElement[]} elements
 * @param {string} prop
 * @param {void} cb
 * @constructor
 * @example
 * new responsiveCustomPropHeight(document.querySelector<HTMLElement>("#wrapper-navbar"), "header-height");
 * @version 1.0.0
 */

export class responsiveCustomPropHeight {
  elements: (HTMLElement | null)[];
  prop: string;
  cb: () => void;
  private height: number | null = null;

  constructor(elements: (HTMLElement | null)[], prop: string, cb?: () => void) {
    this.elements = elements;
    this.prop = prop;
    this.setCustomProp = this.setCustomProp.bind(this);
    this.init();
  }

  init() {
    this.updateHeight();
    this.observe();
  }

  /** 
    Observe the height of all elements and update the custom prop
    @private
    @since 1.0.0
  */

  private observe() {
    // Observe the height of all elements and update the custom prop
    const observer = new ResizeObserver(this.onChange.bind(this));
    this.elements.forEach((element) => {
      if (element) {
        observer.observe(element);
      }
    });
  }

  onChange() {
    // Update height
    this.updateHeight();

    // Set custom prop
    if (this?.prop) {
      this.setCustomProp();
    }

    // if callback is set, call it
    if (this?.cb) {
      this.cb();
    }
  }

  updateHeight() {
    this.height =
      this.elements?.reduce((acc, element) => {
        const height = element?.clientHeight ?? 0;
        return height > acc ? height : acc;
      }, 0) ?? null;
  }

  getHeight() {
    return this.height;
  }

  private setCustomProp() {
    // Set css custom prop
    document.documentElement.style.setProperty(
      `--${this.prop}`,
      `${this.height}px`
    );
  }
}
