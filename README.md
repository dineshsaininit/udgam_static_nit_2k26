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
├── events.php         Event highlights, categories, upcoming schedule, past editions
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
│   ├── events.json      highlights, categories, upcoming schedule, past editions
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

- `upcoming[]`: `name`, `category`, `date`, `time`, `venue`, `status` (`upcoming` | `live` | `done`), `desc`.
- `past[]`: one entry per edition for the homepage Journey: `year`, `url` (its website), `x` (tree position on the artwork), `tagline`, `blurb`, `logo` and `photos[]` (16:10 WebP in `assets/img/legacy/`, ~1100px wide). An edition with no photos shows its logo instead.
- `highlights[]` / `categories[]`: the illustrated stage; `x`/`y` are positions on the 1600-wide artwork.

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
