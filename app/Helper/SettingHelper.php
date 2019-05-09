<?php

/**
 * Get List Backup
 * @return [type] [description]
 */
function get_schedule_backup()
{
 return \App\Models\ScheduleBackup::orderBy('id', 'DESC')->get();
}