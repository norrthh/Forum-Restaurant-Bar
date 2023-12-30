<script setup>

import VFooter from "@/Components/Footer.vue";
import GrayButton from "@/Components/GrayButton.vue";
import {Link} from "@inertiajs/vue3";

defineProps({
    prev: {
        type: String,
    },
});
</script>

<template>
    <v-header></v-header>

    <div class="blockInfo">
        <h1>
            Добро пожаловать в раздел помощи room-service от Ресторана Forum.
            Мы готовы помочь вам с любым вопросом, чтобы ваше посещение было максимально комфортным и приятным.
            Пожалуйста, выберите удобный тип связи из предложенных ниже.
            Спасибо!
        </h1>
<!--        <p>(Для связи используйте кнопки ниже)</p>-->
    </div>

    <div class="flex gap-10" style="margin-top: 10px">
        <a href="https://t.me/79651507772" class="w-full">
            <gray-button>Telegram</gray-button>
        </a>
        <a href="https://wa.me/79651507772" class="w-full">
            <gray-button>WhatsApp</gray-button>
        </a>
    </div>
    <a href="tel:+79651507772">
        <gray-button style="margin-top: 10px">Позвонить</gray-button>
    </a>


    <div class="blockInfo">
        <p>(Если вам удобнее общаться голосом, пожалуйста, свяжитесь с нами по номеру)</p>
    </div>


    <div class="absolute bottom-0 w-[98%]">
        <Link :href="prev">
            <gray-button style="height:50px" @click="callPhoneButton">Вернуться назад</gray-button>
        </Link>
        <v-footer/>
    </div>
</template>

<style scoped lang="less">
    .blockInfo {
        border-radius: 16px;
        background: #FFF;
        box-shadow: 0px 4px 16px 0px rgba(0, 21, 52, 0.06);
        width: 100%;
        padding: 10px;
        text-align: center;
        color: #333;
        margin-top: 20px;
        h1 {
            font-size: 15px;
            font-weight: 700;
            line-height: 120%; /* 18px */
        }
        p {
            opacity: 0.5;
            font-size: 12px;
            font-style: normal;
            font-weight: 500;
            line-height: 120%;
        }
    }
</style>
