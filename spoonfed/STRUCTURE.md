| The word limit for notes | `community.html` and `lib.php`, which must agree |
| Where notes are stored | `lib.php` only. The other scripts go through it |
# Structure: what every file is, and what depends on what

---

## 1. The folder tree

```
website/                                  <-- publish the CONTENTS of this folder
â”‚
â”œâ”€â”€ index.html                            Homepage
â”œâ”€â”€ about.html                            About Harshita
â”œâ”€â”€ psychotherapy.html                    Psychotherapy sessions
â”œâ”€â”€ supervision.html                      Supervision sessions
â”œâ”€â”€ workplace-wellbeing.html                       Workplace Wellbeing, for organisations
â”œâ”€â”€ community.html                        Community
â”œâ”€â”€ disclaimer.html                       Legal
â”œâ”€â”€ privacy-policy.html                   Legal
â”œâ”€â”€ terms-and-conditions.html             Legal
â”‚
â”œâ”€â”€ serve.ps1                             Local viewing helper. NOT part of the website.
â”‚
â””â”€â”€ assets/                               Every picture
    â”œâ”€â”€ logo.png                          Nav logo and browser tab icon. Used by all 9 pages.
    â”œâ”€â”€ Whitelogo.png                     Footer logo. Used by all 9 pages.
    â”œâ”€â”€ harshita-home.png                 Homepage main photo
    â”œâ”€â”€ harshita-glimpse.png              Homepage second photo
    â”œâ”€â”€ therapy-hero.jpg                  Psychotherapy page illustration
    â”œâ”€â”€ supervision-hero.jpg              Supervision page illustration
    â”œâ”€â”€ workplace-wellbeing.png           Organisations page illustration
    â”œâ”€â”€ harshita-organisations.jpg        Organisations page round portrait
    â”œâ”€â”€ community-hero.jpg                Community page top banner
    â”œâ”€â”€ sharedwaysofcoping.jpg            Community page section illustration
    â”‚
    â”œâ”€â”€ harshita-chair.jpg                KEPT BUT UNUSED. Previous homepage photo.
    â”œâ”€â”€ harshita-home-source.png          KEPT BUT UNUSED. Original before editing.
    â”œâ”€â”€ harshita-home 2.png               KEPT BUT UNUSED. Older photo. Note the space in the name.
    â””â”€â”€ logo-full.png                     KEPT BUT UNUSED. Older colour logo.
```

**The four marked KEPT BUT UNUSED are not rubbish.** They are kept on purpose in case an earlier
version of a picture is wanted back. Do not delete them without asking.

---

## 2. Parent and child: how the pages relate

There is no technical parent and child here; every page is an equal, standalone file. But there is
a **navigational** hierarchy, which is what visitors experience, and it is what the menu expresses.

```
index.html  (Home)
â”‚
â”œâ”€â”€ about.html                                  "About" in the menu
â”‚
â”œâ”€â”€ Work With Me      (a menu heading only, not a page of its own)
â”‚   â”œâ”€â”€ psychotherapy.html                      "Psychotherapy sessions"
â”‚   â”œâ”€â”€ supervision.html                        "Supervision sessions"
â”‚   â””â”€â”€ workplace-wellbeing.html                         "Workplace Wellbeing"
â”‚
â”œâ”€â”€ community.html                              "Community" in the menu
â”‚
â””â”€â”€ Footer only, not in the top menu
    â”œâ”€â”€ disclaimer.html
    â”œâ”€â”€ privacy-policy.html
    â””â”€â”€ terms-and-conditions.html
```

**"Work With Me" is not a page.** It is a heading in the menu that opens a small dropdown holding
the three pages beneath it. Clicking the words themselves does nothing on purpose. If you ever see
it behaving like a link, that is a fault.

### An important point about linking

Although the hierarchy above is what a visitor perceives, **every page links to every other page**,
because all nine carry the same menu and the same footer. There is no page you can only reach from
one place. Confirmed: all nine pages link to all nine.

This is why Rule 2 in the README matters so much. The menu is not "on the homepage". It is on all
nine pages, nine separate times.

---

## 3. Inside a single page file

Every page has the same skeleton. Open any of them in a text editor and you will find, in order:

```
<!DOCTYPE html>
<html>
  <head>
      title, description, tab icon
      the Google Fonts link                <-- the only outside stylesheet
      <style>  ... ALL THE CSS FOR THIS PAGE ...  </style>
  </head>
  <body>
      the top menu           (identical on all 9 pages)
      the mobile menu        (identical on all 9 pages)
      the dots down the right edge   (page specific)
      the page banner
      ... the page's own sections ...
      the contact strip
      the footer             (identical on all 9 pages)
      the floating WhatsApp button   (identical on all 9 pages)
      <script>  ... ALL THE JAVASCRIPT FOR THIS PAGE ...  </script>
  </body>
</html>
```

