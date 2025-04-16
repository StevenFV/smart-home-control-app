<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines are used during authentication for various
    | messages that we need to display to the user. You are free to modify
    | these language lines according to your application's requirements.
    |
    */

    'failed' => 'These credentials do not match our records.',
    'password' => 'The provided password is incorrect.',
    'throttle' => 'Too many login attempts. Please try again in :seconds seconds.',
    'forgot_password' => [
        'procedure_message' => "Vous avez oublié votre mot de passe? Pas de problème. Indiquez-nous simplement votre
                            adresse e-mail et nous vous enverrons un lien de réinitialisation qui vous permettra d'en
                            choisir un nouveau.",
        'email' => 'Courriel',
        'email_password_reset_link' => 'Lien de réinitialisation du mot de passe',
    ],
    'login' => [
        'email' => 'Courriel',
        'password' => 'Mot de passe',
        'remember_me' => 'Se souvenir de moi',
        'forgot_password' => 'Mot de passe oublié?',
    ],
    'register' => [
        'name' => 'Nom',
        'email' => 'Courriel',
        'password' => 'Mot de passe',
        'password_confirmation' => 'Confirmez le mot de passe',
        'already_registered' => 'Déjà enregistré?',
        'register' => "S'inscrire",
    ],
];
