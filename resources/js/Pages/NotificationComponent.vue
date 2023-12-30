<script >

import {defineComponent} from "vue";
import VFooter from "@/Components/Footer.vue";
import GrayButton from "@/Components/GrayButton.vue";
import {Link} from "@inertiajs/vue3";

export default defineComponent({
    components: {Link, GrayButton, VFooter}
})
</script>

<template>
    
    <v-header />
    <div style="margin-top: 70vh;">
        <div class="bottom-0">
            <Link :href="route('app')">
                <gray-button style="height:50px" @click="callPhoneButton">Вернуться назад</gray-button>
            </Link>
            <v-footer/>
        </div>
    </div>
</template>

<style scoped>

</style>
