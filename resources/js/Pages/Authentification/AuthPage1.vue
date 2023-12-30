<script>

import GrayButton from "@/Components/GrayButton.vue";
import {defineComponent} from "vue";
import DangerButton from "@/Components/DangerButton.vue";
import {Modal} from 'flowbite'
import { Head, Link } from '@inertiajs/vue3';

export default defineComponent({
    components: {DangerButton, GrayButton, Link},
    methods: {
          callPhoneButton() {
              const $targetEl = document.getElementById('modalEl');

              const options = {
                  backdrop: 'dynamic',
                  backdropClasses: 'bg-gray-900 bg-opacity-50 dark:bg-opacity-80 fixed inset-0 z-40',
                  closable: true,
              };

              const modal = new Modal($targetEl, options);

              modal.show()
          }
    },
})
</script>

<template>
    <img src="/image/logo.png" alt="" class="logoAuth">

    <div class="content">
        <div class="textBlock">
            <p class="textAuth">(Выберите способ заказа)</p>
        </div>
    </div>

    <Link :href="route('app')">
        <gray-button>Приложение</gray-button>
    </Link>

    <a href="tel:+79651507772"><gray-button>Позвонить</gray-button></a>

<!--    @click="callPhoneButton"-->
    <div id="modalEl" tabindex="-1" aria-hidden="true" class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-lg max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">

                <div class="p-6 space-y-6">
                   <div class="shadowBlock">
                       <p>Введите номер телефона</p>
                   </div>

                    <input type="text" class="inputModal" placeholder="+7 (000) 000-00-00">
                    <gray-button>Отправить</gray-button>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
    .content {
        margin-top: 1rem;
        margin-bottom: 1rem;
    }
</style>
