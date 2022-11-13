<template>
    <loading v-model:active="is_loading" :is-full-page="false" />
    <div
        class="rounded-xl shadow-md shadow-gray-400 mt-5 p-5 h-auto overflow-hidden w-full"
    >
        <h1 class="text-bold">
            <i class="fa-solid fa-bag-shopping text-red-600 text-[25px]"></i>
            <span class=" ml-3" style="font-weight: bold"
                >Chi tiết đơn hàng : {{this.order_code['order_code']}}</span
            >
        </h1>
        <div class="list mt-5 overflow-y-auto max-h-[500px]">
            <div class="item flex p-5 border-b-2" v-for="(product, index) in listProducts" :key="index">
                <img
                    :src="product.image_link"
                    alt=""
                    class="w-[200px] h-200px]"
                />
                <div class="content ml-5 w-full">
                    <h2 class="font-bold">
                        Sản phẩm: {{product.product_name}}
                    </h2>
                    <div class="main flex w-full font-semibold my-5">
                        <div class="detail-price pr-[120px] border-r">
                            <ul>
                                <li>
                                    Giá gốc( ¥ ):
                                    <span class="text-red-600"> ¥ {{product.original_price}}</span>
                                </li>
                                <li>
                                    Giá khuyến mãi( ¥ ):
                                    <span class="text-red-600"> ¥ {{product.promotion_price}}</span>
                                </li>
                                <li>
                                    Giá tiền Việt ( ₫ ):
                                    <span class="text-red-600">{{formatPrice(product.price)}}</span>
                                    <span> ( chưa bao gồm chi phí vận chuyển )</span>
                                </li>
                            </ul>
                            <button
                                class="text-red-700 bg-[#F9C74F] py-1 px-4 rounded-xl mt-5"
                            >
                                {{product.status_name}}
                            </button>
                        </div>
                        <div class="detail-product ml-5">
                            <ul>
                                <li>
                                    Website:
                                    <span class="font-bold">{{product.source}}. </span>
                                </li>
                                <li>
                                    Size ( khích thước ): 
                                    <span class="font-bold"> .</span>
                                </li>
                                <li>
                                    Thuộc tính:
                                    <span class="font-bold"> {{product.properties}}.</span>
                                </li>
                                <li>
                                    Quantity ( Số lượng ):
                                    <span class="font-bold">{{product.quantity_bought}}.</span>
                                </li>
                                <li>
                                    Đường dẫn sản phẩm ( link ):
                                    <a
                                        :href="product.url"
                                        class="text-white bg-red-600 pb-1 px-4 rounded-2xl"
                                    >
                                    <i class="fa-sharp fa-solid fa-eye"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import { getOrderProductDetail } from "../../config/order";
import loading from "vue-loading-overlay";
export default {
    components: {
        loading,
    },
    data() {
        return {
            listProducts: [],
            order_code: [],
            is_loading: false,
            lazyLoad: false,
        };
    },
    created() {
        this.getOrderProductDetailByUser();
    },
    methods: {
        formatPrice(value) {
            return new Intl.NumberFormat("en-US", {
                style: "currency",
                currency: "VND",
            }).format(value);
        },
        getOrderProductDetailByUser() {
            this.is_loading = true;
            getOrderProductDetail(this.$route.params.id)
            .then((res) => {
                if(res.data.status == 404){
                    this.$swal.fire(res.data.data.message);
                }else{
                    this.listProducts = res.data.data.orderDetail.order_products;
                    this.order_code = res.data.data.orderDetail.order;
                }
            })
            .catch((error) => {
                this.is_loading = false;
            })
            .finally(() => {
                this.is_loading = false;
            });
        },
    }
}
</script>
