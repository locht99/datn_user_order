<template>
    <div>
        <div v-if="showModalAction"
            class="overflow-x-hidden overflow-y-auto  fade  fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center flex">
            <div class="relative w-auto my-6 mx-auto max-w-6xl">
                <!--content-->
                <div
                    class="modal-cart border-0 rounded-lg shadow-lg relative flex flex-col bg-white outline-none focus:outline-none w-[1200px]">
                    <!--header-->
                    <div class="flex items-start justify-between p-5 border-b border-solid border-slate-200 rounded-t">
                        <div class="flex items-center justify-center">
                            <div>
                                <h3 class="text-3xl font-semibold">
                                    Danh sách địa chỉ
                                </h3>
                            </div>
                            <div class="ml-3">
                                <p
                                    class="text-blue-500 font-semibold text-[18px] cursor-pointer hover:underline hover:decoration-1 ">
                                    Thêm địa chỉ mới</p>
                            </div>
                        </div>
                        <button
                            class="p-1 ml-auto bg-white bg-transparent border-0 text-black opacity-5 float-right text-3xl leading-none font-semibold outline-none focus:outline-none"
                            v-on:click="toggleModalAddRess()">
                            <i class="fas fa-times text-black"></i>
                        </button>
                    </div>
                    <!--body-->
                    <div class="relative p-3 flex-auto">
                        <div class="flex items-center justify-between">
                            <div class="container p-10 mx-auto">
                                <div class="flex flex-col w-full px-0 mx-auto md:flex-row">
                                    <div class="w-full">
                                        <div class="inline-block w-[1100px] shadow rounded-lg overflow-hidden">
                                            <table class="w-full leading-normal">
                                                <thead>
                                                    <tr>
                                                        <th
                                                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">

                                                        </th>
                                                        <th
                                                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                            Họ tên
                                                        </th>
                                                        <th
                                                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                            Điện thoại
                                                        </th>
                                                        <th
                                                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                            Tên địa chỉ
                                                        </th>
                                                        <th
                                                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                                            Địa chỉ
                                                        </th>
                                                        <th
                                                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">

                                                        </th>
                                                        <th
                                                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">

                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="item in dataAddress">
                                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                            <input type="radio" name="radio"
                                                                :checked="is_default.is_default == 1 ? true : false"
                                                                v-on:click="checkedAddress(item)">
                                                        </td>
                                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                            <div class="flex items-center">
                                                                <div class="flex-shrink-0 w-10 h-10">
                                                                    <img class="w-full h-full rounded-full"
                                                                        src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2.2&w=160&h=160&q=80"
                                                                        alt="" />
                                                                </div>
                                                                <div class="ml-3">
                                                                    <p class="text-gray-900 whitespace-no-wrap">
                                                                        {{ item.name }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                            <p class="text-gray-900 whitespace-no-wrap">
                                                                {{ item.phone }}</p>
                                                        </td>
                                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                            <p class="text-gray-900 whitespace-no-wrap">
                                                                {{ item.ward + item.district + item.province }}
                                                            </p>
                                                        </td>
                                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                            <p class="text-gray-900 whitespace-no-wrap w-[380px]">
                                                                {{ item.note }}
                                                            </p>
                                                        </td>
                                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                            <span v-if="item.is_default == 1"
                                                                class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
                                                                <span aria-hidden
                                                                    class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                                                <span class="relative">Mặc định</span>
                                                            </span>
                                                        </td>
                                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                            <div class="flex items-center">
                                                                <div class="m-2">
                                                                    <a href="">Sửa</a>
                                                                </div>
                                                                <div class="m-2">
                                                                    <a href="">Xóa</a>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- footer-->
                    <div class="flex items-center justify-end p-6 border-t border-solid border-slate-200 rounded-b">

                        <button v-on:click="toggleModalAddRess()"
                            class="text-red-600 bg-transparent border border-solid border-red-500 hover:bg-red-500 hover:text-white active:bg-red-600 font-bold uppercase text-sm px-6 py-3 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                            type="button">
                            Lưu thay đổi
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="showModalAction" class="opacity-25 fixed inset-0 z-40 bg-black"></div>
    </div>
</template>
<script>
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
import { getAddress } from '../../config/user';
export default {
    components: {
        Loading
    },
    data() {
        return {
            dataAddress: [],
            is_default: {}
        }
    },
    emits: {
        showModalAddress: Boolean,
        idAddRess: Number
        // foobar: Function
    }, props: {
        showModalAction: Boolean,
    },
    created() {
        this.getAddressUser();
    },
    methods: {
        toggleModalAddRess() {
            this.$emit('showModalAddress', this.showModalAction);
        },
        getAddressUser() {
            let User = JSON.parse(window.localStorage.getItem("user"));
            getAddress(User.id).then((response) => {
                this.dataAddress = response.data;
                let idDefault = this.dataAddress.find((item) => item.is_default == 1);
                this.is_default = idDefault;
                window.localStorage.setItem("is_default_Address", JSON.stringify(idDefault));
            }).catch((error) => {

            })
        },
        checkedAddress(item) {
            let is_default_Address = JSON.parse(window.localStorage.getItem("is_default_Address"));
            const newAddress = {...item};
            newAddress.is_default =1;
            this.is_default = newAddress;
            window.localStorage.setItem("is_default_Address", JSON.stringify(newAddress));

            // let existIsDefaultAddress = is_default_Address.find((item)=>item.id == id);
            // console.log(existIsDefaultAddress);
            this.$emit('idAddRess', item);
        }

    }
}
</script>
<style>
.modal-cart {
    transition: ease-in-out;
    animation-name: modalCart;
    animation-duration: 0.5s;
}

@keyframes modalCart {
    0% {
        transform: translateY(-160px);

    }

    100% {
        transform: translateY(0);
    }
}
</style>