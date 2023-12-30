<script setup>
import DisableButton from "@/Components/DisableButton.vue";
import GrayButton from "@/Components/GrayButton.vue";
import axios from 'axios';
import {ref} from "vue";
import {Link} from "@inertiajs/vue3";
import VFooter from "@/Components/Footer.vue";
import {Modal} from "flowbite";

let categories = ref([]),
    foods = ref([]),
    list = ref([]),
    selectedItems = ref([]),
    button = ref('Все'),
    storage = ref()

function fetchData() {
    axios.get('/api/v1/category')
        .then(res => {
            categories.value = res.data
        })
}

function getFood() {
    axios.get('/api/v1/food')
        .then(res => {
            foods.value = res.data
        })
}

function getItemStorage() {
    if (JSON.parse(localStorage.getItem('foods'))) {
        storage.value = JSON.parse(localStorage.getItem('foods'))['_value']
        storage.value.forEach(object => {
            console.log(object)
            ListFood(object)
        })
    }
}

function ListFood(foodId) {
    if (selectedItems.value.find(item => item.id === foodId.id)) {
        selectedItems.value = selectedItems.value.filter(id => id !== foodId);
    } else {
        selectedItems.value.push(foodId);
    }

    localStorage.setItem('foods', JSON.stringify(selectedItems));
}

function changeButton(buttonName, type) {
    button.value = buttonName

    if (type !== 0) {
        axios.get('/api/v1/food/filter?type=' + type).then(res => {
            foods.value = res.data
        })
        return 0;
    } else {
        getFood()
    }
}

let modalContent = ref({})

function getInfo(object) {
    modalContent.value = object

    const foodCreate = new Modal(document.getElementById('defaultModal'), {
        backdrop: 'dynamic',
        closable: true,
    });

    foodCreate.show()
}

function closeModal() {
    const foodCreate = new Modal(document.getElementById('defaultModal'), {
        backdrop: 'dynamic',
        closable: true,
    });

    foodCreate.hide()

    let backdropElement = document.querySelector('[modal-backdrop]');
    backdropElement.parentNode.removeChild(backdropElement);
}

let selectCategory = () => {
    const foodCreate = new Modal(document.getElementById('selectCategory'), {
        backdrop: 'dynamic',
        closable: true,
    });

    foodCreate.show()
}

let closeSelectCategory = () => {
    const foodCreate = new Modal(document.getElementById('selectCategory'), {
        backdrop: 'dynamic',
        closable: true,
    });

    foodCreate.hide()

    let backdropElement = document.querySelector('[modal-backdrop]');
    backdropElement.parentNode.removeChild(backdropElement);
}

fetchData()
getFood()
getItemStorage()
</script>

<template>
    <v-header/>

    <div class="type flex-row">
        <!-- <button :class="{active: button === 'Все'}"  @click="selectCategory" class="flex gap-2 items-center"> -->
            <!-- <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg"> -->
                <!-- <circle cx="16" cy="16" r="16" fill="#DFE1E8"/> -->
            <!-- </svg> -->

            <!-- Выбрать категорию -->
        <!-- </button> -->
        <button :class="{active: button === 'Все'}"  @click="changeButton('Все', 0)" class="flex gap-2 items-center mb-2">
            <img src="/image/-1.png" style="border-radius: 1.5rem; width: 40px; height: 40px">

                        Все
                    </button>
                    <button v-for="category in categories"  :class="{active: button === category.name}"
                            class="flex items-center gap-2 mb-2"
                            @click="changeButton(category.name, category.id)">
<!--                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">-->
<!--                            <circle cx="16" cy="16" r="16" fill="#DFE1E8"/>-->
<!--                        </svg>-->

                        <img :src="category.image" style="border-radius: 1.5rem; width: 40px; height: 40px">

                        {{ category.name }}
                    </button>
<!--        <button :class="{active: button === 'Все'}"  @click="changeButton('Все', 0)" class="flex gap-2 items-center">-->
<!--            <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">-->
<!--                <circle cx="16" cy="16" r="16" fill="#DFE1E8"/>-->
<!--            </svg>-->

<!--            Выбрать категорию-->
<!--        </button>-->
<!--        <button v-for="category in categories"  :class="{active: button === category.name}"-->
<!--                class="flex items-center gap-2"-->
<!--                @click="changeButton(category.name, category.id)">-->
<!--                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">-->
<!--                    <circle cx="16" cy="16" r="16" fill="#DFE1E8"/>-->
<!--                </svg>-->

