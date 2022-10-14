<template>
    <div class="m-auto">
        <img src="images/background-user.png" alt="background" class="w-full h-screen">
        <div class="w-[460px] h-fit pb-8 bg-white absolute top-0 right-0 left-0 bottom-0 z-[100] m-auto rounded-lg">
            <div v-if="statusRegister" class="bg-green-500 text-white font-bold py-2 p-4">
                {{ statusMessage }}
            </div>
            <!-- <div v-if="statusRegister === false" class="bg-red-700 text-white font-bold py-2 p-4">
                {{ statusMessage }}
            </div> -->
            <form class="mx-[55px] font-bold" @submit.prevent="registerUser()">
                <div class="text-[30px] my-11 ">
                    <p class="text-center">Đăng ký</p>
                </div>
                <div class="text-[#6B6B6B]">
                    <div class="mb-5">
                        <input v-model="dataRegister.username" type="text" placeholder="Tên tài khoản"
                            class="block w-full bg-gray-100 rounded-md border-none p-2 duration-300 shadow focus:outline-none focus:ring focus:ring-red-500 " />
                        <span v-if="errors.username" class="text-red-700 text-[15px] pl-2 font-normal">{{ errors.username[0]
                        }}</span>
                    </div>

                    <div class="mb-5">
                        <input type="text" v-model="dataRegister.email" placeholder="Email"
                            class="block w-full bg-gray-100 rounded-md border-none p-2 duration-300 shadow focus:outline-none focus:ring focus:ring-red-500 " />
                        <span v-if="errors.email" class="text-red-700 text-[15px] pl-2 font-normal">{{ errors.email[0]
                        }}</span>
                    </div>

                    <div class="mb-5">
                        <input type="text" v-model="dataRegister.address" placeholder="Địa chỉ"
                            class="block w-full bg-gray-100 rounded-md border-none p-2 duration-300 shadow focus:outline-none focus:ring focus:ring-red-500 " />
                        <span v-if="errors.address" class="text-red-700 text-[15px] pl-2 font-normal">{{ errors.address[0]
                        }}</span>
                    </div>
                    <div class="mb-5">
                        <input type="text" v-model="dataRegister.phone" placeholder="Số điện thoại"
                            class="block w-full bg-gray-100 rounded-md border-none p-2 duration-300 shadow focus:outline-none focus:ring focus:ring-red-500 " />
                        <span v-if="errors.phone" class="text-red-700 text-[15px] pl-2 font-normal">{{ errors.phone[0]
                        }}</span>
                    </div>
                    <div class="mb-5">
                        <input type="password" v-model="dataRegister.password" placeholder="Mật khẩu"
                            autocomplete="true"
                            class="block w-full bg-gray-100 rounded-md border-none p-2 duration-300 shadow focus:outline-none focus:ring focus:ring-red-500 " />
                        <span v-if="errors.password" class="text-red-700 text-[15px] pl-2 font-normal">{{ errors.password[0]
                        }}</span>
                    </div>
                    <div class="mb-5">
                        <input type="password" v-model="dataRegister.confirm_password" placeholder="Nhập lại mật khẩu"
                            autocomplete="true"
                            class="block w-full bg-gray-100 rounded-md border-none p-2 duration-300 shadow focus:outline-none focus:ring focus:ring-red-500 " />
                        <span v-if="errors.confirm_password" class="text-red-700 text-[15px] pl-2 font-normal">{{ errors.confirm_password[0]
                        }}</span>
                    </div>
                    <div class="text-center m-5">
                        <button class="rounded-2xl text-white px-7 border-solid border-[#B6B4B4] bg-[#FF3F3A] p-6">
                            <img v-if="!lazyLoad" src="images/menu-icon/right-arrow-30.png" alt="icon">
                            <svg v-if="lazyLoad" class="animate-spin h-7 w-7 text-white"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4">
                                </circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                        </button>

                    </div>
                </div>
            </form>
            <div class="text-center font-semibold">
                <router-link class="hover:text-red-500" to="">Quên mật khẩu</router-link> / <router-link
                    class="hover:text-red-500" to="/login">Đăng nhập</router-link>
            </div>
        </div>
    </div>
</template>
<script>
import { register } from '../../config/user';


export default {
    data() {
        return {
            dataRegister: {
                username: "",
                email: "",
                address: "",
                phone: "",
                password: "",
                confirm_password: ""
            },
            errors: [],
            usernameFocus: false,
            emailFocus: false,
            addressFocus: false,
            phoneFocus: false,
            passwordFocus: false,
            confirmPasswordFocus: false,

            statusRegister: 0,
            statusMessage: "",
            lazyLoad: false,
        };
    },
    methods: {
        registerUser() {
            this.lazyLoad = true;
            register(this.dataRegister).then(res => {
                this.statusRegister = true
                this.statusMessage = res.data
                setTimeout(() => {
                    this.lazyLoad = false
                    this.$router.replace('/login')
                }, 2000)
            }).catch(error => {
                this.statusRegister = false
                this.errors = error.response.data.errors
                this.lazyLoad = false
            });
        }
    },
};
</script>
<style>

</style>