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
                                    {{ showModalAddNewAddress == true ? "Thêm địa chỉ mới" : "Danh sách địa chỉ" }}
                                </h3>
                            </div>
                            <div class="ml-3">
                                <p v-on:click="toggleModelAddNewAddress()"
                                    class="text-blue-500 font-semibold text-[18px] cursor-pointer hover:underline hover:decoration-1 ">
                                    {{ showModalAddNewAddress == true ? "Danh sách địa chỉ" : "Thêm địa chỉ mới" }}</p>
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
                                <div class="flex flex-col   px-0 mx-auto md:flex-row"
                                    :class="showModalAddNewAddress ? '' : 'w-full'">
                                    <div class="w-full">
                                        <div v-if="showModalAddNewAddress == false"
                                            class="inline-block w-[1100px] shadow rounded-lg overflow-hidden">
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
                                                        <!-- <th
                                                            class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">

                                                        </th> -->
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="item in dataAddress">
                                                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                            <input type="radio" name="radio" 
                                                            v-on:click="checkedAddress(item)" >
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
                                                        <!-- <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                                            <div class="flex items-center">
                                                                <div class="m-2">
                                                                    <a href=""><i class="fa fa-edit text-[18px]"></i></a>
                                                                </div>
                                                                <div class="m-2">
                                                                    <a href=""><i class="fa fa-trash text-[18px]"></i></a>
                                                                </div>
                                                            </div>
                                                        </td> -->
                                                    </tr>

                                                </tbody>
                                            </table>

                                        </div>
                                        <div v-else>
                                            <div>
                                                <div v-if="statusRegister"
                                                    class="bg-green-500 text-white font-bold py-2 p-4 absolute top-0 left-0 w-full rounded-tl-lg rounded-tr-lg">
                                                    {{ statusMessage }}
                                                </div>
                                                <form action="">
                                                    <div class="mx-[55px] font-bold">
                                                        <div class="text-[30px] my-11">
                                                            <p class="text-center">Thêm địa chỉ</p>
                                                        </div>
                                                        <div class="text-[#6B6B6B]">
                                                            <div class="mb-5">
                                                                <div class="my-4">
                                                                    <select name="selectedProvince"
                                                                        class="block w-full bg-gray-100 rounded-md border-none p-2 duration-300 shadow focus:outline-none"
                                                                        @change="getDistricts($event)"
                                                                        v-model="fillProvince">
                                                                        <option v-if="isLoadingProvince" value="">
                                                                            Đang tải...
                                                                        </option>
                                                                        <option v-else value="">
                                                                            Chọn tỉnh / thành phố
                                                                        </option>

                                                                        <option v-for="(province, index) in provinces"
                                                                            :key="index" :value="province.ProvinceID">
                                                                            {{ province.ProvinceName }}
                                                                        </option>
                                                                    </select>
                                                                    <span
                                                                        class="text-red-700 text-[15px] pl-2 font-semibold h-10">{{
                                                                                errors.selectedProvince
                                                                                    ? errors.selectedProvince[0]
                                                                                    : ""
                                                                        }}</span>
                                                                </div>
                                                                <div class="my-4">
                                                                    <select v-model="fillDistrict"
                                                                        name="selectedDistrict"
                                                                        class="block w-full bg-gray-100 rounded-md border-none p-2 duration-300 shadow focus:outline-none"
                                                                        @change="
                                                                            (isLoadingWard = true), getWards($event)
                                                                        ">
                                                                        <option v-if="isLoadingDistrict" value="">
                                                                            Đang tải...
                                                                        </option>
                                                                        <option v-else value="">
                                                                            Chọn quận huyện
                                                                        </option>

                                                                        <option v-for="(district, index) in districts"
                                                                            :key="index" :value="district.DistrictID">
                                                                            {{ district.DistrictName }}
                                                                        </option>
                                                                    </select>
                                                                    <span
                                                                        class="text-red-700 text-[15px] pl-2 font-semibold h-10">{{
                                                                                errors.selectedDistrict
                                                                                    ? errors.selectedDistrict[0]
                                                                                    : ""
                                                                        }}</span>
                                                                </div>
                                                                <div class="my-4">
                                                                    <select name="selectedWard" v-model="fillWard"
                                                                        class="block w-full bg-gray-100 rounded-md border-none p-2 duration-300 shadow focus:outline-none">
                                                                        <option v-if="isLoadingWard" value="">
                                                                            Đang tải...
                                                                        </option>
                                                                        <option v-else value="">
                                                                            Chọn phường xã
                                                                        </option>

                                                                        <option v-for="(ward, index) in wards"
                                                                            :key="index" :value="ward.WardName">
                                                                            {{ ward.WardName }}
                                                                        </option>
                                                                    </select>
                                                                    <span
                                                                        class="text-red-700 text-[15px] pl-2 font-semibold h-10">{{
                                                                                errors.selectedWard
                                                                                    ? errors.selectedWard[0]
                                                                                    : ""
                                                                        }}</span>
                                                                </div>
                                                                <textarea v-model="dataNewAddress.addressNote" rows="4"
                                                                    placeholder="Địa chỉ cụ thể ( Số nhà, tên đường... )"
                                                                    class="block w-full bg-gray-100 rounded-md border-none p-2 duration-300 shadow focus:outline-none resize-none"></textarea>
                                                            </div>
                                                            <div class="mb-5 flex items-center">
                                                                <input class="rounded bg-[#EDEDED]" type="checkbox"
                                                                    v-model="dataNewAddress.is_default"
                                                                    name="is_default" id="is_default" />
                                                                <label for="is_default">
                                                                    <span
                                                                        class="cursor-pointer ml-2 font-semibold text-black">Đặt
                                                                        làm mặc định</span>
                                                                </label>
                                                            </div>
                                                            <div class="text-center m-5 flex justify-center">

                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- footer-->
                    <div class="flex items-center justify-end p-6 border-t border-solid border-slate-200 rounded-b">
                        <div v-if="showModalAddNewAddress == false">
                            <button v-on:click="toggleModalAddRess()"
                                class="text-red-600 bg-transparent border border-solid border-red-500 hover:bg-red-500 hover:text-white active:bg-red-600 font-bold uppercase text-sm px-6 py-3 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                                type="button">
                                Lưu thay đổi
                            </button>

                        </div>
                        <div v-else>
                            <button v-on:click="registerNewAddress()()"
                                class="text-red-600 bg-transparent border border-solid border-red-500 hover:bg-red-500 hover:text-white active:bg-red-600 font-bold uppercase text-sm px-6 py-3 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                                type="button">
                                Lưu thay đổi
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div v-if="showModalAction" class="opacity-25 fixed inset-0 z-40 bg-black"></div>
    </div>
