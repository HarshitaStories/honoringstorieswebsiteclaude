# Setup checklist: the things only you can provide

This is the list of accounts, links and logins the website touches. Work through it only when you
need to; most of it is already done and working.

---

## Read this first: about passwords

**No password, key or token is written in this folder, and none ever should be.**

This is not an oversight. Anything written into these files can be read by anyone who gets a copy
of the folder, and by anyone who can see the GitHub repository. A GitHub token in a public
repository is typically found and abused within minutes.

**What that means for you:**

- When an AI assistant needs a password or a key, it should tell you what to do and let **you** type
  it in yourself, in the proper place. A good assistant will refuse to put it in a file.
- If any assistant ever offers to "just save your token in a file so we do not have to do this
  again", say no.
- If you think a key has ever been written into a file, treat it as compromised: go to the account,
  delete that key, and create a new one.

The rest of this document tells you where each thing lives and how to get it, without any of it
being written down here.

---

## 1. GitHub, for publishing the website

**Status: an account already exists.**

| Item | Value |
| --- | --- |
| Account username | `HarshitaStories` |
| Repository | `honoringstorieswebsiteclaude` |
| Web address | `https://github.com/HarshitaStories/honoringstorieswebsiteclaude` |
| Password | Not recorded here. It is Harshita's own GitHub password. |

### If an assistant asks you to sign in to GitHub

Modern GitHub does not accept your ordinary password from a command line. It wants a **Personal
Access Token**, which is a long password made specifically for one purpose and which you can cancel
at any time without changing your real password.

**How to make one:**

1. Sign in at **github.com**.
2. Click your picture, top right, then **Settings**.
3. Scroll to the very bottom of the left menu and click **Developer settings**.
4. Click **Personal access tokens**, then **Tokens (classic)**.
5. Click **Generate new token**, then **Generate new token (classic)**.
6. In the **Note** box, write something you will recognise, like `website laptop`.
7. Under **Expiration**, choose 90 days.
8. Tick the single box labelled **repo**. Tick nothing else.
9. Scroll down, click **Generate token**.
10. A long line of letters and numbers appears. **Copy it now.** GitHub will never show it again.

**Where it goes:** when the black command window asks for a **password**, paste the token there.
Your username stays `HarshitaStories`. Do not put the token in any file.

**If it stops working:** tokens expire on the date you chose. Make a new one the same way.

---

## 2. The booking button, cal.com

**Status: working. Nothing needed from you unless you want to change it.**

| Item | Value |
| --- | --- |
| Booking link | `https://cal.com/harshita-sarda-yllcdj/30min` |
| Where it appears | Every "Book a Consultation Call" and "Book a free exploratory call" button, on all nine pages |
| Password | Not recorded here. Harshita's own cal.com login. |

**To change the booking link:** sign in at cal.com, go to **Event Types**, open the event, and copy
the link shown. Then it must be replaced in **all nine page files**, in more than one place per
page. Ask an assistant to do this and to confirm the count afterwards. There are 33 such buttons
across the site.

---

## 3. Email and WhatsApp

**Status: working. Nothing needed from you.**

| Item | Value |
| --- | --- |
| Email shown on the site | `feelseen@honoringstories.com` |
| WhatsApp number | `+91 9152801719`, written in the code as `https://wa.me/919152801719` |
| Google account that owns the form and sheet | `psychotherapist.hs@gmail.com` |

The WhatsApp link format matters: it is the country code `91` followed by the number, with no
spaces, no plus sign, and no brackets.

---

## 4. The Community page coping notes

**This no longer uses Google.** Everything runs on your own Hostinger server.

### Where things live

| Piece | Where |
| --- | --- |
| Every submission, approved or not | `data/notes.json`, inside the website folder |
| Your admin password, scrambled | `data/config.json` |
| The screen where you moderate | `yoursite.com/admin.php` |

### How approving works

1. Someone writes a note on the Community page and presses Share.
2. It is stored as **pending**. Nobody can see it but you.
3. You open `admin.php`, sign in, and read it.
4. **Approve and publish** puts it on the site. **Delete permanently** removes it
   from the file outright, not just hidden.

Nothing is ever published automatically.

### The password

Set the first time you open `admin.php`, and stored as a bcrypt hash, so it
cannot be read back out of the file by anyone, including whoever built the site.

**If you forget it:** delete `data/config.json` through Hostinger's File Manager,
then open `admin.php` again and it will ask you to set a new one. The notes live
in a different file and are not affected.

### The one file that matters most

`data/.htaccess` seals that folder off from the web. **Without it, submissions
nobody has approved become readable by anyone who guesses the address.** It is a
hidden file, so file managers often skip it during upload.

After deploying, always check that `yoursite.com/data/notes.json` returns
**Forbidden**. If it shows you the file, stop and fix it before the site is
public.

### "I can relate"

The tally is kept on the server and decides the order notes appear in, most
related first. **It is never shown to visitors.** Which notes a person has
already ticked is remembered in their own browser, so clearing site data resets
it.

There is no login, so nothing can verify a tick. The count is a warm signal
rather than a measurement, and should not be read as one.

---

## 5. It exists now, and here is why it is safe

An earlier version of this document said a password-protected page listing
submissions could not be built. That was true then: the site was plain files with
no server, so nothing could store a submission and a password written into a
webpage could be read by anyone who opened the page source.

**Moving to Hostinger changed that**, because Hostinger runs PHP. `admin.php` now
does the job properly:

- The password is checked **on the server**, before any note text is put into the
  page. Someone opening `admin.php` without signing in receives the login form
  and nothing else, because nothing else was ever sent to them.
- It is stored as a bcrypt hash, so it cannot be read back out of the file.
- Every approve, edit and delete carries a token, so another website cannot make
  your browser perform one while you happen to be signed in.

**What is still true:** never put a password into a file. `admin.php` asks you to
set one the first time you open it, and stores only the scrambled form.


## 6. The domain name, honoringstories.com

| Item | Value |
| --- | --- |
| Domain | `honoringstories.com` |
| Registrar | Wherever it was purchased. Not recorded here. |
| Password | Not recorded here. |

To point the domain at the published website you sign in to whoever sold you the domain and change
its DNS settings. Both GitHub Pages and Netlify give you the exact values to enter. If you do not
know where the domain was bought, search your email for a renewal receipt.

---

## 7. Business details used in the legal pages

Not secret, but easy to get wrong. These appear in the Disclaimer, Privacy Policy and Terms pages.

| Item | Value |
| --- | --- |
| Legal name | Honoring Stories |
| Business type | Sole proprietorship |
| Udyam Registration Number | `UDYAM-MH-18-0422743` |
| Effective date of the policies | 1 September 2026 |
| Clinical record retention | 7 years after active work ends |
| Location | Andheri West, Mumbai |

Two things deliberately left out: no postal address, and no named grievance officer.

**These three pages have not been checked by a lawyer.** Do that before the website goes public.

---

## Quick summary: what to have ready

Before starting a session with an assistant, have these to hand if the work touches them:

- [ ] GitHub username and a Personal Access Token, if publishing
- [ ] The Google account login, if changing the form or approving notes
- [ ] The cal.com login, only if changing the booking link
- [ ] The domain registrar login, only if connecting the domain

You will not need all of them. Most changes to the website need none of them at all.