The four blocks marked "identical on all 9 pages" are the shared furniture. They are copied, not
shared. That is the trade-off described in the README.

---

## 4. The sections inside each page

These names are the anchors used by the little dots down the right-hand edge of the screen.

| Page | Sections, in order |
| --- | --- |
| `index.html` | values, concerns, glimpse, testimonials, work-with-me, contact |
| `about.html` | bio, values, qualifications, experience, contact |
| `psychotherapy.html` | who, logistics, pricing, process, faqs, contact |
| `supervision.html` | who, logistics, pricing, process, faqs, contact |
| `workplace-wellbeing.html` | why, offer, themes, how, about-me, faqs, contact |
| `community.html` | shared-ways, sip-and-swap, how, contact |
| The three legal pages | Plain text, no sections and no dots |

Psychotherapy and Supervision are deliberately built to the same shape. If you change the structure
of one, the other usually needs the same change so they stay recognisably a pair.

---

## 5. What depends on what

Use this before changing anything, to see what else you will have to touch.

| If you change this | You must also touch |
| --- | --- |
| The top menu | All 9 page files, twice each: the desktop menu and the mobile menu |
| The footer | All 9 page files |
| The floating WhatsApp button | All 9 page files |
| Any colour in the palette | All 9 page files, in the `:root` block at the top of each `<style>` |
| The booking link | All 9 page files, 33 buttons in total |
| The email or WhatsApp number | All 9 page files |
| A picture's filename | Every page that shows it, see the tree in section 1 |
| The word limit for notes | `community.html` and `lib.php`, which must agree |
| Where notes are stored | `lib.php` only. The other scripts all go through it |
| The psychotherapy page layout | Usually the supervision page too, to keep them a matching pair |

---

## 6. The moving parts, and which page each lives on

| What it does | Page | Notes |
| --- | --- | --- |
| Mobile menu open and close | all 9 | |
| Scroll animations, things fading in | all 9 | Switched off automatically for anyone whose device asks for reduced motion |
| The dots down the right edge highlighting as you scroll | 6 | Not on the legal pages |
| Numbers counting up | `index.html` | In the glimpse section |
| Testimonials sliding | `index.html` | 8 real testimonials, used with permission |
| FAQ questions opening | psychotherapy, supervision, corporates | |
| Price changing by country | psychotherapy, supervision | Explained below |
| Confidentiality panel expanding | `workplace-wellbeing.html` | |
| Word counter counting down from 100 | `community.html` | |
| Sending a coping note | `community.html` | |
| Reading approved notes | `community.html` | The only thing that fetches from outside while a visitor is on the page |

### About the price changing by country

Visitors in India see one online price; visitors elsewhere see another. The two are never shown
together.

It works out where the visitor is by reading **their computer's own timezone setting**, which the
browser already knows. It does **not** look up their internet address.

**This was a deliberate privacy decision.** Looking up the internet address would mean sending every
single visitor's IP address to some other company, and the Privacy Policy on this same website says
there is no tracking beyond Google Fonts. That statement had to stay true.

The trade-off is that someone travelling, or using a VPN, sees the price for wherever their computer
thinks it is. That was judged acceptable.

---

## 7. Things that go outside the website

**Two, and only two.** The coping notes used to go to Google Forms and Google
Sheets. They no longer do: submissions and approved notes both live on your own
server now, so those two dependencies are gone.

| What | Purpose | If it stops working |
| --- | --- | --- |
| Google Fonts | The two typefaces | Text falls back to system fonts. Everything stays readable |
| cal.com | The booking button | Booking buttons go nowhere |

Everything else is inside the folder. No database, no analytics, no advertising
trackers, and no cookie banner, because there is nothing that would need one.


## 8. The nine files, at a glance

| File | Size | What it is for |
| --- | --- | --- |
| `index.html` | 79 KB | The homepage. The largest file, because it holds the testimonials and the counting numbers |
| `community.html` | 60 KB | Community. Second largest, because of the note submission and reading code |
| `psychotherapy.html` | 58 KB | Psychotherapy sessions |
| `workplace-wellbeing.html` | 55 KB | Workplace Wellbeing |
| `supervision.html` | 54 KB | Supervision sessions |
| `about.html` | 46 KB | About Harshita |
| `privacy-policy.html` | 41 KB | Legal |
| `terms-and-conditions.html` | 40 KB | Legal |
| `disclaimer.html` | 38 KB | Legal |

The files look large for what they are because each one carries its own complete copy of the
styling. That is expected, not a problem to be fixed.

---

## 9. The PHP files, and what each does

