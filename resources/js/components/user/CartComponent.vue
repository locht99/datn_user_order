<template>
  <Transition name="fade-in">

    <section style="height: 568px; max-height: 568px"
      class="border rounded-xl shadow-md shadow-gray-400 my-10 relative">
      <loading v-model:active="is_loading" :is-full-page="false" />
      <!-- Header cart -->
      <section class="sticky w-full flex justify-between px-5 py-5 bg-white rounded-xl">
        <div class="flex justify-between w-[97%]">
          <div class="flex items-center">
            <img src="/images/trolley.png" alt="" />
            <b class="mx-2 text-lg">Giỏ hàng</b>
          </div>
          <div class="border-b-2 border-b-gray-400">
            <!-- <label for="search" class="">
              <i class="fa-solid fa-magnifying-glass"></i>
              <input type="text" id="search" placeholder="Tìm kiếm sản phẩm" class="border-none focus:ring-0" />
            </label> -->
          </div>
        </div>
        <div>

          <button title="Cập nhật giỏ hàng" v-on:click="syncCart()" class="bg-red-500 px-3 py-2 rounded text-white"><i
              class="fas fa-sync" :class="syncItem ? ' sync-cart' : ''"></i>

          </button>
        </div>
      </section>

      <!-- Content cart -->
      <section v-if="listCart.length > 0" style="max-height: 424px" class="overflow-auto">
        <section class="py-5 px-5" v-for="(cart, index) in listCart" :key="index">
          <div class="rounded-xl shadow-md shadow-gray-400">
            <div class="
              px-5
              py-3
              flex
              justify-between
              items-center
              bg-gray-100
              rounded-t-lg
            ">
              <div class="flex items-center">
                <img src="/images/1688-logo.png" alt="" class="w-[32px]" v-if="cart.source == '1688'" />
                <img src="/images/tmall-logo.png" alt="" class="w-[32px]" v-else-if="cart.source == 'TMALL'" />
                <img src="/images/taobao-logo.png" alt="" class="w-[32px]" v-else-if="cart.source == 'TAOBAO'" />
                <p v-on:click="openShop(cart.shop_url)"
                  class="ml-10 text-lg hover:underline hover:decoration-1 cursor-pointer" v-if="cart.shop_name">{{
                      cart.shop_name
                  }}</p>
                <p v-on:click="openShop(cart.shop_url)"
                  class="ml-10 text-lg hover:underline hover:decoration-1 cursor-pointer" v-else>Không xác định</p>
              </div>
              <div class="flex items-center">
                <label for="kiemhang" class="mx-4 cursor-pointer select-none">

                  <input type="checkbox" v-on:click="checkBoxInventory(cart.id)" v-model="checkGoods[cart.id]" class="
                    mb-1
                    rounded-md
                    cursor-pointer
                    focus:ring-0
                    w-5
                    h-5
                    border-2 border-gray-400
                  " />
                  <i class="fa-solid fa-box-open mx-2 text-lg text-gray-700"></i>
                  <span class="text-sm font-semibold text-gray-600">Kiểm hàng</span>
                </label>

                <label for="donggo" class="mx-4 cursor-pointer select-none">
                  <input type="checkbox" v-on:click="checkWoodWorking(cart.id)" v-model="woodWorking[cart.id]" class="
                    mb-1
                    rounded-md
                    cursor-pointer
                    focus:ring-0
                    w-5
                    h-5
                    border-2 border-gray-400
                  " />
                  <i class="fa-solid fa-boxes-stacked mx-2 text-lg text-gray-700"></i>
                  <span class="text-sm font-semibold text-gray-600">Đóng gỗ</span>
                </label>

                <label for="donggorieng" class="mx-4 cursor-pointer select-none">
                  <input type="checkbox" v-on:click="checkOwn(cart.id)" v-model="ownGood[cart.id]"
                    class="mb-1 rounded-md focus:ring-0 w-5 h-5 border-2 border-gray-400" />
                  <i class="fa-solid fa-box mx-2 text-lg text-gray-700"></i>
                  <span class="text-sm font-semibold text-gray-600">Đóng gỗ riêng</span>
                </label>

              </div>
            </div>
            <div class="w-full flex">
              <div class="w-3/4 border-r-2">
                <table class="w-full">
                  <thead class="h-19 border-b">
                    <tr>
                      <th class="text-left pl-8">
                        <input type="checkbox" v-model="checkBox[index]" v-on:click="checkAllByShop(index)"
                          class="rounded-md cursor-pointer focus:ring-0 w-5 h-5 border-2 border-gray-400" />
                      </th>

                      <th class="text-lg text-left pl-8">Sản phẩm</th>
                      <th class="text-lg text-left pl-8">Số lượng</th>
                      <th class="text-lg text-left pl-8">Tiền hàng</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr class="items-center  pb-2" v-on:mouseover="mouseover(listCartProduct.id)"
                      v-on:mouseleave="mouseleave(listCartProduct.id)"
                      v-for="(listCartProduct, index2) in cart.cart_products" :key="index2">
                      <td class="pl-8">
                        <input type="checkbox" v-on:click="checkByItem(listCartProduct.id, index)"
                          v-model="checkBoxItem[listCartProduct.id]"
                          class="rounded-md cursor-pointer focus:ring-0 w-5 h-5 border-2 border-gray-400" />
                      </td>
                      <td class="pl-8 items-center">
                        <div v-on:click="openShop(listCartProduct.url)">
                          <img :src="listCartProduct.image" class="w-24 py-4 pr-2 float-left cursor-pointer" />
                          <div class="relative top-[20px]">
                            <a class=" text-[13px]  block cursor-pointer">{{ listCartProduct.product_name }}</a>
                            <label for="">
                              <span class="font-semibold text-sm">
                                Thuộc tính:
                              </span>
                              <span class="block cursor-pointer text-[12px]">
                                {{ listCartProduct.properties }}
                              </span>
                            </label>
                          </div>
                        </div>

                      </td>
                      <td class="pl-8">
                        <div class="inline-flex rounded-md shadow-sm">
                          <!-- <button v-on:click="decreasingProduct(listCartProduct, index, index2)"
                            class="py-2 px-4 text-sm font-medium text-white bg-white rounded-l-lg border border-gray-200 hover:bg-gray-100 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
                            -
                          </button> -->
                          <!-- v-on:keyup="checkString(listCartProduct.quantity,listCartProduct, index, index2)" -->
                          <a-input-number id="inputNumber" @blur="cartQuantity(listCartProduct, index, index2)"
                            v-model:value="listCartProduct.quantity" />
                          <!-- <input type="text" autocomplete="off" 
                            class="py-2 text-sm font-medium w-[50px] text-gray-900 bg-white border-t border-b border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-1 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white"> -->
                          <!-- <input type="hidden" :value="listCartProduct.quantity" /> -->
                          <!-- <button v-on:click="increasingProduct(listCartProduct, index, index2)"
                            class="py-2 px-4 text-sm font-medium text-white bg-white rounded-r-md border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
                            +
                          </button> -->
                        </div>

                      </td>
                      <td class="pl-8">
                        <p class="text-red-500 font-semibold text-lg">¥{{ listCartProduct.unit_price_cn }}</p>
                        <p class="text-red-500 font-semibold text-lg">{{ formatPrice(listCartProduct.unit_price_vn) }} đ
                        </p>
                      </td>
                      <td class="pl-8 ">
                        <div class="flex items-center justify-between">
                          <div>
                            <p class="text-red-500 font-semibold text-lg">¥{{ listCartProduct.price_cn }}</p>
                            <p class="text-red-500 font-semibold text-lg">{{ formatPrice(listCartProduct.price) }} đ</p>
                          </div>
                          <div class="pr-1 relative">
                            <a-popconfirm class="cursor-pointer" title="Bạn có muốn xóa sản phẩm?"
                              @confirm="deleteProductCart(listCartProduct.id, index, index2)">
                              <i class="fas fa-trash-alt bg-red-500 p-2 text-white rounded"></i>
                            </a-popconfirm>
                            <!-- <label for="" v-on:click=""
                              class="cursor-pointer absolute left-[-11px]"
                              :class="isTrash[listCartProduct.id] ? 'block' : 'hidden'">
                              
                            </label> -->
                          </div>
                        </div>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <div class="text-xl px-5 w-1/4">
                <div class="min-h-14 flex items-center" v-if="isLoadingTotal == false">
                  <div class="py-2">
                    <div v-for="(item, index4) in feeCartByShop[cart.id]" class="nameShop" :key="index4">
                      <span class="text-sm">{{
                          item.name
                      }}:
                      </span>
                      <span class="text-sm">{{
                          formatPrice(item.value)
                      }} đ</span>
                    </div>
                    <div>

                      <span>Tổng tiền: </span>
                      <span class="text-red-500 font-semibold">{{ formatPrice(totalMoneyByShop[cart.id]) }} đ</span>
                    </div>
                  </div>
                </div>
                <div v-else="" class="min-h-14 flex items-center">
                  <div class="py-2">
                    Loading....
                  </div>
                </div>
                <div class="pt-2">
                  <textarea v-model="noteByShop[cart.id]" name="" id="" class="
                    h-28
                    w-full
                    rounded-xl
                    resize-none
                    border-1 border-gray-400
                    focus:ring-0
                  " placeholder="Chú thích cho đơn hàng..."></textarea>
                  <button v-on:click="toggleModalCart(cart.id, index)"
                    class="w-full mt-2 mb-4 rounded-md text-white py-1">
                    Đặt hàng
                  </button>
                </div>
              </div>
            </div>
          </div>
        </section>

      </section>
      <section v-if="listCart.length <= 0 && is_loading == false" style="max-height: 424px" class="overflow-auto">
        <div class="flex justify-center items-center" style="height: 400px;">
          <p class="font-bold text-center px-3">
            Bạn chưa có sản phẩm nào trong giỏ hàng.
          </p>
        </div>
      </section>

      <!-- Footer cart -->
      <section v-if="listCart.length != 0" class="flex sticky px-10 items-center border-t-2 rounded-bl-xl w-full pt-2">
        <div class="mx-2">
          <input type="checkbox" id="checkboxAll" v-model="checkBoxAllIn" v-on:click="checkBoxAll()"
            class="rounded-md cursor-pointer focus:ring-0 w-5 h-5 border-2 border-gray-400">
          <label for="checkboxAll" class="text-gray-700 mx-1 hover:underline hover:decoration-1 cursor-pointer"> Chọn
            tất cả </label>
          <label for="checkboxAll" v-on:click="deleteAll()"
            class="text-gray-700 mx-1 hover:underline hover:decoration-1 cursor-pointer">| Xóa
            tất cả</label>
        </div>
        <span class="font-semibold text-lg text-gray-700">Tổng thanh toán ( {{ totalQuantityShop }} sản phẩm ):
        </span>
        <span class="text-red-600 text-lg font-semibold mx-1"> {{ formatPrice(totalPriceShop) }} đ</span>
        <button @click="toggleModalCart()"
          class="mx-10 py-2 px-12 border-none text-sm font-semibold rounded-md text-white ">
          Đặt hàng tất cả sản phẩm đã chọn
        </button>
      </section>


      <a-modal v-model:visible="showModal" width="1000px" title="Địa chỉ và đặt cọc" @ok="handleOk">
        <div class="flex flex-col w-full px-0 mx-auto md:flex-row" v-if="is_loading == false">
          <div class="flex flex-col md:w-full">
            <div class="flex items-center justify-between">
              <div>
                <h2 class="mb-4 font-bold md:text-xl text-heading ">Địa chỉ giao hàng
                </h2>
              </div>
              <div>
                <span v-on:click="openModalAddRess()"
                  class="text-blue-500 font-semibold text-[18px] cursor-pointer hover:underline hover:decoration-1">
                  Chỉnh sửa
                </span>
              </div>
            </div>
            <div class="justify-center w-full mx-auto">
              <div class="">
                <div class="space-x-0 lg:flex lg:space-x-4">
                  <div class="w-full lg:w-1/2">
                    <label for="firstName" class="block mb-3 text-sm font-semibold text-gray-500">Họ
                      tên</label>
                    <p class="w-full px-4 py-3 text-sm border lg:text-sm">
                      {{ info_Address.name }}
                    </p>
                  </div>
                  <div class="w-full lg:w-1/2 ">
                    <label for="firstName" class="block mb-3 text-sm font-semibold text-gray-500">Điện
                      thoại</label>
                    <p class="w-full px-4 py-3 text-sm border  lg:text-sm">
                      {{ info_Address.phone }}
                    </p>
                  </div>
                </div>

                <div class="mt-4">
                  <div class="w-full">
                    <label for="Address" class="block mb-3 text-sm font-semibold text-gray-500">Tên địa
                      chỉ</label>
                    <p class="w-full px-4 py-3 text-sm border  lg:text-sm">
                      {{ info_Address.note }}
                    </p>
                  </div>
                </div>
                <div class="mt-4">
                  <div class="w-full">
                    <label for="Address" class="block mb-3 text-sm font-semibold text-gray-500">Địa
                      chỉ</label>
                    <p class="w-full px-4 py-3 text-sm border  lg:text-sm">
                      {{ info_Address.ward }}, {{ info_Address.district }}, {{ info_Address.province }}
                    </p>
                  </div>
                </div>

                <div class="mt-4">
                  <div v-if="cartid != 0">
                    <button v-on:click="createOrder(cartid, index, objPayment.money_deposite)"
                      class="w-full px-6 py-2 text-white bg-orange-600 hover:bg-orange-500">Thanh
                      Toán</button>
                  </div>
                  <div v-if="cartid == 0">
                    <button v-on:click="createOrder(null, null, objPayment.money_deposite)"
                      class="w-full px-6 py-2 text-white bg-orange-600 hover:bg-orange-500">Thanh
                      Toán</button>
                  </div>

                </div>
              </div>
            </div>
          </div>
          <div class="flex flex-col w-full ml-0 lg:ml-12 lg:w-2/5">
            <div class="pt-12 md:pt-0 2xl:ps-4">
              <h2 class="text-xl font-bold">Chi tiết thanh toán
              </h2>
              <div class="mt-4">
                <div class="flex flex-col space-y-4">

                  <div
                    class="flex items-center justify-between w-full py-2 text-sm font-semibold border-b border-gray-300 lg:py-5 lg:px-3 text-heading last:border-b-0 last:text-base last:pb-0">
                    <div>
                      Phí dịch vụ(tạm tính)
                    </div>
                    <div>
                      <span class="ml-2">{{ formatPrice(objPayment.fee) }}đ</span>
                    </div>
                  </div>
                  <div
                    class="flex items-center justify-between w-full py-2 text-sm font-semibold border-b border-gray-300 lg:py-5 lg:px-3 text-heading last:border-b-0 last:text-base last:pb-0">
                    <div>
                      Tạm tính({{ objPayment.quantity }} sản phẩm)
                    </div>
                    <div>
                      <span class="ml-2">{{ formatPrice(objPayment.provisional) }}đ</span>
                    </div>
                  </div>
                  <div
                    class="flex items-center justify-between w-full py-2 text-sm font-semibold border-b border-gray-300 lg:py-5 lg:px-3 text-heading last:border-b-0 last:text-base last:pb-0">
                    <div>
                      Đặt cọc 50%
                    </div>
                    <div>
                      <span class="ml-2">{{ formatPrice(objPayment.money_deposite) }}đ</span>
                    </div>
                  </div>
                  <div
                    class="flex items-center justify-between w-full py-2 text-sm font-semibold border-b border-gray-300 lg:py-5 lg:px-3 text-heading last:border-b-0 last:text-base last:pb-0">
                    <div>
                      Số dư tài khoản
                    </div>
                    <div>
                      <span class="ml-2">{{ formatPrice(objPayment.point) }}đ</span>
                    </div>
                  </div>
                  <div v-if="objPayment.point <= 0"
                    class="flex items-center justify-between w-full py-2 text-sm font-semibold border-b border-gray-300 lg:py-5 lg:px-3 text-heading last:border-b-0 last:text-base last:pb-0">
                    <div>
                      Bạn còn thiếu
                    </div>
                    <div>
                      <span class="ml-2">{{ formatPrice(objPayment.lackMoney) }}đ</span>
                    </div>
                  </div>
                </div>
              </div>


            </div>
          </div>
        </div>
      </a-modal>
      <AddRessComponent v-on:showModalAddress="updateModalAddRess($event)" v-on:idAddRess="updateIdAddress($event)"
        :showModalAction="showModalAddress">
      </AddRessComponent>
      <!-- <vue-topprogress ref="topProgress"></vue-topprogress> -->

    </section>

  </Transition>

