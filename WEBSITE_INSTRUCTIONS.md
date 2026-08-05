# Honoring Stories — Website Instructions

This file is the living source of truth for building this site. It is updated every time new
instructions, content, or decisions come in during a session, including reversals of earlier
decisions. If something here conflicts with an older memory or an earlier commit message, this
file wins.

Last updated: 2026-08-01

---

## 1. Who this is for

**Harshita Sarda** (she/her) — practicing psychotherapist and clinical supervisor, Andheri West,
Mumbai. Contact: feelseen@honoringstories.com.

Two audiences:
- Prospective therapy clients (adults 20–65, worldwide, online)
- Mental health professionals (for supervision, and peer networking via "Sip & Swap")

Site name: **Honoring Stories**. Tagline system: *Express · Embrace · Empower*.

---

## 2. Tech stack & hosting plan

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

Typography: `Cormorant Garamond` (display serif, headings) + `Inter` (body). Loaded from Google
Fonts.

**Color discipline (standing rule):** headings default to charcoal, not purple. Purple/rose are
reserved for deliberate emotional beats only — the hero, the "right fit" callout in the About/Why
Me section, the final CTA. Do not drift back to coloring every heading purple; that was identified
and fixed as a "generic template" problem.

**Content style rule (standing rule, absolute): never use an em dash (—) anywhere on this site —
copy, code comments, alt text, anything.** Rewrite with natural punctuation (commas, colons,
restructured sentences) or a middle dot (`·`) for label/separator use (matches the qualifications
and testimonial-attribution style already in use). This was explicitly requested and must be
treated as permanent, not a one-time cleanup.

**Layout/component conventions established so far:**
- Values section (Express / Embrace / Empower): icon-in-circle card style — **not** the numbered
  editorial list that was tried and explicitly rejected. Keep the icon-card format.
- Qualifications: vertical timeline format (dot markers, left border) — explicitly liked, keep
  this format when adding new entries.
- Concerns cards: each has a small line-icon (added per request).
- Helpline numbers live only in the footer, as a quiet "footnote," never as a prominent mid-page
  banner (a loud pink mid-page crisis banner was explicitly removed for this reason).
- No blog/journal section on the homepage (removed; may return later if requested).
- No decorative "breath" pause section, no "Scroll" hint under the hero (both were tried and then
  explicitly removed).
- A secondary "section rail" navigation exists: a slim vertical dot-rail fixed to the right edge
  (desktop only, ≥1100px), invisible over the hero, fades in once scrolled to "What I hold as
  essential," fades out at the footer. Dots map to each section's eyebrow label; hovering (or the
  active section) reveals the label as a pill tooltip. This must stay visually unobtrusive and
  never crowd or duplicate the main top nav.
- Testimonials: homepage shows only a **2-quote teaser** (not all 8), rotating. The full 8 are
  reserved for a dedicated Peer Testimonials page (not yet built).

---

## 4. Site structure

- **Home** (`index.html`, built): hero, values, concerns, why-this-fits/about teaser, work-with-me
  preview, testimonials teaser, qualifications, contact strip, footer.
- **About** (not yet built): full photo, about-me, education & experience, approach/concerns
  written to an ideal client, small embedded "Contact me" section.
- **Work With Me → Psychotherapy** (not yet built): about, process/logistics **including
  pricing**, exploratory-call link, FAQs, contact section.
- **Work With Me → Supervision** (not yet built): about (two tracks: early-career 0–3 yrs,
  experienced 3+ yrs), process/logistics, exploratory-call link, FAQs, contact section.
- **Peer Testimonials** page (not yet built): all 8 real testimonials in full.
- **Community → Shared Ways of Coping** (not yet built): anonymous Google Form embed,
  admin-moderated before publishing.
- **Community → Sip and Swap Stories** (not yet built): professionals-only networking via
  email/WhatsApp, not for clients or supervisees.

**Important scoping rule:** pricing does **not** appear on the homepage. It belongs only on the
dedicated Psychotherapy and Supervision pages once built.

