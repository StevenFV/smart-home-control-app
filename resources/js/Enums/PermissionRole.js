export default Object.freeze({

    /*
     * When this enum is modified, the enum "app/Enums/PermissionRole.php"
     * have to be change too for consistance with Laravel.
    */

    ADMIN: 'admin',
    ADMIN_OR_USER: 'role:admin,user',
    GUEST: 'guest',
    USER: 'user',
});
