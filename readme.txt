== Changelog ==

=== 4.1.10 ===

- Add template_class option to postgrid module

=== 4.1.9 ===

- Fix primary-theme-hover order for class
- Remove HTML from titleField toString method
- Add toHtml method on titlefield that renders the builder.components.title file so it's only in one place.
- Update references from {!! !!} to {{ }} to use the new toHtml method

=== 4.1.7 - 4.1.8 ===

- Fix button outlines (mostly)
- Add TextArea field
- Fix Global Module not being able to delete once you choose a module
- Add button group around card buttons (and option to add class)
- Add RecursifyFields function to Module.php to allow recursively converting fields into their respective classes
- Fix generated outline styles to make colour the correct bs-colourname