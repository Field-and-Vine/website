# Field and Vine Website

The theme and supporting code for field-vine.com, a WordPress site hosted on WP Engine. Pages, text and photos live in WordPress and are edited there; this repository holds the code.

## Layout

- `wp-content/themes/field-and-vine/`: the block theme, started from Twenty Twenty-Five.
- `wp-content/mu-plugins/`: a must-use plugin for Development that lets an application password pass the environment's password protection.
- `.github/workflows/`: the pull request check and the deploys.

## Deploys

- A pull request runs a PHP syntax check, which uses no secrets.
- A merge to `main` deploys to Development through the `development` environment.
- A published release deploys the theme to Production through the `production` environment, after its required reviewer approves.

Each deploy writes only the files this repository holds and clears the site caches. The theme folder on the server is kept identical to the repository's, so a file removed from the theme here is removed there; nothing else in `wp-content` is removed. A Production deploy stops if the release's commit is not on `main`; the reviewer still confirms that the release points at `main` before approving.

Each GitHub environment holds its own settings: the WP Engine environment name (variable `WPE_ENV`), the site address (variable `SITE_URL`) and a deploy key (secret `WPE_SSHG_KEY_PRIVATE`) belonging to a WP Engine user that can reach only that environment.

## What stays out

This repository is public. Client names, street addresses, account identifiers and secret values never go in its files, commit messages or pull request descriptions. The theme reads contact details from WordPress.
