<template>
    <loading v-model:active="isLoading" />
    <section class="relative">
        <i
            class="fa-solid fa-arrow-left-long absolute top-4 left-8 text-white text-2xl cursor-pointer"
            @click="$router.go(-1)"
        ></i>
    </section>
    <section>
        <img
            src="/images/background-user.png"
            alt="background"
            class="w-full h-screen"
        />
        <div
            class="w-[600px] h-fit pb-8 bg-white absolute top-0 right-0 left-0 bottom-0 z-[100] m-auto rounded-lg"
        >
            <div
                v-if="status"
                class="bg-green-500 text-white font-bold py-2 p-4 absolute top-0 left-0 w-full rounded-tl-lg rounded-tr-lg"
            >
                {{ statusMessage }}
            </div>

            <div
            v-if="status == 'oop'"
            class="bg-red-700 text-white font-bold py-2 p-4 absolute top-0 left-0 w-full rounded-tl-lg rounded-tr-lg"
            >
                {{ statusMessage }}
            </div>
            <form action="" @submit.prevent="submitAccount()">
                <div class="mx-[55px] font-bold">
                    <div class="text-[30px] my-11">
                        <p class="text-center">Cập nhật mật khẩu</p>
                    </div>
                    <div class="text-[#6B6B6B]">
                        <div class="my-5">
                            <input
                                type="password"
                                placeholder="Mật khẩu mới"
                                v-model="dataAccount.password"
                                class="block w-full bg-gray-100 rounded-md border-none p-2 duration-300 shadow focus:outline-none"
                                autocomplete="on"
                            />
                            <span
                                v-if="errors?.password"
                                class="text-sm text-red-700 ml-2 font-semibold"
                                >{{ errors.password[0] }}</span
                            >
                        </div>
                        <div>
                            <input
                                type="password"
                                placeholder="Nhập lại mật khẩu"
                                v-model="dataAccount.password_confirmation"
                                class="block w-full bg-gray-100 rounded-md border-none p-2 duration-300 shadow focus:outline-none"
                                autocomplete="on"
                            />
                            <span
                                v-if="errors?.password_confirmation"
                                class="text-sm text-red-700 ml-2 font-semibold"
                                >{{ errors.password_confirmation[0] }}</span
                            >
                        </div>
                        <div class="text-center m-5 flex justify-center">
                            <button
                                :disabled="checkSubmit"
                                class="rounded-2xl text-white px-7 border-solid border-[#B6B4B4] bg-[#FF3F3A] p-6 flex items-center justify-center"
                            >
                                <svg
                                    v-if="lazyLoad"
                                    class="animate-spin h-7 w-7 text-white"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <circle
                                        class="opacity-25"
                                        cx="12"
                                        cy="12"
                                        r="10"
                                        stroke="currentColor"
                                        stroke-width="4"
                                    ></circle>
                                    <path
                                        class="opacity-75"
                                        fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                                    ></path>
                                </svg>
                                <img
                                    v-if="!lazyLoad"
                                    src="/images/menu-icon/right-arrow-30.png"
                                    alt="icon"
                                />
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>
</template>

<script>
import { resetPassword } from "../../config/user";
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
export default {
    data() {
        return {
            dataAccount: {
                password: "",
                password_confirmation: "",
            },
            errors: {},
            token: "",

            status: "",
            statusMessage: "",
            lazyLoad: false,
            checkSubmit: false,
        };
    },
    components: {
        Loading,
    },
    mounted() {
        this.token =  this.$route.query.token
    },

    methods: {
        submitAccount() {
            this.checkSubmit = true
            this.lazyLoad = true;
            resetPassword(this.dataAccount, this.token)
                .then((res) => {
                    this.status = true;
                    this.statusMessage = res.data.message;
                    this.lazyLoad = false;
                    this.dataAccount.password = "",
                    this.dataAccount.password_confirmation = ""
                    this.checkSubmit = false
                })
                .catch((error) => {
                    this.status = false;
                    this.errors = error.response.data.errors;

                    if(error.response.status == 400){
                        this.status = "oop"
                        this.statusMessage = error.response.data.message
                        this.dataAccount.password = ""
                        this.dataAccount.password_confirmation = ""
                    }

                    this.lazyLoad = false;
                    this.checkSubmit = false
                });
        },
    },
};
</script>

<style scoped>
button {
    background-color: #ff3f3a;
}
</style>