</template>
<script>
import { newAddress } from "../../config/user";

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
            is_default: {},
            showModalAddNewAddress: false,
            dataNewAddress: {
                selectedProvince: "",
                selectedDistrict: "",
                selectedWard: "",
                addressNote: "",
                is_default: false,
            },
            fillProvince: "",
            fillDistrict: "",
            fillWard: "",
            changeDistrict: false,
            changeProvince: false,
            errors: [],
            provinces: [],
            districts: [],
            wards: [],

            isLoadingProvince: false,
            isLoadingDistrict: false,
            isLoadingWard: false,
            isLoading: false,

            statusRegister: 0,
            statusMessage: "",
            lazyLoad: false,
            checkSubmit: false,

        }
    },
    emits: {
        showModalAddress: Boolean,
        idAddRess: Number
        // foobar: Function
    }, props: {
        showModalAction: Boolean,
    },
    mounted() {
        this.getProvinces();
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
            const newAddress = { ...item };
            newAddress.is_default = 1;
            this.is_default = newAddress;
            window.localStorage.setItem("is_default_Address", JSON.stringify(newAddress));

            // let existIsDefaultAddress = is_default_Address.find((item)=>item.id == id);
            // console.log(existIsDefaultAddress);
            this.$emit('idAddRess', item);
        },
        toggleModelAddNewAddress() {
            this.showModalAddNewAddress = !this.showModalAddNewAddress;
            console.log(this.showModalAddNewAddress);
        },
        registerNewAddress() {
            this.dataNewAddress.selectedProvince = this.provinces.filter(
                (value) => value.ProvinceID == this.fillProvince
            )[0]?.ProvinceName;
            this.dataNewAddress.selectedDistrict = this.districts.filter(
                (value) => value.DistrictID == this.fillDistrict
            )[0]?.DistrictName;
            this.dataNewAddress.selectedWard = this.fillWard;
            this.lazyLoad = true;
            newAddress(this.dataNewAddress)
                .then((res) => {
                    this.statusRegister = true;
                    this.statusMessage = res.data;
                    this.lazyLoad = false;
                    this.fillProvince = "";
                    this.fillDistrict = "";
                    this.fillWard = "";
                    this.dataNewAddress.addressNote = "";
                    this.dataNewAddress.is_default = false;
                    this.showModalAddNewAddress = !this.showModalAddNewAddress;
                    this.getAddressUser();
                })
                .catch((error) => {
                    this.statusRegister = false;
                    this.errors = error.response.data.errors;
                    this.lazyLoad = false;
                });
        },

        getProvinces() {
            this.isLoadingProvince = true;
            axios
                .get(
                    "https://online-gateway.ghn.vn/shiip/public-api/master-data/province",
                    {
                        headers: {
                            token: "d0cbad49-5c4b-11ed-b824-262f869eb1a7",
                        },
                    }
                )
                .then((res) => {
                    this.provinces = res.data.data;
                    this.isLoadingProvince = false;
                });
        },

        getDistricts(province) {
            this.isLoadingDistrict = true;
            this.changeProvince = true;
            this.fillDistrict = "";
            this.fillWard = "";
            this.errors = [];
            const provinceId = province.target.value;
            if (provinceId == "") {
                this.districts = [];
                this.isLoadingDistrict = false;
                return;
            }
            axios
                .get(
                    "https://online-gateway.ghn.vn/shiip/public-api/master-data/district",
                    {
                        headers: {
                            token: "d0cbad49-5c4b-11ed-b824-262f869eb1a7",
                        },
                        params: {
                            province_id: provinceId,
                        },
                    }
                )
                .then((res) => {
                    this.districts = res.data.data;
                    this.isLoadingDistrict = false;
                    this.wards = [];
                });
        },

        getWards(district) {
            this.isLoadingWard = true;
            this.changeProvince = false;
            this.fillWard = "";
            this.errors = [];
            const districtId = district.target.value;
            if (districtId == "") {
                this.wards = [];
                this.isLoadingWard = false;
                return;
            }
            axios
                .get(
                    "https://online-gateway.ghn.vn/shiip/public-api/master-data/ward",
                    {
                        headers: {
                            token: "d0cbad49-5c4b-11ed-b824-262f869eb1a7",
                        },
                        params: {
                            district_id: district.target.value,
                        },
                    }
                )
                .then((res) => {
                    this.wards = res.data.data;
                    this.isLoadingWard = false;
                });
        },
    },


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