# Honoring Stories website: the spoonfed copy

**Everything needed to rebuild and run this website, explained from zero.**

Updated 2026-08-30, revised later the same day with the search metadata, the
error pages, the favicon and the renamed organisations page. Supersedes the
2026-08-27 package: the coping notes have
moved off Google Forms onto the site's own server, so the moving parts are
different now.

**This is a copy.** The editable original of this document and the three beside
it lives in the `spoonfed/` folder of the GitHub repository, along with a note
on how to rebuild this package. Edit them there. Anything changed inside this
zip is lost the next time it is built.

---

## Part 1: What you are holding

### 1.1 The website

Nine pages for Harshita Sarda, a psychotherapist and clinical supervisor in
Andheri West, Mumbai. A homepage, an about page, three describing the work she
offers, a community page, and three legal pages.

### 1.2 What is in this folder

```
spoonfed_copy/
│
├── README.md            you are reading this
├── DEPLOY.md            putting it live on Hostinger, step by step
├── SETUP_CHECKLIST.md   the accounts and logins the site touches
├── STRUCTURE.md         how every file relates to every other file
│
├── website/             THE SITE. Upload the contents of this folder.
│   ├── index.html … terms-and-conditions.html      the nine pages
│   ├── 404 / 403 / 500 / error.html                error pages, in your theme
│   ├── favicon.ico, robots.txt, sitemap.xml        icon and search files
│   ├── lib.php, notes.php, submit.php, relate.php  the coping notes
│   ├── admin.php                                   where you moderate them
│   ├── .htaccess                                   server rules. Easy to miss.
│   ├── serve.ps1                                   for viewing it on your own PC
│   ├── assets/                                     every picture
│   └── data/.htaccess                              seals the note store. Critical.
│
└── reference/
    └── WEBSITE_INSTRUCTIONS.md   the full history and reasoning
```

### 1.3 Two things to understand before touching anything

**There is no separate CSS or JavaScript file.** Each of the nine pages is
self-contained: the words, the styling and the behaviour all live inside that one
file. So a change to the menu must be made **nine times**. There is no shared
template. This is the commonest way this site gets broken, and it is covered
again in Part 5.

**Four files are PHP, and PHP must be switched on.** `submit.php`, `notes.php`,
`relate.php` and `admin.php` are programs that run on the server. On a plain file
host they do not run at all and the coping notes section is dead. Hostinger runs
PHP. This is the main reason the site is hosted there rather than somewhere free.

---

## Part 2: Look at it on your own computer

**The quick way**, good for everything except the coping notes: open the
`website` folder and double-click `index.html`.

**The proper way**, needed for the coping notes, because they need PHP:

1. Install PHP if you do not have it. Download the Windows zip from
   `windows.php.net`, unzip it anywhere, and note where `php.exe` ended up.
2. Open the `website` folder, hold **Shift**, right-click an empty area, and
   choose **Open PowerShell window here**.
3. Run, with the path to your own `php.exe`:

   ```
   C:\path\to\php.exe -S localhost:8090
   ```

4. Open **http://localhost:8090/index.html**.

`serve.ps1` is also included and needs nothing installed, but it only serves
plain files, so the coping notes will not work under it. Use it for checking
layout and text, PHP for anything involving notes.

---

## Part 3: Putting it live

See **`DEPLOY.md`**. It covers the upload, switching PHP on, setting your admin
password, and three security checks that must pass before the site is public.

---

## Part 4: How the coping notes work

This is the only part of the site that stores anything.

```
A visitor writes a note on the Community page
        ↓  submit.php
Stored in data/notes.json, marked pending. Nobody can see it.
        ↓  you, at admin.php
You read it and press Approve
        ↓  notes.php
It appears on the notepad on the Community page
```

**Nothing is published automatically.** A submission is invisible to everyone
except you until you approve it. Deleting one removes it from the file outright.

**"I can relate"** adds one to a note's tally. The tally lives on the server and
decides the order notes appear in, most related first. **The number is never
shown to visitors**, deliberately: a running count of other people's agreement
beside something somebody wrote about a hard day turns a quiet gesture into a
score. Which notes a person has already ticked is remembered in their own
browser, so clearing site data resets it. There is no login, so the count is a
warm signal rather than a measurement, and should not be read as one.

