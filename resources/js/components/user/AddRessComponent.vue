<template>
    <div>
        <a-modal v-model="this.showModalAction" width="1000px"
            :title="showModalAddNewAddress == true ? 'Thêm địa chỉ mới' : 'Danh sách địa chỉ'">
            <!--content-->

            <template #footer>
                <div v-if="showModalAddNewAddress == false">

                    <a-button key="back">Return</a-button>
                    <a-button key="submit" type="primary" :loading="loading" @click="toggleModalAddRess()">Lưu thay đổi
                    </a-button>
                </div>
                <div v-else>

                    <a-button key="back">Return</a-button>
                    <a-button key="submit" type="primary" :loading="loading" @click="registerNewAddress()">Lưu thay đổi
                    </a-button>
                </div>

            </template>
            <div class="ml-3">
                <p v-on:click="toggleModelAddNewAddress()"
                    class="text-blue-500 font-semibold text-[18px] cursor-pointer hover:underline hover:decoration-1 ">
                    {{ showModalAddNewAddress == true ? "Danh sách địa chỉ" : "Thêm địa chỉ mới" }}</p>
            </div>
            <!--body-->
            <div class="relative p-3 flex-auto">
                <div class="flex items-center justify-between">
                    <div class="container p-5 mx-auto">

                        <div v-if="showModalAddNewAddress == false">
                            <a-table :columns="columns" :data-source="dataAddress" bordered>
                                <template #bodyCell="{ column, text, record }">
                                    <template v-if="column.dataIndex == 'is_default'">
                                        <input type="radio" name="radio" :checked="text == 1 ? true : false"
                                            v-on:click="checkedAddress(record)">
                                        <label for=""> {{ text == 1 ? ' Mặc định' : '' }}</label>
                                        <!-- <a-radio-group v-on:click="checkedAddress(text)" v-model:value="text">
                                            <a-radio :value="text"></a-radio>
                                        </a-radio-group> -->
                                    </template>
                                </template>
                            </a-table>

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
                                                        @change="getDistricts($event)" v-model="fillProvince">
                                                        <option v-if="isLoadingProvince" value="">
                                                            Đang tải...
                                                        </option>
                                                        <option v-else value="">
                                                            Chọn tỉnh / thành phố
                                                        </option>

                                                        <option v-for="(province, index) in provinces" :key="index"
                                                            :value="province.ProvinceID">
                                                            {{ province.ProvinceName }}
                                                        </option>
                                                    </select>
                                                    <span class="text-red-700 text-[15px] pl-2 font-semibold h-10">{{
                                                            errors.selectedProvince
                                                                ? errors.selectedProvince[0]
                                                                : ""
                                                    }}</span>
                                                </div>
                                                <div class="my-4">
                                                    <select v-model="fillDistrict" name="selectedDistrict"
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

                                                        <option v-for="(district, index) in districts" :key="index"
                                                            :value="district.DistrictID">
                                                            {{ district.DistrictName }}
                                                        </option>
                                                    </select>
                                                    <span class="text-red-700 text-[15px] pl-2 font-semibold h-10">{{
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

                                                        <option v-for="(ward, index) in wards" :key="index"
                                                            :value="ward.WardName">
                                                            {{ ward.WardName }}
                                                        </option>
                                                    </select>
                                                    <span class="text-red-700 text-[15px] pl-2 font-semibold h-10">{{
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
                                                    v-model="dataNewAddress.is_default" name="is_default"
                                                    id="is_default" />
                                                <label for="is_default">
                                                    <span class="cursor-pointer ml-2 font-semibold text-black">Đặt
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
            <!-- footer-->

        </a-modal>

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
    setup() {
        const columns = [

            {
                title: 'Họ tên',
                dataIndex: 'name',

            },
            {
                title: 'Điện thoại',
                dataIndex: 'phone',

            },
            {
                title: 'Tên địa chỉ',
                dataIndex: 'note',

            },
            {
                title: 'Địa chỉ',
                dataIndex: 'ward',

            },
            {
                title: '',
                dataIndex: 'is_default',
            },
        ];
        return {
            columns,
        };
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
            loading: false,
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
        handleOk() {
            this.loading = true;
            setTimeout(() => {
                loading = false;
                visible = false;
            }, 2000);
        },
        toggleModalAddRess() {
            this.$emit('showModalAddress', this.showModalAction);
        },
        getAddressUser() {
            let User = JSON.parse(window.localStorage.getItem("user"));
            getAddress(User.id).then((response) => {
                const isItem = response.data.find((item) => item.is_default == 1);
                window.localStorage.setItem("is_default_Address", JSON.stringify(isItem));
                this.dataAddress = response.data;

            }).catch((error) => {

            })
        },
        checkedAddress(item) {
            // console.log(item);

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