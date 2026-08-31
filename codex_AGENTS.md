# Working on this repository

Read this before changing anything. It is short on purpose; the detail lives in
the files it points at.

## Read these first

1. `WEBSITE_INSTRUCTIONS.md` in this folder. The full record: every decision,
   why it was made, and a table of things already tried and rejected. If
   something in the code looks wrong, check there before changing it.
2. `codex_WEBSITE_INSTRUCTIONS.md`. The Codex-maintained standalone copy of the
   full record. Keep it synchronized with every website change.
3. `spoonfed/README.md`, `spoonfed/STRUCTURE.md`, `spoonfed/DEPLOY.md`,
   `spoonfed/SETUP_CHECKLIST.md`.

Say what you have read before you start editing.

## What this is

A nine page static site for a psychotherapist, plus five small PHP files that
run the coping notes on the Community page. No framework, no build step, no
package manager, no database. Hand written HTML, CSS and JavaScript. Deployed
to Hostinger from this repository.

The site is a **frozen, approved version**. Change only what you are explicitly
asked to change. Do not tidy, refactor, reformat or modernise anything you were
not asked about, however wrong it looks.

## Rules that are not negotiable

1. **Never use an em dash.** Anywhere. Not in visible copy, not in a code
   comment, not in alt text, not in a commit message, not in these documents.
   Use a comma, a full stop, or rewrite. Check with a search before committing.

2. **The nav, footer, WhatsApp button and scroll rail exist nine times**, once
   per page, because there is no shared template. Change one, change all nine,
   then verify all nine. `index.html` writes its CSS across multiple lines
   where the other eight use single lines, so a find and replace tuned to those
   eight silently skips the homepage. This has happened.

3. **Never render a visitor's words as markup.** `textContent` in the browser,
   `htmlspecialchars` in PHP. Do not change either to anything that renders
   HTML, including for formatting.

4. **No password, key or token in any file.** Ever. Tell the user where to enter
   it themselves instead. This repository is public.

5. **Verify by measuring, not by looking.** The preview environment cannot
   reliably screenshot, and does not advance CSS transitions or fire
   requestAnimationFrame. Read computed styles, measure geometry, check
   element order, run the code. Most bugs in this project were invisible.

## A change is not finished until all five are done

This is the part most easily forgotten. When you change the site:

1. **The code change itself**, verified.
2. **`WEBSITE_INSTRUCTIONS.md` updated** if the change affects behaviour, a
   decision, or something a future reader would otherwise re-litigate. Record
   reversals especially: "we tried X and rejected it" is the most valuable and
   most easily lost information here.
3. **`codex_WEBSITE_INSTRUCTIONS.md` updated for every website change**, even a
   tiny copy change. It is the latest standalone Codex record of the frontend,
   backend, reasoning and version history. Keep `codex_spoonfed/*.md` in sync
   whenever the corresponding practical guide changes, and keep
   `codex_AGENTS.md` in sync whenever these operating rules change.
4. **`spoonfed/*.md` updated** if the change affects how the site is run,
   deployed or maintained. Those four files are the source; the zip is built
   from them. Never edit the copies inside `spoonfed_copy.zip`.
5. **Committed and pushed**, with a message saying what changed and why, not
   just what. Push after every completed change without being asked, then ask
   Harshita to deploy from Hostinger.

If the guides change, mention that `spoonfed_copy.zip` is now out of date and
offer to rebuild it. Instructions are in `spoonfed/HOW_TO_UPDATE.md`, including
why `Compress-Archive` must not be used for it.

## Local testing

The coping notes need PHP. `php -S localhost:8090` from the repository root
serves the whole site, PHP included. `serve.ps1` needs nothing installed but
serves plain files only, so the notes will not work under it.

## What lives where

- Nine `.html` pages, each self contained: markup, CSS and JavaScript inside.
- `lib.php`, `submit.php`, `notes.php`, `relate.php`, `admin.php`: the notes.
- `data/`: the note store on the server. Gitignored except its `.htaccess`,
  which is what keeps unapproved submissions private. Never remove it.
- `.htaccess` at the root: server rules for Hostinger, including which files
  are not reachable from the web.
- `assets/`: images. All prepared, not raw. See `WEBSITE_INSTRUCTIONS.md`.

The three homepage counters are real figures about a practice, held in the
`data-target` attributes in `index.html`. Never round one up or adjust it to
look better.

## Things that will look wrong and are not

- **`.htaccess` holds a permanent redirect from `/corporates.html` to
  `/workplace-wellbeing.html`.** The page was renamed. Never delete that line:
  there is no expiry on somebody having bookmarked the old address.
- **Four error pages** (`404`, `403`, `500`, `error.html`) cover fifteen status
  codes between them, mapped in `.htaccess` by meaning rather than by number.
  `error.html` exists for the codes where blaming either side would be wrong.
  They are built from one another, so change one and change the rest.
- **Icon files are duplicated on purpose.** `favicon.ico` sits at the web root
  because browsers ask for that address whether or not a page declares an icon,
  and bookmark bars look only there. The PNG links carry `?v=` because a
  browser keeps favicons in a cache that a hard reload does not clear.
- **The favicon is the feather only, not the whole logo.** The logo is 909x404
  and unreadable at 16 pixels. The crop stops at x=232 because the capital H of
  the wordmark begins at x=240.
- **Page titles are metadata and visible.** A `<title>` is both the browser tab
  and the blue headline in a search result. Changing one changes both, so treat
  it as a content change and ask first.

## When adding or renaming a page

1. The nav dropdown and the mobile drawer, on **all nine** pages.
2. The footer link list, on all nine.
3. The three error pages, which link to the main five.
4. `sitemap.xml`.
5. Its own `canonical` and `og:url`, which must name its real address.
6. If renaming, a `Redirect 301` in `.htaccess` from the old address.

Verify afterwards by loading every page and following every internal link, not
by trusting the find and replace.
