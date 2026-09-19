# Putting the site live on Hostinger

Google Analytics installation, 2026-09-19 (supersedes earlier planned/inactive descriptions):
The nine public pages load assets/analytics-consent.js and assets/analytics-consent.css.
This is a deliberate shared-file exception to the otherwise self-contained pages.
GA4 uses public Measurement ID G-X8CMDXXHBT; it is an identifier, not a password or API secret.
The Google tag is blocked until Accept, including no cookieless consent pings before acceptance.
Accept and Decline have equal styling. Analytics preferences in every footer reopens the panel.
Consent is stored locally for 180 days; blocked storage means visitors may be asked again.
Declining after acceptance disables GA, clears accessible _ga cookies and reloads the page.
Other open tabs react to changed consent. Advertising consent stays denied, Google Signals
and advertising personalisation are disabled. Only the production apex and www hosts load GA.
The configuration sends page visits, strips page query strings/fragments and reduces referrers
to their origin. No form contents, coping notes or booking details are sent by this integration.
Keep Enhanced measurement, Google Signals and advertising features off in the Analytics console.
A click on a booking link is not a completed booking; no booking conversion tracking is installed.
Privacy Policy now describes this implementation. Cookie lifetime is 180 days.
On deployment verify Accept in GA Realtime and no GA requests before consent or after Decline.
Do not add an unconditional Google tag elsewhere. Publish both shared assets with all nine pages.
Milestone A remains frozen; handoff archives need rebuilding before being used as current copies.

Follow this top to bottom. It assumes you have a Hostinger account with a
hosting plan, and nothing else.

---

## Before you start: what makes this site different

Most of this website is plain files that any host can serve. **Four files are
different.** They are PHP, which means they are programs that run on Hostinger's
server rather than in a visitor's browser:

| File | What it does |
| --- | --- |
| `submit.php` | Receives a coping note and stores it, unpublished |
| `notes.php` | Hands the published notes to the Community page |
| `relate.php` | Records an "I can relate" |
| `admin.php` | Where you read and approve submissions |

They matter for one reason: **PHP has to actually be switched on.** On a plain
file host such as GitHub Pages they would not run at all, and the coping notes
section would simply be dead. Hostinger runs PHP, which is why the site is going
there. Step 2 below is the check.

---

## Step 1: Upload the files

1. Sign in to Hostinger and open **hPanel**.
2. Go to **Files â†’ File Manager**.
3. Open the folder called **`public_html`**. This is the folder the internet
   sees. If there is a default `index.html` or a Hostinger welcome page inside,
   delete it.
4. Open the `website` folder from this package on your computer.
5. Select **everything inside it**, including the `assets` folder and the
   `data` folder, and upload it all.

**Two things people get wrong here:**

- **Upload the contents of `website`, not the folder itself.** If you upload the
  folder, every address gains an extra `/website/` in the middle and every
  picture breaks.
- **The upload must include the files whose names begin with a dot**, which
  means `.htaccess` in the main folder and `.htaccess` inside `data`. Some file
  managers hide these. In Hostinger's File Manager, look for a **Settings** or
  **eye** icon and turn on **Show hidden files** before you check. Without the
  one inside `data`, submissions nobody has approved yet become readable by
  anyone. This is the single most important file in the upload.

---

## Step 2: Check PHP is on, and recent

1. In hPanel, go to **Advanced â†’ PHP Configuration**.
2. Make sure the version is **8.0 or newer**. 8.1, 8.2 and 8.3 are all fine.
3. If it is set to 7.4 or older, change it and save.

The site was written and tested against PHP 8.3.

---

## Step 3: Set your admin password

1. In your browser, go to **`yoursite.com/admin.php`**.
2. It will ask you to create a password, because there is not one yet. This
   happens once.
3. Use at least 10 characters, and **do not reuse a password from anywhere
   else**.
4. You will land on the moderation screen. It will be empty, which is correct.

The password is scrambled before it is stored, so nobody can read it back out of
the file, including whoever wrote the site.

---

## Step 4: The three security checks

**Do these before telling anyone the site is live.** Each takes ten seconds.
Type the address into your browser and see what comes back.

| Type this | You should get | If you get something else |
| --- | --- | --- |
| `yoursite.com/data/notes.json` | **Forbidden**, or a 404 | **Stop.** Unapproved submissions are public. See below. |
| `yoursite.com/admin.php` in a private window | The password screen, nothing more | Stop. |
| `yoursite.com/WEBSITE_INSTRUCTIONS.md` | 404 or Forbidden | Not urgent, but the `.htaccess` did not upload |
| `yoursite.com/corporates.html` | Sends you to `/workplace-wellbeing.html` | The redirect did not upload |
| `yoursite.com/nonsense-page` | A cream page reading "This page is not here" | You are seeing the host's page, so .htaccess is not being read |

**If the first one shows you a file instead of an error**, the `.htaccess` inside
`data` did not upload, or Hostinger is not reading it. Upload it again with
hidden files showing. Do not leave the site public until that check passes: it is
the difference between submissions being private and being on the open internet.

---

## Step 5: Test the whole loop

1. Go to **`yoursite.com/community.html`**.
2. Write a test note in the box and press **Share this**.
3. Confirm it does **not** appear on the page. It should thank you instead.
4. Go to **`yoursite.com/admin.php`** and log in. Your note should be waiting.
5. Press **Approve and publish**.
6. Go back to the Community page. It should now be on the notepad.
7. In `admin.php`, press **Delete permanently** to clear your test.

If all seven work, the site is functioning.

---

## Step 6: Point your domain at it

In hPanel, go to **Domains** and follow the instructions there to attach
`honoringstories.com`. You will need the login for whoever you bought the domain
from, so you can change its DNS settings to the values Hostinger gives you.
Changes can take a few hours to take effect worldwide.

---

## Still to do, and not blocking

- **A lawyer has not read the Disclaimer, Privacy Policy or Terms.** They are
  written and live. Get them checked.
- **The Privacy Policy was updated on 9 September 2026** to describe coping notes,
  Hostinger storage and browser local storage. Professional legal review is still needed.
- **The `admin` folder** holds an abandoned attempt at a different admin system.
  It is blocked by `.htaccess` and does nothing. It can be deleted.

---

## If something is wrong

| What you see | What it means | What to do |
| --- | --- | --- |
| Pictures missing | The `assets` folder was not uploaded, or was renamed | Re-upload it, spelled exactly the same |
| The whole page is code | PHP is off, or the file uploaded as plain text | Step 2 |
| Notes section says it could not load | `notes.php` is missing, or PHP is off | Step 1 and Step 2 |
| `admin.php` shows a blank white page | A PHP error. hPanel has an error log under **Advanced** | Send the log text on |
| "That could not be saved" when approving | The `data` folder is not writable | In File Manager, set the `data` folder permissions to 755 |
| Fonts look like an old newspaper | Google Fonts did not load | Check the connection; it is not a site fault |
| A change does not show | The browser cached the page | Press **Ctrl + Shift + R** |
