<script setup>
import {onMounted, ref} from "vue";
import GrayButton from "@/Components/GrayButton.vue";
import {Modal} from "flowbite";
import axios from "axios";


let button = ref(1),
    positionFood = ref(0),
    foods = ref([]),
    buttonFilter = ref(0),
    location = ref(0),
    typeFood = ref(1),
    nameFood = ref(''),
    nameCategory = ref(''),
    priceFood = ref(0),
    alert = ref(),
    file = ref(),
    info = ref(),
    modalData = ref({});


function changeStyleButton(type) {
    button.value = type
    buttonFilter.value = 0
    getFood(type)
}

function changeButtonFilter(type) {
    buttonFilter.value = type
    getFilterData(button.value, type)
}

function getFilterData(timeView, freeze) {
    axios.post('/api/v1/admin/filter', {
        'timeView': timeView,
        'freeze': freeze
    }).then(res => {
        foods.value = res.data
    })
}

function getFood(type) {
    axios.post('/api/v1/admin', {
        'type': type
    }).then(res => {
        positionFood.value = res.data.count
        foods.value = res.data.foods
    })
}

function addFood() {
    const foodCreate = new Modal(document.getElementById('alertPay'), {
        backdrop: 'dynamic',
        closable: true,
    });

    foodCreate.show()
    file.value = '';
}

function removeModalCreate() {
    const foodCreate = new Modal(document.getElementById('alertPay'), {
        backdrop: 'dynamic',
        closable: true,
    });

    foodCreate.hide()

    let backdropElement = document.querySelector('[modal-backdrop]');
    backdropElement.parentNode.removeChild(backdropElement);
}

function addModalCreate() {
    if (nameFood.value !== '' && nameCategory.value !== '') {
        axios.post('/api/v1/food/create', {
            categories_id: typeFood.value,
            name: nameFood.value,
            description: nameCategory.value,
            price: priceFood.value,
            timeView: button.value,
            position: location.value,
            file: file.value,
            info: info.value,
        }).then(res => {
            console.log(res.data)
        })
    } else {
        alert.value = 'Заполните все поля!'
    }
}

function editFood(foodObject) {
    const food = new Modal(document.getElementById('edit'), {
        backdrop: 'dynamic',
        closable: true,
    });

    food.show()
    modalData.value = foodObject
    file.value = ''
}

function closeEditFood() {
    const food = new Modal(document.getElementById('edit'), {
        backdrop: 'dynamic',
        closable: true,
    });

    food.hide()

    let backdropElement = document.querySelector('[modal-backdrop]');
    backdropElement.parentNode.removeChild(backdropElement);
}

function updateEditFoodZ() {

    axios.get('/api/v1/food/update/', {
        params: {
            id: modalData.value.id,
            data: modalData.value,
            file: file.value
        }
    }).then(res => {
        console.log(res.data)
    })
}

const uploadFile = async (event) => {
    const fileZ = event.target.files[0];
    const formData = new FormData();
    formData.append('file', fileZ);

    try {
        axios.post('/upload', formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
            },
        }).then(res => {
            file.value = '/' + res.data.url
        });

        // file.value = response.data.url;
    } catch (error) {
        console.error('Ошибка загрузки файла:', error);
    }
}

onMounted(() => {
    getFood(1)
})

let categories = ref([])
function fetchData() {
    axios.get('/api/v1/category')
        .then(res => {
            categories.value = res.data
        })
}
fetchData()
</script>

