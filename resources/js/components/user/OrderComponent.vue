<template>
    <section
        style="height: 568px; max-height: 568px"
        class="flex rounded-xl w-full border my-10 shadow-md shadow-gray-400"
    >
        <loading v-model:active="is_loading" :is-full-page="false" />
        <section class="w-1/4 border-r-2 px-8 py-5">
            <div class="sticky border-b-2 pb-4 pt-2">
                <i class="fa-solid fa-filter text-2xl text-gray-700 mr-5"></i>
                <span class="text-xl font-bold">Bộ lọc</span>
            </div>
            <div style="max-height: 430px" class="overflow-auto">
                <ul class="pt-3 pb-5">
                    <li class="flex items-center text-xl">
                        <i class="fa-solid fa-caret-right cursor-pointer"></i>
                        <h3 class="ml-2">Theo website</h3>
                    </li>
                    <li class="flex items-center text-lg my-2">
                        <input
                            type="checkbox"
                            id="1688"
                            @click="fillterSource('1688')"
                            v-model="checkBoxSource['1688']"
                            value="1688"
                            class="rounded-md ml-4 focus:ring-0 cursor-pointer"
                        />
                        <label
                            for="1688"
                            class="cursor-pointer pl-2 select-none"
                            >1688.com</label
                        >
                    </li>
                    <li class="flex items-center text-lg my-2">
                        <input
                            type="checkbox"
                            value="TAOBAO"
                            @click="fillterSource('taobao')"
                            v-model="checkBoxSource['taobao']"
                            id="taobao"
                            class="rounded-md ml-4 focus:ring-0 cursor-pointer"
                        />
                        <label
                            for="taobao"
                            class="cursor-pointer pl-2 select-none"
                            >taobao.com</label
                        >
                    </li>
                </ul>

                <ul class="pt-3 pb-5">
                    <li class="flex items-center text-xl">
                        <i class="fa-solid fa-caret-right cursor-pointer"></i>
                        <h3 class="ml-2">Theo trạng thái</h3>
                    </li>
                    <li class="flex items-center text-lg my-2">
                        <input
                            type="checkbox"
                            id="all"
                            :value="allChecked"
                            v-model="allChecked"
                            class="rounded-md ml-4 focus:ring-0 cursor-pointer"
                            :checked="allChecked"
                            @click="fillterAll()"
                        />
                        <label
                            for="all"
                            class="cursor-pointer pl-2 select-none"
                            >Tất cả</label
                        >
                    </li>
                    <li
                        class="flex items-center text-lg my-2"
                        v-for="(status, index) in listStatus"
                        :key="index"
                    >
                        <input
                            @click="fillter(status.order_status_id)"
                            :value="status.order_status_id"
                            :id="'order_status_id_' + status.order_status_id"
                            v-model="checkBoxStatus[status.order_status_id]"
                            type="checkbox"
                            class="rounded-md ml-4 focus:ring-0 cursor-pointer"
                        />
                        <label :for="'order_status_id_' + status.order_status_id" class="cursor-pointer pl-2 select-none"
                            >{{ status.status_name }} ({{
                                status.count_order_product
                            }})</label
                        >
                    </li>
                </ul>
                <!-- Theo trạng thái -->
                <ul class="pt-3 pb-5">
                    <li class="flex items-center text-xl">
                        <i class="fa-solid fa-caret-right cursor-pointer"></i>
                        <h3 class="ml-2">
                            Chờ xác nhận ({{ countStatusConfirmation }})
                        </h3>
                    </li>
                </ul>
            </div>

            <div class="border-t-2">
                <button @click="undo()" class="text-center block m-auto mt-2 text-white px-10 py-2 rounded-lg">
                    Hoàn tác
                </button>
            </div>
        </section>

        <section class="w-3/4">
            <div
                class="sticky w-full flex justify-between p-5 bg-white rounded-xl"
            >
                <div class="flex items-center">
                    <i class="fa-solid fa-receipt text-red-500 text-2xl"></i>
                    <p class="mx-4 text-lg font-bold">Đơn hàng</p>
                </div>
                <label for="search" class="border-b-2 border-b-gray-400">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input
                        type="text"
                        id="search"
                        v-model="search"
                        placeholder="Tìm kiếm mã đơn hàng"
                        class="border-none focus:ring-0"
                    />
                    <button @click="searchs()" type="submit" class="p-2 px-3 ml-2 text-sm font-medium text-white rounded-lg border border-red-500 hover:bg-[#fe7500] focus:ring-4 ">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </label>
            </div>

            <div class="px-5 overflow-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-100 h-14">
                            <th class="w-3 pl-4">Stt</th>
                            <th class="w-1/3 text-left pl-4">
                                Thông tin đơn hàng
                            </th>
                            <th class="w-1/5 text-left pl-4">Gian hàng</th>
                            <th class="w-1/5 text-left pl-4">Mã đơn hàng</th>
                            <th class="w-1/5 text-left pl-4">Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            class="border-b border-gray-200"
                            v-for="(order, index) in listOrder"
                            :key="index"
                        >
                            <td class="text-center">
                                #{{ index + 1 + (this.current_page - 1) * 7 }}
                            </td>
                            <td class="py-3 flex items-center mt-1">
                                <a href="" class="mx-2 underline">{{
                                    order.shop_name
                                }}</a>
                                <span>x{{order.product_count}}</span>
                            </td>
                            <td class="w-1/5 pl-4">{{ order.source }}</td>
                            <td class="w-1/5 pl-4">{{ order.order_code }}</td>
                            <td :class="(this.color[order.order_status_id])" class="first-line:w-1/5 pl-4 font-semibold">
                                {{ order.status_name }}
                            </td>
                        </tr>
                    </tbody>
                </table>
                <Pagination
                    v-if="dataPagination.last_page > 1"
                    :pagination="dataPagination"
                    :offset="7"
                    @pagination-change-page="getFilterOrderByUser"
                ></Pagination>
            </div>
        </section>
    </section>
