== Changelog ==

=== 4.3.0 ===
- Composer packages updated 
- Common packages added (guzzle/http, etc)
- Start the process of swapping to vite
- Make visibility tab stuff work

=== 4.2.3 ===
- Composer packages updated 
- Lazy collections stuff
- A bunch of cleanup 
- New Directives & Component Options 

=== 4.1.14 ===
- Initial major commit for Taxonomy, Term, Relation, and Meta Query items in Post Grid Module. 
- Fixes for taggable and multiple items on Vue select items
- Tweaks to SCSS taggables for widths and heights
- Adjust class output for Title Field (merge issue)

=== 4.1.13 ===

- Add save / cancel buttons
- Update repeater to pass parent field values to it's childen (so things like relational field can check values of things outside the repeater).
- Some small tweaks & bug fixes to title fields

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