# SmartOps Presentation Mode

This folder is intentionally separate from the normal Admin and Technician websites.
The existing web system still opens and works normally. Presentation-only controls appear only after you click **Start Live Demo** from the presentation viewer.

## 1. Add your PowerPoint / Canva pages

Export each page as a high-quality **16:9 PNG** and place it in:

`presentation/slides/`

Use fixed names:

- `slide01.png`
- `slide02.png`
- `slide03.png`
- ...

When you edit one page later, export only that page and replace the same PNG filename. No website code needs to change.

## 2. Set your slide count and demo position

Open:

`presentation/settings.php`

The updated project is configured for **31 slides**. Change:

- `slide_count`
- `demo_after_slide`
- `resume_slide`

Example:

- Slides 1–7 = presentation part 1
- Slide 8 shows **Start Live Demo**
- Demo goes Admin → HITL → Technician
- Continue Presentation resumes at slide 9 (RAG-LLM)

## 3. Embed real videos

Put MP4 files inside:

`presentation/videos/`

Then edit `video_slides` in `presentation/settings.php`.

Example:

```php
'video_slides' => [
    4 => 'business-problem.mp4',
    6 => 'proposed-solution.mp4',
],
```

The selected slide number displays the real embedded video instead of `slideXX.png`.

## 4. Live demo flow

The existing HITL assignment already creates/assigns the Technician task in the shared database.
In Presentation Mode, after the manager clicks **Approve & Assign**, the chosen `case_id` and `technician_id` are remembered only for the demo navigation.

Flow:

`Presentation → Admin → HITL Approve & Assign → Technician View → Accept → Start Repair → Complete Repair → Admin View → Continue Presentation`

The Admin and Technician websites remain separate role-based interfaces. They are linked through the same MySQL workflow records.

## 5. Open Presentation Mode

Use:

`http://localhost/<your-project-folder>/presentation/`

The normal project root still behaves as before and redirects to the Admin login.

## 6. Important: Live demo database behaviour

The presentation live demo uses the isolated application under `presentation/demo_app/` and its synthetic seed data. It is designed so portfolio/demo activity does not overwrite the main SmartOps maintenance dataset.

The guided flow still demonstrates the full role hand-off:

- **Approve & Assign** moves the Room 305 case from HITL review into technician work.
- **Accept / Start / Complete** advances the technician task state.
- Returning to Admin View shows the completion update within the isolated demo session.

See `presentation/demo_app/DEMO_DATA_GUIDE.md` before changing the demo dataset or reset behaviour.
