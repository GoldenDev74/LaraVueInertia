<script setup>
import { Link } from '@inertiajs/vue3'

</script>


<template>
    <nav class="flex justify-between p-4 bg-gray-200">
        <div class="text-lg">
            NavBar
        </div>
        <div>
            <ul class="flex gap-x-4 me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <Link :href="route('myhome')" class="text-gray-700 hover:text-gray-900">Home</Link>
                </li>
                <li class="nav-item">
                    <Link :href="route('myabout')" class="text-gray-700 hover:text-gray-900">About</Link>
                </li>
                <li class="nav-item">
                    <Link :href="route('mycontact')" class="text-gray-700 hover:text-gray-900">Contact</Link>
                </li>
            </ul>
        </div>
    </nav>
</template>