<template>
    <div class="flex items-center">
        <img class="logoProfile" src="/image/logo.png" alt="">
        <h1 class="titleProfile">ROOM SERVICE - ADMIN</h1>
        <div class="ml-auto">
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
        </div>
    </div>

    <div class="type">
        <button :class="{active: button === 1}" @click="changeStyleButton(1)">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                <circle cx="16" cy="16" r="16" fill="#DFE1E8"/>
            </svg>
            Дневное меню
        </button>
        <button :class="{active: button === 2}" @click="changeStyleButton(2)">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                <circle cx="16" cy="16" r="16" fill="#DFE1E8"/>
            </svg>
            Ночное меню
        </button>
    </div>
    <div class="titleInformation">
        <h1 v-if="button === 1">Дневное меню</h1>
        <h1 v-else>Ночное меню</h1>
        <p>Позиций: {{ positionFood }}</p>
    </div>

    <div class="product">
        <div class="product__content mt-2" v-for="food in foods">
            <div class="position">
                <p class="text-white" style="opacity: 1">{{ food.position }}</p>
            </div>
            <div>
                <h1>{{ food.name }}</h1>
                <p>{{ food.description }} ({{ food.price }} руб)</p>
            </div>

            <button @click="editFood(food)">
                <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 35 35" fill="none">
                    <path
                        d="M0 17.5C0 7.83502 7.83502 0 17.5 0C27.165 0 35 7.83502 35 17.5C35 27.165 27.165 35 17.5 35C7.83502 35 0 27.165 0 17.5Z"
                        fill="#B8AFA9"/>
                    <path
                        d="M17.7812 10C18.2127 10 18.5625 10.3498 18.5625 10.7813C18.5625 11.2127 18.2127 11.5625 17.7812 11.5625C17.3498 11.5625 17 11.2127 17 10.7813C17 10.3498 17.3498 10 17.7812 10ZM17.7812 16.25C18.2127 16.25 18.5625 16.5998 18.5625 17.0312C18.5625 17.4627 18.2127 17.8125 17.7812 17.8125C17.3498 17.8125 17 17.4627 17 17.0312C17 16.5998 17.3498 16.25 17.7812 16.25ZM17.7812 22.5C18.2127 22.5 18.5625 22.8498 18.5625 23.2812C18.5625 23.7127 18.2127 24.0625 17.7812 24.0625C17.3498 24.0625 17 23.7127 17 23.2812C17 22.8498 17.3498 22.5 17.7812 22.5Z"
                        fill="white" stroke="white" stroke-width="1.5"/>
                </svg>
            </button>
        </div>
    </div>
    <div class="type">
        <button class="w-full text-center" :class="{ active: buttonFilter === 0}" @click="changeButtonFilter(0)"
                style="display: block">Full
        </button>
        <button class="w-full text-center" :class="{ active: buttonFilter === 1}" @click="changeButtonFilter(1)"
                style="display: block">Freeze
        </button>
    </div>

    <gray-button class="mt-4 text-center" @click="addFood()" style="padding: 18px 30px">Добавить позицию</gray-button>

    <div id="alertPay" tabindex="-1" aria-hidden="true"
         class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full modal">
        <div class="relative w-full max-w-lg max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="p-6 ">
                    <div class="titleInformation">
                        <h1>Добавить позицию</h1>
                    </div>
                    <div class="flex gap-4">
                        <button class="numberButton" @click="(location !== 0) ? location-- : 0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="22" viewBox="0 0 12 22"
                                 fill="none">
                                <path
                                    d="M0 10.9998L10.2732 21.2731L12 19.5464L3.45334 10.9998L11.9998 2.45325L10.2732 0.726562L0 10.9998Z"
                                    fill="white"/>
                            </svg>
                        </button>

                        <div class="numberButton">
                            <p>{{ location }}</p>
                        </div>

                        <button class="numberButton" @click="location++">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="22" viewBox="0 0 12 22"
                                 fill="none">
                                <path
                                    d="M8.54666 10.9999L0 2.45326L1.72675 0.726562L12 10.9999L1.72675 21.2733L0 19.5466L8.54666 10.9999Z"
                                    fill="white"/>
                            </svg>
                        </button>
                    </div>

                    <input type="text" placeholder="Наименование позиции" v-model="nameFood">
                    <input type="text" placeholder="Наименование категории" v-model="nameCategory">

                    <div class="type flex-wrap">
                        <button class="w-full text-center" v-for="category in categories" :class="{ active: typeFood === category.id}"
                                @click="typeFood = category.id"
                                style="display: block; flex-basis: 48%">
                            {{ category.name}}
                        </button>
                    </div>

                    <input type="text" style="margin-top: 10px" placeholder="Цена (₽)" v-model="priceFood">

                    <!-- select file -->
                    <input type="file" @change="uploadFile" v-if="file === ''">
                    <div v-else>
                        <img :src="file" width="339" height="339" class="mx-auto" style="border-radius: 16px" alt="">
                    </div>
                    <input type="text" placeholder="Описание к фото" v-model="info">

                    <button class="numberButton" @click="removeModalCreate()">Вернуться назад</button>
                    <button class="numberButton" @click="addModalCreate()">Добавить позицию</button>

                    <p class="text-center  font-bold">{{ alert }}</p>
                </div>
            </div>
        </div>
    </div>

    <div id="edit" tabindex="-1" aria-hidden="true"
         class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full modal">
        <div class="relative w-full max-w-lg max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="p-6 ">
                    <div class="titleInformation">
                        <h1>Изменить позицию</h1>
                    </div>
                    <div class="flex gap-4">
                        <button class="numberButton" @click="(modalData.position !== 0) ? modalData.position-- : 0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="22" viewBox="0 0 12 22"
                                 fill="none">
                                <path
                                    d="M0 10.9998L10.2732 21.2731L12 19.5464L3.45334 10.9998L11.9998 2.45325L10.2732 0.726562L0 10.9998Z"
                                    fill="white"/>
                            </svg>
                        </button>

                        <div class="numberButton">
                            <p>{{ modalData.position }}</p>
                        </div>

                        <button class="numberButton" @click="modalData.position++">
                            <svg xmlns="http://www.w3.org/2000/svg" width="12" height="22" viewBox="0 0 12 22"
                                 fill="none">
                                <path
                                    d="M8.54666 10.9999L0 2.45326L1.72675 0.726562L12 10.9999L1.72675 21.2733L0 19.5466L8.54666 10.9999Z"
                                    fill="white"/>
                            </svg>
                        </button>
                    </div>

                    <input type="text" placeholder="Наименование позиции" v-model="modalData.name">
                    <input type="text" placeholder="Наименование категории" v-model="modalData.description">

                    <div class="type flex-wrap">
                        <button class="w-full text-center" v-for="category in categories" :class="{ active: typeFood === category.id}"
                                @click="typeFood = category.id"
                                style="display: block; flex-basis: 48%">
                            {{ category.name}}
                        </button>
                    </div>

                    <input type="text" style="margin-top: 10px" placeholder="Цена (₽)" v-model="modalData.price">

                    <!-- select file -->
                    <input type="file" @change="uploadFile" v-if="file === ''">
                    <div v-else>
                        <img :src="file" width="339" height="339" class="mx-auto" style="border-radius: 16px" alt="">
                    </div>
                    <input type="text" placeholder="Описание к фото" v-model="modalData.info">

                    <div class="type" style="margin-bottom: 30px;">
                        <button class="w-full text-center" :class="{ active: modalData.freeze === 0}"
                                @click="modalData.freeze = 0"
                                style="display: block"><p>UnFreeze</p>
                        </button>
                        <button class="w-full text-center" :class="{ active: modalData.freeze === 1}"
                                @click="modalData.freeze = 1"
                                style="display: block"><p>Freeze</p>
                        </button>
                    </div>



                    <button class="numberButton" @click="closeEditFood()">Вернуться назад</button>
                    <button class="numberButton" @click="updateEditFoodZ()">Подтвердить</button>

                    <p class="text-center  font-bold">{{ alert }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped lang="less">

.modal {
    input {
        border-radius: 16px;
        background: #FFF;
        box-shadow: 0px 4px 16px 0px rgba(0, 21, 52, 0.06);
        width: 100%;
        margin-bottom: 10px;
        border: 0;
        color: #333;
        opacity: 0.5;
        text-align: center;

        &::placeholder {
            text-align: center;
        }
    }

    .numberButton {
        padding: 12px 0;

    }

    button {
        padding: 10px 24px 10px 10px;
        border-radius: 100px;
        font-weight: 500;
        font-size: 16px;
        border: 1px solid #DFE1E8;
        width: 100%;
        display: block;
        //color: #333;
    }

    .type {
        button {
            p {
                opacity: 0.5;
                //color: #333;
            }
        }

        .active {
            p {
                opacity: 1;
            }
        }
    }
}

.type {
    margin-top: 10px;
    display: flex;
    gap: 10px;
    overflow-y: auto;

    button {
        display: flex;
        gap: 10px;
        align-items: center;
        padding: 10px 24px 10px 10px;
        border-radius: 100px;
        font-weight: 500;
        font-size: 16px;
        line-height: 150%;
        border: 1px solid #DFE1E8;
    }
}

.type::-webkit-scrollbar {
    width: 0;
}

.type .disable {
    color: rgba(51, 51, 51, 0.40);
}

.type .active {
    border: 1px solid #DFE1E8;
    background: #B8AFA9;
    color: #fff;
}

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

.titleInformation {
    border-radius: 16px;
    background: #FFF;
    box-shadow: 0px 4px 16px 0px rgba(0, 21, 52, 0.06);
    color: var(--dark, #333);
    text-align: center;
    padding: 8px 10px;

    h1 {
        text-align: center;
        font-size: 15px;
        font-weight: 700;
    }

    p {
        font-size: 12px;
        font-weight: 500;
        opacity: 0.5;
    }
}

.product .product__content {
    padding: 0 5px;

    .position {
        background: #B8AFA9;
        padding: 15px 15px;
        height: 100%;
        display: block;
        margin-right: 10px;
        color: #fff;
        border-top-left-radius: 10px;
        border-bottom-left-radius: 10px;
    }
}

</style>
