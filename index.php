<?php

include_once('settings.php');

function hasAvailabilitiesSaved($kid, $availabilities) {
    foreach ($availabilities as $entry) {
        if ($entry['Kid'] === $kid) return true;
    }
    return false;
}

$justsaved = false;
// Kid needs to be selected and needs to exist
if (!empty($_POST['kid']) && isset($kids[$_POST['kid']])) {
    // Parents are either not coming, or have selected at least one availability
    if ((!empty($_POST['availabilities']) || (!empty($_POST['not-coming']) && $_POST['not-coming'] === '1'))) {
        // Kid cannot have availabilties saved already
        if (!hasAvailabilitiesSaved($_POST['kid'], $availabilities)) {
            $stm = $db->prepare('INSERT INTO Moments VALUES (:k, :a, :n, :c)');
            $stm->bindValue(':k', $_POST['kid'], SQLITE3_TEXT);
            $stm->bindValue(':a', (empty($_POST['availabilities']) ? "" : implode(",", $_POST['availabilities'])), SQLITE3_TEXT);
            $stm->bindValue(':n', $_POST['note'] ?? "", SQLITE3_TEXT);
            $stm->bindValue(':c', ((!empty($_POST['not-coming']) && $_POST['not-coming'] === '1') ? 0 : 1), SQLITE3_INTEGER);
            $res = $stm->execute();
            $justsaved = true;
        }
    } else {
        echo 'Kid selected but no input';
    }
}

?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oudercontact</title>
	<link href="https://fonts.googleapis.com/css2?family=Bitter:wght@300;600&display=swap" rel="stylesheet">
    <style>
        :root {
            --main-color: #0481ED;
            --light-bg: #d5e4f1;
            --light-text: #4499e2;
        }
        * {
            background: none repeat scroll 0 0 transparent;
            border: medium none;
            border-spacing: 0;
            margin: 0;
            padding: 0;
            text-align: left;
            text-decoration: none;
            text-indent: 0;
        }
        p {
            margin: 20px 0;
            color: var(--main-color);
        }
        .thanks {
            font-size: 24px;
            margin: 50px 0;
        }
        html, body {
            width: 100%;
            height: 100%;
            background: #F2F2F2;
            color: var(--main-color);
            font-family: "Bitter", "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-weight: 300;
        }
        .container {
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .extra-shadow {
            border-radius: 15px;
            box-shadow: 0px 3px 40px rgba(0, 0, 0, 0.05);
        }
        .content {
            position: relative;
            border-radius: 15px;
            box-shadow: 0px 3px 6px rgba(0, 0, 0, 0.05);
            width: 700px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            padding: 0 30px;
            padding-bottom: 10px;
            box-sizing: border-box;
        }
        .content:before {
            display: block;
            margin-left: -30px;
            position: absolute;
            content: '';
            width: 100%;
            height: 16px;
            background: var(--main-color);
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
        }
        h1 {
            margin-top: 48px;
            font-size: 48px;
            font-weight: 600;
        }
        b {
            font-weight: 600;
        }
        .select-dropdown {
			cursor: pointer;
            margin-bottom: 20px;
            position: relative;
            background-color: var(--light-bg);
            width: auto;
            float: left;
            max-width: 100%;
            border-radius: 2px;
        }
        .select-dropdown select {
			cursor: pointer;
            font-family: "Bitter", "Helvetica Neue", Helvetica, Arial, sans-serif;
            color: var(--main-color);
            font-size: 1rem;
            font-weight: 600;
            max-width: 100%;
            padding: 8px 24px 8px 10px;
            border: none;
            background-color: transparent;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
        }
        .select-dropdown select:active, .select-dropdown select:focus {
            outline: none;
            box-shadow: none;
        }
        .select-dropdown:after {
            content: " ";
            position: absolute;
            top: 50%;
            margin-top: -2px;
            right: 8px;
            width: 0;
            height: 0;
            border-left: 5px solid transparent;
            border-right: 5px solid transparent;
            border-top: 5px solid var(--main-color);
        }

        .moment-selection {
            position: relative;
            display: flex;
            width: 100%;
            flex-wrap: wrap;
            justify-content: space-between;
        }

        input[type="checkbox"] {
            position: absolute;
            margin-left: -9999px;
        }

        .moment-selection input[type="checkbox"]:checked + .moment, input[type="checkbox"]:checked + .moment-selection.coming .moment {
            background: var(--light-bg);
            color: var(--main-color);
            font-weight: 600;
        }

        #not-coming:checked ~ .availabilities {
            display: none;
        }

        .moment-selection .checkbox-container {
            width: 49.5%;
            position: relative;
        }

        .moment-selection.coming .checkbox-container {
            width: 100%;
        }
		
		.moment-selection .checkbox-container:first-of-type .moment {
			border-top-left-radius: 7px;
        }
		.moment-selection .checkbox-container:nth-of-type(2) .moment {
			border-top-right-radius: 7px;
        }
		.moment-selection .checkbox-container:nth-last-of-type(2) .moment {
			border-bottom-left-radius: 7px;
        }
		.moment-selection .checkbox-container:last-of-type .moment {
			border-bottom-right-radius: 7px;
        }

        .moment-selection.coming .checkbox-container .moment {
            border-radius: 7px;
        }

        .moment-selection .moment {
            user-select: none;
            width: 100%;
            margin: 3px 0;
            height: 40px;
            border: 2px solid var(--light-bg);
            box-sizing: border-box;
            cursor: pointer;
            color: var(--light-text);
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .moment-selection .moment.selected {
            background: var(--light-bg);
            color: var(--main-color);
            font-weight: 600;
        }
		
		.moment:hover {
			background: var(--light-bg);
		}

        .button-container {
            margin: 30px 0;
            display: flex;
            justify-content: flex-end;
            width: 100%;
        }

        .button-container button {
            font-family: "Bitter", "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-size: 20px;
            border-radius: 7px;
            background: var(--main-color);
            padding: 10px 30px;
            box-sizing: border-box;
            font-weight: 600;
            color: white;
            border: none;
            cursor: pointer;
        }

        #realsave {
            display: none;
            --main-color: #ed0404;
        }

        textarea {
            font-family: "Bitter", "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-size: 16px;
            width: 100%;
            border: 2px solid var(--light-bg);
            box-sizing: border-box;
            border-radius: 7px;
            color: var(--main-color);
            padding: 10px 20px;
            resize: none;
        }

        textarea::placeholder {
            font-family: "Bitter", "Helvetica Neue", Helvetica, Arial, sans-serif;
            font-size: 16px;
            color: var(--light-text);

        }

        input:focus, textarea:focus, select:focus{
            outline: none;
            border: 2px solid var(--main-color);
        }

        @media screen and (max-width: 699px) {
            .container {
                justify-content: flex-start;
                align-items: flex-start;
            }
            .extra-shadow, .content, .content::before {
                border-radius: 0;
            }
            .content {
                width: auto;
            }
        }

        @media screen and (max-width: 500px) {
            .moment-selection {
                flex-direction: column;
            }
            .moment-selection .checkbox-container {
                width: 100%;
            }
			.moment-selection .checkbox-container:first-of-type .moment {
				border-top-left-radius: 7px;
				border-top-right-radius: 7px;
			}
			.moment-selection .checkbox-container:nth-of-type(2) .moment {
				border-top-right-radius: 0;
			}
			.moment-selection .checkbox-container:nth-last-of-type(2) .moment {
				border-bottom-left-radius: 0;
			}
			.moment-selection .checkbox-container:last-of-type .moment {
				border-bottom-right-radius: 7px;
				border-bottom-left-radius: 7px;
			}
        }

    </style>
