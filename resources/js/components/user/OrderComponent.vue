<template>
    <section style="height: 568px; max-height: 568px"
        class="flex rounded-xl w-full border my-10 shadow-md shadow-gray-400 relative">
        <section class="w-1/4 border-r-2 px-8 py-5">
            <div class="sticky border-b-2 pb-4 pt-2">
                <i class="fa-solid fa-filter text-2xl text-gray-700 mr-5"></i>
                <span class="text-xl font-bold">Bộ lọc</span>
            </div>
            <div style="max-height: 430px" class="overflow-auto">
                <ul class="pt-3 pb-5">
                    <li class="flex items-center text-xl">
                        <i class="fa-solid fa-caret-right cursor-pointer"></i>
                        <h3 class="ml-2">Theo trạng thái</h3>
                    </li>
                    <li class="flex items-center text-lg my-2">
                        <input type="checkbox" id="all" :value="allChecked" v-model="allChecked"
                            class="rounded-md ml-4 focus:ring-0 cursor-pointer" :checked="allChecked"
                            @click="fillterAll()" />
                        <label for="all" class="cursor-pointer pl-2 select-none">Tất cả</label>
                    </li>
                    <li class="flex items-center text-lg my-2" v-for="(status, index) in listStatus" :key="index">
                        <input @click="fillter(status.order_status_id)" :value="status.order_status_id"
                            :id="'order_status_id_' + status.order_status_id"
                            v-model="checkBoxStatus[status.order_status_id]" type="checkbox"
                            class="rounded-md ml-4 focus:ring-0 cursor-pointer" />
                        <label :for="'order_status_id_' + status.order_status_id"
                            class="cursor-pointer pl-2 select-none">{{ status.status_name }} ({{
                                    status.count_order_product
                            }})</label>
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
                <button @click="undo()" class="undo text-center block m-auto mt-2 text-white px-10 py-2 rounded-lg">
                    Hoàn tác
                </button>
            </div>
        </section>

        <section class="w-3/4 relative">
            <loading v-model:active="is_loading" :is-full-page="false" />
            <div class="sticky w-full flex justify-between p-5 bg-white rounded-xl">
                <div class="flex items-center">
                    <i class="fa-solid fa-receipt text-red-500 text-2xl"></i>
                    <p class="mx-4 text-lg font-bold">Đơn hàng</p>
                </div>
                <label for="search" class="border-b-2 border-b-gray-400">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" id="search" v-model="search" placeholder="Tìm kiếm mã đơn hàng"
                        class="border-none focus:ring-0" />
                    <button @click="searchs()" type="submit"
                        class="searchs p-2 px-3 ml-2 text-sm font-medium text-white rounded-lg border border-red-500 hover:bg-[#fe7500] focus:ring-4 ">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                </label>
            </div>

            <div v-if="listOrder.length > 0" class="px-5 overflow-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-100 h-14">
                            <th class="w-3 pl-4">ID</th>
                            <th class="w-1/5 text-left pl-4">
                                Thông tin đơn hàng
                            </th>
                            <th class="w-3 pl-4">SL</th>
                            <th class="w-1/4 text-left pl-4">Mã đơn hàng</th>
                            <th class="w-1/5 text-left pl-12">Trạng thái</th>
                            <th class="w-1/5 text-left pl-4">Thời gian</th>
                            <th class="w-1/6 text-left pl-4">Chi tiết</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="border-b border-gray-200" v-for="(order, index) in listOrder" :key="index">
                            <td class="text-center">
                                #{{ index + 1 + (this.current_page - 1) * 7 }}
                            </td>
                            <td class="py-2 items-center mt-1">
                                <button @click="showModalDetail(true, order.id)"
                                    class="detail-order mx-2 font-semibold text-center block m-auto mt-2 text-white px-4 rounded-lg">Xem
                                    chi tiết</button>
                            </td>
                            <td class="w-3 pl-4">
                                <span>x{{ order.product_count }}</span>
                            </td>
                            <td class="w-1/4 text-left pl-4">{{ order.order_code }}</td>
                            <td class="mt-1">
                                <button @click="showModalStatus(true, order.id)"
                                    :class="(this.color[order.order_status_id])"
                                    class=" w-[150px] first-line:w-1/5 pl-4 font-semibold rounded-lg px-3 ml-2 text-sm text-white border border-white hover:text-white hover:bg-red-500 focus:ring-4 ">
                                    {{ order.status_name }}
                                </button>
                            </td>
                            <td class="w-1/5 text-left pl-4 font-semibold">
                                {{ format_date(order.updated_at) }}
                            </td>
                            <td class="w-1/6 text-left pl-4">
                                <router-link :to="'/order-detail/' + order.id"><i class="fa-solid fa-list"
                                        style="padding: inherit;"></i></router-link>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <Pagination v-if="dataPagination.last_page > 1" :pagination="dataPagination" :offset="7"
                    @pagination-change-page="getFilterOrderByUser"></Pagination>
            </div>
            <div v-if="listOrder.length <= 0 && is_loading == false" class="flex justify-center items-center"
                style="height: 400px;">
                <p class="font-semibold text-center px-3">
                    Bạn chưa có đơn hàng nào.
                </p>
            </div>
        </section>
    </section>
    <a-modal v-model:visible="showModal" style="width:800px"
        :title="'Thông tin đơn hàng ' + this.listInfo['order_code']">
        <loading v-model:active="is_loading_detail" :is-full-page="false" />
        <div class="relative p-3 pb-5">
            <div class="items-center justify-between">
                <div class="container px-4 mx-auto">
                    <div class="pt-12 md:pt-0 2xl:ps-4">

                        <div class="mt-2">
                            <div class="flex flex-col space-y-4">
                                <div
                                    class="flex items-center justify-between w-full py-2 text-sm font-semibold border-b border-gray-300 lg:py-3 lg:px-3 text-heading last:border-b-0 last:text-base last:pb-0">
                                    <div>
                                        Nguồn hàng:
                                    </div>
                                    <div>
                                        <span class="ml-2" v-for="(source, index) in listSource" :key="index">{{
                                                source.source
                                        }}</span>
                                    </div>
                                </div>
                                <div
                                    class="flex items-center justify-between w-full py-1 text-sm font-semibold border-b border-gray-300 lg:py-3 lg:px-3 text-heading last:border-b-0 last:text-base last:pb-0">
                                    <div>
                                        Phí mua hàng:
                                    </div>
                                    <div>
                                        <span class="ml-2">{{ formatPrice(this.listInfo['purchase_fee'])
                                        }}</span>
                                    </div>
                                </div>
                                <div
                                    class="flex items-center justify-between w-full py-1 text-sm font-semibold border-b border-gray-300 lg:py-3 lg:px-3 text-heading last:border-b-0 last:text-base last:pb-0">
                                    <div>
                                        Phí kiểm hàng:
                                    </div>
                                    <div>
                                        <span class="ml-2">{{ formatPrice(this.listInfo['inventory_fee'])
                                        }}</span>
                                    </div>
                                </div>

                                <div
                                    class="flex items-center justify-between w-full py-1 text-sm font-semibold border-b border-gray-300 lg:py-3 lg:px-3 text-heading last:border-b-0 last:text-base last:pb-0">
                                    <div>
                                        Phí vận chuyển (TQ->VN):
                                    </div>
                                    <div>
                                        <span class="ml-2">{{ this.listInfo['global_shipping_fee'] == "0.00" ?
                                                "Được cập nhập sau khi về kho trung quốc" :
                                                formatPrice(this.listInfo['global_shipping_fee'])
                                        }}</span>
                                    </div>
                                </div>
                                <div
                                    class="flex items-center justify-between w-full py-1 text-sm font-semibold border-b border-gray-300 lg:py-3 lg:px-3 text-heading last:border-b-0 last:text-base last:pb-0">
                                    <div>
                                        Phí vận chuyển (VN):
                                    </div>
                                    <div>
                                        <span class="ml-2 text-red-500">{{ this.listInfo['express_shipping_fee']
                                                == "0.00" ? 'Được cập nhập sau khi về kho Việt Nam' :
                                                formatPrice(this.listInfo['express_shipping_fee'])
                                        }}</span>
                                    </div>
                                </div>
                                <div
                                    class="flex items-center justify-between w-full py-1 text-sm font-semibold border-b border-gray-300 lg:py-3 lg:px-3 text-heading last:border-b-0 last:text-base last:pb-0">
                                    <div>
                                        Tổng tiền (tạm tính):
                                    </div>
                                    <div>
                                        <span class="ml-2 text-red-500">{{
                                                formatPrice(this.listInfo['total_price_order'])
                                        }}</span>
                                    </div>
                                </div>

                                <div
                                    class="flex items-center justify-between w-full py-1 text-sm font-semibold border-b border-gray-300 lg:py-3 lg:px-3 text-heading last:border-b-0 last:text-base last:pb-0">
                                    <div>
                                        Tiền đã trả (đặt cọc):
                                    </div>
                                    <div>
                                        <span class="ml-2 text-red-500">{{
                                                formatPrice(this.listInfo['deposit_amount'])
                                        }}</span>
                                    </div>
                                </div>

                                <div
                                    class="flex items-center justify-between w-full py-1 text-sm font-semibold border-b border-gray-300 lg:py-3 lg:px-3 text-heading last:border-b-0 last:text-base last:pb-0">
                                    <div>
                                        <span> Tiền còn nợ (số tiền còn lại cần thanh toán khi nhận
                                            hàng):</span><br>
                                        <span>(Số tiền sẽ thay đổi liên tục trong quá trình vận chuyển)</span>
                                    </div>
                                    <div>
                                        <span class="ml-2 text-red-500">{{ this.listInfo['remaining_amount'] ==
                                                null ? 'Được cập nhập trong quá trình vận chuyển' :
                                                formatPrice(this.listInfo['remaining_amount'])
                                        }}</span>
                                    </div>
                                </div>
                                <div
                                    class="flex items-center justify-between w-full py-2 text-sm font-semibold border-b border-gray-300 lg:py-5 lg:px-3 text-heading last:border-b-0 last:text-base last:pb-0">
                                    <div>
                                        Địa chỉ nhận:
                                    </div>
                                    <div>
                                        <span class="ml-2 text-sm">SDT:
                                            {{ this.address['phone'] }}/{{ this.address['note'] }}/{{
                                                    this.address['district']
                                            }}/{{ this.address['ward'] }}/{{
        this.address['province']
}}.</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </a-modal>

    <!-- <div v-if="showModal" class="opacity-25 fixed inset-0 z-40 bg-black"></div> -->
    <div v-if="show_modal_status"
        class="overflow-x-hidden overflow-y-auto  fade  fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center flex">
        <div class="relative w-auto my-6 mx-auto max-w-6xl">
            <loading v-model:active="is_loading_status" :is-full-page="false" />
            <!--content-->
            <div
                class="modal-cart border-0 rounded-lg shadow-lg relative flex flex-col bg-white outline-none focus:outline-none ">
                <!--header-->
                <div class="flex items-start justify-between p-5 border-b border-solid border-slate-200 rounded-t">
                    <div>
                        <h4 class="text-xl font-bold">Lịch sử đơn hàng</h4>
                        <button
                            class="detail-order mx-2 font-semibold text-center block m-auto mt-2 text-white px-4 rounded-lg">{{
                                    this.trackingStatusOderId['order_code']
                            }}</button>
                    </div>
                    <button v-on:click="showModalStatus(false)"
                        class="pb-2 ml-auto bg-transparent border-0 text-gray-500 float-right text-3xl leading-none font-semibold outline-none focus:outline-none">
                        x
                    </button>
                </div>
                <!--body-->
                <div class="relative p-3 pb-5">
                    <div class="items-center justify-between">
                        <div class="container px-4 mx-auto">
                            <div class="pt-12 md:pt-0 2xl:ps-4">
                                <div class="flex m-auto h-auto" v-for="(statusDetail, index) in listStatusDetail"
                                    :class="{ 'no-line': index == listStatusDetail.length - 1 }">
                                    <span class="font-semibold text-md w-[150px]">{{ statusDetail.created_at }}</span>
                                    <div class="relative">
                                        <p class="break-point inline-block relative w-[10px] h-[10px] bg-[#E93B3B]"
                                            :class="{ 'bg-[#5672fd]': index == 0 }"></p>
                                    </div>
                                    <span class="w-auto font-semibold" :class="{ 'true-color': index == 0 }">{{
                                            statusDetail.tracking_status_name
                                    }}</span>
                                </div>
                                <div v-if="listStatusDetail.length <= 0 && is_loading == false"
                                    class="flex justify-center items-center" style="height: 100px;">
                                    <p class="font-semibold text-center px-3">
                                        Lịch sử đơn hàng của bạn sẽ được cập nhập sau khi đơn hàng được giao.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div v-if="show_modal_status" class="opacity-25 fixed inset-0 z-40 bg-black"></div>

