<template>
    <loading v-model:active="isLoading" :color="backGroundcolor" />
    <section class="relative">
        <div class="w-full h-48 bg-black bg-profile">
            <!-- <img src="/images/bg.png" alt="" class="w-full" /> -->
        </div>
        <i
            class="fa-solid fa-arrow-left-long absolute top-4 left-8 text-white text-2xl cursor-pointer"
            @click="$router.go(-1)"
        ></i>
    </section>
    <section class="image1">
        <img
            src="/images/user-default.png"
            alt=" "
            class="max-w-32 max-h-32 w-auto h-auto m-auto rounded-full border-2 border-orange-500 overflow-hidden select-auto cursor-pointer bg-white"
        />
        <h1 class="text-2xl mt-2 text-center font-bold">{{ userInfo.name }}</h1>

        <p class="mt-2 font-semibold text-center">
            Số dư:{{ formatPrice(userInfo.point) }}
        </p>

        <div class="w-2/3 m-auto shadow-md shadow-gray-400 py-5 mt-2 px-24">
            <form action="" method="post" @submit.prevent="updateUser">
                <div class="flex justify-between">
                    <div>
                        <div class="my-3">
                            <label for="" class="block text-left font-semibold"
                                >Tên đăng nhập</label
                            >
                            <input
                                type="text"
                                name="username"
                                class="w-72 h-10 mt-2 rounded-lg"
                                :value="userInfo.username"
                                :disabled="!username"
                            />
                            <i
                                class="fa-solid fa-pen-to-square ml-3 text-xl text-gray-600 cursor-pointer"
                                @click="username = true"
                            ></i>
                        </div>
                        <div class="my-3">
                            <label for="" class="block text-left font-semibold"
                                >Email</label
                            >
                            <input
                                type="text"
                                name="email"
                                class="w-72 h-10 mt-2 rounded-lg"
                                :value="userInfo.email"
                                :disabled="!email"
                            />
                            <i
                                class="fa-solid fa-pen-to-square ml-3 text-xl text-gray-600 cursor-pointer"
                                @click="email = true"
                            ></i>
                        </div>
                        <div class="my-3">
                            <label for="" class="block text-left font-semibold"
                                >Số điện thoại</label
                            >
                            <input
                                type="text"
                                name="phone"
                                class="w-72 h-10 mt-2 rounded-lg"
                                :value="userInfo.phone"
                                :disabled="!phone"
                            />
                            <i
                                class="fa-solid fa-pen-to-square ml-3 text-xl text-gray-600 cursor-pointer"
                                @click="phone = true"
                            ></i>
                        </div>
                    </div>
                    <div class="my-3">
                        <label for="" class="block text-left font-semibold"
                            >Địa chỉ</label
                        >
                        <textarea
                            name="address"
                            id=""
                            class="h-36 resize-none mt-2 w-72 rounded-lg"
                            :disabled="!address"
                            v-model="userInfo.address"
                        >
                        </textarea>
                        <i
                            class="fa-solid fa-pen-to-square ml-3 text-xl text-gray-600 cursor-pointer"
                            @click="address = true"
                        ></i>
                    </div>
                </div>

                <button class="m-auto block text-white px-10 py-2 rounded-lg">
                    Cập nhật
                </button>
            </form>
        </div>
    </section>
</template>

<script>
import { getUser, updateUser } from "../config/user";
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
export default {
    watch: {
        $route: {
            immediate: true,
            handler(to, from) {
                document.title ='Thông tin cá nhân';
            }
        },
    },
    data() {
        return {
            active1: false,
            username: false,
            email: false,
            phone: false,
            address: false,
            userInfo: {},
            isLoading: false,
            backGroundcolor: "#E93B3B",
        };
    },
    created() {
        this.getUserInfo();
    },
    components: {
        Loading,
    },
    methods: {
        getUserInfo() {
            this.isLoading = true;
            getUser()
                .then((res) => {
                    this.userInfo = res.data;
                    console.log(res);
                })
                .finally(() => {
                    this.isLoading = false;
                });
        },
        formatPrice(value) {
            return new Intl.NumberFormat("en-US", {
                style: "currency",
                currency: "VND",
            }).format(value);
        },
        updateUser(event) {
            this.isLoading = true;
            var data = {};
            let target = event.target;
            for (let i = 0; i < target.length; i++) {
                if (target.elements[i].value) {
                    data[target.elements[i].name] = target.elements[i].value;
                }
            }
            this.userInfo = data
            updateUser(data)
                .then((response) => {
                    this.$swal('Chỉnh sửa thành công !');
                })
                .catch((error) => {
                    this.$swal(error.data.message);
                })
                .finally(() => {
                    this.isLoading = false;
                });
        },
    },
};
</script>

<style scoped>
button {
    background-color: #ff3f3a;
}
.image1 {
    transform: translateY(-70px);
}
.bg-profile {
    background-image: url("/images/bg.png");
}
</style>
