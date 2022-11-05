<template>
    <div class="m-auto">
        <img
            src="images/background-user.png"
            alt="background"
            class="w-full h-screen"
        />
        <div
            class="w-[750px] h-fit pb-8 bg-white absolute top-0 right-0 left-0 bottom-0 z-[100] m-auto rounded-lg"
        >
            <div
                v-if="statusRegister"
                class="bg-green-500 text-white font-bold py-2 p-4 absolute top-0 left-0 w-full rounded-tl-lg rounded-tr-lg"
            >
                {{ statusMessage }}
            </div>

            <form class="mx-[55px] font-bold" @submit.prevent="registerUser()">
                <div class="text-[30px] my-11">
                    <p class="text-center">Đăng ký</p>
                </div>
                <div class="text-[#6B6B6B] grid grid-cols-2 gap-5">
                    <div>
                        <div class="mb-4">
                            <input
                                v-model="dataRegister.username"
                                type="text"
                                placeholder="Tên tài khoản"
                                class="block w-full bg-gray-100 rounded-md border-none p-2 duration-300 shadow focus:outline-none"
                            />
                            <span
                                class="text-red-700 text-[15px] pl-2 font-semibold h-5"
                                >{{
                                    typeof errors.username !== "undefined"
                                        ? errors.username[0]
                                        : ""
                                }}</span
                            >
                        </div>

                        <div class="my-4">
                            <input
                                type="text"
                                v-model="dataRegister.email"
                                placeholder="Email"
                                class="block w-full bg-gray-100 rounded-md border-none p-2 duration-300 shadow focus:outline-none"
                            />
                            <span
                                class="text-red-700 font-semibold text-[15px] pl-2 h-5"
                                >{{ errors.email ? errors.email[0] : "" }}</span
                            >
                        </div>
                        <div class="my-4">
                            <input
                                type="password"
                                v-model="dataRegister.confirm_password"
                                placeholder="Nhập lại mật khẩu"
                                autocomplete="true"
                                class="block w-full bg-gray-100 rounded-md border-none p-2 duration-300 shadow focus:outline-none"
                            />
                            <span
                                class="text-red-700 text-[15px] pl-2 font-semibold h-10"
                                >{{
                                    errors.confirm_password
                                        ? errors.confirm_password[0]
                                        : ""
                                }}</span
                            >
                        </div>

                        <div class="my-4">
                            <select
                                v-model="fillDistrict"
                                name="selectedDistrict"
                                class="block w-full bg-gray-100 rounded-md border-none p-2 duration-300 shadow focus:outline-none"
                                @change="
                                    (isLoadingWard = true), getWards($event)
                                "
                            >
                                <option
                                    v-if="isLoadingDistrict"
                                    value=""
                                >
                                    Đang tải...
                                </option>
                                <option v-else value="">Chọn quận huyện</option>

                                <option
                                    v-for="(district, index) in districts"
                                    :key="index"
                                    :value="district.DistrictID"
                                >
                                    {{ district.DistrictName }}
                                </option>
                            </select>
                            <span
                                class="text-red-700 text-[15px] pl-2 font-semibold h-10"
                                >{{
                                    errors.selectedDistrict
                                        ? errors.selectedDistrict[0]
                                        : ""
                                }}</span
                            >
                        </div>
                    </div>
                    <div>
                        <div class="mb-4">
                            <input
                                type="text"
                                v-model="dataRegister.phone"
                                placeholder="Số điện thoại"
                                class="block w-full bg-gray-100 rounded-md border-none p-2 duration-300 shadow focus:outline-none"
                            />
                            <span
                                class="text-red-700 text-[15px] pl-2 font-semibold h-10"
                                >{{ errors.phone ? errors.phone[0] : "" }}</span
                            >
                        </div>
                        <div class="my-4">
                            <input
                                type="password"
                                v-model="dataRegister.password"
                                placeholder="Mật khẩu"
                                autocomplete="true"
                                class="block w-full bg-gray-100 rounded-md border-none p-2 duration-300 shadow focus:outline-none"
                            />
                            <span
                                class="text-red-700 text-[15px] pl-2 font-semibold h-10"
                                >{{
                                    errors.password ? errors.password[0] : ""
                                }}</span
                            >
                        </div>

                        <div class="my-4">
                            <select
                                name="selectedProvince"
                                class="block w-full bg-gray-100 rounded-md border-none p-2 duration-300 shadow focus:outline-none"
                                @change="
                                    getDistricts($event)
                                "
                                v-model="fillProvince"
                            >
                                <option v-if="isLoadingProvince" value="">
                                    Đang tải...
                                </option>
                                <option v-else value="">
                                    Chọn tỉnh / thành phố
                                </option>

                                <option
                                    v-for="(province, index) in provinces"
                                    :key="index"
                                    :value="province.ProvinceID"
                                >
                                    {{ province.ProvinceName }}
                                </option>
                            </select>
                            <span
                                class="text-red-700 text-[15px] pl-2 font-semibold h-10"
                                >{{
                                    errors.selectedProvince
                                        ? errors.selectedProvince[0]
                                        : ""
                                }}</span
                            >
                        </div>

                        <div class="my-4">
                            <select
                                name="selectedWard"
                                v-model="fillWard"
                                class="block w-full bg-gray-100 rounded-md border-none p-2 duration-300 shadow focus:outline-none"
                            >
                                <option v-if="isLoadingWard" value="">
                                    Đang tải...
                                </option>
                                <option v-else value="">Chọn phường xã</option>

                                <option
                                    v-for="(ward, index) in wards"
                                    :key="index"
                                    :value="ward.WardName"
                                >
                                    {{ ward.WardName }}
                                </option>
                            </select>
                            <span
                                class="text-red-700 text-[15px] pl-2 font-semibold h-10"
                                >{{
                                    errors.selectedWard
                                        ? errors.selectedWard[0]
                                        : ""
                                }}</span
                            >
                        </div>
                    </div>
                </div>
                <div>
                    <textarea
                        v-model="dataRegister.addressNote"
                        rows="2"
                        placeholder="Địa chỉ cụ thể ( Số nhà, tên đường... )"
                        class="block w-full bg-gray-100 rounded-md border-none p-2 duration-300 shadow focus:outline-none resize-none"
                    ></textarea>
                </div>
                <div class="text-center m-5">
                    <button
                        :disabled="checkSubmit"
                        class="rounded-2xl text-white px-7 border-solid border-[#B6B4B4] bg-[#FF3F3A] p-6"
                    >
                        <img
                            v-if="!lazyLoad"
                            class="cursor-pointer user-select-none"
                            src="images/menu-icon/right-arrow-30.png"
                            alt="icon"
                        />
                        <svg
                            v-if="lazyLoad"
                            class="animate-spin h-7 w-7 text-white fill-white cursor-pointer user-select-none"
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
                    </button>
                </div>
            </form>
            <div class="text-center font-semibold">
                <router-link class="hover:text-red-500" to=""
                    >Quên mật khẩu</router-link
                >
                /
                <router-link class="hover:text-red-500" to="/login"
                    >Đăng nhập</router-link
                >
            </div>
        </div>
    </div>
