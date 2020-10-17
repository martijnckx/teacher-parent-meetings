<?php 

include_once('settings.php');

function getAvailabilitiesOfKid($kid, $availabilities) {
    foreach ($availabilities as $entry) {
        if ($entry['Kid'] === intval($kid)) return $entry['Moments'];
    }
    return null;
}

?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oudercontact</title>
    <style>
    .availabilities {
        display: flex;
        flex-wrap: nowrap;
        overflow-x: auto;
        margin-left: 150px;
    }
    .kid {
        min-width: 150px;
        width: 150px;
        border-right: 2px solid #CCC;
        margin: 20px 0;
        display: flex;
        flex-direction: column;
        text-align: center;
    }
    .kid:first-of-type {
        border-left: 2px solid #ccc;
    }
    .timeslot {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100px;
        background: #EEE;
    }
    .timeslot:nth-child(even) {
        background: #F6F6F6;
    }
    .timeslot.available {
        background: #adecad;
    }
    .timeslot.available:nth-child(even) {
        background: #adecad;
    }
    .fixed {
        position: absolute;
        z-index: 1;
        margin-left: -150px;
    }
    </style>
</head>
<body>
    <div class="availabilities">
        <div class="kid fixed">
        <p>&nbsp;</p>
        <?php foreach ($moments as $moment => $readable) { ?>
            <div class="timeslot <?php if (in_array($moment, $entry['Moments'])) { echo 'available'; } ?>">
            <?= $readable ?>
            </div>
            <?php } ?>
        </div>
        <?php foreach ($availabilities as $entry) { ?>
        <div class="kid">
            <p><?=$kids[$entry['Kid']]?></p>
            <?php foreach ($moments as $moment => $readable) { ?>
            <div class="timeslot <?php if (in_array($moment, $entry['Moments'])) { echo 'available'; } ?>">
            
            </div>
            <?php } ?>
            </div>
        <?php } ?>
    </div>
</body>
</html>