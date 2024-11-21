<script setup>
import AuthentificationCardLogoUrl from '../../images/authentification-card-logo.svg'
import {Link} from '@inertiajs/vue3';
</script>

<template>
    <Link :href="'/'">
        <img :src="AuthentificationCardLogoUrl"
             alt="Authentification Card Logo"
             class="block h-48 w-auto"
        >
    </Link>
</template>
