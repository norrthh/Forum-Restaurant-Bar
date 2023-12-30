<script>

import {defineComponent} from "vue";
import DisableButton from "@/Components/DisableButton.vue";
import GrayButton from "@/Components/GrayButton.vue";
import {Link} from "@inertiajs/vue3";

export default defineComponent({
    components: {DisableButton, GrayButton, Link},
    methods: {
        handleButton(button) {
            this.activeButton = button
        },
        saveData() {
            localStorage.setItem('typeApp', this.activeButton)
        }
    },
    data() {
        return {
            activeButton: null
        }
    },
    beforeUnmount() {
        localStorage.setItem('typeApp', this.activeButton)
    }
})
</script>

<template>
    <img src="/image/logo.png" alt="" class="logoAuth">

    <div class="content">
        <div class="textBlock">
            <p class="textAuth">Пожалуйста, выберете отель в котором вы проживаете, для выбора используйте кнопки ниже.</p>
        </div>

        <div class="flex gap-2 items-center mt-4">
            <component @click="handleButton(1)" :is="activeButton === 1 ? 'gray-button' : 'disable-button'">Памир</component>
            <component @click="handleButton(2)" :is="activeButton === 2 ? 'gray-button' : 'disable-button'">Тянь-Шань</component>
        </div>

        <gray-button v-if="!activeButton" :disabled="!activeButton">Продолжить</gray-button>

        <Link :href="route('location') + `?number=` + activeButton" @click="saveData" v-else>
            <gray-button>Продолжить</gray-button>
        </Link>
    </div>
</template>

<style>

</style>
