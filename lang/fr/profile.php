<?php

return [
    'profile' => 'Profil',
    'profile_information' => [
        'title' => 'Informations sur le profil',
        'description' => "Mettre à jour les informations de profil et l'adresse courriel de votre compte.",
        'select_a_new_photo' => 'Sélectionner une nouvelle photo',
        'remove_photo' => 'Supprimer la photo',
        'name' => 'Nom',
        'email' => 'Courriel',
        'email_verification' => [
            'unverified' => "Votre adresse courriel n'est pas vérifiée.",
            're_send' => 'Cliquez ici pour renvoyer le courriel de vérification.',
            'link' => 'Un nouveau lien de vérification a été envoyé à votre adresse courriel.',
        ],
        'saved.' => 'Enregistré.',
        'save' => 'Enregistrer',
    ],
    'update_password' => [
        'title' => 'Mettre à jour le mot de passe',
        'description' => 'Assurez-vous que votre compte utilise un mot de passe long et aléatoire pour rester sécurisé.',
        'current_password' => 'Mot de passe actuel',
        'new_password' => 'Nouveau mot de passe',
        'confirm_password' => 'Confirmer le mot de passe',
        'saved.' => 'Enregistré.',
        'save' => 'Enregistrer',
    ],
    'two_factor_authentication' => [
        'title' => 'Authentification à deux facteurs',
        'description' => "Ajoutez une sécurité supplémentaire à votre compte en utilisant l'authentification à deux
                          facteurs.",
        'enabled_message' => "Vous avez activé l'authentification à deux facteurs.",
        'finish_enabling' => "Terminer l'activation de l'authentification à deux facteurs.",
        'not_enabled' => "Vous n'avez pas activé l'authentification à deux facteurs.",
        'operation' => "Lorsque l'authentification à deux facteurs est activée, un jeton sécurisé et aléatoire vous sera
                        demandé lors de l'authentification. Vous pouvez récupérer ce jeton à partir de l'application
                        Google Authenticator de votre téléphone.",
        'qr_code_enabling' => "Pour terminer l'activation de l'authentification à deux facteurs, scannez le code QR
                               suivant à l'aide de l'application d'authentification de votre téléphone ou entrez la clé
                               de configuration et fournissez le code OTP généré.",
        'qr_code_enabled' => "L'authentification à deux facteurs est maintenant activée. Scannez le code QR suivant à
                              l'aide de l'application d'authentification de votre téléphone ou entrez la clé de
                              configuration.",
        'setup_key' => 'Clé de configuration:',
        'code' => 'Code',
        'store_code_message' => "Enregistrez ces codes de récupération dans un gestionnaire de mots de passe sécurisé. Ils
                                 peuvent être utilisés pour récupérer l'accès à votre compte si votre dispositif
                                 d'authentification à deux facteurs est perdu.",
        'enable' => 'Activer',
        'confirm' => 'Confirmer',
        'regenerate_recovery_codes' => 'Régénérer les codes de récupération',
        'show_recovery_codes' => 'Afficher les codes de récupération',
        'cancel' => 'Annuler',
        'disable' => 'Désactiver',
    ],
    'browser_sessions' => [
        'title' => 'Sessions de navigation',
        'description' => "Gérez et déconnectez vos sessions actives sur d'autres navigateurs et appareils.",
        'information_text' => 'Si nécessaire, vous pouvez vous déconnecter de toutes vos autres sessions de navigation
                               sur tous vos appareils. Certaines de vos sessions récentes sont listées ci-dessous ;
                               toutefois, cette liste peut ne pas être exhaustive. Si vous pensez que votre compte a été
                               compromis, vous devriez également mettre à jour votre mot de passe.',
        'unknown' => 'Inconnu',
        'this_device' => 'Cet appareil',
        'last_active' => 'Dernier actif',
        'log_out_other_browser_sessions' => 'Se déconnecter des autres sessions de navigation',
        'done' => 'Terminé.',
        'logout_all_devices_message' => 'Veuillez entrer votre mot de passe pour confirmer que vous souhaitez vous
                                         déconnecter de vos autres sessions de navigation sur tous vos appareils.',
        'cancel' => 'Annuler',
    ],
    'delete_account' => [
        'title' => 'Supprimer le compte',
        'description' => 'Supprimez définitivement votre compte.',
        'information_text' => 'Une fois votre compte supprimé, toutes ses ressources et données seront définitivement
                               supprimées. Avant de supprimer votre compte, veuillez télécharger toutes les données ou
                               informations que vous souhaitez conserver.',
        'delete_account' => 'Supprimer le compte',
        'permanently_delete_account_message' => 'Êtes-vous sûr de vouloir supprimer votre compte ? Une fois votre compte
                                                 supprimé, toutes ses ressources et données seront définitivement supprimées.
                                                 Veuillez entrer votre mot de passe pour confirmer que vous souhaitez
                                                 supprimer définitivement votre compte.',
        'cancel' => 'Annuler',
    ],
];
