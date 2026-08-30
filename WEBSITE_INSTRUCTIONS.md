# Honoring Stories · Website Instructions

This file is the living source of truth for building this site. It is updated every time new
instructions, content, or decisions come in during a session, including reversals of earlier
decisions. If something here conflicts with an older memory or an earlier commit message, this
file wins.

Last updated: **2026-08-27, 23:29 IST**

---

## 0. START HERE: frozen snapshot, 2026-08-27

**Read this section before touching anything.**

### 0.1 What this snapshot is

As of **2026-08-27, 23:29 IST**, at commit **`202b42c`**, Harshita reviewed the site running on her
local machine and **approved it as the final version**. Every page, every asset, every behaviour
described in this file is the state she signed off.

Her instruction, verbatim in substance: *do not overwrite any functionality, design, or any kind of
change that is not in this current version.*

That means, for whoever picks this up next, human or AI:

- **Change only what you are explicitly asked to change.** Do not tidy, refactor, modernise,
  reformat, or "improve" anything you were not asked about, however wrong it looks. Several things
  in this codebase look wrong and are deliberate; they are flagged throughout with the reason.
- **Do not revert anything to an earlier form** because an older commit, an older memory, or your
  own instinct suggests it. Many details here are the third or fourth attempt after explicit
  rejections. The reversal history is recorded in section 0.5 so you can see what has already been
  tried and turned down.
- **If a change you are asked to make would break something described here, say so before doing
  it**, rather than doing it and mentioning it after.
- Where this file and any other source disagree, **this file wins.**

### 0.2 Verified state at the moment of the snapshot

Checked, not assumed, at the time of writing:

| Check | Result |
| --- | --- |
| Tracked files vs last commit | clean, nothing uncommitted |
| Local `master` vs `origin/master` | in sync |
| Assets referenced by the HTML | 10, **all tracked and present on disk** |
| Total commits on `master` | 107 |
| Em dashes anywhere in the repo | 0 |
| Pages | 9 HTML files, all serving HTTP 200 locally |

A fresh `git clone` of this repository renders byte-identically to what she approved. Nothing the
site loads at runtime lives outside the repo except the Google Fonts stylesheet and the two Google
endpoints listed in section 0.4.

### 0.3 How to run it

```
powershell -NoProfile -ExecutionPolicy Bypass -File serve.ps1
```

Then open `http://localhost:8080/index.html`.

`serve.ps1` is a small .NET `HttpListener` static file server committed at the repo root. It exists
because **this machine has no Node, Python or PHP installed**, so the usual one-line dev server is
not available. It sends no-cache headers, so edits appear on an ordinary refresh. It refuses to
serve outside the repo folder.

Opening the HTML files directly as `file:///...` mostly works, since all links are relative, **but
the Shared Ways of Coping notes will fail to load**, because the browser blocks the cross-origin
fetch to Google from a `file://` page. Use the server when testing that section.

### 0.4 The only external dependencies

| What | Where | Breaks if it goes away |
| --- | --- | --- |
| Google Fonts | Cormorant Garamond + Inter | Type falls back to Georgia and system sans |
| Google Form | `SHARED_FORM_URL` in `community.html` | The coping submission box stops accepting notes |
| `notes.json` (in this repo, not external) | `SHARED_NOTES_JSON` in `community.html` | Published notes stop appearing; page shows its own graceful empty state. As of 2026-08-27 this replaced a live Google Sheet CSV read; see section 4. |
| Sveltia CMS, at `/admin` | `unpkg.com` CDN script in `admin/index.html` | The admin editing screen stops loading. `notes.json` can still be edited directly on GitHub; nothing about the public site depends on Sveltia at all |
| cal.com | booking link, section 6 contact details | Every "Book a Consultation Call" button dead-ends |

There is **no build step, no framework, no package manager, no backend, and no database.** Every
page is a single self-contained `.html` file carrying its own `<style>` and `<script>`. This is
deliberate and is explained in section 2.

### 0.5 Things already tried and explicitly rejected

Do not reintroduce any of these. Each was built, shown, and turned down.

| Tried | Outcome |
| --- | --- |
| Animated wavy section dividers | Rejected, reverted same session |
| "We" voice on the organisations page | Rejected, reverted to "I" |
| Decorative doodles down the Work With Me section | Rejected, removed |
| Two earlier stat-row designs | Rejected twice before the frameless count-up was accepted |
| Pink sliding-bar hover on cards | Replaced with the purple treatment |
| Full-bleed section divider lines | Removed globally |
| Second (paler) Workplace Wellbeing illustration | Installed, then reverted; the third is in place |
| Confidentiality as a modal `<dialog>` | Replaced by the inline collapsible |
| Pricing anywhere on the homepage | Removed; lives only on the two service pages |
| Instagram link in the footer | Removed |

---

## 1. Who this is for

**Harshita Sarda** (she/her), practicing psychotherapist and clinical supervisor, Andheri West,
Mumbai. Contact: feelseen@honoringstories.com.

The site serves several **adult** audiences in one place, and copy/structure should stay
professionally credible for all of them, not just warm for one:
- Prospective therapy clients, India and abroad, signing up for the first time
- Existing clients
- Existing and prospective supervisees
- Colleagues and peers in the mental health field

Site name: **Honoring Stories**. Tagline system: *Express · Embrace · Empower*.

---

## 2. Tech stack and hosting plan

- **Static HTML/CSS/JS only.** No frameworks, no build step, no Vercel, no Supabase. This is a
  deliberate choice: the site will eventually migrate into WordPress, and a plain static site
  avoids throwing away framework/backend work later.
- Local dev preview is served by `serve.ps1` (a PowerShell `HttpListener` script) at
  `http://localhost:8080/`, because this machine has no Python or Node installed.
- GitHub repo: `https://github.com/HarshitaStories/honoringstorieswebsiteclaude`. Commit and push
  after every completed change, without being asked each time, unless told otherwise. Only pause
  for confirmation on unusual/destructive git operations (force-push, history rewrite, branch
  deletion, etc.).
- `InstructionsWebsite.zip` and `Peer Testimonials (Responses).xlsx` are intentionally gitignored:
  the zip's content is fully captured below, and the spreadsheet contains real people's personal
  email addresses that shouldn't be committed.
- Eventual WordPress migration: no native GitHub sync in WordPress, so this will mean either a
  GitHub-sync plugin or manual file upload once the static build is finalized.

---

## 3. Design system

Palette (CSS custom properties, already in `index.html`):

| Token | Hex |
|---|---|
| `--deep-purple` | `#5B2E6B` |
| `--purple` | `#7A4D8F` |
| `--purple-soft` | `#B295C4` |
| `--rose` | `#D96A9C` |
| `--rose-soft` | `#F2C5D5` |
| `--cream` | `#F8F1E4` |
| `--cream-warm` | `#FDFAF2` |
| `--charcoal` | `#2B1E2F` |
| `--charcoal-soft` | `#4A3C50` |
| `--muted` | `#8A7E90` |
| `--line` | `rgba(91,46,107,0.14)` |

Typography: `Cormorant Garamond` (display serif, headings) plus `Inter` (body). Loaded from
Google Fonts.

**The Google Fonts `<link>` must be byte-identical on every page.** The canonical URL is:

    https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,400;0,500;0,600;1,400;1,500&family=Inter:wght@400;500;600&display=swap

`supervision.html` once carried a corrupted variant of this (`0,500;0,500;0,600`, weight 400
missing and 500 duplicated). Google Fonts rejects a malformed weight tuple with **HTTP 400 for the
whole request**, so both Cormorant Garamond *and* Inter silently failed there and the page fell
back to Georgia, making it visibly different from every other page. The failure is easy to miss
because nothing errors visibly, the type just looks wrong. If a page's type ever looks off, fetch
its font URL and check for a 400 before touching any CSS.

**Color discipline (standing rule):** headings default to charcoal, not purple. Purple and rose
are reserved for deliberate emotional beats only, such as the hero, a "right fit" style callout,
and the final CTA. Do not drift back to coloring every heading purple; that was identified and
fixed as a "generic template" problem.

**Content style rule (standing rule, absolute): never use an em dash anywhere on this site,**
including copy, code comments, alt text, and this instructions file itself. Rewrite with natural
punctuation (commas, colons, periods, restructured sentences) or a middle dot (`·`) for
label/separator use, matching the qualifications and testimonial-attribution style already in
use. This was explicitly requested and must be treated as permanent, not a one-time cleanup.

**Layout/component conventions established so far:**
- Values section (Express / Embrace / Empower): icon-in-circle card style, not the numbered
  editorial list that was tried and explicitly rejected. Keep the icon-card format wherever
  values are shown.
- Qualifications: vertical timeline format (dot markers, left border), explicitly liked. Keep
  this format wherever qualifications are shown, even though the full list has moved off the
  homepage (see section 4).
- Concerns cards: each has a small line-icon (added per request).
- Helpline numbers live only in the footer, as a quiet footnote, never as a prominent mid-page
  banner. A loud pink mid-page crisis banner was explicitly removed for this reason.
- No blog/journal section on the homepage (removed; may return later if requested).
- No decorative "breath" pause section, no "Scroll" hint under the hero. Both were tried and then
  explicitly removed.
