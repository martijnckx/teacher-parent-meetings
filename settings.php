<?php

$kids = [
    "1" => "Brenden Jenkins",
    "2" => "Isma Legge",
    "3" => "Tayyib Cortes",
    "4" => "Alessio Chaney",
    "5" => "Ashlee Parry",
    "6" => "Robbie Gibbs",
    "7" => "Jordanne Hicks",
    "8" => "Fardeen Vega",
    "9" => "Kiyan Healy",
    "10" => "Chad Cote",
    "11" => "Samia Boyd",
    "12" => "Eleasha Burris",
    "13" => "Josie Bateman",
    "14" => "Sohaib Washington",
    "15" => "Aaisha Weston",
    "16" => "Deen Friedman",
    "17" => "Kia Greenaway",
    "18" => "Wil Acosta",
    "19" => "Beverley Moran",
];

$moments = [
    "tu1213" => "Tuesday 12:00 - 13:00",
    "tu1314" => "Tuesday 13:00 - 14:00",
    "tu1415" => "Tuesday 14:00 - 15:00",
    "tu1516" => "Tuesday 15:00 - 16:00",
    "tu1617" => "Tuesday 16:00 - 17:00",
    "tu1718" => "Tuesday 17:00 - 18:00",
    "fr1213" => "Friday 12:00 - 13:00 ",
    "fr1314" => "Friday 13:00 - 14:00 ",
    "fr1415" => "Friday 14:00 - 15:00 ",
    "fr1516" => "Friday 15:00 - 16:00 ",
    "fr1617" => "Friday 16:00 - 17:00 ",
    "fr1718" => "Friday 17:00 - 18:00 ",
];

$db = new SQLite3('db.sqlite');
$res = $db->query('SELECT * FROM Moments ORDER BY Kid ASC');
$availabilities = [];
while ($row = $res->fetchArray()) {
    $row['Moments'] = explode(',', $row['Moments']);
    array_push($availabilities, $row);
}