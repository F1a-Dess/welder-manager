<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <nav class="flex justify-between p-4 bg-gray-200">
        <div class="text-lg">
            WSM
        </div>
        <div>
            <ul class="flex gap-x-4 me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <link class="text-dark" :href="route('home')">Home</link>
                </li>
                <li class="nav-item">
                    <link class="text-dark" :href="route('aboutUs')">About Us</link>
                </li>
                <li class="nav-item">
                    <link class="text-dark" :href="route('contact')">Contact</link>
                </li>
            </ul>
        </div>
        
    </nav>
</template>


