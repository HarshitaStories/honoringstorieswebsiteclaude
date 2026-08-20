# Honoring Stories · Website Instructions

This file is the living source of truth for building this site. It is updated every time new
instructions, content, or decisions come in during a session, including reversals of earlier
decisions. If something here conflicts with an older memory or an earlier commit message, this
file wins.

Last updated: 2026-08-01

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
- A **floating WhatsApp button** (`.wa-float`) is fixed to the bottom right of every page. Styled in
  the site palette (rose-soft to purple-soft gradient, deep-purple glyph) rather than WhatsApp
  green, which would clash with the cream/purple scheme. It carries a slow 6s `waGlow` halo pulse,
  deliberately low-opacity: the brief was "very gentle soft glow, very subtle and not loud but
  still visible". Keep it that way, do not raise the opacity or speed it up. An italic glass pill
  tooltip ("Reach out on WhatsApp", same treatment as the section-rail labels) appears on hover and
  is hidden below 600px. The existing reduced-motion rule already flattens the pulse.
- The footer logo is now the real brand logo image (`assets/logo-full.png`, feather, cupped hands,
  wordmark, tagline), shown at full color, not the earlier hand-drawn inline SVG approximation or
  an inverted/white-filtered version. Keep it in its original colors against the dark footer.

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
  - The glimpse section (`#glimpse`) replaced four separate sections (why-this-fits narrative,
    Work With Me preview, testimonials carousel, qualifications timeline) with a compact block:
    a section head ("A little more to help you decide" / "Grounded in experience, held with
    care"), then a two-column row of an image placeholder (reserved for a future photo) and a
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
- **Work With Me, For Organisations** (`corporates.html`, built): the third entry in the Work With
  Me dropdown, aimed at companies and teams. Built from the `psychotherapy.html` template so nav,
  footer and styling stay identical. Copy was drafted and approved by the user before any building.
  - **No pricing anywhere on this page, by explicit instruction.** The pricing CSS inherited from
    the template was stripped out rather than left dead, so it cannot creep back in. The "A
    conversation" step in the process is what handles the pricing question instead. Do not add a
    price table, a "from" figure, or a package tier here without being asked.
  - Sections: hero (centred, single column, no artwork yet), Why this matters, What I offer
    (three `.concern-card`s: Workshops, One-on-one mini sessions, Customised plans), Themes
    (`.theme-pill` list of 8, plus a note inviting their own), Confidentiality, How it works
    (5-step process), a short About block linking to `about.html`, 7 FAQs, and a contact CTA.
  - **Confidentiality has its own block** (`.confidential`) rather than being a line in the copy.
    For the organisation it is usually the deciding question, and for the employee it is what makes
    the space usable at all. It states plainly that the employer receives no names, notes, or
    account of what was discussed, only broad non-identifying themes, with the risk-of-harm
    exception. Keep this prominent; it is also repeated as an FAQ because people look in both places.
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
- **Community** (`community.html`, built): one page holding both community spaces, built from the
  `psychotherapy.html` template so nav, footer, CSS and scripts stay identical. Copy is taken from
  the source docs `About - Shared ways of coping.docx` and `About - Sip and Swap stories.docx` in
  `InstructionsWebsite.zip`, lightly edited only to remove contractions and em dashes.
  - Hero is deliberately **single-column and centred**, unlike the two-column inner-page heroes,
    because there is no artwork for this page yet and a dashed placeholder in the most prominent
    slot would look unfinished.
  - **Shared Ways of Coping** (`#shared-ways`): intro copy beside a reserved
    `.visual-placeholder` (the source doc explicitly says "add relevant image"), three
    `.note-pill`s (anonymous / optional / read before publishing), then the published notes and
    the sharing call to action.
  - **Published notes system** (chosen deliberately over the alternatives, see below). Notes are
    rendered by JS from a **Google Sheet**, so new ones appear without editing this repo:
    - Two constants at the top of the page script drive everything: `SHARED_NOTES_CSV` and
      `SHARED_FORM_URL`. Both are currently **empty**, which is what makes the page show three
      clearly-labelled sample notes plus a "Coming soon" block. Filling them in switches the page
      to live data automatically; nothing else needs changing.
    - **Publish only the "Approved" tab** of the responses sheet as CSV, never the raw responses
      tab. Publishing the raw tab would make every unmoderated submission publicly readable and
      defeat the point of moderating. The Approved tab should be a formula pulling only ticked
      rows, e.g. `=FILTER(Responses!B2:B, Responses!C2:C=TRUE)`.
    - The form's **"Collect email addresses" setting must be OFF**, otherwise the space is not
      actually anonymous despite saying so.
    - Note text is inserted with **`textContent`, never `innerHTML`**. This is text arriving from
      a public form, so treating it as markup would be an injection hole even with a human
      moderating. Do not "improve" this to innerHTML to allow formatting.
    - The CSV reader rejoins fields (`r.join(',')`) rather than taking `r[0]`, because the
      Approved tab is a single column. Taking the first field alone silently truncates a note
      mid-sentence if its commas ever arrive unquoted, publishing half of what someone wrote with
      no visible error. Verified against quoted commas, embedded newlines, escaped quotes,
      unquoted commas, a header row, and an empty sheet.
    - Cards are **quote only, with no name, credentials or years**, unlike the homepage
      testimonial cards they are visually modelled on. The anonymity is the point.
    - Empty and failed states both say something gentle rather than showing a blank area, and the
      sample notes never appear once a real source is configured.
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

---

## 7. Open items / not yet built

- Peer Testimonials page (full 8 testimonials)
- **Google Form and Sheet for Shared Ways of Coping.** The display and the fetch/moderation
  plumbing are built and tested; only the two URLs are missing. To go live: create the anonymous
  form (email collection OFF), link its responses sheet, add an "Approved" tab filtered to ticked
  rows, publish **that tab only** as CSV, then set `SHARED_NOTES_CSV` and `SHARED_FORM_URL` in
  `community.html`. The sample notes and the "Coming soon" block disappear on their own once both
  are set. Until then the samples are labelled as samples on the page so nothing reads as a real
  submission.
- Artwork for the Community page: the hero (currently text-only by design) and the reserved
  `.visual-placeholder` in Shared Ways of Coping, which the source doc asks for.
- Footer legal pages: Disclaimer, Privacy Policy, Terms and Conditions (currently placeholder
  links)
- Real photo for the homepage glimpse section's image placeholder
- Real Instagram/blog content, if ever reintroduced
