<?php
/**
 * SmartOps Presentation settings
 * ------------------------------
 * 1) Export every PowerPoint/Canva page as a 16:9 PNG.
 * 2) Name them slide01.png, slide02.png, slide03.png ...
 * 3) Put videos in /presentation/videos/.
 * 4) Slides 02 and 03 keep the PPT image as the background and place
 *    a real, manually-played video on top of the photo area.
 */
return [
    'title' => 'SmartOps AI Presentation',

    // Total number of exported presentation pages.
    'slide_count' => 31,

    // Live demo hand-off position.
    'demo_after_slide' => 8,
    'resume_slide' => 9,

    /**
     * VIDEO OVERLAYS
     * --------------
     * The slide PNG remains visible. The video is layered over the photo area.
     * Videos use controls and DO NOT autoplay, so you press Play yourself.
     *
     * Expected files:
     *   presentation/videos/slide02.mp4
     *   presentation/videos/slide03.mp4
     *
     * left/top/width/height are percentages of the 16:9 slide canvas.
     * The values below match the large central photo area in your screenshot.
     */
    'video_overlays' => [
        2 => [
            'file' => 'slide02.mp4',
            'left' => '10.70%',
            'top' => '16.80%',
            'width' => '76.95%',
            'height' => '75.00%',
            'fit' => 'cover',
        ],
        3 => [
            'file' => 'slide03.mp4',
            'left' => '10.70%',
            'top' => '16.80%',
            'width' => '76.95%',
            'height' => '75.00%',
            'fit' => 'cover',
        ],
    ],

    /**
     * Optional legacy mode: replace an ENTIRE slide with a video.
     * Leave empty because slides 02 and 03 now use overlays instead.
     */
    'video_slides' => [],
];
