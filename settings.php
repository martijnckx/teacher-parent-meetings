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
    "tu1314" => "Dinsdag 27/10 tussen 13:30 - 14:30",
    "tu1415" => "Dinsdag 27/10 tussen 14:30 - 15:30",
    "tu1516" => "Dinsdag 27/10 tussen 15:30 - 16:30",
    "tu1617" => "Dinsdag 27/10 tussen 16:30 - 17:30",
    "tu1718" => "Dinsdag 27/10 tussen 17:30 - 18:30",
    "tu1819" => "Dinsdag 27/10 tussen 18:30 - 19:30",
    "wo1314" => "Woensdag 28/10 tussen 13:30 - 14:30 ",
    "wo1415" => "Woensdag 28/10 tussen 14:30 - 15:30 ",
    "wo1516" => "Woensdag 28/10 tussen 15:30 - 16:30 ",
    "wo1617" => "Woensdag 28/10 tussen 16:30 - 17:30 ",
];

$db = new SQLite3('db.sqlite');
$res = $db->query('SELECT * FROM Moments ORDER BY Kid ASC');
$availabilities = [];
while ($row = $res->fetchArray()) {
    $row['Moments'] = explode(',', $row['Moments']);
    array_push($availabilities, $row);
}