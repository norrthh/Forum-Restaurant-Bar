<script setup>
    import {Link} from "@inertiajs/vue3";
</script>

<template>
    <div class="flex items-center">
        <img class="logoProfile" src="/image/logo.png" alt="">
        <h1 class="titleProfile">ROOM SERVICE</h1>
        <div class="ml-auto">
            <Link :href="route('notification')">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <g clip-path="url(#clip0_113_77)">
                        <path
                            d="M18 8C18 6.4087 17.3679 4.88258 16.2426 3.75736C15.1174 2.63214 13.5913 2 12 2C10.4087 2 8.88258 2.63214 7.75736 3.75736C6.63214 4.88258 6 6.4087 6 8C6 15 3 17 3 17H21C21 17 18 15 18 8Z"
                            stroke="#333333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        <circle cx="18" cy="3" r="4" fill="#F2968F" stroke="#FCFCFC" stroke-width="2"/>
                        <path
                            d="M13.73 21C13.5542 21.3031 13.3019 21.5547 12.9982 21.7295C12.6946 21.9044 12.3504 21.9965 12 21.9965C11.6496 21.9965 11.3054 21.9044 11.0018 21.7295C10.6982 21.5547 10.4458 21.3031 10.27 21"
                            stroke="#333333" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </g>
                    <defs>
                        <clipPath id="clip0_113_77">
                            <rect width="24" height="24" fill="white"/>
                        </clipPath>
                    </defs>
                </svg>
            </Link>
        </div>
    </div>
</template>

<style scoped>
.logoProfile {
    width: 31.999px;
    height: 31.999px;
}

.titleProfile {
    color: #333;
    font-size: 23px;
    font-weight: 800;
    margin-left: 10px;
}
</style>