**Everything is in `data/notes.json`, inside the site's own folder.** No Google,
no database, no third party. That folder is sealed off by `data/.htaccess`.
If that file goes missing, submissions nobody has approved become public.

---

## Part 5: Rules that must not be broken

Each of these was learned by something going wrong.

**1. Never use an em dash.** The long dash. Not in the words, not in a code
comment, not in a picture description. Use a comma or rewrite the sentence.

**2. Menu and footer changes must be made nine times.** They appear on all nine
pages and each page has its own copy. **There is a trap:** `index.html` writes
its styling across several lines where the other eight use one line each, so a
find-and-replace tuned to those eight **silently skips the homepage**. This has
happened.

**3. Never render a visitor's words as markup.** The code uses `textContent` in
the browser and `htmlspecialchars` in PHP. Both mean "treat this as text, never
as instructions". Someone submitting `<img onerror=...>` gets it shown as
letters. Do not change these to anything that renders HTML, even for formatting.

**4. Pictures are prepared, not raw.** Every illustration had its background
either recoloured to the exact page cream or removed. Drop in a raw file and you
will see a faint rectangle, because its cream will be very slightly the wrong
shade.

**5a. A page title is both the browser tab and the blue headline Google shows.**
Changing one changes both, so it is a content change, not a technical detail.

**5b. Never remove the redirect in `.htaccess`** from `/corporates.html`. That
page was renamed, and there is no expiry on somebody having bookmarked the old
address.

**5. No prices on the homepage.** They belong only on the Psychotherapy and
Supervision pages. The organisations page has none at all, by instruction.

**6. Change only what you were asked to change.** Several things here look wrong
and are deliberate, with a comment beside them explaining why. Ten separate
things were built, shown, rejected and removed. Check the "already tried and
rejected" table in `reference/WEBSITE_INSTRUCTIONS.md` before you undo anything.

---

## Part 6: Working with an AI on this site

Paste this to start:

> Read README.md, DEPLOY.md, SETUP_CHECKLIST.md, STRUCTURE.md and
> reference/WEBSITE_INSTRUCTIONS.md before doing anything. This site is a
> frozen, approved version. Change only exactly what I ask for, nothing else.
> Before making any change, tell me what you are about to do and which files it
> touches. If what I am asking would break something documented in those files,
> tell me before you do it, not after. Never put a password, key or token into a
> file.

**What a good assistant will ask you for**, all explained in
`SETUP_CHECKLIST.md`:

| When you ask for | It should ask for |
| --- | --- |
| "Publish the site" | Your Hostinger login, or a GitHub token |
| "Change the booking link" | The new cal.com link |
| "Change the email or number" | The new one |
| "Add a picture" | The file, and where it goes |
| "Build a public page listing all submissions" | It should refuse and explain why |

**Words to avoid:** "clean this up", "modernise it", "make it better". Those
invite changes nobody asked for. Ask for one specific thing at a time.

---

## Part 7: Technical summary

- **Type:** nine hand-written HTML pages, plus five small PHP scripts.
- **Build step:** none. What is in the folder is what gets published.
- **Frameworks:** none. No React, no jQuery, no Bootstrap, no package manager.
- **Database:** none. The coping notes live in one JSON file.
- **PHP:** 8.0 or newer. Written and tested against 8.3.
- **CSS:** hand-written, inside each page. Custom properties for the palette,
  Grid and Flexbox for layout, 3D transforms for the notepad page turn.
- **JavaScript:** hand-written, plain browser JS, no libraries.
- **Fonts:** Cormorant Garamond and Inter, from Google Fonts. The only external
  request the site makes.
- **Palette:** deep purple `#5B2E6B`, purple `#7A4D8F`, soft purple `#B295C4`,
  rose `#D96A9C`, soft rose `#F2C5D5`, cream `#F8F1E4`, warm cream `#FDFAF2`,
  charcoal `#2B1E2F`.
- **Accessibility:** semantic headings, alt text throughout, `aria-live` on
  things that change, `aria-pressed` on the relate button, keyboard reachable
  controls, and a reduced-motion rule that stops every animation for anyone
  whose device asks for it.
- **Security:** admin password stored as a bcrypt hash and checked on the
  server; sessions regenerated on login; CSRF tokens on every moderation action;
  a honeypot on the public form; file writes locked and written atomically; the
  note store sealed by `.htaccess`.
