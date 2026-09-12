# SmartOps AI Web System

SmartOps AI is a web-based hotel maintenance management system that combines maintenance case management, RAG-LLM-assisted decision support, Human-in-the-Loop (HITL) governance, technician task handling, SLA monitoring, and operational dashboards.

## Project highlights

- **Admin portal:** executive overview, smart maintenance intelligence, HITL escalation, workforce/task monitoring, maintenance records, and technician management.
- **Technician portal:** assigned, in-progress, support, overdue, history, and account views in a mobile-first interface.
- **HITL governance:** escalates safety-related, low-confidence, out-of-knowledge-base, and high/critical cases for human review.
- **Maintenance workflow:** complaint intake → AI result → HITL/auto-routing → technician assignment → accept/start/complete → admin monitoring.
- **SLA rules:** technician acceptance within 30 minutes and repair completion within 90 minutes of repair start.
- **Backend:** PHP, MySQL, PDO prepared statements, and a FastAPI integration service.
- **Presentation demo:** an isolated Room 305 product demo under `presentation/demo_app/`.

## Technology stack

- HTML, CSS, JavaScript
- PHP
- MySQL
- FastAPI / Python
- Chart.js
- XAMPP/WAMP for local development

## Repository structure

```text
admin_portal/          Admin web application
technician_website/    Technician mobile portal
assets/                Shared CSS and JavaScript
config/                PHP configuration
includes/              Shared PHP helpers/components
data/                  RAG-LLM / pipeline sample data
phpmyadmin_database/   MySQL schema and migration SQL
smartops_fastapi/      FastAPI integration service
presentation/          Portfolio presentation and isolated demo
index.php              Project entry point
```

## Local setup

1. Place the repository folder in your XAMPP/WAMP web root.
2. Start Apache and MySQL.
3. Import `phpmyadmin_database/smartstay_unified_database.sql`.
4. Copy `smartops_fastapi/.env.example` to `smartops_fastapi/.env` and update local values if required.
5. Start the FastAPI service using the macOS or Windows launcher in `smartops_fastapi/`.
6. Open the project through your local Apache URL, for example `http://localhost/SmartOps-AI-Web-System/`.

FastAPI health check: `http://127.0.0.1:8001/health`

## Public-repository security

Local environment files and operating-system/editor artefacts are excluded from Git. The repository does **not** include `smartops_fastapi/.env`.

Authentication is database-backed in this GitHub-ready version; fixed login bypasses are not included. For admin signup/password-reset protection, configure a local environment variable:

```text
SMARTOPS_ADMIN_ACCESS_CODE=<your-local-admin-access-code>
```

Do not commit real credentials or access codes to the repository.

## FastAPI integration

SmartOps FastAPI runs on port `8001` and can call the ML recommendation API configured through `ML_API_URL` (default example: `http://127.0.0.1:8000/api/v1/recommendation`).

The main complaint-processing endpoint is:

```text
POST /api/v1/ml/process-complaint
```

Example request:

```json
{
  "case_id": "TEST-001",
  "room_id": "1203",
  "complaint_text": "The air conditioner is not cooling."
}
```

## Presentation demo

`presentation/demo_app/` contains an isolated synthetic demo dataset for the portfolio presentation. It is separated from the main production-style complaint data and dynamically rebases dates into the current rolling seven-day window.

See `presentation/demo_app/DEMO_DATA_GUIDE.md` and `LIVE_DEMO_ROOM305_SETUP.md` for details.

## GitHub note

The repository contains two original MP4 presentation files larger than 25 MB. They are below GitHub's 100 MB Git object limit, but GitHub's browser uploader may reject files above its browser-upload limit. For the complete repository, use GitHub Desktop or Git from the command line rather than uploading all files through the browser.
