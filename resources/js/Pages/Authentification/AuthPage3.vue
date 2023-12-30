<script setup>

import GrayButton from "@/Components/GrayButton.vue";
import {onBeforeUnmount, onMounted, ref} from "vue";
import {Link} from "@inertiajs/vue3";


onBeforeUnmount(() => {
    localStorage.setItem('Number', activeNumber.value.toString());
})

const numbers = Array.from({ length: (localStorage.getItem('typeApp') === '1' ? 123 : 125) }, (_, i) => i + 1);
const activeNumber = ref(null);
const scrollWrapper = ref(null);

onMounted(() => {
    activeNumber.value = 1
});

const checkScroll = (event) => {
    const element = event.target;
    const listItems = element.querySelectorAll('li');
    const center = window.innerWidth / 2;

    listItems.forEach(item => {
        const rect = item.getBoundingClientRect();
        const elementCenter = rect.left + rect.width / 2;

        if (Math.abs(center - elementCenter) < rect.width / 2) {
            activeNumber.value = parseInt(item.textContent.trim(), 10);
        }
    });
};

const activeButton = (event) => {
    activeNumber.value = event
}

</script>

<template>
    <img src="/image/logo.png" alt="" class="logoAuth">

    <div class="content">
        <div class="textBlock">
            <p class="textAuth">Пожалуйста, укажите номер отеля в котором вы проживаете из предложенных ниже.</p>
        </div>
    </div>

    <div class="wrapper" ref="scrollWrapper" @scroll="checkScroll">
        <ul class="list horizontal-list">
            <li v-for="number in numbers" :key="'left-' + number" :class="{ active: activeNumber === number }" @click="activeButton(number)">{{ number }}</li>
        </ul>
    </div>

    <div class="content">
        <Link :href="route('menu') + `?typeApp=` + typeApp + `&location=` + number">
            <gray-button>Продолжить</gray-button>
        </Link>
    </div>

    <div id="edit" tabindex="-1" aria-hidden="true"
         class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full modal">
        <div class="relative w-full max-w-lg max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="p-6 ">
                    <div class="titleInformation">
                        <h1>Укажите Ваш номер</h1>
                    </div>
                    <input type="text" placeholder="1" v-model="inputAlternative">
                    <button class="numberButton" @click="updateButtonAlternative">Подтвердить</button>
                </div>
            </div>
        </div>
    </div>


</template>

<style scoped lang="less">
.wrapper {
    overflow-y: scroll;
    white-space: nowrap;
}
.list {
    display: flex;
    list-style: none;
    padding: 0;
    margin: 0;
}
.list li {
    padding: 10px 20px;
    transition: background-color 0.3s;
}
.list li:hover, .list li.active {
    background-color: #b8afa9;
    color: #fff;
}

.group {
    width: 100%;
    display: flex;
    height: 70px;

@apply grid-cols-2;

    .decrement {
        transform: rotate(180deg);

        li {
            transform: rotate(180deg);
        }
    }

    ul {
        display: inline-flex;
        overflow-y: auto;

        li {
            margin: 10px;

            button {
                //padding: 10px 14px;
                border-radius: 60px;
                background-color: #dcd7d4;
                color: #fff;
                display: flex;
                width: 100px;
                justify-content: center;
                padding: 10px;

                span {
                    color: #fff;
                    opacity: 1;
                }
            }
        }
    }
}

.selectedButton {
    border-radius: 60px;
    background-color: #B8AFA9;
    color: #fff;
    display: flex;
    width: 100px;
    justify-content: center;
    //padding: 10px;
    height: 44px;
    align-items: center;
    margin-top: 10px;

    span {
        color: #fff;
        opacity: 1;
    }
}
</style>