</template>

<script>
import { getFilterOrder } from "../../config/order";
import loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
import { useAttrs } from "vue";
export default {
    components: {
        loading,
    },
    data() {
        return {
            arr_status_id: [],
            arr_source: [],
            checkBoxStatus: [],
            checkBoxSource: [],
            search: '',
            allChecked: true,
            is_loading: false,
            color: [],
            listOrder: [],
            listStatus: [],
            countStatusConfirmation: 0,
            dataPagination: {},
            current_page: 0,
            lazyLoad: false,
        };
    },
    mounted() {
        this.getFilterOrderByUser();
    },
    methods: {
        formatPrice(value) {
            return new Intl.NumberFormat("en-US", {
                style: "currency",
                currency: "VND",
            }).format(value);
        },
        getFilterOrderByUser(page = 1) {
            this.is_loading = true;
            getFilterOrder(page, {
                order_status_id: this.arr_status_id,
                source: this.arr_source,
                search: this.search,
            })
                .then((res) => {
                    this.dataPagination = res.data.data.filterDataOder;
                    this.listOrder = this.dataPagination.data;
                    this.current_page = this.dataPagination.current_page;
                    this.listStatus = res.data.data.filterStatus;
                    this.countStatusConfirmation = res.data.data.countStatusConfirmation;

                    this.listStatus.forEach((value) => {
                        if(value.order_status_id == 1)
                            this.color[value.order_status_id] = 'text-[#00beff]';
                        else if(value.order_status_id == 4)
                            this.color[value.order_status_id] = 'text-[#ffb900]';
                        else if(value.order_status_id == 5)
                            this.color[value.order_status_id] = 'text-[#fe7500]';
                        else if(value.order_status_id == 6)
                            this.color[value.order_status_id] = 'text-[#00ff00]';
                        else if(value.order_status_id == 7)
                            this.color[value.order_status_id] = 'text-[#1c64f2]';
                        else if(value.order_status_id == 8)
                            this.color[value.order_status_id] = 'text-[#ff3f3a]';
                        else if(value.order_status_id == 9)
                            this.color[value.order_status_id] = 'text-[#ff0000]';
                        else if(value.order_status_id == 10)
                            this.color[value.order_status_id] = 'text-[#4d4da7]';
                        else if(value.order_status_id == 11)
                            this.color[value.order_status_id] = 'text-[#000000]';
                        else if(value.order_status_id == 13)
                            this.color[value.order_status_id] = 'text-[#ff0000]';
                        else
                            this.color[value.order_status_id] = 'text-[#808080]';
                    })
                })
                .catch((error) => {
                    this.is_loading = false;
                })
                .finally(() => {
                    this.is_loading = false;
                });
        },
        searchs(){
            if(this.search == ''){
                return this.$swal.fire('Chưa có thông tin mã đơn hàng!');
            }
            this.allChecked = true;
            this.checkBoxSource['taobao'] = false;
            this.checkBoxSource['1688'] = false;
            this.listStatus.forEach((value) => {
                this.checkBoxStatus[value.order_status_id] = false;
            })
            this.arr_source = [];
            this.arr_status_id = [];
            this.getFilterOrderByUser();
        },
        undo(){
            this.allChecked = true;
            this.checkBoxSource['taobao'] = false;
            this.checkBoxSource['1688'] = false;
            this.listStatus.forEach((value) => {
                this.checkBoxStatus[value.order_status_id] = false;
            })
            this.search = '';
            this.arr_source = [];
            this.arr_status_id = [];
            this.getFilterOrderByUser();
        },
        fillterAll(){
            if(Object.keys(this.arr_status_id).length == 0){
                // this.allChecked = true;
                return this.$swal.fire('Đang chọn trạng thái tất cả!');
            }
            this.listStatus.forEach((value) => {
                this.checkBoxStatus[value.order_status_id] = false;
            })
            this.search = '';
            this.arr_status_id = [];
            this.getFilterOrderByUser();
        },
        fillterSource(source) {
          this.checkBoxSource[source] = !this.checkBoxSource[source];

          if (this.checkBoxSource[source]) {
            this.arr_source.push(source);
          }else if (this.checkBoxSource[source] == false) {
            this.arr_source = this.arr_source.filter((item) => item != source);
          }
          this.search = '';
          this.getFilterOrderByUser();
        },
        fillter(id) {
            this.search = '';
            if(this.allChecked == true){
                this.allChecked = false;
            }
            this.checkBoxStatus[id] = !this.checkBoxStatus[id];

            if (this.checkBoxStatus[id]) {
              this.arr_status_id.push(id);
            }else if (this.checkBoxStatus[id] == false) {
              this.arr_status_id = this.arr_status_id.filter((item) => item != id);
            }
            if(Object.keys(this.arr_status_id).length == 0){
                this.allChecked = true;
                return this.getFilterOrderByUser();
            }
            this.getFilterOrderByUser();
        },
        pageChange(pageNumber) {
            this.currentPage = pageNumber;
            this.getFilterOrderByUser();
        },
    },
};
</script>

<style scoped>
button {
    background-color: #ff3f3a;
}
::-webkit-scrollbar {
    width: 15px;
    height: 20px;
}

::-webkit-scrollbar-track {
    border-radius: 100vh;
    background: transparent;
}

::-webkit-scrollbar-thumb {
    background: #e0cbcb;
    border-radius: 100vh;
    border: 3px solid #f6f7ed;
}

::-webkit-scrollbar-thumb:hover {
    background: rgb(253, 114, 114);
}

.min-w-max.pagination div {
    display: none !important;
    background: yellow;
}
</style>
