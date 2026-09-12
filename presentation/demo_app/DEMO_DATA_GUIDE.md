# SmartOps Demo Data Guide

## Recommended product-demo setup

Keep the demo dataset fixed and synthetic. Do not automatically copy new production complaints into the product website demo.

The demo database is created from:

`presentation/demo_app/phpmyadmin_database/smartstay_unified_database.sql`

When the guided demo opens, PHP performs these steps:

1. Creates an isolated database named `smartops_demo_<session hash>`.
2. Imports the fixed synthetic seed.
3. Finds the latest seed date and moves it to today.
4. Preserves the relative day distribution for the rolling seven-day charts.
5. Moves the Room 305 guided case to today.
6. Updates date-based `SOAI-YYYYMMDD-NNN` case IDs to match the rebased complaint date.
7. Stores the rebase date in `demo_meta`.

## Adding another fake demo case later

Add the same `case_id` consistently to the relevant seed tables:

- `cases`
- `smart_maintenance_tickets`
- `hitl_cases` only when human review is required
- `workforce_cases` when the case already has workforce state
- `technician_tasks` when the case already has technician task state

Use a synthetic case ID and synthetic room/issue. Keep the seed timestamps within the existing seven-day seed timeline. The bootstrap code will move them to the current presentation week automatically.

After changing the seed:

1. Change `dataset_version` inside `smartstay_unified_database.sql`.
2. Put the same value in `config/snapshot_version.txt`.
3. Reload the guided demo. The version mismatch forces every session database to rebuild.

## Important rules

- Keep Room 305 as a pending HITL case so the guided flow remains available.
- Do not use guest names, phone numbers, message IDs, or other real personal data.
- Do not change the demo database name to `smartstay_php`.
- Do not add a production-database connection to `config/db.php`.
- Use the normal production website separately from the embedded product demo.
