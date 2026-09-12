<?php
require_once __DIR__ . '/../includes/helpers.php';
require_once __DIR__ . '/../includes/presentation_mode.php';

presentation_mode_stop();
redirect_to(app_url('presentation/index.php#technology'));