- A secondary "section rail" navigation exists: a slim vertical dot-rail fixed to the right edge
  (desktop only, 1100px and up), invisible over the hero, fades in once scrolled past the hero,
  fades out at the footer. Dots map to each remaining homepage section; hovering, or the active
  section, reveals the label as a pill tooltip. Keep this in sync with whatever sections actually
  exist on the homepage; it currently lists Values, Concerns, Glimpse, Testimonials, and Contact.
  On top of the scroll-based visibility, the rail also **auto-fades on idle**: after 2 seconds
  with no mouse movement or scroll, it fades out over 1 second; any mouse/scroll activity fades it
  back in quickly (0.25s). The label tooltip pill uses a glassmorphism treatment: an opaque-leaning
  translucent cream-white base (`rgba(253,250,242,0.8)`), a strong backdrop blur plus saturation
  boost, a light inner top highlight, and a soft white border, tuned to read clearly as frosted
  glass rather than a barely-there tint. Keep both of these behaviors if the rail is touched again.
- The native browser scrollbar is hidden site-wide (`scrollbar-width: none` plus the
  `::-webkit-scrollbar` equivalent) while scrolling itself still works normally. This was an
  explicit request; don't reintroduce a visible scrollbar.
- Homepage uses **progressive disclosure** past the Concerns section: rather than stacking several
  full trust-building sections (a "why this fits" narrative, a Work With Me preview, a testimonial
  carousel, and a full qualifications timeline), those are consolidated into one compact "glimpse"
  section (see section 4) that links out to dedicated pages for anyone who wants more.
- Reserved image placeholders (dashed border, "Photo to be added" label) are an acceptable
  standing pattern when content is promised but not yet supplied; replace with the real asset
  when it arrives instead of redesigning around its absence.
