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
                            <div class="text-center text-black font-semibold">
                                <div class="flex items-center justify-center space-x-2 my-5">
                                    <span class="h-px w-24 bg-[#EDEDED]"></span>
                                    <span class="text-back">Đăng nhập bằng</span>
                                    <span class="h-px w-24 bg-[#EDEDED]"></span>
                                </div>
                            </div>
                            <div class="flex justify-center gap-5 w-full">
                                <button type="submit"
                                    class="w-full flex items-center justify-center mb-6 md:mb-0 border border-[#EDEDED] hover:border-gray-900 hover:text-red-500 text-sm text-gray-300 p-3 rounded-lg tracking-wide font-medium cursor-pointer transition ease-in duration-500">
                                    <svg class="w-4 mr-2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path fill="#EA4335"
                                            d="M5.266 9.765A7.077 7.077 0 0 1 12 4.909c1.69 0 3.218.6 4.418 1.582L19.91 3C17.782 1.145 15.055 0 12 0 7.27 0 3.198 2.698 1.24 6.65l4.026 3.115Z" />
                                        <path fill="#34A853"
                                            d="M16.04 18.013c-1.09.703-2.474 1.078-4.04 1.078a7.077 7.077 0 0 1-6.723-4.823l-4.04 3.067A11.965 11.965 0 0 0 12 24c2.933 0 5.735-1.043 7.834-3l-3.793-2.987Z" />
                                        <path fill="#4A90E2"
                                            d="M19.834 21c2.195-2.048 3.62-5.096 3.62-9 0-.71-.109-1.473-.272-2.182H12v4.637h6.436c-.317 1.559-1.17 2.766-2.395 3.558L19.834 21Z" />
                                        <path fill="#FBBC05"
                                            d="M5.277 14.268A7.12 7.12 0 0 1 4.909 12c0-.782.125-1.533.357-2.235L1.24 6.65A11.934 11.934 0 0 0 0 12c0 1.92.445 3.73 1.237 5.335l4.04-3.067Z" />
                                    </svg>
                                    <span>Google</span>
                                </button>

                                <button type="submit"
                                    class="w-full flex items-center justify-center mb-6 md:mb-0 border border-[#EDEDED] hover:border-gray-900 hover:text-red-500 text-sm text-gray-300 p-3 rounded-lg tracking-wide font-medium cursor-pointer transition ease-in duration-500 px-">
                                    <svg class="w-4 mr-2" viewBox="0 0 100 100" style="
                                            enable-background: new 0 0 100 100;
                                        " xml:space="preserve" xmlns="http://www.w3.org/2000/svg">
                                        <g id="Layer_1" />
                                        <g id="Layer_2">
                                            <path
                                                d="M50 2.5c-58.892 1.725-64.898 84.363-7.46 95h14.92c57.451-10.647 51.419-93.281-7.46-95z"
                                                style="fill: #1877f2" />
                                            <path
                                                d="M57.46 64.104h11.125l2.117-13.814H57.46v-8.965c0-3.779 1.85-7.463 7.781-7.463h6.021V22.101c-12.894-2.323-28.385-1.616-28.722 17.66V50.29H30.417v13.814H42.54V97.5h14.92V64.104z"
                                                style="fill: #f1f1f1" />
                                        </g>
                                    </svg>
                                    <span>Facebook</span>
                                </button>
                            </div>
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
                <router-link class="hover:text-red-500" to="">Quên mật khẩu</router-link>
                /
                <router-link class="hover:text-red-500" to="/register">Đăng kí</router-link>
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
                        this.lazyLoad = false
                        if(this.$router.options.history.base == ""){
                            return this.$router.replace('/')
                        }else{
                            this.$router.back();
                        }
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
