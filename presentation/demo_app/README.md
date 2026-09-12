# SmartOps Embedded Product Demo

This folder contains the isolated SmartOps dashboard build used by the product-presentation live demo.

## Demo behaviour

- Uses curated **synthetic/fake maintenance data** only.
- Never connects to or synchronises with the production `smartstay_php` database.
- Creates a separate MySQL database for every browser session.
- Rebuilds the demo from the bundled SQL seed whenever a fresh guided demo starts.
- Automatically moves the seed dates into the current rolling seven-day window.
- Keeps the guided **Room 305 HVAC water leakage case on today’s date**.
- Allows the current visitor to complete the Admin → Technician workflow.
- Resets to the original figures and Room 305 state on the next fresh demo.

## Guided Room 305 workflow

1. Review the highlighted Room 305 HITL case.
2. Approve and assign an available HVAC technician.
3. Switch to Technician View.
4. Accept, start, and complete the task.
5. Return to Admin View and open the completion notification.

The embedded SQL snapshot version is `2026-07-31-room305-dynamic-rolling-v3-zero-date-fix`.

See `DEMO_DATA_GUIDE.md` before adding or changing synthetic demo cases.
