# Parent-teacher night

A tool designed for my mom, a primary school teacher, to quickly and easily gather all availabilities of parents to create an optimal planning for the parent-teacher night.

## Requirements

- PHP server (pref Apache)
- SQLite3

## Setup

- Deploy all files to a PHP webserver.
- Edit `settings.php` to suit your needs.
- Optionally, create a .htpasswd to restrict access to `overview.php`, as all responses will be visible here
- Create an SQLite3 database called `"db.sqlite"` (or another name, if you change the db name in `settings.php`).
- Create one table in the database:

```SQL
CREATE TABLE Moments
(Kid INT PRIMARY KEY NOT NULL,
Moments TEXT NOT NULL);
```

## Usage

- Parents fill in the form, indicating at which times they would be available
  - Once saved, the kid's name will dissapear from the list (to prevent duplicate responses)
  - Confirmation of saving is required, to make sure parents have selected all possible availablities
- Teachers can view reponses at `/overview` (or `/overview.php` if not served form Apache)

## Management

To truncate (clear) the database, run `sqlite3 db.sqlite` again and execute the following query:

```SQL
DELETE FROM Moments;
```

## Notes

All names in this repository are fake names generated with [name-generator](https://www.name-generator.org.uk/).
