<template>
  <Transition name="fade-in">

    <section style="height: 568px; max-height: 568px" class="border rounded-xl shadow-md shadow-gray-400 my-10">
      <loading v-model:active="is_loading" :is-full-page="false" />
      <!-- Header cart -->
      <section class="sticky w-full flex justify-between px-5 py-5 bg-white rounded-xl">
        <div class="flex items-center">
          <img src="/images/trolley.png" alt="" />
          <b class="mx-2 text-lg">Giỏ hàng</b>
        </div>
        <label for="search" class="border-b-2 border-b-gray-400">
          <i class="fa-solid fa-magnifying-glass"></i>
          <input type="text" id="search" placeholder="Tìm kiếm sản phẩm" class="border-none focus:ring-0" />
        </label>
      </section>

      <!-- Content cart -->
      <section style="max-height: 424px" class="overflow-auto">
        <section class="py-5 px-5" v-for="(cart, index) in listCart" :key="index">
          <div class="rounded-xl shadow-md shadow-gray-400">
            <div class="
              px-5
              py-3
              flex
              justify-between
              items-center
              bg-gray-100
              rounded-xl
            ">
              <div class="flex items-center">
                <img src="/images/1688-logo.png" alt="" v-if="cart.source == '1688'" />
                <img src="/images/tmall-logo.png" alt="" v-else-if="cart.source == 'TMALL'" />
                <img src="/images/taobao-logo.png" alt="" v-else-if="cart.source == 'TAOBAO'" />
                <p class="ml-10 text-xl" v-if="cart.shop_name">{{ cart.shop_name }}</p>
                <p class="ml-10 text-xl" v-else>Không xác định</p>
              </div>
              <div class="flex items-center">
                <label for="kiemhang" class="mx-4 cursor-pointer select-none">
                  <input type="checkbox"  v-model="checkGoods[cart.id]" class="
                    mb-1
                    rounded-md
                    cursor-pointer
                    focus:ring-0
                    w-5
                    h-5
                    border-2 border-gray-400
                  " />
                  <i class="fa-solid fa-box-open mx-2 text-lg text-gray-700"></i>
                  <span class="text-lg font-semibold text-gray-600">Kiểm hàng</span>
                </label>

                <label for="donggo" class="mx-4 cursor-pointer select-none">
                  <input type="checkbox"  name="ff" class="
                    mb-1
                    rounded-md
                    cursor-pointer
                    focus:ring-0
                    w-5
                    h-5
                    border-2 border-gray-400
                  " />
                  <i class="fa-solid fa-boxes-stacked mx-2 text-lg text-gray-700"></i>
                  <span class="text-lg font-semibold text-gray-600">Đóng gỗ</span>
                </label>

                <label for="donggorieng" class="mx-4 cursor-pointer select-none">
                  <input type="checkbox" name="ff"
                    class="mb-1 rounded-md focus:ring-0 w-5 h-5 border-2 border-gray-400" />
                  <i class="fa-solid fa-box mx-2 text-lg text-gray-700"></i>
                  <span class="text-lg font-semibold text-gray-600">Đóng gỗ riêng</span>
                </label>
              </div>
            </div>
            <div class="w-full flex">
              <div class="w-3/4 border-r-2">
                <table class="w-full">
                  <thead class="h-14 border-b-2">
                    <tr>
                      <th class="text-left pl-8">
                        <input type="checkbox" v-model="checkBox[index]" v-on:click="checkAllByShop(index)"
                          class="rounded-md cursor-pointer focus:ring-0 w-5 h-5 border-2 border-gray-400" />
                      </th>

                      <th class="text-xl text-left pl-8">Sản phẩm</th>
                      <th class="text-xl text-left pl-8">Số lượng</th>
                      <th class="text-xl text-left pl-8">Tiền hàng</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr class="items-center" v-for="(listCartProduct, index2) in cart.cart_products" :key="index2">
                      <td class="pl-8">
                        <input type="checkbox" v-on:click="checkByItem(listCartProduct.id, index)"
                          v-model="checkBoxItem[listCartProduct.id]"
                          class="rounded-md cursor-pointer focus:ring-0 w-5 h-5 border-2 border-gray-400" />
                      </td>
                      <td class="pl-8 items-center">
                        <img :src="listCartProduct.image" class="w-24 py-4 pr-2 float-left" />
                        <a class="mt-8 underline block">{{ listCartProduct.product_name }}</a>
                      </td>
                      <td class="pl-8">
                        <input type="number" v-on:change="cartQuantity(listCartProduct, index, index2)"
                          v-model="listCartProduct.quantity"
                          class="w-24 rounded-md h-8 border-2 border-gray-400 font-semibold text-lg focus:ring-0">
                      </td>
                      <td class="pl-8">
                        <p class="text-red-500 font-semibold text-xl">¥{{ listCartProduct.unit_price_cn }}</p>
                        <p class="text-red-500 font-semibold text-xl">{{ formatPrice(listCartProduct.unit_price_vn) }} đ
                        </p>
                      </td>
                      <td class="pl-8">
                        <p class="text-red-500 font-semibold text-xl">¥{{ listCartProduct.price_cn }}</p>
                        <p class="text-red-500 font-semibold text-xl">{{ formatPrice(listCartProduct.price) }} đ</p>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="text-xl px-5 w-1/4">
                <div class="h-14 flex items-center">
                  <span>Tổng tiền: </span>
                  <span class="text-red-500 font-semibold ml-3">{{ formatPrice(cart.total_price) }}</span>
                </div>
                <div>
                  <textarea name="" id="" class="
                    h-28
                    w-full
                    rounded-xl
                    resize-none
                    border-1 border-gray-400
                    focus:ring-0
                  " placeholder="Chú thích cho đơn hàng..."></textarea>

                  <button class="w-full mt-2 mb-4 rounded-md text-white py-1">
                    Đặt hàng
                  </button>
                </div>
              </div>
            </div>
          </div>
        </section>

      </section>


      <!-- Footer cart -->
      <section class="sticky px-10 items-center border-t-2 rounded-bl-xl w-full pt-2">
        <span class="font-semibold text-xl text-gray-700">Tổng thanh toán ( {{ totalQuantityShop }} sản phẩm ):
        </span>
        <span class="text-red-600 text-xl font-semibold">¥0 ~ {{ formatPrice(totalPriceShop) }}</span>
        <button @click="createOrder()" class="mx-10 py-2 px-12 border-none text-xl rounded-md text-white">
          Thanh toán
        </button>
      </section>
    </section>
  </Transition>
