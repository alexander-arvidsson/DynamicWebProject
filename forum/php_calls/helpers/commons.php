<?php
$db = new SQLite3('../db/user.db') or die('Unable to connect');

function rowCount($result)
{
    $numRows = 0;
    while ($result->fetchArray(SQLITE3_ASSOC)) {
        ++$numRows;
    }
    return $numRows;
}
?>