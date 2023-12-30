<script setup>
import {computed, defineComponent, onMounted, ref} from "vue";
import axios from "axios";
import VFooter from "@/Components/Footer.vue";
import GrayButton from "@/Components/GrayButton.vue";
import {Link, router} from "@inertiajs/vue3";
import DangerButton from "@/Components/DangerButton.vue";
import {Modal} from "flowbite";
// import { InertiaApp} from "@inertiajs/vue3/types/app.js";

const foods = ref(),
    selectedObjects = ref([]),
    totalPrice = ref(0),
    phoneNumber = ref(),
    typeApp = ref(JSON.parse(localStorage.getItem('typeApp'))),
    numberApp = ref(JSON.parse(localStorage.getItem('Number')));

// console.log(localStorage.getItem('fix'))

function fetchData() {
    if (JSON.parse(localStorage.getItem('foods')) !== null) {
        foods.value = JSON.parse(localStorage.getItem('foods'))['_value']
        foods.value.forEach(object => {
            if (object.timeView === ((new Date().getHours() <= 22 && new Date().getHours() >= 8) ? 1 : 2)) {
                selectObject(object)
            }
        })

        console.log(foods)
    } else {
        window.location.replace('/menu')
    }
}

function selectObject(object) {
    if (typeof object !== 'object') {
        return false;
    }

    if (selectedObjects.value.indexOf(object) === -1) {
        selectedObjects.value.push(object);
    }

    object.clickCount = (object.clickCount || 0) + 1;
    object.totalPrice = object.price * object.clickCount;

    totalPrice.value += object.price;
}

function deleteObject(object) {
    console.log(object)
    if (object.clickCount === 1) {
        foods.value.splice(object, 1);
        selectedObjects.value.splice(object, 1);
        totalPrice.value -= object.price;

        localStorage.setItem('foods', JSON.stringify(selectedObjects));
        return false;
    }

    object.clickCount = (object.clickCount || 0) - 1;
    object.totalPrice = object.price * object.clickCount;

    totalPrice.value -= object.price;

}

function callPhoneButton() {
    const modal = new Modal(document.getElementById('modalEl'), {
        backdrop: 'dynamic',
        closable: true,
    });

    modal.show()
}

function payOrder() {
    const pay = new Modal(document.getElementById('pay'), {
        backdrop: 'dynamic',
        backdropClasses: 'bg-gray-900 bg-opacity-50 dark:bg-opacity-80 fixed inset-0 z-40',
        closable: true,
    });

    const modal = new Modal(document.getElementById('modalEl'), {
        backdrop: 'dynamic',
        closable: true,
    });

    let backdropElement = document.querySelector('[modal-backdrop]');
    if (backdropElement) {
        backdropElement.parentNode.removeChild(backdropElement);
    }

    modal.hide()
    pay.show()
}

function alertPay() {
    const pay = new Modal(document.getElementById('pay'), {
        backdrop: 'dynamic',
        backdropClasses: 'bg-gray-900 bg-opacity-50 dark:bg-opacity-80 fixed inset-0 z-40',
        closable: true,
    });

    const modal = new Modal(document.getElementById('modalEl'), {
        backdrop: 'dynamic',
        closable: true,
    });

    modal.hide()
    pay.hide()

    let backdropElement = document.querySelector('[modal-backdrop]');
    if (backdropElement) {
        backdropElement.parentNode.removeChild(backdropElement);
    }

    showAlertInfo()

    axios.post('/api/v1/order/create/cash', {
        selectedObjects: selectedObjects.value,
        phone: phoneNumber.value,
        typeApp: typeApp.value,
        numberApp: numberApp.value,
        totalPrice: totalPrice.value
    })
}

function showAlertInfo() {
    const alertInfo = new Modal(document.getElementById('alertPay'), {
        backdrop: 'dynamic',
        closable: true,
    });

    alertInfo.show()
}

function closeAlert() {
    let backdropElement = document.querySelector('[modal-backdrop]');
    backdropElement.parentNode.removeChild(backdropElement);

    const alertInfo = new Modal(document.getElementById('alertPay'), {
        backdrop: 'dynamic',
        closable: true,
    });

    alertInfo.hide()
}

const props = defineProps({
    pay: {
        type: String,
    },
});
onMounted(() => {
    if (props.pay === 'pay') {
        showAlertInfo()
    }
})

function formatPhoneNumber() {
    const cleanedPhoneNumber = phoneNumber.value.replace(/\D/g, '').slice(0, 11)
    let formattedNumber = '+7';

    if (cleanedPhoneNumber.length > 0) {
        formattedNumber += ' (' + cleanedPhoneNumber.substr(1, 3) + ')';
    }
    if (cleanedPhoneNumber.length > 4) {
        formattedNumber += ' ' + cleanedPhoneNumber.substr(4, 3);
    }
    if (cleanedPhoneNumber.length > 7) {
        formattedNumber += '-' + cleanedPhoneNumber.substr(7, 2);
    }
    if (cleanedPhoneNumber.length > 9) {
        formattedNumber += '-' + cleanedPhoneNumber.substr(9);
    }

    phoneNumber.value = formattedNumber;
};

