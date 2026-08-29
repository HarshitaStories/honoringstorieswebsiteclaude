# Working on this repository

Read this before changing anything. It is short on purpose; the detail lives in
the files it points at.

## Read these first

1. `WEBSITE_INSTRUCTIONS.md` in this folder. The full record: every decision,
   why it was made, and a table of things already tried and rejected. If
   something in the code looks wrong, check there before changing it.
2. `spoonfed/README.md`, `spoonfed/STRUCTURE.md`, `spoonfed/DEPLOY.md`,
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

## A change is not finished until all four are done

This is the part most easily forgotten. When you change the site:

1. **The code change itself**, verified.
2. **`WEBSITE_INSTRUCTIONS.md` updated** if the change affects behaviour, a
   decision, or something a future reader would otherwise re-litigate. Record
   reversals especially: "we tried X and rejected it" is the most valuable and
   most easily lost information here.
3. **`spoonfed/*.md` updated** if the change affects how the site is run,
   deployed or maintained. Those four files are the source; the zip is built
   from them. Never edit the copies inside `spoonfed_copy.zip`.
4. **Committed and pushed**, with a message saying what changed and why, not
   just what. Push after every completed change without being asked.

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
