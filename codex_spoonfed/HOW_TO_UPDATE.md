# Keeping these guides current

The four documents beside this one are the **source**. `spoonfed_copy.zip` and
the Word file in the repository root are **copies made from them**, for handing
to somebody who does not use Git.

This directory is the Codex-maintained copy requested on 2026-08-31. The
editable practical sources remain in `spoonfed/`. Whenever a source guide
changes, update its matching file here in the same commit. Every website change
must also be recorded with context in `codex_WEBSITE_INSTRUCTIONS.md`.

**Edit the files here. Never edit the ones inside the zip.** Anything changed
inside the zip is lost the next time it is rebuilt.

---

## Making a change

Edit the relevant file here, on GitHub or on your computer, and commit it. That
is the whole job. The zip and the Word file will be out of date until somebody
rebuilds them, which matters only when you are about to hand them to someone.

| File | What belongs in it |
| --- | --- |
| `README.md` | What the site is, how to run it, the rules that must not be broken |
| `DEPLOY.md` | Putting it live, and the checks to run afterwards |
| `SETUP_CHECKLIST.md` | Accounts, links and logins the site touches |
| `STRUCTURE.md` | Which file does what, and what depends on what |

Decisions, reversals and reasoning go in `WEBSITE_INSTRUCTIONS.md` in the root
instead. That is the long record; these four are the practical guide.

---

## Rebuilding the zip

Only needed when you want to hand the package to somebody.

The zip contains these four files, plus a `website/` folder holding everything
the live site needs, plus `reference/WEBSITE_INSTRUCTIONS.md`.

**One trap.** In PowerShell, `Compress-Archive` **silently leaves out files
whose names begin with a dot.** That means it drops `.htaccess`, and the copy
inside `data/` is the file that keeps unapproved submissions private. A package
built with it looks complete and is not. This has happened once already.

Use the .NET API instead, which takes the folder as it finds it:

```powershell
Add-Type -AssemblyName System.IO.Compression.FileSystem
[System.IO.Compression.ZipFile]::CreateFromDirectory(
  "C:\path\to\spoonfed_copy", "C:\path\to\spoonfed_copy.zip",
  [System.IO.Compression.CompressionLevel]::Optimal, $true)
```

Then open the zip and confirm **both** `.htaccess` files are listed before
sending it anywhere.

---

## Rebuilding the Word file

Only needed when somebody wants to read it without Markdown. Join the four
files into one, convert to HTML, and open that in Word, which saves it as
`.docx`. Any Markdown to Word tool does the same job; pandoc is the usual one
where it is available.

Name it with the date, as `spoonfed_copy_YYYY-MM-DD.docx`. The date is there
because it is a snapshot and will not track later edits. If the guides change,
export a new dated copy rather than editing the old one, so the two can never
quietly disagree.

---

## The rule that keeps this useful

**When something about the site changes, change the guide in the same commit.**

The gap between what a document says and what is true opens quietly and is
almost never noticed until somebody follows the document and it does not work.
The package has already been wrong once this way: it explained a Google Form
and a spreadsheet formula for weeks after both had been replaced.