</template>

<script>
import { getCart, createCart, cartCheckout } from "../../config/cart";
import loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";

export default {
  components: {
    loading,
  },
  data() {
    return {
      is_loading: false,
      listCart: [],
      totalPriceShop: 0,
      ids: [],
      quantity: [],
      totalQuantityShop: 0,
      lazyLoad: false,
      checkBox: [],
      checkBoxItem: [],
      keyObject: '',
      object: {},
      keyObjectGoods: '',
      objectGoods: {},
      checkGoods: [],
      woodWorking: [],
      ownWood: []
    };
  },
  created() {
    this.listCart = JSON.parse(window.localStorage.getItem("cart"));
  },
  mounted() {
    this.getCartByUser();
  },

  methods: {
    formatPrice(value) {
      return new Intl.NumberFormat("en-US", {
        style: "currency",
        currency: "VND",
        currencyDisplay: "code"
      }).format(value)
        .replace("VND", "")
        .trim();
    },
    checkAllByShop(index) {
      this.checkBox[index] = !this.checkBox[index];
      this.listCart[index].cart_products.forEach((element, index2) => {
        if (this.checkBox[index]) {
          this.checkBoxItem[element.id] = !this.checkBoxItem[element.id];
        } else {
          this.checkBoxItem[element.id] = false;
        }
      });
    },
    checkByItem(id, index) {
      let count = 0;
      this.checkBoxItem[id] = !this.checkBoxItem[id];

      this.listCart[index].cart_products.forEach((element, index2) => {
        Object.keys(this.checkBoxItem).forEach((ele, index3) => {
          if (ele == element.id) {
            if (this.checkBoxItem[element.id]) {
              count++
            }
          }
        })
      });
      if (count == this.listCart[index].cart_products.length) {
        this.checkBox[index] = true;
      } else {
        this.checkBox[index] = false;
      }

      // })
    },
    getTotal(index) {
      let totalPrice = 0;
      let totalShop = 0;
      this.listCart[index].cart_products.forEach((element) => {
        totalPrice += +element.price;
      })
      this.listCart[index].total_price = totalPrice;
      this.listCart.forEach((element) => {
        totalShop += + element.total_price;
      })
      this.totalPriceShop = totalShop;
    },

    getTotalQuantity(index, index2) {
      let quantityItem = 0;
      this.listCart.forEach((element) => {
        element.cart_products.forEach((ele) => {
          this.quantity[ele.id] = ele.quantity;
          quantityItem += +ele.quantity;
        })
      });
      this.totalQuantityShop = quantityItem;
    },
    getCartByUser() {
      let totalShop = 0;
      let quantityShop = 0;
      let quantityItem = 0;

      this.is_loading = true;
      getCart().then((res) => {
        this.listCart = res.data.data;

        window.localStorage.setItem("cart", JSON.stringify(this.listCart));
      }).then(() => {
        this.listCart = JSON.parse(window.localStorage.getItem("cart"));
      }).catch((error) => {
        this.is_loading = false;
      })
        .finally(() => {
          this.is_loading = false;
        });
      this.listCart.forEach((element) => {
        totalShop += + element.total_price;
      })
      this.listCart.forEach((element) => {
        this.keyObjectGoods = element.id;
        this.objectGoods[this.keyObjectGoods] = false;
        this.checkGoods = this.objectGoods;
        element.cart_products.forEach((ele) => {
          this.quantity[ele.id] = ele.quantity;
          quantityItem += +ele.quantity;
          this.keyObject = ele.id;
          this.object[this.keyObject] = false;
          this.checkBoxItem = this.object;
        })
      });

      this.totalQuantityShop = quantityItem;
      this.totalPriceShop = totalShop;
    },

    cartQuantity(product, index, index2) {
      this.listCart[index].cart_products[index2].quantity = product.quantity;
      this.listCart[index].cart_products[index2].price = product.quantity * product.unit_price_vn;
      this.listCart[index].cart_products[index2].price_cn = product.quantity * product.unit_price_cn;
      this.getTotal(index);
      this.getTotalQuantity(index, index2);
      window.localStorage.setItem("cart", JSON.stringify(this.listCart));
    },

    createOrder() {
      // console.log(this.checkBoxItem);
      let count = 0;
      Object.keys(this.checkBoxItem).forEach((ele) => {
        if (this.checkBoxItem[ele]) {
          count++;
        }
      })
      if (count == 0) {
        return this.$swal("Vui lòng chọn ít nhất 1 sản phẩm");
      }
      const data = {
        'money_deposite': this.totalPriceShop,
        'data': { ids: this.checkBoxItem, data: this.listCart, note: '', quantity: this.quantity },
      };
      createCart(data).then((response) => {
        // console.log(response);
        window.localStorage.removeItem("cart");
        this.$swal('Thanh toán đơn hàng thành công');
        this.data = [];
        this.totalPriceShop = 0
        this.ids = [];
        this.listCart = [];
        this.quantity = [];

      }).catch((error) => {
        console.log(error);
        this.$swal(error.response.data.message);
      })
    }
  }
};
</script>


<style scoped>
button {
  background-color: #ff3f3a;
}

table tbody td {
  max-width: 250px;
}

::-webkit-scrollbar {
  width: 20px;
  height: 20px;
}

::-webkit-scrollbar-track {
  border-radius: 100vh;
  background: #f7f4ed;
}

::-webkit-scrollbar-thumb {
  background: #e0cbcb;
  border-radius: 100vh;
  border: 3px solid #f6f7ed;
}

::-webkit-scrollbar-thumb:hover {
  background: #c0a0b9;
}
</style>