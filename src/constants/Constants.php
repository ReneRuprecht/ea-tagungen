<?php
define("connectionString", "./events.txt");
define('eventDateRegex', '/^[0-9]{4,4}[-][0-9]{1,2}[-][0-9]{1,2}$/');
define('timeRegex', '/^\d{2}[:]\d{2}$/');
define('speakerRegex', '/^((?:[p|P]rof\.))?\s*((?:[d|D]r\.))?\s*([a-zA-ZÄäÖöÜüẞß\-]+)$/');
