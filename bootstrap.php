<?
// Global includes
$RELATIVE_PATH_CALENDAR = $GLOBALS['RELATIVE_PATH_CALENDAR']; // Weird hack
require_once 'lib/calendar/lib/DbCalendarEvent.class.php';

require_once 'vendor/trails/trails.php';
require_once 'app/controllers/studip_controller.php';

// Local includes
require 'app/models/Stoodle.php';
require 'app/models/StoodleOption.php';
require 'app/models/StoodleComment.php';
require 'app/models/StoodleAnswer.php';

if (!function_exists('spoken_time')) {
    function spoken_time($time, $max_displayed = 2)
    {
        $result = array();

        $seconds = $time % 60;
        if ($seconds == 1) {
            $result[] = _('1 Sekunde');
        } else if ($seconds > 0) {
            $result[] = sprintf(_('%u Sekunden'), $seconds);
        }
        $time = (int)($time / 60);

        $minutes = $time % 60;
        if ($minutes == 1) {
            $result[] = _('1 Minute');
        } else if ($minutes > 0) {
            $result[] = sprintf(_('%u Minuten'), $minutes);
        }
        $time = (int)($time / 60);

        $hours = $time % 24;
        if ($hours == 1) {
            $result[] = _('1 Stunde');
        } else if ($hours > 1) {
            $result[] = sprintf(_('%u Stunden'), $hours);
        }
        $time = (int)($time / 24);

        if (empty($result) and $time == 1) {
            $result[] = sprintf(_('%u Stunden'), 24);
        } else if ($time == 1) {
            $result[] = _('1 Tag');
        } else if ($time > 0) {
            $result[] = sprintf(_('%u Tage'), $time);
        }

        return implode(', ', array_slice(array_reverse($result), 0, $max_displayed));
    }
}
