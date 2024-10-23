<?php

return [
    'model_not_found' => ':model sa ID-jem :id nije pronađen.',
    'initial_password_must_be_changed' => 'Prvo morate promeniti početnu lozinku da biste mogli koristiti aplikaciju.',

    'pagination' => [
        'invalid_page_number' => 'Broj stranice koji ste uneli je invalidan.',
        'page_not_found' => 'Stranica nije pronađena',
    ],

    'users' => [
        'model_name' => 'Korisnik',

        'details_successful_update' => 'Korisnički detalji uspešno izmenjeni.',
        'details_failed_update' => 'Izmena korisničkih podataka neuspešna! Molimo Vas, pokušajte opet.',

        'find_success' => '{1} :count korisnik pronađen.|[2,*] :count korisnika pronađeno.',
        'find_fail' => 'Nije pronađen nijedan korisnik sa ovakvim kriterijumima pretrage.',

        'get' => 'Korisnik uspešno pronađen.',
    ],

    'jobs' => [
        'model_name' => 'Posao',

        'unauthorized' => 'Nemata prava da vršite operacije nad ovim poslom.',

        'successful_create' => 'Uspešno napravljen novi posao.',
        'successful_update' => 'Uspešno izmenjen posao.',
        'successful_delete' => 'Uspešno izbrisan posao.',

        'failed_update' => 'Neuspešna izmena posla! Molimo Vas, pokušajte ponovo.',
        'failed_delete' => 'Neuspešno brisanje posla.',
    ],

    'posts' => [
        'model_name' => 'Objava',

        'unauthorized' => 'Nemate prava da vršite operacije nad ovom objavom.',

        'successful_create' => 'Uspešno napravljena nova objava.',
        'successful_update' => 'Uspešno izmenjena objava.',
        'successful_delete' => 'Uspešno obrisana objava.',

        'failed_update' => 'Neuspešna izmena objave! Molimo Vas, pokušajte ponovo.',
        'failed_delete' => 'Neuspešno brisanje objave! Molimo Vas, pokušajte ponovo.',
    ],

    // For blade pages
    'dashboard' => [
        'overview' => 'Pregled',
        'users' => 'Korisnici',
        'logout' => 'Izloguj se',
    ],
];
