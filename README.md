# UDGAM 2K26 — NIT Sikkim

Website for UDGAM 2K26, the annual cultural festival of the National Institute of Technology Sikkim. *Chase the Bloom.*

## Running locally

Any PHP 8 install works; no database, no Composer.

```powershell
cd path\to\Udgam
php -S localhost:8000
```

Then open <http://localhost:8000/>.

## Folder structure

```
Udgam/
├── index.php          Homepage: welcome gate, hero, about (3D island), journey, explore
├── events.php         All 27 events as festival passes: headliners + filterable open floor
├── gallery.php        Memories + photo gallery with lightbox
├── sponsors.php       Sponsor tiers, why-sponsor, sponsorship contact
├── team.php           Core committee hierarchy + 15 committee cards (roster dialog, search)
├── contact.php        Contact channels, address, map
├── includes/
│   ├── config.php     Site constants, contact details, navigation, helper functions
│   ├── header.php     <head>, fixed header with corner logo + main navigation
│   ├── journey.php    "A Journey Through Time" road + edition panel (homepage and gallery)
│   └── footer.php     "Get in Touch" poster footer (HTML version on phones), falling petals, Ferris-wheel menu, script tags
├── data/              Editable content (JSON)
│   ├── core.json        core committee tiers, President down to Joint Secretaries (team.php)
│   ├── committees.json  every organising committee and its members (team.php, sponsors contact)
│   ├── events.json      events (fees, team sizes, rulebooks), categories, past editions
│   ├── gallery.json     memories + photo tiles
│   └── sponsors.json    sponsor tiers and slots
├── assets/
│   ├── css/           style.css (all pages) + sponsors.css (the Sponsors page's own look, loaded via $page['css'])
│   ├── js/            main.js (shared), island.js, journey.js, events.js, gallery.js, team.js, island-viewer.js (3D)
│   ├── img/           artwork (hero, gate, journey scene, event photos, logo…)
│   ├── fonts/         self-hosted woff2 fonts
│   └── models/        island.glb + island-texture.jpg for the rotating 3D campus
└── uploads/           your own photos: team/, gallery/, sponsors/
```

## Editing content

Everything editable lives in `data/*.json`; the PHP pages render from it.

### Team — `data/core.json` and `data/committees.json`

`core.json` is the hierarchy at the top of the Team page, one entry per tier in display order:

```json
{ "title": "Vice Presidents", "people": [ { "n": "Full Name", "r": "Vice President", "img": "uploads/team/name.webp", "li": "https://www.linkedin.com/in/..." } ] }
```

`committees.json` lists the organising committees; each has `id`, `name` and members `m` (the card icon is picked by `id` in team.php):

```json
{ "n": "Full Name", "r": "Lead", "t": 1, "img": "uploads/team/name.webp", "li": "https://www.linkedin.com/in/...", "a": ["nickname"] }
```

| key | meaning |
|-----|---------|
| `n` | name |
| `r` | role / designation |
| `t` | committee members only: `1` lead, `2` associate lead, `3` member (groups the roster) |
| `img` | local portrait, e.g. `uploads/team/name.webp` (square, 600px works well) |
| `p` | alternatively a Google Drive file id of the portrait (shared "anyone with the link") |
| `li` | optional LinkedIn profile URL |
| `a` | optional aliases so search finds nicknames or old spellings |

People without a photo get their initials. Deep-link a committee with `team.php#c-<id>` (or `team.php?c=<id>`).

### Events — `data/events.json`

- `events[]`: every event of UDGAM 2K26 (taken from udgamnits.live), in display order: `id`, `name`, `category` (one of `categories[].id`), `headliner` (shown as a big pass at the top), `fee` (0 = free entry) with `per` (`team` / `person`), `team` = `[min, max]` players, optional `tagline`, `desc`, `rounds[]` and `rules` (rulebook PDF or document link).
- `categories[]`: `id`, `label` and `hue` (the two colours of that category's passes).
- `past[]`: one entry per edition for the homepage Journey: `year`, `url` (its website), `x` (tree position on the artwork), `tagline`, `blurb`, `logo` and `photos[]` (16:10 WebP in `assets/img/legacy/`, ~1100px wide). An edition with no photos shows its logo instead.
- Event icons are chosen in `events.php` (`$ICONS`): one per headliner, one per category for the rest.

### Gallery — `data/gallery.json`

Each photo: `title`, `sub`, `cat` (must match a filter id), `img`, `shape` (`w` landscape, `t` portrait, `s` square), optional `fit`/`pos`.
Drop files in `uploads/gallery/` and reference them as `uploads/gallery/file.jpg`.

### Sponsors — `data/sponsors.json`

Fill a slot's `name`, `logo` (e.g. `uploads/sponsors/acme.png`) and optional `url`. Empty names render as "Your Logo Here" placeholders.

### Contact details

Email, Instagram, YouTube, address and map live once in `includes/config.php` (`$SITE`) and are used by the footer, contact page and sponsors page.

## Notes

- The welcome gate shows once per browser session on the homepage; deep links such as `index.php#about` skip it.
- The corner logo is fixed in the top-left of the header and links home; it only scales slightly on hover.
- The Ferris-wheel menu on the right edge scrolls to sections on the current page and links to the other pages.

## Hosting on a small server

- `.htaccess` (Apache) turns on gzip/Brotli for text files and long browser caching: CSS/JS are linked with `?v=<file time>` by `asset()`, so they are cached for a year and still update after a deploy; images, fonts and the 3D model for a month; pages are always re-checked. `includes/` and `data/` have their own `.htaccess` that blocks direct access.
- If the host does not compress, `includes/config.php` gzips each page itself (`ob_gzhandler`). On nginx, enable `gzip` for html/css/js/svg/json and add `expires` rules equivalent to `.htaccess`.
- The 3D island (`assets/js/island-viewer.js` + `assets/models/`, about 1.8 MB) is fetched only when the About section comes near, and never on phones, Data Saver or low-memory devices: they keep the still poster picture.
- Repeated icons are drawn once per page (`flower_symbol()` in `config.php`, output by `header.php`) and reused with `<use>`, which keeps pages like the Team page light.
- Gallery tiles and Journey photos load as they come near the screen.
- Images are WebP, sized to how large they are shown (`logo-sm.webp` for the header, `hero-logo-800.webp` for phones). Add new photos at about 1000px wide for landscape, 700px for portrait, quality 76–82.
