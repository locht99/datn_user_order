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
            <form action="" @submit.prevent="registerNewAddress()">
                <div class="mx-[55px] font-bold">
                    <div class="text-[30px] my-11">
                        <p class="text-center">Thêm địa chỉ</p>
                    </div>
                    <div class="text-[#6B6B6B]">
                        <div class="mb-5">
                            <div class="my-4">
                                <select
                                    name="selectedProvince"
                                    class="block w-full bg-gray-100 rounded-md border-none p-2 duration-300 shadow focus:outline-none"
                                    @change="getDistricts($event)"
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
                                }}</span>
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
                                    <option v-if="isLoadingDistrict" value="">
                                        Đang tải...
                                    </option>
                                    <option v-else value="">
                                        Chọn quận huyện
                                    </option>

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
                                    }}</span>
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
                                    <option v-else value="">
                                        Chọn phường xã
                                    </option>

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
                                }}</span>
                            </div>
                            <textarea
                                v-model="dataNewAddress.addressNote"
                                rows="4"
                                placeholder="Địa chỉ cụ thể ( Số nhà, tên đường... )"
                                class="block w-full bg-gray-100 rounded-md border-none p-2 duration-300 shadow focus:outline-none resize-none"
                            ></textarea>
                        </div>
                        <div class="mb-5 flex items-center">
                            <input class="rounded bg-[#EDEDED]" type="checkbox" v-model="dataNewAddress.is_default" name="is_default" id="is_default" />
                            <label for="is_default">
                                <span class="cursor-pointer ml-2 font-semibold text-black">Đặt làm mặc định</span>
                            </label>
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
import { newAddress } from "../../config/user";
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
export default {
    data() {
        return {
            dataNewAddress: {
                selectedProvince: "",
                selectedDistrict: "",
                selectedWard: "",
                addressNote: "",
                is_default: false
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
        };
    },
    components: {
        Loading,
    },
    mounted() {
        this.getProvinces();
    },

    methods: {
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
                    setTimeout(() => {
                        this.$router.replace("/login");
                    }, 1500);
                    this.lazyLoad = false;
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
};
</script>

<style scoped>
button {
    background-color: #ff3f3a;
}
</style>
