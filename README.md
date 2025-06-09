# FicheNum

FicheNum is a lightweight PHP application that turns any content into an interactive learning sheet. Give it a link, a PDF, an image or a question and FicheNum generates a concise "ultra-sheet" that includes text summaries, infographics, audio synthesis and even a quiz. Everything can be shared instantly via a generated QR code.

Generated sheets are stored using Markdown syntax which is converted to HTML on the fly with the [Parsedown](https://parsedown.org) library. This keeps the raw content easy to edit while displaying a clean, ebook-style layout in the browser.

## Setup

1. Clone this repository.
2. Update the database credentials in `config.php` if needed. The application expects a MySQL database and uses PHP PDO.
3. Make sure you have PHP 8 or later installed with the PDO MySQL extension.

## Running locally

From the project root run:

```bash
php -S localhost:8000
```

Then open `http://localhost:8000` in your browser to access FicheNum.

## Key features

- **Ultra-fast conversion** – transform any content into an interactive sheet in under 30 seconds.
- **Proprietary AI (FicheGPT)** – analyzes and condenses information with high precision.
- **Automatic assets** – generates text summaries, infographics, audio and quizzes.
- **Universal sharing** – each sheet comes with a QR code and a direct link ready to distribute.

FicheNum aims to simplify content digestion for students, teachers and professionals alike. Feel free to adapt the code to your own needs.

## User registration

The `register.php` page lets visitors create an account. It checks whether the email already exists, stores a verification token and sends a confirmation link using PHP's `mail()` function. Following the link triggers `verify.php` which marks the user as verified.

## Admin dashboard

Users with the `admin` role can access `/admin/dashboard.php` after logging in. The navigation bar on the home page shows a Dashboard link for admins.
