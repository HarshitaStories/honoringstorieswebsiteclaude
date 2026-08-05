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
- The nav bar's "Book a Consultation" button (`.nav-cta`) is also glassmorphic: a translucent
  purple-to-rose gradient fill, backdrop blur plus saturation, a soft white glass border, an inset
  top highlight, and a floating drop shadow, shifting toward rose on hover. It replaced a solid
  deep-purple fill; keep the glass treatment if this button is touched again.
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

---

## 4. Site structure

- **Home** (`index.html`, built): hero, values, concerns, a consolidated "glimpse" section, a
  dedicated testimonials section, contact strip, footer.
  - The glimpse section (`#glimpse`) replaced four separate sections (why-this-fits narrative,
    Work With Me preview, testimonials carousel, qualifications timeline) with a compact block:
    a section head ("A little more to help you decide" / "Grounded in experience, held with
    care"), then a two-column row of an image placeholder (reserved for a future photo) and a
    short approach paragraph (see About Harshita / approach paragraph in section 5), followed by
    a full-width animated **stat counter row** (see Practice stats in section 5) below that row,
    separated by a hairline divider. The stats were originally squeezed into the half-width text
    column and got visually clipped by the fixed section-rail tooltip on narrower viewports; moving
    them to their own full-width row fixed that. The three self-select links ("For therapy
    clients", "For practitioners and supervisees", "Curious about me") sit in their own plain
    section right after testimonials, pointing to the dedicated pages below. This was a deliberate
    restructure: the homepage should hook, present concerns, give one credibility beat, and then
    let each audience choose where to go deeper, rather than making everyone scroll through
    everything.
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
- **About** (not yet built): full photo, about-me, education and experience (full qualifications
  timeline), the fuller "why this fits" narrative that used to live on the homepage,
  approach/concerns written to an ideal client, small embedded "Contact me" section.
- **Work With Me, Psychotherapy** (not yet built): about, process/logistics including pricing,
  exploratory-call link, FAQs, contact section.
- **Work With Me, Supervision** (not yet built): about (two tracks: early-career 0 to 3 years,
  experienced 3-plus years), process/logistics including pricing, exploratory-call link, FAQs,
  contact section, plus a reserved space for group supervision once scoped.
- **Peer Testimonials** page (not yet built): all 8 real testimonials in full.
- **Community, Shared Ways of Coping** (not yet built): anonymous Google Form embed,
  admin-moderated before publishing.
- **Community, Sip and Swap Stories** (not yet built): professionals-only networking via
  email/WhatsApp, not for clients or supervisees.

**Important scoping rule:** pricing does not appear on the homepage. It belongs only on the
dedicated Psychotherapy and Supervision pages once built.

---

## 5. Content

### About Harshita
MA in Clinical Psychology; Diploma in Counseling Psychology (Xavier's College); Diploma in
Supervision for Mental Health Practice (TISS). **7+ years as a therapist, 4+ years as a
supervisor** (corrected from an earlier 6+/3+ figure; always use 7+/4+). Works with adults 20 to
65; concerns include anxiety, relationship challenges, self-confidence/self-esteem, depression,
trauma, sleep difficulties, emotional regulation, life transitions. Particular interest in
anxiety and relational dynamics, identity, self-worth, belonging.

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

Style convention: number huge and bold, label small and light, "+" used consistently on all
three. Keep this pairing (7 / 400 / 2,000) unless the user supplies updated figures.

### Approach / values (Express, Embrace, Empower)
- **Express**: a grounded, non-judgmental space to speak what feels hard to say, at your own pace.
- **Embrace**: meeting every part of you, the tender, the tired, the uncertain, with warmth and respect.
- **Empower**: helping you reconnect with your own capacity, clarity, and agency, gently and collaboratively.

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
- Days/hours: Tue to Sat, 8am to 6pm IST. Duration: 50 min. Format: video/voice via Google Meet
  or WhatsApp.
- **Pricing (current, to be placed only on the Psychotherapy page, presented thoughtfully rather
  than as a bare price table):**
  - Rs 2,100, online sessions, India-based clients
  - Rs 2,500, online sessions, clients based outside India
  - Rs 3,000, in-person/offline sessions, Andheri West, Mumbai
- Flow: reach out, basic details shared, free 20-min exploratory call, book via link/payment,
  confirmed via UPI or bank transfer.
- FAQs (8): how to start; what to prepare (nothing needed, join on time, quiet private space,
  good internet, steady device, optional water/notebook/pen); confidentiality (private, exception
  is risk of harm, discussed upfront); not knowing what to talk about (fine, can start anywhere);
  session frequency (usually weekly to start, revisited collaboratively); feeling worse before
  better (normal, supported, feedback taken); stopping anytime (client-led, ended thoughtfully);
  cancellation policy (free reschedule/cancel up to 3 hrs before session).

### Supervision sessions
- Days/hours: Tue to Fri, 8am to 6pm IST. Duration: 60 min. Format: **online or offline
  (in-person)**.
- **Pricing (current): Rs 1,800 per session, same rate for both online and offline.**
- Two tracks: early-career (0 to 3 years) and experienced (3-plus years) practitioners.
- Flow: reach out, basic details shared, free 20-min exploratory call, consent form, time/day
  scheduled, confirmed with a calendar invite after payment (UPI/bank transfer).
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

- About page: needs the full qualifications timeline and the full "why this fits" narrative that
  used to live on the homepage, plus the about-me content already listed in section 5.
- Psychotherapy page (including the 3-tier pricing presentation)
- Supervision page (pricing: Rs 1,800/session, online or offline), plus a reserved group
  supervision section once details are supplied
- Peer Testimonials page (full 8 testimonials)
- Community pages: Shared Ways of Coping (Google Form embed, admin-moderated), Sip and Swap
  Stories (email/WhatsApp flow, professionals only)
- Footer legal pages: Disclaimer, Privacy Policy, Terms and Conditions (currently placeholder
  links)
- Real photo for the homepage glimpse section's image placeholder
- Real Instagram/blog content, if ever reintroduced
