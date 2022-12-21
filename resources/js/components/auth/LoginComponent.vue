<template>
    <div class="m-auto">
        <img src="images/background-user.png" alt="background" class="w-full h-screen" />
        <div class="w-[460px] h-fit pb-8 bg-white absolute top-0 right-0 left-0 bottom-0 z-[100] m-auto rounded-lg">
            <form action="" @submit.prevent="submitLogin()">
                <div v-if="statusLogin" class="bg-green-500 text-white font-bold py-2 p-4 rounded-tl-lg rounded-tr-lg">
                    {{ statusMessage }}
                </div>
                <div v-if="!statusLogin && statusMessage != '' && !statusMessage.username && !statusMessage.password" class="bg-red-700 text-white font-bold py-2 p-4 rounded-tl-lg rounded-tr-lg">
                    {{ statusMessage }}
                </div>
                <div class="mx-[55px] font-bold">
                    <div class="text-[30px] my-11">
                        <p class="text-center">Đăng nhập</p>
                    </div>
                    <div class="text-[#6B6B6B]">
                        <div class="mb-5">
                            <input type="text" v-model="credentials.username" placeholder="Tên tài khoản"
                                class="block w-full bg-gray-100 rounded-md border-none p-2 duration-300 shadow focus:outline-none" />
                            <span v-if="statusMessage.username" class="text-sm text-red-700 ml-2 font-semibold">{{
                            statusMessage.username[0] }}</span>
                        </div>
                        <div class="mb-5">
                            <input type="password" v-model="credentials.password" placeholder="Mật khẩu"
                                class="block w-full bg-gray-100 rounded-md border-none p-2 duration-300 shadow focus:outline-none"
                                autocomplete="on" />
                            <span v-if="statusMessage.password" class="text-sm text-red-700 ml-2 font-semibold">{{
                            statusMessage.password[0] }}</span>
                        </div>
                        <div class="mb-5">
                            <input class="rounded bg-[#EDEDED]" type="checkbox" name="" id="" />
                            <span class="ml-2 font-semibold text-black">Lưu đăng nhập</span>
                        </div>
                        <div class="text-center m-5 flex justify-center">
                            <button
                                :disabled="checkSubmit"
                                class="rounded-2xl text-white px-7 border-solid border-[#B6B4B4] bg-[#FF3F3A] p-6 flex items-center justify-center">
                                <svg v-if="lazyLoad" class="animate-spin h-7 w-7 text-white"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                        stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor"
                                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                    </path>
                                </svg>
                                <img v-if="!lazyLoad" src="images/menu-icon/right-arrow-30.png" alt="icon" />
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            <div class="text-center font-semibold">
                <router-link class="hover:text-red-500" to="/user/forgot-password">Quên mật khẩu</router-link>
                /
                <router-link class="hover:text-red-500" to="/register">Đăng kí</router-link>
                <div>
                    <p>Hotline: 0383530895</p>
                </div>   
                <div>
                    <p>Copyright © Đặt Hàng Việt Trung</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { login } from "../../config/user";
export default {
    data() {
        return {
            credentials: {
                username: "",
                password: "",
            },
            statusLogin: 0,
            statusMessage: "",
            lazyLoad: false,
            lastPath: "",
            errors: [],
            checkSubmit: false
        };
    },
    created() {
        this.lastPath = this.$router.options.history.state.back
    },
    methods: {
        submitLogin() {
            this.lazyLoad = true;
            this.checkSubmit = true
            login(this.credentials)
                .then((res) => {
                    const { data } = res;
                    if (data) {
                        localStorage.setItem("token", data.access_token);
                    }
                })
                .then(() => {
                    this.statusLogin = true
                    this.statusMessage = "Đăng nhập thành công!"
                    setTimeout(() => {
                        if(this.$router.options.history.base == ""){
                            return this.$router.replace('/')
                        }else{
                            this.$router.back();
                        }
                        this.lazyLoad = false
                    }, 1500)
                }).catch(error => {
                    this.checkSubmit = false
                    this.statusLogin = false
                    this.statusMessage = error.response.data.message
                    this.lazyLoad = false
                });
        },
    },
};
</script>
<style>

</style>
