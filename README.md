=== All The Things ===

Contributors: tcmulder
Tags: acf, pattern library
Requires at least: 5.8.2
Tested up to: 6.7.2
Stable tag: 3.1.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Creates a pattern library where one can develop features in isolation, separate from the site's live pages.

Features:

- Patterns: Add patterns under "Patterns" in the admin menu, and group them with the optional "Types" taxonomy.
- Archive: Visit `/all-the-things/` to see a live thumbnail grid of every pattern, optionally grouped by type.
- Quick‑Jump Menu: Open a menu from any page with cmd+p, type words or press up to filter, then press enter to visit the selected pattern.
- Shortcode: Use `[thing id="123"]` or `[thing slug="post-slug"]` to output a post's content (such as a synced pattern) anywhere.
- Template Friendly: Patterns use your theme's page templates, so they look like they do on the live site.
- Safe by Default: Via `AQUA_PATTERNS_ALLOWED_SERVERS`, only localhost or hand-picked servers can access the patterns or see the menu.

== Description ==

.......................................

== Installation ==

1. Upload "all-the-things" to the "/wp-content/plugins/" directory.
2. Activate the plugin through the "Plugins" menu in WordPress.

== Changelog ==

= 3.1.1 =

- Adjust styling so headings don't risk being hidden and spacing is more consistent on archive.
- Fix PHP warning if there are no posts.

= 3.1.0 =

- Allow closing select box with escape key or command/ctrl+p again.
- Allow opening in new tab if shift+command/ctrl+p (simplifies previous behavior).

= 3.0.2 =

- Fix edit post link.
- Allow open in new tab (must hold cmd/ctrl before opening select box)
- Move select down so it is easier to click.

= 3.0.1 =

- Refactor archive.
- Ensure all the things doesn't load inside it's own archive iframes.

= 3.0.0 =

- Change shortcode to be [thing id="123"] or [thing slug="post-slug"] for showing synced pattern content.
- Use select rather than list to navigate.
- Refactor much of the code.

= 2.0.3 =

- Allow page templates to be used (previously it forced use of its own single.php file even if a different template was chosen).

= 2.0.2 =

- Fallback to index.php in the event page.php isn't available for single posts.

= 2.0.1 =

- Make select box even easier to use (just type and hit enter).
- Prevent slow iframes from halting load of other iframes.
- Add types taxonomy.
- Add [aqua_synced_pattern id="123"] shortcode to show synced pattern content.

= 2.0.0 =

- Make select box easier to use (has timeout and allows Esc key to halt navigation)

= 1.0.3 =

- Lazy load thumbnails and add list.

= 1.0.2 =

- Add thumbnails.

= 1.0.1 =

- Refactor code to make adjustments easier (via constants at the top of the main plugin file).

= 1.0.0 =

- Officially added repo for plugin (though I've been using this already for years).