</template>

<script>
import { getFilterOrder } from "../../config/order";
import { getOrderInfo } from "../../config/order";
import { getHistoryDetail } from "../../config/order";
import loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
import moment from 'moment';
export default {
    watch: {
        $route: {
            immediate: true,
            handler(to, from) {
                document.title = 'Đơn hàng Việt - Trung';
            }
        },
    },
    components: {
        loading,
    },
    data() {
        return {
            showModal: false,
            show_modal_status: false,
            arr_status_id: [],
            checkBoxStatus: [],
            search: '',
            allChecked: true,
            is_loading: false,
            is_loading_detail: false,
            is_loading_status: false,
            color: [],
            address: [],
            listOrder: [],
            listStatus: [],
            listInfo: [],
            listSource: [],
            listStatusDetail: [],
            trackingStatusOderId: [],
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
        format_date(value) {
            if (value) {
                return moment(String(value)).format('DD-MM-YYYY')
            }
        },
        getFilterOrderByUser(page = 1) {
            this.is_loading = true;
            getFilterOrder(page, {
                order_status_id: this.arr_status_id,
                search: this.search,
            })
                .then((res) => {
                    this.dataPagination = res.data.data.filterDataOder;
                    this.listOrder = this.dataPagination.data;
                    this.current_page = this.dataPagination.current_page;
                    this.listStatus = res.data.data.filterStatus;
                    this.countStatusConfirmation = res.data.data.countStatusConfirmation;

                    this.listStatus.forEach((value) => {
                        if (value.order_status_id == 1)
                            this.color[value.order_status_id] = 'text-[#00beff]';
                        else if (value.order_status_id == 4)
                            this.color[value.order_status_id] = 'text-[#ffb900]';
                        else if (value.order_status_id == 5)
                            this.color[value.order_status_id] = 'text-[#fe7500]';
                        else if (value.order_status_id == 6)
                            this.color[value.order_status_id] = 'text-[#00ff00]';
                        else if (value.order_status_id == 7)
                            this.color[value.order_status_id] = 'text-[#1c64f2]';
                        else if (value.order_status_id == 8)
                            this.color[value.order_status_id] = 'text-[#ff3f3a]';
                        else if (value.order_status_id == 9)
                            this.color[value.order_status_id] = 'text-[#ff0000]';
                        else if (value.order_status_id == 10)
                            this.color[value.order_status_id] = 'text-[#4d4da7]';
                        else if (value.order_status_id == 11)
                            this.color[value.order_status_id] = 'text-[#00ff09]';
                        else if (value.order_status_id == 13)
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

        searchs() {
            if (this.search == '') {
                return this.$swal.fire('Chưa có thông tin mã đơn hàng!');
            }
            this.allChecked = true;
            this.listStatus.forEach((value) => {
                this.checkBoxStatus[value.order_status_id] = false;
            })
            this.arr_status_id = [];
            this.getFilterOrderByUser();
        },
        undo() {
            this.allChecked = true;
            this.listStatus.forEach((value) => {
                this.checkBoxStatus[value.order_status_id] = false;
            })
            this.search = '';
            this.arr_status_id = [];
            this.getFilterOrderByUser();
        },
        fillterAll() {
            if (Object.keys(this.arr_status_id).length == 0) {
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
        fillter(id) {
            this.search = '';
            if (this.allChecked == true) {
                this.allChecked = false;
            }
            this.checkBoxStatus[id] = !this.checkBoxStatus[id];

            if (this.checkBoxStatus[id]) {
                this.arr_status_id.push(id);
            } else if (this.checkBoxStatus[id] == false) {
                this.arr_status_id = this.arr_status_id.filter((item) => item != id);
            }
            if (Object.keys(this.arr_status_id).length == 0) {
                this.allChecked = true;
                return this.getFilterOrderByUser();
            }
            this.getFilterOrderByUser();
        },
        showModalStatus(data, order_id = null) {
            this.show_modal_status = data;
            this.trackingStatusOderId = [];
            this.listStatusDetail = [];
            if (order_id) {
                this.is_loading_status = true;
                getHistoryDetail({
                    order_id: order_id,
                })
                    .then((res) => {
                        this.trackingStatusOderId = res.data.data.historyDetail.order;
                        this.listStatusDetail = res.data.data.historyDetail.tracking_status;
                        console.log(this.trackingStatusOderId);

                    })
                    .catch((error) => {
                        this.is_loading_status = false;
                    })
                    .finally(() => {
                        this.is_loading_status = false;
                    });
            }
        },
        showModalDetail(data, order_id = null) {
            this.showModal = data;
            if (order_id) {
                this.is_loading_detail = true;
                getOrderInfo({
                    order_id: order_id,
                })
                    .then((res) => {
                        this.listInfo = res.data.data.orderInfo.order;
                        this.listSource = res.data.data.orderInfo.source;
                        this.address = res.data.data.orderInfo.address;
                    })
                    .catch((error) => {
                        this.is_loading_detail = false;
                    })
                    .finally(() => {
                        this.is_loading_detail = false;
                    });
            }
        },
        pageChange(pageNumber) {
            this.currentPage = pageNumber;
            this.getFilterOrderByUser();
        },

    },
};
</script>

<style scoped>
.undo,
.detail-order,
.searchs {
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

.break-point {
    margin: 5px 25px;
    border-radius: 50%;
    display: flex;
    justify-content: center;
}

.break-point:after {
    content: "";
    width: 3px;
    height: 25px;
    background: #eee8e8;
    position: absolute;
    top: 17px;
}

.no-line .break-point::after {
    position: unset;
    width: 0;
    height: 0;
}

.true-color {
    color: #5672fd;
}

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