</head>
<body>

    <div class="container">
        <div class="extra-shadow">
            <form class="content" action="?" method="post">
                <h1>Online Oudercontact</h1>
                <?php if ($justsaved) { ?>
                <p class="thanks"><b>Bedankt!</b> Je beschikbaarheden zijn opgeslagen. De juf gaat nu een planning maken, en laat zo snel mogelijk per <b>e-mail</b> weten wanneer jij aan de beurt bent. Je ontvangt tegelijk de link naar de online omgeving waarin het gesprek plaatsvindt.</p>
                <?php } else { ?>
                <p>Duid hier graag <b>alle momenten</b> aan waarop je aanwezig zou kunnen zijn op het oudercontact.
                De juf zal op basis van alle antwoorden een planning opstellen,
                en je per mail laten weten op welk specifiek moment je aan de beurt bent.</p>

                <p style="width: 100%;">Ik ben een ouder of voogd van:</p>
                <div class="select-dropdown">
                    <select required name="kid">
                        <option value="" selected disabled>Duid aan</option>
                        <?php foreach ($kids as $number => $name) {
                        if (!hasAvailabilitiesSaved($number, $availabilities)) {    
                        ?>
                        <option value="<?= $number ?>"><?= $name ?></option>
                        <?php }} ?>
                    </select>
                </div>

                <p>Als je niet kunt of wilt komen naar het oudercontact, klik je op deze knop:</p>

                <input type="checkbox" name="not-coming" value="1" id="not-coming">
                <div class="moment-selection coming">
                    <div class="checkbox-container">
                        <label for="not-coming" class="moment">Ik zal niet aanwezig zijn op het oudercontact</label>
                    </div>
                </div>

                <div class="availabilities">
                    <p>Ik kan op al deze momenten <b>(duid zoveel mogelijk opties aan)</b>:</p>

                    <div class="moment-selection">
                        <?php foreach ($moments as $code => $readable) { ?>
                            <div class="checkbox-container">
                                <input type="checkbox" name="availabilities[]" value="<?= $code ?>" id="<?= $code ?>">
                                <label for="<?= $code ?>" class="moment"><?= $readable ?></label>
                            </div>
                        <?php } ?>
                    </div>
                </div>

                <p>Wil je nog iets extra melden of vragen? Laat het hier onder weten aan de juf.</p>
                <textarea name="note" id="note" placeholder="Typ hier je vraag of opmerking ..." rows="4"></textarea>

                <div class="button-container" id="fakesave"><button type="submit" onclick="confirmSave(event)">Opslaan</button></div>
                
                <div id="realsave">
                    <p>Heb je zeker <b>alle beschikbare momenten</b> aangeduid? Als je er nog extra wilt aanduiden, kun je dat nu doen. Als je helemaal zeker bent, klik je nogmaals op 'Opslaan'.</p>
                    <div class="button-container"><button type="submit">Opslaan</button></div>
                </div>
                <?php } ?>
            </form>
        </div>
    </div>

<script>
function confirmSave(e) {
    e.preventDefault();
    document.getElementById('fakesave').style.display = "none";
    document.getElementById('realsave').style.display = "block";
}
</script>
</body>
</html>