---

## 5. Content

### About Harshita
MA in Clinical Psychology; Diploma in Counseling Psychology (Xavier's College); Diploma in
Supervision for Mental Health Practice (TISS). **7+ years as a therapist, 4+ years as a
supervisor** (this was corrected from an earlier 6+/3+ figure — always use 7+/4+). Works with
adults 20–65; concerns include anxiety, relationship challenges, self-confidence/self-esteem,
depression, trauma, sleep difficulties, emotional regulation, life transitions. Particular
interest in anxiety and relational dynamics, identity, self-worth, belonging.

### Approach / values (Express · Embrace · Empower)
- **Express** — a grounded, non-judgmental space to speak what feels hard to say, at your own pace.
- **Embrace** — meeting every part of you, the tender, the tired, the uncertain, with warmth and respect.
- **Empower** — helping you reconnect with your own capacity, clarity, and agency, gently and collaboratively.

Eclectic, trauma-informed, queer-affirmative, intersectional, neurodivergent inclusive. Completed
Queer Affirmative Practice course (Mariwala Health Foundation) and complex trauma training
(ISSTD).

### Qualifications (timeline, in order)
1. MA in Clinical Psychology
2. Diploma in Counseling Psychology, Xavier's College
3. Diploma in Supervision for Mental Health Practice, TISS
4. Queer Affirmative Counseling Practice, Mariwala Health Initiative
5. Gestalt Therapy: Basic & Advanced (60 hours, Psychphoenix)
6. **Complexities of Complex Trauma Accelerated**, The International Society for the Study of
   Trauma and Dissociation (ISSTD) — added per explicit request

### Previous work experience
- Private Practice, since 2023 (individual therapy + supervision)
- Xavier's College, Field Supervisor for MA 2nd-year interns (contractual, since Feb 2021)
- Cultfit, freelance psychologist, online 1:1 therapy, Jun 2020–Feb 2023, 1050+ positive reviews
- iCall, Covid Mental Health Helpline volunteer counselor, Sep 2020–Jan 2021
- CanKids, pediatric cancer patients/caregivers at Tata Memorial Hospital, Feb–Aug 2020
- Naraindas Morbai Budhrani Trust, psychologist for cancer patients/caregivers at Nair, KEM, Wadia
  Hospitals, Jul–Dec 2019

### Psychotherapy sessions
- Days/hours: Tue–Sat, 8am–6pm IST. Duration: 50 min. Format: video/voice via Google Meet or
  WhatsApp.
- **Pricing (current, to be placed only on the Psychotherapy page, presented thoughtfully rather
  than as a bare price table):**
  - ₹2,100 — online sessions, India-based clients
  - ₹2,500 — online sessions, clients based outside India
  - ₹3,000 — in-person/offline sessions, Andheri West, Mumbai
- Flow: reach out → basic details shared → free 20-min exploratory call → book via link/payment →
  confirmed via UPI or bank transfer.
- FAQs (8): how to start · what to prepare (nothing needed; join on time, quiet private space,
  good internet, steady device; optional water/notebook/pen) · confidentiality (private; exception
  is risk of harm, discussed upfront) · not knowing what to talk about (fine, can start anywhere) ·
  session frequency (usually weekly to start, revisited collaboratively) · feeling worse before
  better (normal, supported, feedback taken) · stopping anytime (client-led, ended thoughtfully) ·
  cancellation policy (free reschedule/cancel up to 3 hrs before session).

### Supervision sessions
- Days/hours: Tue–Fri, 8am–6pm IST. Duration: 60 min. Format: **online or offline (in-person)**.
- **Pricing (current): ₹1,800 per session, same rate for both online and offline.**
- Two tracks: early-career (0–3 yrs) and experienced (3+ yrs) practitioners.
- Flow: reach out, basic details shared, free 20-min exploratory call, consent form, time/day
  scheduled, confirmed with a calendar invite after payment (UPI/bank transfer).
- FAQs (6): how to start · preparation (note topics; goals reviewed after first session) ·
  confidentiality (same policy as therapy) · meeting frequency (generally bimonthly/every 2 weeks,
  adjustable) · allowed topics (client cases, ethical dilemmas, logistics, building practice,
  burnout, imposter syndrome) · cancellation (same 3-hr free reschedule/cancel policy).

### Group supervision (planned, not yet scoped)
Harshita wants to start offering group supervision and wants a dedicated section/space reserved
for it on the site, but pricing, format, cadence, and other details are not decided yet. Do not
build this section until the actual content is supplied, other than reserving a clearly-labeled
placeholder slot in the site plan (see Open Items).

### Peer testimonials
8 real testimonials collected via Google Form, all with explicit consent for name, education,
years of experience, and testimonial text to appear on the site. Full text lives in this repo's
private working notes (not committed, due to the source spreadsheet containing personal emails) —
**ask if the full 8 need to be re-supplied for the dedicated Testimonials page.** Homepage
currently shows a 2-quote rotating teaser:
1. Deepapriya Vishwanthan — MA (Applied Psychology), M.Phil (Social Sciences), 16 yrs experience
2. Zahra Diwan — MA Clinical Psychology (Adults), MSc Child and Adolescents Mental Health, 7 yrs
   experience

The other 6 (Rinkle Jain, Aaushi Shah, Sanika Nanal, Anis Syed, Rajshree, Ananyaa Kale) are
approved and ready to use on the full Testimonials page whenever it's built.

### Helpline numbers (footer only, quiet placement, non-crisis-service disclaimer alongside)
1. MannTalks — 8686139139 (Mon–Sun, 10am–6pm)
2. iCall — 9152987821 (Mon–Sat, 10am–8pm)
3. KIRAN Mental Health (Government) — 1800-599-0019 (24/7)
4. Spandan — 7389366696 (24/7)
5. Vandrevala Foundation — 9999666555 (24/7)

### Contact details (use these everywhere, not placeholders)
- Email: **feelseen@honoringstories.com**
- WhatsApp: **+91 9152801719** (linked as `https://wa.me/919152801719`)
- LinkedIn: **https://www.linkedin.com/in/psychologistharshita**
- Booking link (consultation calls): **https://cal.com/harshita-sarda-yllcdj/30min**
- Location: Andheri West, Mumbai (not just "Mumbai, India")
- Instagram: deliberately **not** linked in the footer (removed per request)

---

## 6. Standing behavioral rules for whoever (human or AI) works on this repo next

1. Never use an em dash. Anywhere. Ever.
2. Keep pricing off the homepage; it belongs on the Psychotherapy/Supervision pages only.
3. Keep the Values section as icon-cards, and Qualifications as a vertical timeline. Don't
   "improve" these into a different layout without being asked.
4. Helpline numbers stay a quiet footer footnote, never a prominent banner.
5. Commit and push after finishing a requested change without waiting to be asked, unless the user
   says otherwise. Only pause for confirmation on destructive/unusual git operations.
6. This file must be updated whenever new instructions, content, or corrections come in, including
   when the user removes or reverses something already built. Treat omissions as information too:
   if a feature is explicitly removed, note that it was tried and rejected so it doesn't get
   silently re-added later.
7. Full peer testimonial data and any other personal-data-bearing source files stay out of git
   (see `.gitignore`); only their approved, ready-to-publish text belongs in HTML or in this file.

---

## 7. Open items / not yet built

- About page
- Psychotherapy page (including the 3-tier pricing presentation)
- Supervision page (updated pricing: ₹1,800/session, online or offline)
- Group supervision section: reserved space only, content/pricing/format not yet supplied, do not
  build until Harshita provides details
- Peer Testimonials page (full 8 testimonials)
- Community pages: Shared Ways of Coping (Google Form embed, admin-moderated), Sip and Swap
  Stories (email/WhatsApp flow, professionals only)
- Footer legal pages: Disclaimer, Privacy Policy, Terms & Conditions (currently placeholder links)
- Real Instagram/blog content, if ever reintroduced
