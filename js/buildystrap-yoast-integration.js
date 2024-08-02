class MyCustomDataPlugin {
  constructor() {
    // Ensure YoastSEO.js is present and can access the necessary features.
    if (typeof YoastSEO === "undefined" || typeof YoastSEO.analysis === "undefined" || typeof YoastSEO.analysis.worker === "undefined") {
      return;
    }

    YoastSEO.app.registerPlugin("MyCustomDataPlugin", { status: "ready" });

    this.registerModifications();
  }

  /**
   * Registers the addContent modification.
   *
   * @returns {void}
   */
  registerModifications() {
    const callback = this.addContent.bind(this);

    // Ensure that the additional data is being seen as a modification to the content.
    YoastSEO.app.registerModification("content", callback, "MyCustomDataPlugin", 10);
  }

  /**
   * Adds to the content to be analyzed by the analyzer.
   *
   * @param {string} data The current data string.
   *
   * @returns {string} The data string parameter with the added content.
   */
  addContent(data) {
    const rendered_page = window?.global_vars?.rendered_page || null;

    data = rendered_page ? rendered_page : data;

    return data;
  }
}

/**
 * Adds eventlistener to load the plugin.
 */
if (typeof YoastSEO !== "undefined" && typeof YoastSEO.app !== "undefined") {
  new MyCustomDataPlugin();
} else {
  jQuery(window).on(
    "YoastSEO:ready",
    function () {
      new MyCustomDataPlugin();
    }
  );
}