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
├── index.php          Homepage: welcome gate, hero, about (3D island), main leads, journey, explore
├── events.php         Event highlights, categories, upcoming schedule, past editions
├── gallery.php        Memories + photo gallery with lightbox
├── sponsors.php       Sponsor tiers, why-sponsor, sponsorship contact
├── team.php           Office bearers + full committee directory (search / filter)
├── contact.php        Contact channels, address, map, illustrated poster
├── includes/
│   ├── config.php     Site constants, contact details, navigation, helper functions
│   ├── header.php     <head>, fixed header with corner logo + main navigation
│   └── footer.php     Footer, falling petals, Ferris-wheel menu, script tags
├── data/              Editable content (JSON)
│   ├── committees.json  every committee and member (drives team.php and the homepage leads)
│   ├── events.json      highlights, categories, upcoming schedule, past editions
│   ├── gallery.json     memories + photo tiles
│   └── sponsors.json    sponsor tiers and slots
├── assets/
│   ├── css/style.css  single stylesheet for all pages
│   ├── js/            main.js (shared), island.js, journey.js, events.js, gallery.js, directory.js, island-viewer.js (3D)
│   ├── img/           artwork (hero, gate, journey scene, event photos, logo…)
│   ├── fonts/         self-hosted woff2 fonts
│   └── models/        island.glb + island-texture.jpg for the rotating 3D campus
└── uploads/           your own photos: team/, gallery/, sponsors/
```

## Editing content

Everything editable lives in `data/*.json`; the PHP pages render from it.

### Team / committee directory — `data/committees.json`

```json
{ "n": "Full Name", "r": "Role shown on the card", "t": 1, "p": "GoogleDriveFileId", "a": ["nickname"] }
```

| key | meaning |
|-----|---------|
| `n` | name |
| `r` | role / designation |
| `t` | tier: `0` office bearer (shown on the homepage as core), `1` lead (shown on the homepage strip), `2` associate lead, `3` member |
| `p` | Google Drive file id of the portrait (shared "anyone with the link") |
| `img` | alternatively a local photo, e.g. `uploads/team/name.jpg` (takes priority over `p`) |
| `a` | optional aliases so search finds nicknames |

The homepage's "main leads" section is derived automatically: everyone with `t` 0 or 1, de-duplicated across committees.

### Events — `data/events.json`

- `upcoming[]`: `name`, `category`, `date`, `time`, `venue`, `status` (`upcoming` | `live` | `done`), `desc`.
- `past[]`: year + link to that edition's website (also drives the Journey on the homepage).
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
