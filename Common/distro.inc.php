<?php
define('ProgramRelease', 'STABLE');
define('ProgramBuild', '4638+2240+2240');
//Add the Timezone Check if not setup by system
if(strlen(ini_get('date.timezone')))
	date_default_timezone_set(ini_get('date.timezone'));
else
	date_default_timezone_set('UTC');
?>