These five are what make the coping notes work. They run on the server, not in
the visitor's browser.

| File | Reached by | What it does |
| --- | --- | --- |
| `submit.php` | The Community page, when someone presses Share | Checks the note, stores it as pending. Never publishes. |
| `notes.php` | The Community page, on load | Returns **approved notes only**, ordered most related first |
| `relate.php` | The relate button | Adds one to a note's tally |
| `admin.php` | You, by typing the address | Login, then approve, edit, unpublish, delete |
| `lib.php` | The other four | Shared reading and writing. Never opened directly. |

### What is deliberately not sent to the browser

`notes.php` returns only each note's text and a random id. It does **not** send
the relate count, and does **not** send the time a note was submitted.

Both are on purpose. A count beside somebody's note about a hard day turns a
quiet gesture into a score. A submission time is a small identifying detail on a
wall that promises anonymity. Neither is needed by the page, so neither leaves
the server.

### The store

```
data/
â”œâ”€â”€ .htaccess     seals this folder off from the web. Critical.
â”œâ”€â”€ notes.json    every submission, approved or not
â”œâ”€â”€ config.json   the admin password, scrambled
â””â”€â”€ notes.lock    a lock file the code manages itself
```

The last three are created automatically. **Only `.htaccess` has to be
uploaded.** If it is missing, unapproved submissions become public.

### Two things in the code that look odd and are not

**The lock is taken on a separate file**, never on `notes.json` itself. Windows
refuses to rename over a file that has an open handle, so locking the data file
and then writing to it fails there while working on Linux. That would have been
a bug that only appeared on one machine.

**Writes go to a temporary file and are renamed into place.** A rename is
atomic, so a visitor reading the file mid-write can never catch it half written.

---

## 10. Search, social and error handling

Added after the site was otherwise finished. None of it changes a page's
appearance; the only thing a visitor sees is the browser tab.

### Metadata, in every page's `<head>`

| Tag | What it does |
| --- | --- |
| `<title>` | The browser tab, and the blue headline in a search result |
| `description` | The grey sentence under that headline |
| `canonical` | Names the real address, so the same page reached with a trailing slash is not counted twice |
| `og:` and `twitter:` | What shows when the link is pasted into WhatsApp or LinkedIn |

`assets/share-card.png` is the picture those use, built from the logo on the
page cream. Titles run 29 to 63 characters and descriptions stay under 160,
which is roughly what Google shows before cutting.

The homepage alone carries a block of structured data. Everything in it is
already written in plain words elsewhere on the site, so it restates rather
than discloses. Locality only, no street address.

`robots.txt` and `sitemap.xml` sit at the root. Both exclude the moderation
screen, the note store and the scratch pages.

### The error pages

Four files, `404.html`, `403.html`, `500.html` and `error.html`, covering
fifteen status codes mapped in `.htaccess` by meaning:

| Meaning | Codes |
| --- | --- |
| Not here | 404, 410 |
| Not yours to see | 401, 403 |
| Our fault | 500, 502, 503, 504, 408 |
| Neither side clearly at fault | 400, 405, 406, 413, 414, 429 |

Two things about them are deliberate. **Every path inside them is absolute**,
because an error page is served at whatever address the visitor typed, so a
relative path would resolve against a folder that may not exist. And **each
stands alone**, with its styling inline and no script: whatever is broken must
not be able to break the page explaining it.

What they cannot cover: if the site is down, the account suspended, or the
domain not resolving, the visitor never reaches the server and the host's own
page is what they see.

### The icons

`favicon.ico` at the root, plus 16px and 32px PNGs and an Apple touch icon in
`assets/`. The root `.ico` matters because browsers request that address
whether or not a page declares an icon, and bookmark bars look only there.

The icon is the feather alone. The full logo is 909x404 and illegible at 16
pixels, and the crop stops at x=232 because the wordmark starts at x=240.

### The renamed page

The organisations page was `/corporates.html` and is now
`/workplace-wellbeing.html`. A `Redirect 301` in `.htaccess` keeps the old
address working for anyone holding it. **That line must never be removed.**

## Figures on the homepage

The three counters, years, clients served and sessions completed, are real
figures Harshita supplies. They live in one place only, the `data-target`
attribute on each `.stat-num` in `index.html`, and the counter animates up to
whatever is there.

**Never adjust one to look better.** They are claims about a practice, and the
current pairing is 7, 400 and 3,000. If a figure changes, change the attribute
and the record in `WEBSITE_INSTRUCTIONS.md`, nothing else.

The formatting uses `en-IN`, so 3000 renders as 3,000. That matters above ten
thousand, where Indian grouping differs from Western: 100000 renders as
1,00,000, not 100,000. That is intended.
