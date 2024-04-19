<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
    items: Object
})
</script>

<template>
    <div>
        <ul>
            <li v-for="(item, index) in items" :key="index" class="inline-block mr-2">
                <Link
                    v-text="item.title"
                    :href="item.href"
                    :class="{ 'text-white': (index + 1) !== items.length, 'text-gray-500': (index + 1) === items.length }"
                ></Link>
                <span class="pl-3 text-white" v-if="(index + 1) !== items.length">></span>
            </li>
        </ul>
    </div>
</template>

<style scoped>

</style>
