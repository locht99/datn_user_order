<template>
    <div>
        <div class="flex justify-center mt-5">
            <div class=" container max-w-full block rounded-lg shadow-lg bg-white ">
                <div class="py-3 px-6 border-b border-gray-300">
                    <h3 class="text-gray-900 font-semibold text-[20px]"> Nạp tiền</h3>
                </div>
                <div class="p-6">
                    <div class="content">
                        <div class="option-payment">
                            <div class="md:flex justify-between">
                                <div class="mx-2 my-2">
                                    <button
                                        class="whitespace-nowrap inline-block px-[8rem] py-2.5 bg-red-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-red-700 hover:shadow-lg focus:bg-red-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-red-800 active:shadow-lg transition duration-150 ease-in-out">Ngân
                                        hàng</button>
                                </div>
                                <div class="mx-2 my-2">
                                    <button
                                        class="whitespace-nowrap inline-block px-[8rem] py-2.5 bg-red-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-red-700 hover:shadow-lg focus:bg-red-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-red-800 active:shadow-lg transition duration-150 ease-in-out">Paypal</button>

                                </div>
                                <div class="mx-2 my-2">
                                    <button
                                        class="whitespace-nowrap inline-block px-[8rem] py-2.5 bg-red-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-red-700 hover:shadow-lg focus:bg-red-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-red-800 active:shadow-lg transition duration-150 ease-in-out">Ví
                                        điện tử</button>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <div>
                                <p class="font-semibold mx-2">Tỷ giá: {{formatPrice(this.exchangeRate)}} = 1 Tệ</p>
                            </div>
                        </div>
                        <div class="mt-3 mx-2">

                            <div class="form">
                                <div class="flex items-center  py-3">
                                    <!-- Author: FormBold Team -->
                                    <!-- Learn More: https://formbold.com -->
                                    <div class=" w-full max-w-[550px] bg-white">
                                        <form class="py-6" method="POST" @submit.prevent="createTransaction()">
                                            <div class="mb-5">
                                                <label for="amount"
                                                    class="mb-3 block text-base font-medium text-[#07074D]">
                                                    Số tiền:
                                                </label>
                                                <input type="text" v-model="formTransaction.amount" name="amount"
                                                    id="amount" placeholder="Số tiền..."
                                                    class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md" />
                                            </div>
                                            <div class="mb-5">
                                                <label for="type-payment" class="mb-3 block text-base font-medium">
                                                    Hình thức thanh toán
                                                </label>
                                                <select v-model="formTransaction.typePayment" name="type-payment"
                                                    class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md">
                                                    <option :value="item.name" v-for="item in this.dataPayment">
                                                        {{ item.name }}</option>
                                                </select>
                                            </div>
                                            <div class="mb-5">
                                                <label for="type-transaction"
                                                    class="mb-3 block text-base font-medium text-[#0707d]">Loại giao
                                                    dịch</label>
                                                <select type="text" v-model="formTransaction.typeTransaction"
                                                    name="type-transaction" id="type-transaction"
                                                    class="w-full rounded-md border border-[#e0e0e0] bg-white py-3 px-6 text-base font-medium text-[#6B7280] outline-none focus:border-[#6A64F1] focus:shadow-md">
                                                    <option :value="item.id" v-for="item in this.data">
                                                        {{ item.type_name }}
                                                    </option>
                                                </select>
                                            </div>

                                            <div>
                                                <button
                                                    class="whitespace-nowrap inline-block px-[8rem] py-2.5 bg-red-600 text-white font-medium text-xs leading-tight uppercase rounded shadow-md hover:bg-red-700 hover:shadow-lg focus:bg-red-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-red-800 active:shadow-lg transition duration-150 ease-in-out">Nạp
                                                    tiền</button>
                                            </div>
                                        </form>
                                    </div>
                                    <div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="py-3 px-6 border-t border-gray-300 text-gray-600">
                    <!-- 2 days ago -->
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { createTransaction, getTypeTransaction, getCodeTransaction, getPayment, checkOrCreateTransaction } from '../../../config/transaction.js';
// import pusher
import Pusher from 'pusher-js';
import { Swal } from 'sweetalert2/dist/sweetalert2';
import { getExchangeRate } from '../../../config/transaction.js';
export default {
    watch: {
        $route: {
            immediate: true,
            handler(to, from) {
                document.title = 'Nạp tiền';
            }
        },
    },
    data() {
        return {
            formTransaction: {
                orderCodeResponse: '',
                amount: '',
                storeId: 'Test',
                typeTransaction: '',
                typePayment: '',
            },
            data: [],
            dataPayment: [],
            OrderCode: '',
            redirect: '',
            exchangeRate: 0
        }
    },
    setup() {

    },
    methods: {
        formatPrice(value) {
            return new Intl.NumberFormat("en-US", {
                style: "currency",
                currency: "VND",
            }).format(value);
        },
        getTypeTransaction() {

            getTypeTransaction().then((response) => {
                this.data = response.data;
            }).catch(() => {

            }).finally(() => {

            })
        },
        getTypePayment() {
            getPayment().then((response) => {
                this.dataPayment = response.data;
            })
        },
        getGenerateCode() {
            getCodeTransaction().then((response) => {
                this.OrderCode = response.data;
            });

        },
        createTransaction() {
            this.formTransaction.orderCodeResponse = this.OrderCode;
            createTransaction(this.formTransaction).then((response) => {
                this.redirect = response.data.payUrl;
                window.open(this.redirect, '_blank');
            }).catch(error => {

            })
        },
        fetchTransaction() {
            const queryString = window.location.search;
            const urlParams = new URLSearchParams(queryString);
            const resultCode = urlParams.get("resultCode");

        },
        getExchange() {
            getExchangeRate().then((res) => {
                const { data } = res;
                console.log(data);
                this.exchangeRate = data;
            });
        },
        echoTransaction() {

        }

    },
    created() {
        this.getTypeTransaction();
        this.getTypePayment();
        this.getGenerateCode();
        this.fetchTransaction();
        this.getExchange();
        // console.log($Auth.check());
        let user = JSON.parse(window.localStorage.getItem("user"));
        // console.log(window.Echo.private('eventTransaction'+user.id).listen('TransactionSent'));


    },
    mounted() {
        // Pusher.logToConsole = true;
        let user = JSON.parse(window.localStorage.getItem("user"));
        let test = 'eventTransaction.' + user.id;
        window.Echo.channel('eventTransaction.' + user.id).listen('TransactionSent', (res) => {
            if (res.transaction.success == false) {
                this.$swal('Nạp tiền thất bại', '', 'OK');
            } else {
                this.$swal('Nạp tiền thành công', '', 'OK');
            }
        })
    },
}
</script>
<style lang="">
    
</style>