</template>

<script>
import { getCart, createCart, cartCheckout, deleteCart, cartCheckoutByProduct, deleteAllCart } from "../../config/cart";
import AddRessComponent from "./AddRessComponent.vue";
import loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";
export default {
  watch: {
    $route: {
      immediate: true,
      handler(to, from) {
        document.title = 'Giỏ hàng';
      }
    },
  },
  components: {
    loading,
    AddRessComponent,
  },
  data() {
    return {
      is_loading: false,
      listCart: [],
      totalPriceShop: 0,
      ids: [],
      noteByShop: [],
      quantity: [],
      totalQuantityShop: 0,
      lazyLoad: false,
      checkBox: [],
      checkBoxItem: [],
      keyObject: '',
      showModal: false,
      isLoadingTotal: false,
      object: {},
      keyObjectGoods: '',
      objectGoods: {},
      checkGoods: [],
      woodWorking: [],
      ownGood: [],
      listTotalCart: [],
      feeCartByShop: [],
      deposite_money: 0,
      totalMoneyByShop: [],
      isOwnGood: [],
      isGoodWorking: [],
      isTrash: [],
      syncItem: false,
      objPayment: {
        fee: 0,
        provisional: 0,
        money_deposite: 0,
        point: 0,
        quantity: 0,
        lackMoney: 0
      },
      cartid: 0,
      index: 0,
      checkBoxAllIn: false,
      showModalAddress: false,
      id_address: {},
      info_Address: {},
      count: 0

    };
  },

  mounted() {
    this.getCartByUser();


  },
  methods: {
    // checkByNote(){
    //   console.log(this.noteByShop);
    // },

    openShop(url) {
      window.open(url, '_blank');

    },
    openModalAddRess() {
      this.showModalAddress = !this.showModalAddress;
      this.showModal = !this.showModal;
    },
    updateModalAddRess(event) {
      this.showModalAddress = !event;
      this.showModal = !this.showModal;

    },
    handleOk(e){
       this.showModal=!this.showModal;
    },
    updateIdAddress(event) {
      this.id_address = event;
      this.info_Address = event;
    },
    deleteAll() {
      this.$swal.fire({
        title: 'Bạn có chắc chắn muốn xóa giỏ hàng',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Xóa'
      }).then((result) => {
        if (result.isConfirmed) {
          deleteAllCart({ Id: Object.keys(this.checkBoxItem) }).then((response) => {
            // this.getTotalQuantity();
            this.getCartByUser();
            this.$swal.fire(
              'Deleted!',
              'Xóa sản phẩm khỏi giỏ hàng thành công',
              'success'
            )
          }).catch((error) => {

          })
        }
      });

      // console.log(Object.keys(this.checkBoxItem));
    },
    mouseover(id) {
      this.isTrash[id] = true;
    },
    mouseleave(id) {
      this.isTrash[id] = false;

    },
    toggleModalCart(cartid = null, index = null) {
      let infoAddress = JSON.parse(window.localStorage.getItem("is_default_Address"));
      this.info_Address = infoAddress;
      let moneyProfile = JSON.parse(window.localStorage.getItem("user"));
      if (this.showModal == false) {
        this.objPayment.quantity = 0;
        // console.log();

      }
      if (cartid != null) {
        this.checkOutCart();
        this.cartid = cartid;
        this.index = index;
        if (cartid != null) {
          this.checkBox[index] = true;
          this.listCart[index].cart_products.forEach((element) => {
            if (this.listCart[index].id == cartid) {
              this.checkBoxItem[element.id] = true;
              this.objPayment.quantity += element.quantity;
            } else {
              this.checkBoxItem[element.id] = false;
            }
          });
        }
        let cart_shop = this.listTotalCart.data.fee[cartid];
        let feePay = cart_shop[1].value;
        let moneyPay = cart_shop[0].value;
        this.objPayment.provisional = moneyPay;
        this.objPayment.fee = feePay;
        this.objPayment.money_deposite = this.listTotalCart.data.money_deposite_byShop[cartid];
        this.objPayment.point = moneyProfile.point;

      }
      Object.keys(this.checkBoxItem).forEach((ele) => {
        if (this.checkBoxItem[ele]) {
          this.count++;
        }
      });
      if (this.count == 0) {
        return this.$swal("Vui lòng chọn ít nhất 1 sản phẩm");
      } else {
        this.showModal = !this.showModal;
      }
      if (this.showModal && cartid == null) {
        this.is_loading = true;
        cartCheckoutByProduct({ ids: this.checkBoxItem, quantity: this.quantity, inventory: this.checkGoods }).then((response) => {
          this.objPayment.provisional = response.data.totalMoney;
          this.objPayment.fee = response.data.feePurchase;
          this.objPayment.money_deposite = response.data.money_deposite;
          this.objPayment.point = moneyProfile.point;
          this.objPayment.quantity = response.data.quantity;
        }).finally(() => {
          this.is_loading = false;
        });
      }
    },
    syncCart() {
      this.syncItem = !this.syncItem;
      this.getCartByUser();
      // this.checkOutCart();
    },
    formatPrice(value) {
      return new Intl.NumberFormat("en-US", {
        style: "currency",
        currency: "VND",
        currencyDisplay: "code"
      }).format(value)
        .replace("VND", "")
        .trim();
    },
    deleteProductCart(id, index, index2) {
      this.listCart[index].cart_products = this.listCart[index].cart_products.filter((item) => item.id != id);

      deleteCart(id).then((response) => {
        this.checkOutCart();
        // this.getTotalQuantity();
      }).then(() => {
        this.$swal.fire(
          'Deleted!',
          'Xóa sản phẩm khỏi giỏ hàng thành công',
          'success'
        )
      })


    },
    checkOwn(cartid) {
      this.ownGood[cartid] = !this.ownGood[cartid];
      this.woodWorking[cartid] = false;
      this.feeCartByShop[cartid].push({ "name": "Đóng gỗ riêng", "value": 0 });
      this.feeCartByShop[cartid] = this.feeCartByShop[cartid].filter((item) => item.name != 'Đóng gỗ');
      if (this.ownGood[cartid] == false) {
        this.feeCartByShop[cartid] = this.feeCartByShop[cartid].filter((item) => item.name != 'Đóng gỗ riêng');
      }
    },
    checkWoodWorking(cartid) {
      this.woodWorking[cartid] = !this.woodWorking[cartid];
      this.ownGood[cartid] = false;
      this.feeCartByShop[cartid].push({ "name": "Đóng gỗ", "value": 0 });
      this.feeCartByShop[cartid] = this.feeCartByShop[cartid].filter((item) => item.name != 'Đóng gỗ riêng');
      if (this.woodWorking[cartid] == false) {
        this.feeCartByShop[cartid] = this.feeCartByShop[cartid].filter((item) => item.name != 'Đóng gỗ');

      }

    },

    checkBoxAll() {
      this.checkBoxAllIn = !this.checkBoxAllIn;
      this.listCart.forEach((element, index) => {
        this.checkBox[index] = !this.checkBox[index];

        element.cart_products.forEach((ele) => {
          this.checkBoxItem[ele.id] = !this.checkBoxItem[ele.id];
          if (element.cart_products.length == this.checkBoxItem.length) {
            this.checkBoxAllIn = true;
          }
        })

      })
    },
    checkBoxInventory(cartid) {
      this.checkGoods[cartid] = !this.checkGoods[cartid];
      this.checkOutCart();
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
      this.checkBoxByAll();
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

      this.checkBoxByAll();

      // })
    },
    checkBoxByAll() {
      let CountCheckall = 0;
      Object.keys(this.checkBoxItem).forEach((ele) => {
        if (this.checkBoxItem[ele]) {
          CountCheckall++;
        }
      })
      if (this.listTotalCart.data.cart_products.length == CountCheckall) {
        this.checkBoxAllIn = true;
      } else {
        this.checkBoxAllIn = false;
      }
    },
    getTotal(index) {
      let totalPrice = 0;
      let totalShop = 0;
      this.listCart[index].cart_products.forEach((element) => {
        totalPrice += +element.price;
      });
      this.listCart[index].total_price = totalPrice;
      this.listCart.forEach((element) => {
        totalShop += + element.total_price;
      })
      this.totalPriceShop = totalShop;
    },

    getTotalQuantity() {

      this.checkOutCart(this.listCart, this.quantity);

    },
    getCartByUser() {
      let totalShop = 0;
      let quantityShop = 0;
      let quantityItem = 0;
      this.is_loading = true;
      this.isLoadingTotal = true;

      getCart().then((res) => {
        this.listCart = res.data.data;
        this.listCart.forEach((element) => {
          totalShop += + element.total_price;
        })
        this.listCart.forEach((element) => {
          this.keyObjectGoods = element.id;
          this.objectGoods[this.keyObjectGoods] = false;

          this.checkGoods = this.objectGoods;
          let cartid = element.id;
          this.ownGood[cartid] = false;
          this.woodWorking[cartid] = false;

          element.cart_products.forEach((ele) => {
            this.quantity[ele.id] = ele.quantity;
            quantityItem += +ele.quantity;
            this.checkBoxItem[ele.id] = false;
          })
        })
      }).then(() => {
        this.checkOutCart(this.listCart);

      })
        .catch((error) => {
          this.is_loading = false;
        }).finally(() => {
          this.is_loading = false;
        });


    },
    cartQuantity(listCartProduct, index, index2) {
      if (listCartProduct.quantity <= 0) {
        this.$swal("Số lượng không được nhỏ hơn 1");
        listCartProduct.quantity = 1;
      } else {
        this.listCart[index].cart_products[index2].quantity = listCartProduct.quantity;
        this.listCart[index].cart_products[index2].price = listCartProduct.quantity * listCartProduct.unit_price_vn;
        let totalPriceCN = listCartProduct.quantity * listCartProduct.unit_price_cn;
        this.listCart[index].cart_products[index2].price_cn = totalPriceCN.toFixed(2)
        this.getTotalQuantity();
        this.getTotal(index);
      }
    },

    checkOutCart(value = null, quantity = null) {
      let quantityItem = 0;
      this.listCart.forEach((element) => {
        element.cart_products.forEach((ele) => {
          this.quantity[ele.id] = ele.quantity;
          quantityItem += +ele.quantity;
        })
      });
      const data = {
        ids: this.checkBoxItem,
        data: this.listCart || value,
        quantity: this.quantity || quantityItem,
        inventory: this.checkGoods
      }
      cartCheckout(data).then((response) => {
        const { data } = response.data;
        this.listTotalCart = response.data;
        this.feeCartByShop = response.data.data.fee;
        this.deposite_money = response.data.data.money_deposite;
        this.totalMoneyByShop = response.data.data.total_money_byShop;
        let dataCheckout = JSON.parse(data.request).data;
        this.listCart = dataCheckout;
        this.totalPriceShop = data.total_money;
        this.totalQuantityShop = data.totalQuantityOrder;
        this.syncItem = false;

      }).catch((error) => {

      }).finally(() => {
        this.syncItem = false;
        this.isLoadingTotal = false;
      })
    },

    createOrder(cartid = null, index = null, deposite_money = null) {
      // console.log(this.checkBoxItem);
      let listCart = this.listCart;
      if (cartid != null) {
        this.listCart[index].cart_products.forEach((element) => {
          if (this.listCart[index].id == cartid) {
            this.checkBoxItem[element.id] = true;
          } else {
            this.checkBoxItem[element.id] = false;
          }
        });
        listCart = [this.listCart[index]];
      }
      const data = {
        'money_deposite': deposite_money,
        'data': { ids: this.checkBoxItem, data: listCart, id_address: JSON.parse(window.localStorage.getItem("is_default_Address")), note: this.noteByShop, quantity: this.quantity, option: { ownGood: this.ownGood, goodWorking: this.woodWorking, inventory: this.feeCartByShop } },
      };
      createCart(data).then((response) => {
        // console.log(response);
        this.$swal.fire({
          position: 'top-end',
          icon: 'success',
          title: 'Thanh toán đơn hàng thành công',
          showConfirmButton: false,
          timer: 1500
        })
        this.showModal = false;
        listCart = [];
        this.clear();
      }).catch((error) => {
        this.$swal(error.response.data.message);
      })
    },
    clear() {
      this.checkBoxItem = [];
      this.checkBox = [];
      this.listCart = [];
      this.count = 0;
    }
  }
};
</script>


<style scoped>
button {
  background-color: #ff3f3a;
}

table tbody td {
  max-width: 280px;
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

.sync-cart {
  transform: rotate(360deg);
  -webkit-animation: spin 1s linear infinite;
  /* Safari */
  animation: spin 1s linear infinite;
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

@-webkit-keyframes spin {
  0% {
    -webkit-transform: rotate(0deg);
  }

  100% {
    -webkit-transform: rotate(360deg);
  }
}

@keyframes spin {
  0% {
    transform: rotate(0deg);
  }

  100% {
    transform: rotate(360deg);
  }
}
</style>