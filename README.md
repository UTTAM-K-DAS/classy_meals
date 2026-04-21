# classy_meals

## GitHub Pages deployment

This repository contains a PHP application, but GitHub Pages can only host static files.  
Pages is deployed with GitHub Actions using `.github/workflows/pages.yml`, which publishes the `pages/` directory.

- Published entry file: `pages/index.html`
- SPA-style fallback: `pages/404.html` redirects to `pages/index.html`

## Local preview

Preview the static Pages content locally:

```bash
cd pages
python3 -m http.server 8000
```

Then open `http://localhost:8000`.
