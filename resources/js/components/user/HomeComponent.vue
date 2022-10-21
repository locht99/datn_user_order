<template>
    <section class="homepage-content grid gap-4 mt-[20px]">
        <section
            class="border rounded-xl shadow-md shadow-gray-400 px-5 max-h-[568px] h-auto overflow-hidden"
        >
            <p class="my-5 items-center flex">
                <img src="/images/trolley.png" alt="" />
                <b class="mx-2 text-lg">Đơn hàng mới: </b>
                <span class="text-lg font-semibold text-gray-500">5 đơn</span>
            </p>

            <table class="w-full ">
                <thead class="sticky">
                    <tr class="bg-gray-100 h-12 table w-full box-border">
                        <th class="w-1/4 text-left pl-20">Mã đơn</th>
                        <th class="w-1/4 text-left pl-20">Lịch sử</th>
                        <th class="w-1/4 text-left pl-20">Trạng thái</th>
                        <th class="w-1/4 text-left pl-20">Khác</th>
                    </tr>
                </thead>
                <tbody class="block max-h-[238px] overflow-y-auto">
                    <tr
                        class="h-16 border-b border-gray-300 table w-full box-border"
                    >
                        <td class="pl-20 w-1/4">MD001</td>
                        <td class="w-1/4 pl-20">16:30 - 26/8/2022</td>
                        <td class="w-1/4 pl-20">Chờ xác nhận</td>
                        <td
                            class="w-1/4 pl-20 text-blue-600 cursor-pointer underline"
                        >
                         <router-link to="/order-detail">chi tiết</router-link> 
                        </td>
                    </tr>
                    <tr
                        class="h-16 border-b border-gray-300 table w-full box-border"
                    >
                        <td class="pl-20 w-1/4">MD001</td>
                        <td class="w-1/4 pl-20">16:30 - 26/8/2022</td>
                        <td class="w-1/4 pl-20">Chờ xác nhận</td>
                        <td
                            class="w-1/4 pl-20 text-blue-600 cursor-pointer underline"
                        >
                         <router-link to="/order-detail">chi tiết</router-link> 
                        </td>
                    </tr>
                    <tr
                        class="h-16 border-b border-gray-300 table w-full box-border"
                    >
                        <td class="pl-20 w-1/4">MD001</td>
                        <td class="w-1/4 pl-20">16:30 - 26/8/2022</td>
                        <td class="w-1/4 pl-20">Chờ xác nhận</td>
                        <td
                            class="w-1/4 pl-20 text-blue-600 cursor-pointer underline"
                        >
                         <router-link to="/order-detail">chi tiết</router-link> 
                        </td>
                    </tr>
                    <tr
                        class="h-16 border-b border-gray-300 table w-full box-border"
                    >
                        <td class="pl-20 w-1/4">MD001</td>
                        <td class="w-1/4 pl-20">16:30 - 26/8/2022</td>
                        <td class="w-1/4 pl-20">Chờ xác nhận</td>
                        <td
                            class="w-1/4 pl-20 text-blue-600 cursor-pointer underline"
                        >
                         <router-link to="/order-detail">chi tiết</router-link> 
                        </td>
                    </tr>
                    <tr
                        class="h-16 border-b border-gray-300 table w-full box-border"
                    >
                        <td class="pl-20 w-1/4">MD001</td>
                        <td class="w-1/4 pl-20">16:30 - 26/8/2022</td>
                        <td class="w-1/4 pl-20">Chờ xác nhận</td>
                        <td
                            class="w-1/4 pl-20 text-blue-600 cursor-pointer underline"
                        >
                         <router-link to="/order-detail">chi tiết</router-link> 
                        </td>
                    </tr>

                </tbody>
            </table>
        </section>

        <section class="border rounded-xl shadow-md shadow-gray-400">
            <p class="flex justify-center items-center my-8">
                <img src="/images/payper-send.png" alt="" class="mx-2" />
                <b class="mx-2 text-lg">Hoạt động mới</b>
            </p>
        </section>
    </section>
    <div
        class="bank border rounded-xl shadow-md shadow-gray-400 mt-5 p-5 h-[210px] h-auto overflow-hidden w-full"
    >
        <div class="head flex">
            <div class="title w-[200px]">
                <i
                    class="fa-solid fa-building-columns text-red-700 text-[30px]"
                ></i>
                <span class="font-bold text-[20px] ml-4">Số tài khoản</span>
            </div>
            <div
                class="line bg-[#F5F5F5] w-full ml-5 px-10 rounded-xl font-bold"
            >
                <p class="pt-1">
                    Để tiền <span class="text-red-700">NẠP TIỀN</span> vào ví
                    nhanh. Chuyển khoản quý khách vui lòng nhập nội dung:
                    <span class="text-red-700">KH0001</span> (không thêm bớt).
                </p>
            </div>
        </div>
        <div class="main mt-5 flex">
            <div class="ti-gia bg-[#F5F5F5] w-auto flex p-5 rounded-xl">
                <img src="/images/transaction.png" alt="" class="w-[60px] h-[60px] mr-5" />
                <div class="text mt-2">
                    <span class="font-bold">¥1 = 3,630₫</span> <br />
                    <span>Tỷ giá nhân dân tệ</span>
                </div>
            </div>
            <div class="bank-item w-full ml-5 ">
                <table class="table-auto ">
                    <thead>
                        <tr class="border-b-2">
                            <td class="border-r-2">
                                <img
                                    src="/images/vcb.png"
                                    alt=""
                                    class="w-[100px] m-auto"
                                    
                                />
                            </td>
                            <td class="border-r-2">
                                <img
                                    src="/images/tcb.png"
                                    alt=""
                                    class="w-[100px] m-auto" 
                                />
                            </td>
                            <td>
                                <img
                                    src="/images/vtb.png"
                                    alt=""
                                    class="w-[100px] m-auto"
                                />
                            </td>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td class="px-4 border-r-2">
                                <ul>
                                    <li>Chủ tài khoản: VU CONG LUC</li>
                                    <li>STK: 9978942425</li>
                                    <li>
                                        Chi nhánh: Vietcombank CN Quảng Ninh.
                                    </li>
                                </ul>
                            </td>
                            <td class="px-4 border-r-2">
                                <ul>
                                    <li>Chủ tài khoản: VU CONG LUC</li>
                                    <li>STK: 9978942425</li>
                                    <li>
                                        Chi nhánh: Vietcombank CN Quảng Ninh.
                                    </li>
                                </ul>
                            </td>
                            <td class="px-4">
                                <ul>
                                    <li>Chủ tài khoản: VU CONG LUC</li>
                                    <li>STK: 9978942425</li>
                                    <li>
                                        Chi nhánh: Vietcombank CN Quảng Ninh.
                                    </li>
                                </ul>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
export default {
    data() {
        return {};
    },

    methods: {
        getAll() {
            axios.get("getUser").then((res) => {
                console.log(res.data);
            });
        },
    },

    mounted() {
        this.getAll();
    },
};
</script>

<style scoped>
.homepage-content {
    grid-template-columns: 2fr 1fr;
}
</style>