</template>
<script>
import axios from "axios";
import { register } from "../../config/user";

export default {
    data() {
        return {
            dataRegister: {
                username: "",
                email: "",
                address: "",
                phone: "",
                password: "",
                confirm_password: "",
                selectedProvince: "",
                selectedDistrict: "",
                selectedWard: "",
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

            statusRegister: 0,
            statusMessage: "",
            lazyLoad: false,
            checkSubmit: false
        };
    },
    mounted() {
        this.getProvinces();
    },
    watch: {},

    methods: {
        registerUser() {
            this.dataRegister.selectedProvince = this.provinces.filter(
                (value) => value.ProvinceID == this.fillProvince
            )[0]?.ProvinceName;
            this.dataRegister.selectedDistrict = this.districts.filter(
                (value) => value.DistrictID == this.fillDistrict
            )[0]?.DistrictName;
            this.dataRegister.selectedWard = this.fillWard;
            this.lazyLoad = true;
            this.checkSubmit = true

            register(this.dataRegister)
                .then((res) => {
                    this.statusRegister = true;
                    this.statusMessage = res.data;
                    setTimeout(() => {
                        this.lazyLoad = false;
                        this.$router.replace("/login");
                    }, 1500);
                })
                .catch((error) => {
                    this.checkSubmit = false
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
                this.isLoadingDistrict = false
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
                this.isLoadingWard = false
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
};
</script>
<style></style>