const increasedObjectsMessage = computed(() => {
    return selectedObjects.value
        .filter(object => object.clickCount > 0)
        .map(object => `${object.name} - ${object.clickCount} clicks`)
        .join(', ');
});


fetchData()
</script>

<template>
    <v-header/>

    <div class="product">
        <div class="product__content mt-2" v-for="food in selectedObjects">
            <div>
                <h1>{{ food.name }}</h1>
                <p>{{ food.description }} ({{ food.price }}₽)</p>
            </div>

            <div class="flex items-center ml-auto gap-2 buttonMenu">
                <button @click="deleteObject(food)">
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="26" viewBox="0 0 13 2" fill="none">
                        <path d="M1 1.2085H11.4167" stroke="white" stroke-width="1" stroke-linecap="round"/>
                    </svg>
                </button>
                <button @click="selectObject(food)">
                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="26"
                         viewBox="0 0 25 26" fill="none">
                        <path d="M13.2083 18.1131V7.27979" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                        <path d="M8 12.6968H18.4167" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
                    </svg>
                </button>
            </div>
        </div>

        <div class="footerInfo">
            <div class="infoOrder" v-for="object in selectedObjects">
                <h1>x{{ object.clickCount }} - {{ object.name }} {{ object.totalPrice }}₽</h1>
            </div>

            <h1 class="mt-2">Итого {{ totalPrice }}₽</h1>
            <p class="alert">(Для оформления заказа нажмите на кнопку ниже)</p>
        </div>

        <gray-button style="height:50px" @click="callPhoneButton">Оформить заказ</gray-button>
    </div>
    <Link :href="route('menu')">
        <gray-button style="height:50px">Вернуться назад</gray-button>
    </Link>
    <v-footer/>

    <div id="modalEl" tabindex="-1" aria-hidden="true"
         class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-lg max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">

                <div class="p-6 space-y-6">
                    <div class="shadowBlock">
                        <p>Введите номер телефона</p>
                    </div>

                    <form action="#">
                        <input v-model="phoneNumber" @input="formatPhoneNumber" type="text" class="inputModal"
                               placeholder="+7 (000) 000-00-00"
                               required>
                        <gray-button @click="payOrder" type="button">Отправить</gray-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="pay" tabindex="-1" aria-hidden="true"
         class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-lg max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="p-6 ">
                    <div class="shadowBlock">
                        <p>Выберите способ оплаты</p>
                    </div>

                    <Link
                        :data="{ selectedObjects:selectedObjects, phone: phoneNumber, typeApp: typeApp, numberApp: numberApp, totalPrice: totalPrice }"
                        :href="route('v1.order.store')">
                        <gray-button>Онлайн</gray-button>
                    </Link>
                    <gray-button @click="alertPay()">Карта/Наличные</gray-button>
                </div>
            </div>
        </div>
    </div>

    <div id="alertPay" tabindex="-1" aria-hidden="true"
         class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-lg max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="p-6 ">
                    <div class="shadowBlock">
                        <p>Заказ успешно оформлен!</p>
                        <h2>(С Вами свяжутся в ближайшее время для уточнения заказа)</h2>
                    </div>
                    <gray-button @click="closeAlert()">Вернуться назад</gray-button>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped lang="less">
.buttonMenu {
    button {
        padding: 5px;
    }
}

.footerInfo {
    box-shadow: 0px 4px 16px 0px rgba(0, 21, 52, 0.06);
    padding: 8px 10px;
    text-align: center;
    margin: auto;

    .infoOrder {
        margin: auto;
    }

    h1 {
        color: var(--dark, #333);
        font-size: 15px;
        font-weight: 700;
    }

    .alert {
        color: #333;
        font-size: 12px;
        font-weight: 500;
        opacity: 0.5;
    }
}

.inputModal {
    border-radius: 16px;
    border: 1px solid #333;
    background: #FFF;
    box-shadow: 0px 4px 16px 0px rgba(0, 21, 52, 0.06);
    width: 100%;
    margin-bottom: 1rem;
}

.shadowBlock {
    box-shadow: 0px 4px 16px 0px rgba(0, 21, 52, 0.06);
    border-radius: 16px;
    text-align: center;
    padding: 10px 0px;

    h2 {
        opacity: 0.5;
        font-size: 12px;
        font-weight: 500;
        color: #333;
    }
}

.shadowBlock p {
    font-size: 15px;
    font-weight: 700;
    color: #333;
}
</style>
