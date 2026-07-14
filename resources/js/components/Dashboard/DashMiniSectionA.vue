<script lang="ts" setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <Link href="#">
        <div class="stats grid items-center pt-3 shadow">
            <div class="stat place-items-center">
                <div class="stat-title">Messages</div>
                <div class="stat-value">14</div>
                <div class="stat-desc">unread messages in your inbox</div>
            </div>
        </div>
    </Link>
</template>

<style scoped></style>