- **How illustrations are prepared.** Every illustration Harshita supplies arrives on its own
  off-cream backdrop, close enough to the page colour to look like a mistake rather than a choice.
  Two treatments, both done offline with PowerShell and System.Drawing:
  - **Recolour to the page cream** (`248,241,228`) where the backdrop is near-uniform. Cheap, and
    the resulting JPEG is small.
  - **Flood fill from the image borders to transparency** where a cut-out is wanted. This is the
    only method that works on these files: a plain colour threshold cannot separate artwork from
    backdrop, because their own light tones sit within 2 to 12 of it, so any tolerance wide enough
    to lift the background also erases the peach figures, tables and mugs. The flood fill spreads
    through the background but **stops at the drawn outlines even where the colours match**.
  - Always composite the result over the page cream and look at it before installing.
  - The flood fill must be **compiled** (`Add-Type` C#), not an interpreted PowerShell loop. On
    1.5 million pixels the interpreted version does not finish inside two minutes.
  - **Transparency is expensive.** A cut-out PNG of one of these runs 860 to 920 KB against roughly
    88 KB for the same picture flattened to cream as a JPEG, and on a flat-cream page they look
    identical. Harshita has been told and currently prefers the PNG. Only keep transparency where
    the background behind it could actually change.
- A **floating WhatsApp button** (`.wa-float`) is fixed to the bottom right of every page. Styled in
  the site palette (rose-soft to purple-soft gradient, deep-purple glyph) rather than WhatsApp
  green, which would clash with the cream/purple scheme. It carries a slow 6s `waGlow` halo pulse,
  deliberately low-opacity: the brief was "very gentle soft glow, very subtle and not loud but
  still visible". Keep it that way, do not raise the opacity or speed it up. An italic glass pill
  tooltip ("Reach out on WhatsApp", same treatment as the section-rail labels) appears on hover and
  is hidden below 600px. The existing reduced-motion rule already flattens the pulse.
- The footer logo is the real brand logo image (`assets/Whitelogo.png`, feather, cupped hands,
  wordmark, tagline), not the earlier hand-drawn inline SVG approximation. It is **45px tall and
  centred in its column**, both horizontally and vertically. It was 64px and pinned to the top
  left, which left it in the corner of a large empty area, since the brand column holds nothing
  else. The other footer columns stay top-aligned, so the logo sits level with the middle of the
  Explore list by design.
- **Nav hover is a purple glow, not an underline.** Two text shadows: a tight one at 10px that
  keeps the letterforms defined, and a wider fainter one at 22px for the halo, both
  `rgba(122, 77, 143, ...)`. The `.nav-links a::after` underline that used to do this is gone
  site-wide; if it reappears, that is a regression.
  - The Work With Me dropdown toggle carries the same glow, so the whole bar behaves alike, and
    its `transition` must name `text-shadow` or the glow snaps on instead of fading.
  - **`.nav-cta` is excluded** via `:not(.nav-cta)`. It is a filled purple button and a bloom
    behind its white text reads as a smudge.
- The same purple bloom appears as a `box-shadow` on hover elsewhere, for example `.theme-pill` on
  the organisations page. Reach for that pairing (tight halo plus a softer drop) when something new
  needs a hover state, rather than inventing a third treatment.

---

## 4. Site structure

- **Home** (`index.html`, built): hero, values, concerns, a consolidated "glimpse" section, a
  dedicated testimonials section, contact strip, footer.
  - **Hero**, deliberately aligned to the Psychotherapy page hero (that page is the reference the
    home page follows, per explicit instruction):
    - Headline is "A space to feel seen, heard, and slowly *untangle* what feels heavy." The rose
      italic `<em>` emphasis is on **untangle** (moved off "heard" on request).
    - `h1` uses the same `clamp(2.4rem, 5.5vw, 3.6rem)` as `.page-hero h1`, so both render at an
      identical size. Do not scale the home headline independently of the inner pages.
    - `.hero-inner` matches `.page-hero-inner` (`1.05fr 0.95fr`, `gap: 4rem`, padding
      `10rem 0 5rem`) with one intentional exception: it is `align-items: flex-start` rather than
      `center`. The inner pages centre because illustration and text are near equal height; the
      home portrait is much taller, and centring pushed the eyebrow far down the page. Top-aligning
      puts "Express · Embrace · Empower" at the same level as "For individuals" (160px vs 166px).
    - `assets/harshita-home.png` is a **transparent PNG cut-out**. Its framing went through three
      treatments; only the third is current. (1) Free-floating with a `drop-shadow()` following her
      silhouette. (2) A white rounded rectangle matching `.hero-art`, with the bottom edge masked
      away and a blurred halo on `.hero-photo::before`. (3) **Current: a soft radial "safe area"
      with no box at all.** Both the earlier versions are superseded, so do not reintroduce the
      rounded rectangle, the white fill, the `border-radius`, or the `::before` halo, which is
      deleted outright.
    - How the current treatment works, and why each part is needed:
      - `.hero-photo-frame` carries **both** a radial-gradient `background` and a radial-gradient
        `mask-image` whose stops **mirror each other exactly**. If they diverge, the fill and the
        alpha falloff draw two separate edges instead of one. The fill uses the page's own cream
        (`--cream-warm` into `--cream`), not white, so it reads as the photo dissolving into the
        page rather than a spotlight behind her.
      - The taper uses **many stops approximating an ease curve** rather than two or three. A short
        taper leaves a visible ring where her dark hair meets the page.
      - `padding: 0 18% 2%` is load-bearing: it gives the gradient room to reach full transparency
        *inside* the element. Without it, a radius wider than 50% is clipped by the element edge
        partway through the fade, which draws exactly the vertical boundary the mask is meant to
        avoid.
      - The `img` transform is `translateX(-8.5%) translateY(-4%) scale(1.16)`. The `-8.5%` centres
        her (the source has 17.5% empty margin on the left against 0.5% on the right); the scale
        and vertical shift crop out roughly 12% of dead transparent space above her hair so her
        head sits at the top of the frame instead of floating mid-way down. Overflow from this is
        caught by `overflow: hidden`, which is safe because the mask has already faded those edges
        to near-zero opacity. **If the photo is re-cut or replaced, re-measure the subject's
        bounding box and redo these numbers.**
      - Negative margins (`.hero-photo-frame { margin: 0 -8% }`, `-20%` at 900px+) deliberately
        let the frame spill past its grid column, because the overspill is fully-faded glow rather
        than content. `.hero-photo { margin-bottom: -4rem }` (`-5rem` at 900px+) cancels the hero's
        bottom padding so she reaches the section's base edge, and `margin-top: 2.75rem` on desktop
        lines her hairline up with the top of the headline rather than the eyebrow above it.
        Verified there is no horizontal page overflow at 800px despite the negative margins.
    - `assets/harshita-home-source.png` is the original flat-white-background version, kept so the
      cut-out can be redone. The cut-out was made by flood-filling inward from the image borders,
      not by a global colour key: her shirt is only ~23 units from pure white and her teeth and
      eye whites are white too, so a plain "remove all white" pass punches holes through them.
      Any future re-cut must preserve that border-connected constraint.
    - `assets/harshita-home 2.png` is the older grey-studio-backdrop photo, now unused.
  - **The glimpse photo is `assets/harshita-glimpse.png`, a transparent cut-out.** `.glimpse-visual
    img` therefore carries **no edge feathering and no crop**, only `width: 100%; height: auto`.
    Both were removed deliberately when the photo changed:
    - The old four-edge mask suited a rectangular photo ending on a hard boundary. A cut-out
      already dissolves into the page, so the mask would fade the artwork itself rather than an
      edge that is no longer there.
    - The old `aspect-ratio: 4/5; object-fit: cover` cropped to a ratio the current file does not
      have, taking slices off it for nothing.
    If a future photo is a plain rectangle again, put both back; if it is a cut-out, leave them off.
    `assets/harshita-chair.jpg` is the previous rectangular photo, kept but unused.
  - The glimpse section (`#glimpse`) replaced four separate sections (why-this-fits narrative,
    Work With Me preview, testimonials carousel, qualifications timeline) with a compact block:
    a section head ("A little more to help you decide" / "Grounded in experience, held with
    care"), then a two-column row of a photo of Harshita and a
    right-hand column (`.glimpse-trust`) holding the short approach paragraph (see About Harshita
    / approach paragraph in section 5) followed immediately by a "More about my approach" link
    (`.approach-link`), both stacked in that column. This link used to be the third of three
    self-select cards further down the page; it was folded up here instead, "beside the photo
    placeholder... above the number stats" per explicit request, so the About pathway reads as part
    of the intro rather than a fourth destination competing with Psychotherapy/Supervision.
    `.approach-link` has been stripped down over three passes, each time toward "seamless": it
    started as a bordered card with an avatar icon and a description, then lost the box and icon but
    kept a `border-top` rule and the description, and is **now just the italic serif words "More
    about my approach" plus a small arrow**, with no rule, no box, no icon, and no supporting
    copy. Do not reintroduce any of those; the whole point is that it reads as the last line of the
    paragraph above it, not a separate component. The paragraph's font size (`0.98rem`) was also
    matched to `.value-card p` on request, "make this font similar to" the Express/Embrace/Empower
    body text.
    Below the two-column row sits the full-width animated **stat counter row** (see Practice stats
    in section 5), separated by a petal divider. The stats were originally squeezed into the
    half-width text column and got visually clipped by the fixed section-rail tooltip on narrower
    viewports; moving them to their own full-width row fixed that.
  - The self-select links section (`#work-with-me`) now holds only **two** cards, "Psychotherapy
    sessions" and "Supervision sessions" (the third, About, moved up into glimpse as described
    above). It has its own section head, eyebrow "Ready when you are", title "Work With Me", same
    pattern as every other section head on the page; previously this section had no heading of its
    own. It sits in its own plain section right after testimonials, pointing to the dedicated pages
    below. This was a deliberate restructure: the homepage should hook, present concerns, give one
    credibility beat, and then let each audience choose where to go deeper, rather than making
    everyone scroll through everything. **This section is no longer a nav destination** (see the
    nav dropdown note below); it stays purely as homepage content, and its `#work-with-me` id is
    now unreferenced by any link.
  - The testimonials carousel has its own section (`#testimonials`), separate from glimpse, with
    its own entry in the section rail nav. It was originally nested inside glimpse; the user
    explicitly asked for it to be its own section, then went through two layout iterations before
    settling on the current one:
    1. First tried as a side-gutter label next to the carousel card.
    2. Then redesigned into its current form: "From fellow therapists" is a proper section header
       (eyebrow "In their own words" + `<h2>`, same section-head pattern as Values/Concerns/
       Glimpse), and the card below splits into a **3:6 grid** (`.testimonial-grid`,
       `grid-template-columns: 3fr 6fr`): a smaller left column (`.testimonial-meta`, content
       vertically centered) with name, qualifications, and years experience, and a bigger right
       column (`.testimonial-body`) with the full write-up. Years experience is a small, subtle
       rose-tinted pill badge (`.meta-years`), not a large bold line; a bigger bold deep-purple
       treatment was tried and rejected as too loud for the section's quiet tone. An initials
       avatar circle was also tried and then explicitly removed; don't re-add either. Both
       columns are driven by parallel slide arrays
       (`.meta-slide` / `.body-slide`, matched by index) so a single prev/next/dot/autoplay
       carousel advances them together, with an added pause/play toggle button
       (`#carPlayPause`) that stops/resumes the 5s autoplay. Nav controls (arrows, dots,
       play/pause) sit in one centered row below the card. Keep this structure; don't revert to
       the single-column quote-only layout.
  - Full qualifications and the full "why this fits" narrative are intentionally **not** on the
    homepage anymore. They belong on the About page once built. This is an accepted, explicit
    tradeoff, not an oversight. The full testimonial set, by contrast, lives directly on the
    homepage as the carousel described above.
- **About** (`about.html`, built): no standalone photo/name hero banner (one was tried and then
  removed as redundant with the bio section right below it). Instead, the bio section itself opens
  with a two-column row: a full-picture placeholder (dashed border, not the small circular
  hero-photo style) on the left, the write-up on the right, stacking on narrower screens. Bio copy
  is de-duplicated from the near-identical "About me page" and "Approach as a therapist" source
  docs (used the fuller version once), with the age range stated as "18+" (not the source docs'
  "20 to 65").
  - The bio is **truncated behind a "Read more" toggle**: the first two paragraphs always show,
    the remaining four (including the closing italic `p.bio-quote`) sit inside `.bio-more` and
    expand on click, with the link text flipping to "Read less". The collapse uses the
    `grid-template-rows: 0fr -> 1fr` technique so it animates to the content's natural height
    without hard-coding a max-height. `.read-more-link` is deliberately **plain underlined text,
    not a pill or button**, so it sits in the paragraph flow rather than reading as a UI control.
  - Two things to watch if this is edited: the closing quote paragraph is styled via
    `p.bio-quote`, **not** `p:last-child`, because it is no longer the last child once nested
    inside `.bio-more`. And the "Sessions offered in English and Hindi" `.lang-note` must stay
    **outside** the collapsible block so it is always visible.
  Then: a 5-card values section in this **exact order, set deliberately**: Eclectic,
  Trauma-informed, Intersectional, Queer-affirmative, Neurodivergent inclusive. At the 3-up
  breakpoint (1000px+) the grid is declared as **six** columns with each card spanning two, and
  cards 4 and 5 pinned to `grid-column: 2 / span 2` and `4 / span 2`. That shifts the second row by
  exactly half a card so it sits centred beneath the three above, instead of sitting flush left with
  a gap on the right. Six columns of width c with gap g make a two-column card 2c+g wide, and three
  of those plus gaps total 6c+5g, so row-one widths are identical to a plain 3-column grid.
  Verified: all five cards render 355px wide, and row two's centre matches row one's. The offset is
  applied **only** at this breakpoint; below it the grid is 2-up then 1-up, where a half-card shift
  would look broken. Reordering the cards will break the intended pairing, so move the markup and
  the nth-child rules together. Then Qualifications (same vertical timeline component
  originally built for the homepage, all 6 entries), an Experience section in the same timeline
  style (Private Practice, Xavier's College, Cultfit, iCall, CanKids, Budhrani Trust), and a small
  embedded "Contact me" section. Shares the homepage's design system (own copy of the CSS, not a
  shared stylesheet) but is a fully separate file; built without touching `index.html` per explicit
  instruction. All homepage nav "About" references (top nav, mobile drawer, hero button, footer,
  and the glimpse-links "Curious about me" card) now point to `about.html`.
- **Work With Me, Psychotherapy** (`psychotherapy.html`, built): hero using the staged
  `assets/therapy-hero.jpg` artwork, a concerns recap, a **logistics infographic** (days, duration,
  format, location, see the note below), a 3-tier pricing block, a
  step-by-step process timeline including a consent-form step (real link supplied, see section 5),
  all 8 FAQs as native `<details>` accordions, a languages note, and a contact section.
- **Work With Me, Supervision** (`supervision.html`, built): same pattern, using
  `assets/supervision-hero.png`. Includes a **three-track** section ("Wherever you are in your
  practice", eyebrow "Three ways in"): 0-3 years/Early-career, 3-6 years/Mid-career, 6+ years/
  Experienced (this third card and the "Mid-career" rename were added after the user approved the
  proposed write-up). Pricing is Rs 1,800/session online, Rs 2,500 per 60-min in-person session
  (corrected from an earlier equal Rs 1,800 for both); a reserved "Coming soon: Group Supervision"
  card; the consent-form step with its real link; all 6 FAQs; a languages note; a contact section.
- **Session logistics infographic** (`.logistics-grid`, on both Psychotherapy and Supervision).
  Replaced the original four bordered cards, which were explicitly rejected: "create this section in
  info graphic UI without containers with dynamic mouse interaction". Current form:
  - **No containers.** `.logistic-card` keeps only `text-align: center`; no background, border,
    radius, padding, or hover lift. Do not put the boxes back.
  - The four points are **beads threaded on a single line**. `.logistics-grid::before` draws the
    thread, bounded `left: 12.5%; right: 12.5%`, which lands exactly on the first and last icon
    centres in a 4-column grid. Each icon's first `box-shadow` is a 7px ring in the **section's own
    background colour** (`var(--cream)`), punching a gap in the thread so the icons read as beads on
    it. If a page ever gives this section a different background, that ring colour must change too.
    The thread is hidden below 700px, where the grid drops to two columns.
  - **Dynamic mouse interaction**: each point carries a `--prox` custom property (0 to 1) that JS
    sets every frame from the cursor's distance, driving icon lift, scale, and shadow, plus a small
    lift on the label and value. A second pseudo-element (`::after`) is a brighter stretch of thread
    masked by a radial gradient that follows the pointer via `--mx`.
  - Tuning that matters, do not casually change: the falloff radius is **380px, deliberately wider
    than the ~224px gap between points**, so a neighbouring point lifts gently instead of the effect
    being all-or-nothing like plain hover (an earlier 210px radius was strictly narrower than the
    gap, which made it behave exactly like `:hover`). Vertical distance is weighted at 0.55 because
    the points sit in a horizontal row and the cursor is usually below the icon over the text.
  - Easing is done in **JS** (values lerp toward target each frame); there is deliberately **no CSS
    transition** on these properties, since a transition would restart on every `pointermove` and
    lag behind the cursor. The whole script is skipped on touch input and under
    `prefers-reduced-motion`, leaving the section static and fully readable.
- On both Psychotherapy and Supervision pages: the consent-form link in the process step is
  styled as a small rose pill (`.consent-link` class) so it's more visible without being loud. The
  clickable email and WhatsApp links live in the "Reach out" (step 1) process item, not the
  bottom contact section (moved there per explicit request, since having them in both places felt
  redundant).
- All internal anchor links (e.g. `index.html#community`) account for the fixed nav bar via
  `scroll-padding-top: 90px` on `html` in every page. Without it, the fixed ~77px nav sat directly
  on top of the scrolled-to section and made it look like the link had gone nowhere.
- **"Work With Me" is a nav dropdown, not a link.** It previously pointed at `#work-with-me`, which
  scrolled to the two-card section on the homepage; that was explicitly rejected as the wrong
  destination. It now works like this, consistently on all four pages:
  - **Desktop** (`.nav-dropdown`): the label is a `<button>`, deliberately **not** a link, with
    `cursor: default`. It only opens the menu; clicking the words does nothing. The menu opens on
    `:hover` **and** `:focus-within`, so it is reachable by keyboard. A `::before` pseudo-element on
    the menu bridges the `0.9rem` gap below the label, otherwise the menu closes as the pointer
    travels down to it. `.nav-dropdown-menu a::after { display: none }` suppresses the inherited
    `.nav-links a` underline sweep on the menu items.
  - **Mobile drawer**: there is no hover, so both destinations are always listed, indented
    (`.nav-drawer-sub`) under a plain non-clickable `.nav-drawer-label`. Do not convert this into a
    tap-to-expand accordion; always-visible was the chosen behaviour.
  - **Footer "Explore" column**: split into two flat links, "Psychotherapy sessions" and
    "Supervision sessions" (footers list flat links rather than dropdowns). The heart icon is used
    for Psychotherapy and the people icon for Supervision, matching the homepage self-select cards.
  - Both sub-items go straight to `psychotherapy.html` and `supervision.html`. Nothing in the nav
    or footer scrolls to the homepage `#work-with-me` section any more.
- Both Psychotherapy and Supervision FAQs were rewritten in a warmer, more caring tone (2026-08-08,
  approved by the user before implementing). Style note the user gave afterward: avoid contractions
  like "I'll"/"we'll"/"you'll", spell them out as "I will"/"we will"/"you will" throughout FAQ copy
  (and the word "cadence" was flagged as not simple enough, replaced with "schedule" in the
  supervision "how often will we meet" answer).
- **Peer Testimonials** page (not yet built): all 8 real testimonials in full.
- **Work With Me, For Organisations** (`workplace-wellbeing.html`, built): the third entry in the Work With
  Me dropdown, aimed at companies and teams. Built from the `psychotherapy.html` template so nav,
  footer and styling stay identical. Copy was drafted and approved by the user before any building.
  - **No pricing anywhere on this page, by explicit instruction.** The pricing CSS inherited from
    the template was stripped out rather than left dead, so it cannot creep back in. The "A
    conversation" step in the process is what handles the pricing question instead. Do not add a
    price table, a "from" figure, or a package tier here without being asked.
  - Sections: hero, Why this matters, What I offer
    (three `.concern-card`s: Workshops, One-on-one mini sessions, Customised plans), Themes
    (`.theme-pill` list of 8, plus a note inviting their own), Confidentiality, How it works
    (5-step process), a short About block linking to `about.html`, 7 FAQs, and a contact CTA.
  - **The hero deliberately uses `.page-hero-inner` with no overrides**, so its two-column
    arrangement, column ratio, gap, type scale and spacing match the Psychotherapy and Supervision
    banners exactly: copy on the left, visual on the right. An earlier version put the picture on
    the left and flipped the column ratio, and the user asked for it to match Psychotherapy
    instead. If a `.corp-hero-split` style override reappears, that is a regression. The reserved
    image slot is square (1/1), because the therapy art is 1.12:1 and the supervision art is 1:1,
    which keeps the three banners a similar height.
  - **The banner art is `assets/workplace-wellbeing.png`, a transparent cut-out**, so `.hero-art`
    is `display: block` and nothing else. The inherited `border-radius: 20px` plus drop shadow was
    removed: around a cut-out it outlines a card that is not there. It was also dead on the three
    legal pages, which carried the rule and no such image.
  - **In the nav dropdown and mobile drawer this page is labelled "Workplace Wellbeing"**, matching
    its own headline. The footer link and the homepage Work With Me card still say "For
    organisations", and the browser tab title is still "For Organisations · Honoring Stories".
    That split is deliberate as of the last request, not an oversight.
  - `.corp-prose` is **centred**, so the "Beyond awareness" copy sits under its centred heading.
    The About block opts back out via `.about-split .corp-prose { text-align: left }`, because it
    runs beside her circular portrait and needs a straight left edge against it. Keep that override
    if either rule is touched.
  - `.theme-pill` borders are `rgba(91, 46, 107, 0.3)`, **not `var(--line)`**. At 0.14 alpha they
    were all but invisible against the cream these sit on. Hover adds the site's purple bloom as a
    box-shadow.
  - **Her portrait sits in the About block, not the hero**: `assets/harshita-organisations.jpg`
    (560x840, 62 KB), cropped to a 220px circle at `object-position: 50% 14%`. The source
    `Harshitafororganizations.jpg` had a navy background, flood-filled from the image borders to
    white at tolerance 45, which isolates the navy without touching her blazer, hair or skin. Two
    small teal artifacts remain at the left edge of the source and fall outside the circular crop,
    so do not widen that crop without re-checking them.
  - **Confidentiality is a collapsible panel inside "What I offer"**, centred beneath the three
    cards, opened by an `.info-btn` reading "ⓘ On confidentiality". It states plainly that the
    employer receives no names, notes, or account of what was discussed, only broad
    non-identifying themes, with the risk-of-harm exception. It is also repeated as an FAQ,
    because people look in both places, and that repetition matters more now that the panel starts
    closed.
    - It went through three forms: an always-visible `.confidential` card in its own section, then
      a modal `<dialog>`, then this. Each move was requested. Do not move it again unasked.
    - The trigger keeps **the words next to the icon**, not a bare "ⓘ". A lone icon is easy to
      scroll past, and for an employer weighing this up it is usually the deciding question.
    - The panel animates with `grid-template-rows: 0fr → 1fr`, not a `max-height` guess, so it
      eases to the text's real height rather than clipping it or easing against a height that is
      not there. `aria-expanded` on the button is the **single source of truth** for open state, so
      the chevron rotation, the grid row and assistive technology cannot disagree.
    - Panel text stays **left aligned** even though the block is centred. Three centred paragraphs
      are hard to read.
  - **Written in "I", like every other page. This was decided after trying the alternative.** The
    page was briefly rewritten in a corporate "we" voice and then reverted, so do not switch it
    again. The reasons it went back:
    1. Honoring Stories is a **sole proprietorship**. There is no team, so "we" is not accurate,
       and it contradicts the Terms and Privacy Policy, which say the same thing in the first
       person singular.
    2. **The confidentiality promise is stronger in "I".** "What an individual shares with me stays
       with them" reassures an employee precisely because it names one person holding it. Any
       plural form implies a group can read what was said, which is the opposite of the point. In
       the "we" version this sentence had to be reworded around the pronoun to avoid the problem,
       which was a signal the voice was fighting the content.
    3. A named clinician is the **differentiator** against large impersonal EAP vendors, not a
       weakness to disguise.
    Note that four naturally plural phrases remain and are correct: "Themes we can work with" and
    "we will find something workable" are the collaborative you-and-me sense, and two FAQ questions
    ("Will we be told...", "our industry") are written in the enquiring organisation's own voice.
  - **Deliberately claims no corporate track record.** Nothing in the source material describes
    previous organisational work, so there are no client names, logos, "trusted by" lines, or
    outcome statistics. If real ones are supplied later they belong near the top. Do not invent
    percentages about attrition or productivity to fill the gap.
- **Legal pages** (`disclaimer.html`, `privacy-policy.html`, `terms-and-conditions.html`, all
  built). Drafted as plain content first, reviewed by the user, and **still to be checked by a
  lawyer** before the site goes public. Written from scratch rather than adapted from another
  practice's pages, both because legal text is copyrighted and because a copied policy would
  misdescribe this practice's actual setup.
  - Shared identity block on all three: sole proprietorship, private practice of Harshita Sarda,
    **Udyam Registration Number UDYAM-MH-18-0422743**. Udyam is deliberately described as a
    **business** registration, not a professional or clinical one, since it is an MSME registration
    and implying clinical accreditation would be misleading. Effective date on all three:
    **1 September 2026**.
  - Confirmed facts these documents rely on, verified against the code rather than assumed: the
    site sets **no cookies, runs no analytics and has no tracking scripts**; the only passive data
    flow is **Google Fonts**, which gives Google visitors' IP addresses on every page. If analytics
    are ever added, or the fonts are self-hosted, the Privacy Policy must be updated to match.
  - Clinical record retention is **7 years after active work is completed**.
  - By explicit decision: **no registered postal address**, **no named grievance officer** (concerns
    route to `feelseen@honoringstories.com`, which keeps a stated mechanism in place), and **no
    GDPR section**, the user having confirmed it is not needed.
  - Layout: no section rail (single flowing documents, so the rail script is stripped too), a
    centred hero with the effective date, `.legal-body` prose styling, a `.legal-crisis` block in
    the Disclaimer giving the helplines prominence, and `.legal-links` cross-links between the
    three. The footer's three previously dead `href="#"` placeholders are now wired on all nine
    pages.
- **Community** (`community.html`, built): one page holding both community spaces, built from the
  `psychotherapy.html` template so nav, footer, CSS and scripts stay identical. Copy is taken from
  the source docs `About - Shared ways of coping.docx` and `About - Sip and Swap stories.docx` in
  `InstructionsWebsite.zip`, lightly edited only to remove contractions and em dashes.
  - Hero is **single-column and centred**, unlike the two-column inner-page heroes, and now opens
    with a full-bleed illustrated band (`assets/community-hero.jpg`) between the nav and the
    "Community" eyebrow. Its motifs are cut at both left and right edges because it is drawn as a
    repeating pattern, so it runs to the window edges: contained in a centred box those cut motifs
    read as a crop mistake. `.page-hero` already has `overflow: hidden`, so the 100vw breakout
    cannot cause sideways scrolling.
  - **Shared Ways of Coping** (`#shared-ways`): intro copy beside a reserved
    `.visual-placeholder` (the source doc explicitly says "add relevant image"), three
    `.note-pill`s (anonymous / optional / read before publishing), then the published notes and
    the sharing box.
  - **The sharing box takes the note on the page itself** rather than sending people to Google.
    It is the question as a prompt, a textarea, a live counter that counts 100 words down to 0, a
    consent tick, and a submit button that stays disabled until there is both text and consent.
    Past the limit the counter turns rose and submit disables again.
    - It posts a plain `<form>` at a hidden iframe rather than using `fetch()`. That needs no CORS
      permission from Google, and it degrades correctly without scripting: the visitor lands on
      Google's own confirmation page instead of seeing the thank-you in place. **Do not "modernise"
      this to `fetch()`**, it will start failing on CORS.
    - Field names are Google's own question ids, `entry.725693056` for the note and
      `entry.1145237366` for consent. If the form's questions are edited these can change and
      submissions will silently stop arriving. Re-read them from the live form if that happens.
  - **Published notes system, second design (2026-08-27 onward): Sveltia CMS writing to
    `notes.json`, replacing the earlier live Google Sheet CSV read.** The Google Form is still
    where a visitor's submission arrives and is still the private moderation inbox; only the
    *publishing* step changed.
    - **The flow now:** a visitor submits through `SHARED_FORM_URL`, unchanged, and it lands in
      the Google Form's own responses sheet, unchanged. Harshita reads it there. To publish it she
      adds an entry to **`notes.json`** at the repo root and commits it, either by editing the
      file directly on GitHub, or through the **Sveltia CMS** admin screen at `/admin`, which
      writes the same file without her handling any punctuation. The page reads that file, not
      Google, for what it displays.
    - `notes.json`'s shape is `{ "notes": [ { "note": "..." }, ... ] }`. **Keep the wrapping
      `"notes"` key.** A Sveltia/Decap "files" collection always saves an object keyed by field
      name; it does not write a bare top-level array. `community.html` reads `data.notes`, so the
      two must agree, and this was verified before either side was written.
    - The page constant is `SHARED_NOTES_JSON = 'notes.json'` (`community.html`). `SHARED_FORM_URL`
      is unchanged from before, `?usp=sharing&ouid=...` still stripped, still Harshita's Google
      account id, still must never be pasted back in raw.
    - Malformed entries in `notes.json` (not a string, blank after trimming, not even an object)
      are silently skipped rather than thrown, so one bad entry cannot blank the whole section.
    - Note text is inserted with **`textContent`, never `innerHTML`**. This is text a human has
      copied in from a public form submission, so treating it as markup would be an injection hole
      even with a moderator in the loop. Do not "improve" this to innerHTML to allow formatting.
    - Cards are **quote only, with no name, credentials or years**, unlike the homepage
      testimonial cards they are visually modelled on. The anonymity is the point.
    - Empty and failed states both say something gentle rather than showing a blank area.
    - **The admin screen, `admin/index.html` and `admin/config.yml`, is not yet functional.**
      Sveltia needs an OAuth connection to GitHub before login works, and that requires creating
      something (a small OAuth proxy, or moving hosting to a provider like Netlify that supplies
      one) which only Harshita can authorise, since it means a new account or a new service
      attached to her GitHub. Until that piece exists, publishing a note means editing
      `notes.json` directly on GitHub, which works today with no setup at all. See open items.
    - **First design (2026-08-14 through 2026-08-27, superseded): live Google Sheet CSV read.**
      Kept here because the reasoning inside it is still relevant if the site ever needs a
      moderation step with no human editing files by hand.
      - Two constants drove it: `SHARED_NOTES_CSV` and `SHARED_FORM_URL`. The CSV was the
        "Approved" tab of the sheet published to the web, never the raw responses tab, which
        would have made every unmoderated submission publicly readable.
      - The publishing formula, in the Approved tab:
        `=FILTER('Original response'!B2:B, 'Original response'!D2:D=TRUE, ARRAYFORMULA(REGEXMATCH(LOWER('Original response'!C2:C&""), "^yes")))`
        Two conditions, consent and a moderation tick, both required. `ARRAYFORMULA` was load
        bearing: without it `REGEXMATCH` does not iterate a range in Google Sheets and the whole
        filter silently matches nothing, which cost a long debugging detour.
      - Google cached the published CSV for about five minutes, so a newly ticked note did not
        appear instantly. A CSV parser handled quoted commas, embedded newlines and escaped
        quotes, rejoining fields rather than taking the first one, since the Approved tab was a
        single column and taking `r[0]` alone would silently truncate a note at an unquoted comma.
        Rows carrying a spreadsheet error (`#REF!`, `#N/A`, and the rest) were dropped, and bare
        `TRUE`/`FALSE` cells from the tick-box column stripped, so neither could be rendered as
        though a person had written it.
      - **Why it was replaced:** the formula broke more than once in ways that were not obvious
        from the sheet, and every fix depended on someone who understood spreadsheet formulas and
        regular expressions. Editing a small JSON file, or filling in a form, does not.
    - Alternatives considered and why not: a custom backend (Supabase/Firebase) is ruled out by
      the project's no-backend rule and is heavy for a page of short notes; a WordPress form
      plugin is the natural long-term home but needs the migration first; Airtable adds another
      vendor. Because the submissions live in Google Sheets, none of this is trapped: after the
      WordPress move the same sheet can be read or imported.
  - **Sip and Swap Stories** (`#sip-and-swap`): three `.concern-card`s covering who it is for
    (2+ years experience), the format (40-minute one-to-one video call), and what gets talked
    about, then the intention paragraph, then the fit note. That note, that the space is **not**
    for existing, previous, or potential therapy clients or supervisees, is a `.gentle-note`
    (a quiet left rule), deliberately not a loud warning banner. It comes straight from the
    source doc and must not be dropped.
  - **How Sip and Swap works** (`#how`): three-step process timeline. Step 1 asks for a LinkedIn
    profile alongside the message, which is how the source doc describes it.
  - Unused CSS and the logistics-infographic script inherited from the psychotherapy template were
    stripped out of this file rather than left dead.
  - Before this page existed, the "Community" nav item on all four pages pointed at
    `index.html#community`, **an anchor that never existed anywhere**, so the link was silently
    dead site-wide. All 15 Community links now point to `community.html`.

**Important scoping rule:** pricing does not appear on the homepage. It belongs only on the
dedicated Psychotherapy and Supervision pages once built.

---

## 5. Content

### About Harshita
MA in Clinical Psychology; Diploma in Counseling Psychology (Xavier's College); Diploma in
Supervision for Mental Health Practice (TISS). **7+ years as a therapist, 4+ years as a
supervisor** (corrected from an earlier 6+/3+ figure; always use 7+/4+). Works with adults 18+
(corrected from an earlier 20 to 65 range; always use 18+ going forward). Concerns include
anxiety, relationship challenges, self-confidence/self-esteem, depression,
trauma, sleep difficulties, emotional regulation, life transitions. Particular interest in
anxiety and relational dynamics, identity, self-worth, belonging. **Sessions offered in English
and Hindi** (shown as a small pill note on the About, Psychotherapy, and Supervision pages).

### Approach paragraph (used in the glimpse section, next to the photo placeholder)
> "My work is rooted in an eclectic, trauma-informed, queer-affirmative, and integrative
> approach. I believe that therapy is not a one-size-fits-all process and thoughtfully adapt my
> approach to each client's pace, needs, and lived experiences. Guided by a sensitivity to the
> ways in which personal experiences are shaped by relational, cultural, and social contexts, I
> strive to create a therapeutic space that is responsive to each individual's unique story."

Use this verbatim; it was supplied directly by Harshita for this placement.

### Practice stats (homepage animated counter row)
Displayed in the glimpse section as three large animated numbers that count up from zero when
scrolled into view, replacing the earlier trust-line paragraph:
- 7+, Years
- 400+, Clients served
- 2,000+, Sessions completed

Style convention: keep this pairing (7 / 400 / 2,000) unless the user supplies updated figures.
Went through four passes: (1) heavy bold sans-serif numbers above a flat full-width rule, rejected
as "very corporate for a safe psychotherapist's website"; (2) upright serif numbers on the same
flat layout, rejected as well ("I don't like the stats UI... improve the design to suit the page's
theme"); (3) boxed `.stat-card`s with borders, hover lift, and gradient icon circles, also rejected
("remove the icons and boxes, make it seamless"); (4) **current**: frameless. `.stat-card` keeps
only `text-align: center` in a 3-column grid (`max-width: 720px`); no background, border, radius,
padding, hover lift, or icons. The numbers sit directly on the section background so the row reads
as one calm band. Numbers are upright serif (not italic; that read as "too cursive and decorative"
in an earlier pass). The count-up eases in and out with a gentle smoothstep (`p*p*(3-2p)`) over
**3200ms**, progressively slowed from 1600 to 2000 to 3200 across passes as the user kept asking
for calmer motion. If revisited, keep going simpler and slower, not back toward cards or icons.

### Approach / values (Express, Embrace, Empower)
- **Express**: a grounded, non-judgmental space to speak what feels hard to say, at your own pace.
- **Embrace**: meeting every part of you, the tender, the tired, the uncertain, with warmth and respect.
- **Empower**: helping you reconnect with your own capacity, clarity, and agency, gently and collaboratively.

The three `.value-icon` circles have a slow ambient glow pulse (`iconGlow` keyframes, box-shadow
0 to `0 0 26px 8px rgba(217,106,156,0.3)` and back, 7s ease-in-out infinite, each card offset by a
negative `animation-delay` so they don't glow in unison), requested explicitly ("glow in glow out
in slow speed"). This is separate from the existing hover scale/rotate, which still applies on top.

Eclectic, trauma-informed, queer-affirmative, intersectional, neurodivergent inclusive. Completed
Queer Affirmative Practice course (Mariwala Health Foundation) and complex trauma training
(ISSTD).

### Qualifications (timeline format, in order; currently reserved for the About page)
1. MA in Clinical Psychology
2. Diploma in Counseling Psychology, Xavier's College
3. Diploma in Supervision for Mental Health Practice, TISS
4. Queer Affirmative Counseling Practice, Mariwala Health Initiative
5. Gestalt Therapy: Basic and Advanced (60 hours, Psychphoenix)
6. **Complexities of Complex Trauma Accelerated**, The International Society for the Study of
   Trauma and Dissociation (ISSTD), added per explicit request

### Previous work experience
- Private Practice, since 2023 (individual therapy and supervision)
- Xavier's College, Field Supervisor for MA 2nd-year interns (contractual, since Feb 2021)
- Cultfit, freelance psychologist, online 1:1 therapy, Jun 2020 to Feb 2023, 1050+ positive reviews
- iCall, Covid Mental Health Helpline volunteer counselor, Sep 2020 to Jan 2021
- CanKids, pediatric cancer patients/caregivers at Tata Memorial Hospital, Feb to Aug 2020
- Naraindas Morbai Budhrani Trust, psychologist for cancer patients/caregivers at Nair, KEM,
  Wadia Hospitals, Jul to Dec 2019

### Psychotherapy sessions
- Days/hours: Tue to Sat, 8am to 6pm IST. Duration: 50 min. Format: **video call only** via Google
  Meet or WhatsApp (no voice-only sessions offered, per explicit correction).
- **Pricing (current, to be placed only on the Psychotherapy page, presented thoughtfully rather
  than as a bare price table):**
  - Rs 2,100, 50-min video session via Google Meet or WhatsApp, India-based clients
  - Rs 2,500, 50-min video session via Google Meet or WhatsApp, clients based outside India
  - Rs 3,000, in-person/offline sessions, Andheri West, Mumbai
- **The two online prices are never shown together.** The page displays two cards, "Online session"
  and "In person". The online figure is chosen from the visitor's own timezone: `Asia/Kolkata` or
  its legacy alias `Asia/Calcutta` shows Rs 2,100, anything else shows Rs 2,500. In-person is
  Rs 3,000 for everyone. This was an explicit request: visitors should not see that two online
  rates exist.
  - Implemented with **timezone, not a geo-IP service**. Timezone is read locally and sends nothing
    anywhere, so it adds no network request, no third-party dependency, no rate limit, and keeps
    the Privacy Policy's "no tracking, no third-party calls beyond Google Fonts" statement true. A
    geo-IP lookup would have transmitted every visitor's IP to another company and made that
    statement false.
  - **Both figures are in the markup**, with one hidden by CSS via a `geo-intl` class the head
    script sets. The script runs in `<head>`, before the body paints, so the correct price is the
    first thing drawn. Swapping the text after load would let the wrong price paint and visibly
    flip. Do not move this script to the bottom of the page.
  - The HTML default is the **India** price, so a visitor with JavaScript disabled sees Rs 2,100.
    That deliberately errs toward under-quoting a rare international edge case rather than
    over-quoting a local client, and the exploratory call happens before any payment anyway.
  - Known limitation: a VPN, or a client travelling, shows the price for where their device thinks
    it is. Low stakes, since billing is by UPI or bank transfer after a conversation.
- Flow: reach out, basic details shared, free 20-min exploratory call, **fill the consent form**,
  book via link/payment, confirmed via UPI or bank transfer. The consent-form step was added after
  the therapy consent form link was supplied (previously only supervision had this step); use the
  same pattern for both going forward.
- **Consent form (therapy):**
  `https://docs.google.com/forms/d/e/1FAIpQLSfmgCVHweP1bHLzMb8dAdRFE3fAfggpMXOXX3KUnOakmR02qA/viewform?usp=sharing&ouid=110517816113101014359`
- FAQs (8): how to start; what to prepare (nothing needed, join on time, quiet private space,
  good internet, steady device, optional water/notebook/pen); confidentiality (private, exception
  is risk of harm, discussed upfront); not knowing what to talk about (fine, can start anywhere);
  session frequency (usually weekly to start, revisited collaboratively); feeling worse before
  better (normal, supported, feedback taken); stopping anytime (client-led, ended thoughtfully);
  cancellation policy (free reschedule/cancel up to 3 hrs before session).

### Supervision sessions
- Days/hours: Tue to Fri, 8am to 6pm IST. Duration: 60 min. Format: **online (video call) or
  offline (in-person)**.
- **Pricing (current): Rs 1,800 per session online; Rs 2,500 per 60-min session in person at
  Andheri West, Mumbai (corrected from an earlier equal Rs 1,800 for both, in-person is now
  priced separately).**
- Currently two tracks shown on the page: early-career (0 to 3 years) and 3 to 6 years
  (label updated from "3+ years"). A third track for 6+ years practitioners is planned (see Open
  Items) with new write-up copy pending approval.
- Flow: reach out, basic details shared, free 20-min exploratory call, consent form, time/day
  scheduled, confirmed with a calendar invite after payment (UPI/bank transfer).
- **Consent form (supervision):**
  `https://docs.google.com/forms/d/e/1FAIpQLSdYik7Trg3YT__pQjntHeagLircLKxFBlJfZq-RfbGMm1bS6g/viewform?usp=sharing&ouid=110517816113101014359`
- FAQs (6): how to start; preparation (note topics, goals reviewed after first session);
  confidentiality (same policy as therapy); meeting frequency (generally bimonthly/every 2 weeks,
  adjustable); allowed topics (client cases, ethical dilemmas, logistics, building practice,
  burnout, imposter syndrome); cancellation (same 3-hr free reschedule/cancel policy).

### Group supervision (planned, not yet scoped)
Harshita wants to start offering group supervision and wants a dedicated section/space reserved
for it on the site, but pricing, format, cadence, and other details are not decided yet. Do not
build this section until the actual content is supplied, other than reserving a clearly-labeled
placeholder slot in the site plan (see Open Items).

### Peer testimonials
8 real testimonials collected via Google Form, all with explicit consent for name, education,
years of experience, and testimonial text to appear on the site. Full text lives in this repo's
private working notes, not committed, because the source spreadsheet contains personal emails.

The homepage glimpse section (see section 4) shows all 8 in an **autosliding carousel**: one
quote visible at a time, manual prev/next arrow buttons plus dot navigation, autoplay every 5
seconds that resets whenever someone interacts manually. This reverses an earlier decision to
show only a 1-quote static teaser; the user explicitly asked for all 8 back with autoplay. Order:
Deepapriya Vishwanthan, Rinkle Jain, Aaushi Shah, Sanika Nanal, Anis Syed, Zahra Diwan, Rajshree,
Ananyaa Kale. The same full set should be reused (not re-collected) if a dedicated Testimonials
page is built later.

### Helpline numbers (footer only, quiet placement, non-crisis-service disclaimer alongside)
1. MannTalks, 8686139139 (Mon to Sun, 10am to 6pm)
2. iCall, 9152987821 (Mon to Sat, 10am to 8pm)
3. KIRAN Mental Health (Government), 1800-599-0019 (24/7)
4. Spandan, 7389366696 (24/7)
5. Vandrevala Foundation, 9999666555 (24/7)

### Contact details (use these everywhere, not placeholders)
- Email: **feelseen@honoringstories.com**
- WhatsApp: **+91 9152801719** (linked as `https://wa.me/919152801719`)
- LinkedIn: **https://www.linkedin.com/in/psychologistharshita**
- Booking link (consultation calls): **https://cal.com/harshita-sarda-yllcdj/30min**
- Location: Andheri West, Mumbai (not just "Mumbai, India")
- Instagram: deliberately **not** linked in the footer (removed per request)

**Every call-to-action must resolve to one of those three destinations, never to an in-page
anchor.** The rule, by button:
- Anything labelled **"Book a Consultation Call"** or **"Book a free exploratory call"**, including
  the nav button in the header and the mobile drawer on every page, opens the **cal.com booking
  link** in a new tab. The nav button used to point at `#contact`, which merely scrolled down the
  page, and on the three legal pages was dead outright because they have no contact section.
- **"Start a conversation"** and **"Email me"** open **mailto:feelseen@honoringstories.com**,
  same tab (a mailto must not open a blank tab).
- **"Reach out"** and **"Message on WhatsApp"**, plus the floating `.wa-float` bubble, open
  **https://wa.me/919152801719** in a new tab.

The only `href="#contact"` links that may remain are the `.rail-dot` scroll-rail markers, which are
in-page navigation by design. If a booking CTA ever points at `#contact` again, that is a
regression. There are currently 33 such CTAs across the nine pages.

### Pending visual asset
A photo was referenced by screenshot earlier in the project for a "why this fits" style visual,
but never successfully uploaded. The homepage's glimpse section currently has a dashed-border
"Photo to be added" placeholder reserved for it (or a different photo Harshita provides later).
Replace that placeholder when the real image arrives; do not build further design around its
absence.

---

## 6. Standing behavioral rules for whoever, human or AI, works on this repo next

1. Never use an em dash. Anywhere. Ever. Including in this file.
2. Keep pricing off the homepage; it belongs on the Psychotherapy/Supervision pages only.
3. Keep the Values section as icon-cards, and Qualifications as a vertical timeline, wherever
   either appears. Don't "improve" these into a different layout without being asked.
4. Helpline numbers stay a quiet footer footnote, never a prominent banner.
5. Homepage content past the Concerns section should stay light: one consolidated credibility
   section plus a single contact CTA, not a stack of separate proof sections. Deeper material
   (full qualifications, full testimonials, full "why this fits" narrative, Work With Me details)
   belongs on dedicated pages linked from the homepage, not inline on it.
6. Commit and push after finishing a requested change without waiting to be asked, unless the
   user says otherwise. Only pause for confirmation on destructive/unusual git operations.
7. This file must be updated whenever new instructions, content, or corrections come in,
   including when the user removes or reverses something already built. Treat omissions as
   information too: if a feature is explicitly removed, note that it was tried and rejected so
   it doesn't get silently re-added later.
8. Full peer testimonial data and any other personal-data-bearing source files stay out of git
   (see `.gitignore`); only their approved, ready-to-publish text belongs in HTML or in this file.
9. Do not build or implement anything until explicitly told to create. Gathering, confirming, and
   logging instructions is fine and expected in the meantime.
10. **The 2026-08-27 version is approved and frozen. Change only what you are explicitly asked to
    change.** Do not overwrite, revert, refactor, reformat or "improve" any functionality, design
    or content that is not part of the change you were asked for. If something looks wrong, check
    section 0.5 and the surrounding code comments first: most oddities here are the third or fourth
    attempt after an explicit rejection. If a requested change would break something documented in
    this file, say so before making it, not after.
11. When changing anything in the nav, footer, WhatsApp button or scroll-rail, **apply it to all
    nine pages**, and verify all nine afterwards. There is no shared template. `index.html` writes
    its CSS across multiple lines while the other eight use single lines, so a find-and-replace
    tuned to the eight will silently skip it.
12. Verify by measuring, not by assuming. This preview environment does not reliably produce
    screenshots or advance CSS transitions, so a visual check may show a change as failing when it
    has worked. Read computed styles with transitions disabled, measure geometry, and check
    element order in the DOM instead.
13. **A change is not finished until four things are done**, and the last three are the ones
    forgotten: the code change itself, verified; `WEBSITE_INSTRUCTIONS.md` updated if the change
    touches behaviour or a decision; `spoonfed/*.md` updated if it touches how the site is run,
    deployed or maintained; and a commit pushed with a message saying what changed and why.
    Record reversals especially. "We tried X and rejected it" is the most valuable and most
    easily lost information in this project, and it is the thing that otherwise gets rebuilt by
    accident six months later.
14. `spoonfed/*.md` are the source for the spoonfed guides. `spoonfed_copy.zip` and the Word file
    are built from them. **Never edit the copies inside the zip**, they are overwritten on every
    rebuild. When the guides change, say that the zip is now stale and offer to rebuild it, per
    `spoonfed/HOW_TO_UPDATE.md`.
15. `AGENTS.md` in the repository root is the short version of these rules, written so that a
    coding assistant picks them up on its own. If a rule here changes in a way that affects how
    someone works on the repo, change it there too.

---

## 7. Open items / not yet built

- **Sveltia CMS authentication.** `admin/index.html` and `admin/config.yml` exist and are correctly
  configured, but login does not work yet: Sveltia needs an OAuth connection to GitHub, and setting
  that up means either standing up a small OAuth proxy or moving hosting to a provider that
  supplies one (Netlify is the natural fit, and it is free). Either path means creating a new
  account or authorising a new service against Harshita's GitHub, which is not something to do on
  her behalf without asking. Until this is done, publishing a note means editing `notes.json`
  directly on GitHub's own web editor, which works today with no setup required. Once the
  connection exists, add its `base_url` to the commented line in `admin/config.yml`.
- Peer Testimonials page (full 8 testimonials). The 8 already run in the homepage carousel, and
  Harshita has not decided whether a separate page is wanted.
- **Legal review of the three policy pages.** They are written and live, and the footer links are
  wired, but a lawyer has not yet been through them. Do this before the site is public.
- **A `community/copingresponse` admin page listing raw submissions, password protected.**
  Requested and **deliberately not built on the static site**, for two reasons that are worth
  keeping written down, because the request will come back:
  1. A static site has no server, so nothing running in a visitor's browser can write to it. Notes
     must go to something external. That is what the Google Form is.
  2. A password in static JavaScript is readable by anyone who opens the page source. Over what
     people disclose here, a fake lock is worse than none, because it invites treating the page as
     private when it is not.
  The right home for this is the WordPress migration, where accounts and access control are real
  and server-side. Meanwhile the responses sheet **is** the admin view, behind actual Google
  authentication on Harshita's own account. Supabase was evaluated as a genuine middle option
  (row-level security makes the lock real, free tier is ample) and set aside because free projects
  pause after a week of inactivity, and she wants something that holds without being watched.
- Artwork for the reserved `.visual-placeholder` in Shared Ways of Coping, which the source doc
  asks for. The Community hero art is now in place.
- The organisations page hero **image slot** still shows "Image to be added"; her portrait is in
  the About block lower down, not the banner.
- Real Instagram/blog content, if ever reintroduced
- **A `.gitattributes` file.** The repo and working tree disagree on line endings, and every commit
  emits CRLF warnings. Two machines work on this, so this will cause real conflicts eventually. Do
  it at a moment when neither machine has work in progress.
- Unused assets that could be cleared once nobody wants them back: `assets/harshita-chair.jpg`,
  `assets/Harshitahomepagechair.png` (6.5 MB, untracked), and the untracked originals Harshita
  uploads (`workplacewellbeing*.png`, `newhomepagehs.png`, `testimageblack.png`, `waysofcoping*.png`).
  Her originals are deliberately left untracked; only the processed versions are committed.

---

## 8. File manifest (state at 2026-08-27)

Every file tracked in the repository, what it is, and whether the site actually loads it. Sizes are
approximate and only there to flag the heavy ones.

### 8.1 Pages

| File | Size | What it is |
| --- | --- | --- |
| `index.html` | 79 KB | Homepage. Hero, values, concerns, glimpse section (photo + approach + animated stats), Work With Me cards, testimonials carousel, contact strip. |
| `about.html` | 46 KB | About Harshita. Bio behind a Read more / Read less toggle, values icon-cards, qualifications timeline. |
| `psychotherapy.html` | 58 KB | Psychotherapy sessions. Who it is for, session logistics infographic, geo-aware pricing, FAQs. |
| `supervision.html` | 54 KB | Supervision sessions. Same structure as psychotherapy, different copy and pricing. |
| `workplace-wellbeing.html` | 55 KB | Workplace Wellbeing, for organisations. No pricing anywhere, by explicit instruction. |
| `community.html` | 60 KB | Community. Shared Ways of Coping (submission box + published notes) and Sip and Swap Stories. |
| `disclaimer.html` | 38 KB | Legal. Effective 1 September 2026. |
| `privacy-policy.html` | 41 KB | Legal. Effective 1 September 2026. |
| `terms-and-conditions.html` | 40 KB | Legal. Effective 1 September 2026. |

All nine carry an identical nav, footer, floating WhatsApp button and scroll-rail. **A change to any
of those must be applied to all nine**, because there is no shared stylesheet or template. This is
the single biggest maintenance hazard in the repo and the cause of most bugs found so far: a rule
fixed on eight pages and missed on the ninth.

`index.html` formats its CSS across multiple lines where the other eight use single lines. Any
find-and-replace across all pages will silently skip `index.html` unless you check. This has
already caused one missed change.

### 8.2 Assets the site loads

| File | Size | Used by | Notes |
| --- | --- | --- | --- |
| `assets/logo.png` | 26 KB | all 9 | Favicon and nav logo. |
| `assets/Whitelogo.png` | 16 KB | all 9 | Footer logo. 45px tall, centred in its column. |
| `assets/harshita-home.png` | 979 KB | `index.html` | Hero cut-out, transparent. Must stay PNG. Heaviest asset on the site. |
| `assets/harshita-glimpse.png` | 166 KB | `index.html` | Glimpse-section portrait, transparent cut-out, 340x319. Low resolution for its slot; a larger original would improve it. |
| `assets/therapy-hero.jpg` | 309 KB | `psychotherapy.html` | Illustration, backdrop flattened to page cream. |
| `assets/supervision-hero.jpg` | 159 KB | `supervision.html` | Illustration, backdrop flattened to page cream. |
| `assets/workplace-wellbeing.png` | 893 KB | `workplace-wellbeing.html` | Meeting illustration, background cut to transparency. Third of three versions; the other two were rejected. |
| `assets/harshita-organisations.jpg` | 62 KB | `workplace-wellbeing.html` | Portrait in the About block, 220px circle at `object-position: 50% 14%`. |
| `assets/community-hero.jpg` | 77 KB | `community.html` | Full-bleed repeating band at the top of the page. |
| `assets/sharedwaysofcoping.jpg` | 100 KB | `community.html` | Section illustration, backdrop flattened to cream-warm. |

### 8.3 Assets tracked but no longer loaded

Kept deliberately, not dead weight to be tidied away. Do not delete without asking.

| File | Size | Why it is still here |
| --- | --- | --- |
| `assets/harshita-chair.jpg` | 169 KB | Previous glimpse photo, a plain rectangle. If the glimpse photo ever goes back to a rectangle, this is the one, and the feathering CSS described in section 4 goes back with it. |
| `assets/harshita-home-source.png` | 575 KB | Original of the hero cut-out, before background removal. |
| `assets/harshita-home 2.png` | 560 KB | Older grey-studio-backdrop hero photo. Note the space in the filename. |
| `assets/logo-full.png` | 29 KB | Full-colour logo, superseded by `Whitelogo.png` in the footer. |

### 8.4 Other tracked files

| File | What it is |
| --- | --- |
| `serve.ps1` | Local static file server. See section 0.3. |
| `.gitignore` | Excludes the personal-data source files. See below. |
| `WEBSITE_INSTRUCTIONS.md` | This file. |

### 8.5 Untracked files in the working folder

These sit in `assets/` on Harshita's machine and are **deliberately not committed**. They are the
raw originals she uploads; only the processed versions go into the repo.

`Harshitafororganizations.jpg`, `Harshitahomepagechair.png`, `newhomepagehs.png`,
`testimageblack.png`, `waysofcoping1.png`, `waysofcoping2.png`, `workplacewellbeing.png`,
`workplacewellbeing3.png`, `workplacewellbring2.png` (note the "wellbring" typo in that filename),
and `hello.html` (a scratch file that was once committed by accident and removed again).

**Do not commit these.** They are large, superseded by the processed versions, and committing one
of them was already undone once.

Separately, `InstructionsWebsite.zip` and `Peer Testimonials (Responses).xlsx` are kept out of git
by `.gitignore` because they carry personal data. Keep it that way.

---

## 9. Change history

Every commit on `master`, newest first, as the record of how the approved version was reached.
Reversals are included on purpose: they show what has already been rejected.


### 2026-08-30

| Change | Why |
| --- | --- |
| Organisations page renamed `/corporates.html` to `/workplace-wellbeing.html`, with a `Redirect 301` | The address was the one place a visitor still met the word "corporates", which is not the language the page uses. The redirect must never be removed. |
| Search and social metadata on all nine pages | Titles, descriptions, canonical, Open Graph, Twitter. Verified that on every page the only altered line is inside `<head>`. |
| Structured data, homepage only | Restates what the site already says in plain words. Locality only, deliberately no street address. |
| `robots.txt`, `sitemap.xml`, `share-card.png` | The card is built from the logo on the page cream, so no new artwork. |
| Four error pages, fifteen status codes | Grouped by meaning, not number. `error.html` covers the codes where blaming either side would be wrong. Cannot cover the site being down entirely. |
| Favicon rebuilt as the feather alone | The full logo is 909x404 and illegible at 16px. The crop stops at x=232 because the wordmark begins at x=240, found by scanning for purple ink rather than by eye. |
| `favicon.ico` at the web root, and `?v=` on the PNG links | Browsers request the root address regardless of what a page declares, and keep icons in a cache a hard reload does not clear. |
| Three notes per browser | Counted in the visitor's own storage. A courtesy, not a control: there is no login to tie it to. |
| Error messages on both forms | The Share button is no longer disabled. A disabled button refuses to act and will not say why. |
| Caption above the notepad | Hidden along with the pad, so it never introduces an empty space. |
| Homepage logo linked to `#` | Fixed. Every other page linked home properly. |
| Subject lines on the three enquiry buttons | So an arriving email says what it is about. |
| "cadence" replaced with "timings" | Industry wording the rest of the site does not use. |
| Raw uploads named in `.gitignore` | A wildcard swept 20 MB of originals into the repo three times. |
### 2026-08-27

| Commit | Change |
| --- | --- |
| `202b42c` | Brought this file back in step with the previous 17 commits. |
| `e3e72e1` | Folded confidentiality into "What I offer" as a centred collapsible; theme pill borders raised from 0.14 to 0.3 alpha and given the purple hover bloom; themes note shortened to "Or bring a theme of your own." |
| `013784b` | Centred the "Beyond awareness" copy under its centred heading. |
| `0350201` | Swapped the Workplace Wellbeing banner for the third illustration. |
| `777037e` | Replaced the nav underline hover with a purple glow, on all nine pages. |
| `0eb4069` | Moved the confidentiality panel behind an info button. Superseded later the same day by `e3e72e1`. |
| `c38e47f` | Reverted the second Workplace Wellbeing illustration. |
| `bff7b93` | Swapped in the second, paler Workplace Wellbeing illustration. Reverted above. |
| `a24dc55` | Put the meeting illustration on the Workplace Wellbeing banner; renamed the nav item from "For organisations" to "Workplace Wellbeing"; removed the stale `.hero-art` card styling. |
| `b1c28a4` | Footer logo centred in its column at 45px, down from 64px, on all nine pages. |
| `af202ba` | Swapped the homepage glimpse photo for the trimmed test cut-out. |
| `ddbc252` | Used the illustrated cut-out for the glimpse photo; removed the edge feathering and the 4:5 crop that suited the old rectangular photo. |
| `90d37d3` | Swapped the Community banner for the repeating band and ran it full bleed. |
| `f50f558` | Added the coping illustration at the top of the Community page. |
| `b7da0f1` | Replaced the "Share what helped you" button with an on-page submission box: prompt, textarea, 100-word countdown, consent tick. |
| `68d0156` | Wired the published Approved sheet; added the guard that stops a broken sheet formula being published as if it were a person's note. |
| `034310b` | Wired the Shared Ways of Coping form link, with the `ouid` account id stripped. |
| `3f5550f` | Removed a stray em dash from a code comment. |

### 2026-08-26 and earlier

| Commit | Change |
| --- | --- |
| `cb66673` | Made the header "Book a Consultation Call" button open the calendar. It pointed at `#contact`, which merely scrolled, and was dead entirely on the three legal pages. |
| `91743a5` | Added Harshita's photo to the organisations page and matched that banner's layout to Psychotherapy. |
| `180ed08` | Blended the coping illustration into its section; retitled the corporates hero to "Workplace Wellbeing". |
| `4f4ba6d` | Replaced the footer logo with the white version. |
| `447beba`, `3e4da2c` | Added the chair portrait to the glimpse section and feathered its edges. |
| `b9db0a8` | Matched the two pricing cards; stopped the logistics thread showing through the milestone dots. |
| `4e3d043`, `a74e6f0` | Sat the supervision and therapy illustrations directly on their banners. |
| `6e3c0ae` | Geo-aware pricing by timezone; logistics markers became milestone dots. |
| `158d428` | Evened out the session logistics so all four points share one shape. |
| `c3c4f67` | Moved "Read less" to the end of the expanded bio; purple hover on value cards. |
| `8ce3527` | Left-aligned the About copy on the organisations page. |
| `dd8b555` | Moved the hero feather behind the subject and aligned her to the text block. |
| `ff1cd7d` | Reworded the testimonials eyebrow to lead into the heading. |
| `04d7a67` | Symmetric theme pills, centred cards, section lines removed, glow direction fixed. |
| `dea4ed7` | Removed `hello.html` from the repo after a wildcard swept it in. |
| `d036b0f` | Purple hover on concern cards; image slot in the corporates hero. |
| `274f959` | Added "For organisations" as a third card in the homepage Work With Me row. |
| `c4dc6ca` | Added the Disclaimer, Privacy Policy and Terms pages and wired the footer links. |
| `56423f4` | Reverted the organisations page to an "I" voice. |
| `0313f91` | Switched the organisations page to a "we" voice. Reverted above. |
| `ec5ea94` | Added the For Organisations page as a third Work With Me offering. |
| `6c9a1f6` | Hero photo as a soft radial safe area; collapsed the About bio behind Read more. |
| `098500a` | Optimised the two heaviest illustrations, 3.7 MB down to 263 KB. |
| `acf4a37` | Added the Shared Ways of Coping illustration. |
| `9a7a0da` | Added the anonymous shared-notes system to the Community page. |

Earlier commits cover the initial build of the homepage, About, Psychotherapy, Supervision and
Community pages, and are described in sections 3 to 5 rather than listed here.
