<script setup>
import AuthenticationCardLogoUrl from '../../images/authentication-card-logo.svg'
import {Link} from '@inertiajs/vue3';
</script>

<template>
    <Link :href="'/'">
        <img :src="AuthenticationCardLogoUrl"
             alt="Authentication Card Logo"
             class="block h-48 w-auto"
        >
    </Link>
</template>
