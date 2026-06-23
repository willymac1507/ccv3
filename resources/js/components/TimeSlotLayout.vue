<script setup lang="ts"></script>

<template>
    <div class="grid grid-cols-7 grid-rows-9 gap-2">
        <div class="col-span-2 col-start-2 text-center">Week 1</div>
        <div class="col-span-2 text-center">Week 2</div>
        <div class="col-span-2 text-center">Week 3</div>
        <div class="col-start-2 text-center">AM</div>
        <div class="text-center">PM</div>
        <div class="text-center">AM</div>
        <div class="text-center">PM</div>
        <div class="text-center">AM</div>
        <div class="text-center">PM</div>
        <div>Mon</div>
        <slot name="monday" class="justify-items-center"/>
        <div>Tue</div>
        <slot name="tuesday" />
        <div>Wed</div>
        <slot name="wednesday" />
        <div>Thu</div>
        <slot name="thursday" />
        <div>Fri</div>
        <slot name="friday" />
        <div>Sat</div>
        <slot name="saturday" />
        <div>Sun</div>
        <slot name="sunday" />
    </div>
</template>