<!--                <p>{{ category.name }}</p>-->
<!--        </button>-->
    </div>
    <div class="product">
        <div class="product__content mt-2" v-for="food in foods" @click="getInfo(food)">
            <div>
                <h1>{{ food.name }}</h1>
                <p>{{ food.description }} ({{ food.price }}₽)</p>
            </div>

            <button @click="ListFood(food)">
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="26"
                     viewBox="0 0 25 26" fill="none" v-if="!selectedItems.find(item => item.id === food.id)">
                    <path d="M13.2083 18.1131V7.27979" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                    <path d="M8 12.6968H18.4167" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="26"
                     viewBox="0 0 25 26" fill="none" v-else>
                    <path fill-rule="evenodd" clip-rule="evenodd"
                          d="M18.7815 8.63397C19.0866 8.95127 19.0866 9.46572 18.7815 9.78302L11.4898 17.3663C11.1847 17.6836 10.6901 17.6836 10.385 17.3663L6.21832 13.033C5.91323 12.7157 5.91323 12.2013 6.21832 11.884C6.52342 11.5667 7.01808 11.5667 7.32318 11.884L10.9374 15.6427L17.6767 8.63397C17.9818 8.31667 18.4764 8.31667 18.7815 8.63397Z"
                          fill="white"/>
                </svg>
            </button>
        </div>
    </div>

    <div>
        <div class="purchases">
            <disable-button v-if="selectedItems.length === 0">Перейти в корзину</disable-button>

            <Link :href="route('order')" v-else>
                <gray-button>Перейти в корзину</gray-button>
            </Link>
        </div>

        <v-footer/>
    </div>

    <div id="defaultModal" tabindex="-1" aria-hidden="true" style="width: 339px; margin: auto"
         class="fixed top-0 modal left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-xl shadow dark:bg-gray-700">
                <!-- Modal header -->
                <!--                <img :src="modalContent.file" alt="" class="w-full h-[339px] rounded-xl">-->

                <div :style="{ 'background-image': `url('${modalContent.file}')` }" class="w-full h-[339px] rounded-xl">
                    <button style="padding: 15px;" class="absolute right-0" @click="closeModal">
                        <svg width="35" height="35" viewBox="0 0 35 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g opacity="0.5">
                                <path
                                    d="M0 17.5C0 7.83502 7.83502 0 17.5 0C27.165 0 35 7.83502 35 17.5C35 27.165 27.165 35 17.5 35C7.83502 35 0 27.165 0 17.5Z"
                                    fill="white"/>
                            </g>
                            <path d="M13.8171 21.183L21.1828 13.8174" stroke="#333333" stroke-width="1.5"
                                  stroke-linecap="round"/>
                            <path d="M13.8171 13.8174L21.1828 21.183" stroke="#333333" stroke-width="1.5"
                                  stroke-linecap="round"/>
                        </svg>

                    </button>
                </div>
                <h1 style="padding-top:10px">{{ modalContent.name }}</h1>
                <p style="padding-bottom: 10px; padding-top: 4px">{{ modalContent.description }}</p>
            </div>
        </div>
    </div>

    <div id="selectCategory" tabindex="-1" aria-hidden="true" style="width: 350px; margin: auto"
         class="fixed top-0 modal left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-xl shadow dark:bg-gray-700">
                <div class="w-full rounded-xl">
                    <button style="padding: 15px;" class="absolute right-0" @click="closeSelectCategory">
                        <svg width="35" height="35" viewBox="0 0 35 35" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <g opacity="0.5">
                                <path
                                    d="M0 17.5C0 7.83502 7.83502 0 17.5 0C27.165 0 35 7.83502 35 17.5C35 27.165 27.165 35 17.5 35C7.83502 35 0 27.165 0 17.5Z"
                                    fill="white"/>
                            </g>
                            <path d="M13.8171 21.183L21.1828 13.8174" stroke="#333333" stroke-width="1.5"
                                  stroke-linecap="round"/>
                            <path d="M13.8171 13.8174L21.1828 21.183" stroke="#333333" stroke-width="1.5"
                                  stroke-linecap="round"/>
                        </svg>
                    </button>
                </div>

                <div class="p-4 mt-2 category">
                    <button :class="{active: button === 'Все'}"  @click="changeButton('Все', 0)" class="flex gap-2 items-center mb-2">
                        <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="16" cy="16" r="16" fill="#DFE1E8"/>
                        </svg>

                        Все
                    </button>
                    <button v-for="category in categories"  :class="{active: button === category.name}"
                            class="flex items-center gap-2 mb-2"
                            @click="changeButton(category.name, category.id)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                            <circle cx="16" cy="16" r="16" fill="#DFE1E8"/>
                        </svg>

                        {{ category.name }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped lang="less">
.modal {
    text-align: center;

    h1 {
        color: var(--Dark, #333);
        text-align: center;
        font-size: 15px;
        font-weight: 700;
    }

    p {
        color: var(--Dark, #333);
        text-align: center;
        font-size: 12px;
        font-style: normal;
        font-weight: 500;
        opacity: 0.5;
    }
}

.type {
    margin-top: 10px;
    display: -webkit-box;
    gap: 10px;
    overflow-y: auto;
}

.type::-webkit-scrollbar {
    width: 0;
}

.disable {
    color: rgba(51, 51, 51, 0.40);
}

.active {
    border: 1px solid #DFE1E8;
    background: #B8AFA9;
    color: #fff;
}

#selectCategory .category button, .type button {
    padding: 10px 24px 10px 10px;
    border-radius: 100px;
    font-weight: 500;
    font-size: 16px;
    line-height: 150%;
    border: 1px solid #DFE1E8;
}

.purchases {
    padding: 18px;
    bottom: 40px;
    width: 100%;
    background: white
}


.disabledButton {
    border: 1px solid #DFE1E8 !important;
    opacity: 0.5 !important;
    color: black !important;
    background: none !important;
}

.productOrder {
    height: 72% !important;
}

.order {
    box-shadow: 0px 4px 16px 0px rgba(0, 21, 52, 0.06);
    border-radius: 16px;
    text-align: center;
    padding: 8px 10px;
}

.order .order_info, .order_price {
    font-size: 15px;
    font-weight: 700;
    color: #333;
}

.order .order_alert {
    font-size: 12px;
    font-weight: 500;
    color: #333;
    opacity: 0.5;
}


</style>
