<template>
  <Transition name="fade-in">

    <section style="height: 568px; max-height: 568px" class="border rounded-xl shadow-md shadow-gray-400 my-10 ">
      <loading v-model:active="is_loading" :is-full-page="false" />
      <!-- Header cart -->
      <section class="sticky w-full flex justify-between px-5 py-5 bg-white rounded-xl">
        <div class="flex justify-between w-[97%]">
          <div class="flex items-center">
            <img src="/images/trolley.png" alt="" />
            <b class="mx-2 text-lg">Giỏ hàng</b>
          </div>
          <div class="border-b-2 border-b-gray-400">
            <label for="search" class="">
              <i class="fa-solid fa-magnifying-glass"></i>
              <input type="text" id="search" placeholder="Tìm kiếm sản phẩm" class="border-none focus:ring-0" />
            </label>
          </div>
        </div>
        <div>

          <button title="Cập nhật giỏ hàng" v-on:click="syncCart()" class="bg-red-500 px-3 py-2 rounded text-white"><i
              class="fas fa-sync" :class="syncItem ? ' sync-cart' : ''"></i>

          </button>
        </div>
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
                  <span class="text-lg font-semibold text-gray-600">Kiểm hàng</span>
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
                  <span class="text-lg font-semibold text-gray-600">Đóng gỗ</span>
                </label>

                <label for="donggorieng" class="mx-4 cursor-pointer select-none">
                  <input type="checkbox" v-on:click="checkOwn(cart.id)" v-model="ownGood[cart.id]"
                    class="mb-1 rounded-md focus:ring-0 w-5 h-5 border-2 border-gray-400" />
                  <i class="fa-solid fa-box mx-2 text-lg text-gray-700"></i>
                  <span class="text-lg font-semibold text-gray-600">Đóng gỗ riêng</span>
                </label>

              </div>
            </div>
            <div class="w-full flex">
              <div class="w-3/4 border-r-2">
                <table class="w-full">
                  <thead class="h-20 border-b-2">
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
                    <tr class="items-center  pb-2" v-on:mouseover="mouseover(listCartProduct.id)"
                      v-on:mouseleave="mouseleave(listCartProduct.id)"
                      v-for="(listCartProduct, index2) in cart.cart_products" :key="index2">
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
                        <div class="inline-flex rounded-md shadow-sm">
                          <button v-on:click="decreasingProduct(listCartProduct, index, index2)"
                            class="py-2 px-4 text-sm font-medium text-white bg-white rounded-l-lg border border-gray-200 hover:bg-gray-100 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
                            -
                          </button>
                          <input type="text" v-on:change="cartQuantity(listCartProduct, index, index2)"
                            v-model="listCartProduct.quantity"
                            class="py-2 text-sm font-medium w-[50px] text-gray-900 bg-white border-t border-b border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-1 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
                          <button v-on:click="increasingProduct(listCartProduct, index, index2)"
                            class="py-2 px-4 text-sm font-medium text-white bg-white rounded-r-md border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-2 focus:ring-blue-700 focus:text-blue-700 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:hover:text-white dark:hover:bg-gray-600 dark:focus:ring-blue-500 dark:focus:text-white">
                            +
                          </button>
                        </div>

                      </td>
                      <td class="pl-8">
                        <p class="text-red-500 font-semibold text-xl">¥{{ listCartProduct.unit_price_cn }}</p>
                        <p class="text-red-500 font-semibold text-xl">{{ formatPrice(listCartProduct.unit_price_vn) }} đ
                        </p>
                      </td>
                      <td class="pl-8 ">
                        <div class="flex items-center justify-between">
                          <div>
                            <p class="text-red-500 font-semibold text-xl">¥{{ listCartProduct.price_cn }}</p>
                            <p class="text-red-500 font-semibold text-xl">{{ formatPrice(listCartProduct.price) }} đ</p>
                          </div>
                          <div class="pr-1 relative">
                            <label for="" v-on:click="deleteProductCart(listCartProduct.id, index, index2)"
                              class="cursor-pointer absolute left-[-11px]"
                              :class="isTrash[listCartProduct.id] ? 'block' : 'hidden'">
                              <i class="fas fa-trash-alt bg-red-500 p-2 text-white rounded"></i>
                            </label>
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
                      }}đ</span>
                    </div>
                    <div>
                      <span>Tổng tiền: </span>
                      <span class="text-red-500 font-semibold">{{ formatPrice(totalMoneyByShop[cart.id]) }}</span>
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


      <!-- Footer cart -->
      <section v-if="listCart.length != 0" class="flex sticky px-10 items-center border-t-2 rounded-bl-xl w-full pt-2">
        <div class="mx-2">
          <input type="checkbox" id="checkboxAll" v-model="checkBoxAllIn" v-on:click="checkBoxAll()"
            class="rounded-md cursor-pointer focus:ring-0 w-5 h-5 border-2 border-gray-400">
          <label for="checkboxAll" class="text-gray-700 mx-1 hover:underline hover:decoration-1 cursor-pointer"> Chọn
            tất cả </label>
          <label for="checkboxAll" class="text-gray-700 mx-1 hover:underline hover:decoration-1 cursor-pointer">| Xóa
            tất cả</label>
        </div>
        <span class="font-semibold text-xl text-gray-700">Tổng thanh toán ( {{ totalQuantityShop }} sản phẩm ):
        </span>
        <span class="text-red-600 text-xl font-semibold"> {{ formatPrice(totalPriceShop) }}đ</span>
        <button @click="toggleModalCart()" class="mx-10 py-2 px-12 border-none text-sm rounded-md text-white ">
          Đặt hàng tất cả sản phẩm đã chọn
        </button>
      </section>
      <div v-if="showModal"
        class="overflow-x-hidden overflow-y-auto  fade  fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center flex">
        <div class="relative w-auto my-6 mx-auto max-w-6xl">
          <!--content-->
          <div
            class="modal-cart border-0 rounded-lg shadow-lg relative flex flex-col bg-white outline-none focus:outline-none w-[1200px]">
            <!--header-->
            <div class="flex items-start justify-between p-5 border-b border-solid border-slate-200 rounded-t">
              <h3 class="text-3xl font-semibold">
                Địa chỉ và đặt cọc
              </h3>
              <button
                class="p-1 ml-auto bg-white bg-transparent border-0 text-black opacity-5 float-right text-3xl leading-none font-semibold outline-none focus:outline-none"
                v-on:click="toggleModalCart()">
                <i class="fas fa-times text-black"></i>
              </button>
            </div>
            <!--body-->
            <div class="relative p-3 flex-auto">
              <div class="flex items-center justify-between">
                <div class="container p-10 mx-auto">
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
                                class="w-full px-6 py-2 text-white bg-blue-600 hover:bg-blue-900">Thanh
                                Toán</button>
                            </div>
                            <div v-if="cartid == 0">
                              <button v-on:click="createOrder(null, null, objPayment.money_deposite)"
                                class="w-full px-6 py-2 text-white bg-blue-600 hover:bg-blue-900">Thanh
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
                </div>
              </div>
            </div>
            <!--footer-->
            <!-- <div class="flex items-center justify-end p-6 border-t border-solid border-slate-200 rounded-b">

              <button
                class="text-white bg-transparent border border-solid border-red-500 hover:bg-red-500 hover:text-white active:bg-red-600 font-bold uppercase text-sm px-6 py-3 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                type="button" v-on:click="toggleModal()">
                Thanh toán
              </button>
            </div> -->
          </div>
        </div>
      </div>
      <div v-if="showModal" class="opacity-25 fixed inset-0 z-40 bg-black"></div>
      <AddRessComponent v-on:showModalAddress="updateModalAddRess($event)" v-on:idAddRess="updateIdAddress($event)"
        :showModalAction="showModalAddress">
      </AddRessComponent>
    <vue-topprogress ref="topProgress"></vue-topprogress>

    </section>

  </Transition>

</template>

<script>
import { getCart, createCart, cartCheckout, deleteCart, cartCheckoutByProduct } from "../../config/cart";
import AddRessComponent from "./AddRessComponent.vue";
import loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";

export default {
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
      info_Address: {}

    };
  },

  mounted() {
    this.getCartByUser();
  },
  methods: {
    // checkByNote(){
    //   console.log(this.noteByShop);
    // },
    openModalAddRess() {
      this.showModalAddress = !this.showModalAddress;
      this.showModal = !this.showModal;
    },
    updateModalAddRess(event) {
      this.showModalAddress = !event;
      this.showModal = !this.showModal;

    },
    updateIdAddress(event) {
      this.id_address = event;
      this.info_Address = event;

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
      console.log(this.info_Address);
      let moneyProfile = JSON.parse(window.localStorage.getItem("user"));
      if (this.showModal == false) {
        this.objPayment.quantity = 0;

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
      let count = 0;
      Object.keys(this.checkBoxItem).forEach((ele) => {
        if (this.checkBoxItem[ele]) {
          count++;
        }
      });
      if (count == 0) {
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
      this.$swal.fire({
        title: 'Bạn có chắc chắn muốn xóa sản phẩm khỏi giỏ hàng',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Xóa'
      }).then((result) => {
        if (result.isConfirmed) {
          this.listCart[index].cart_products = this.listCart[index].cart_products.filter((item) => item.id != id);
          deleteCart(id).then((response) => {
            this.getCartByUser();
            this.getTotalQuantity();
          }).then(() => {
            this.$swal.fire(
              'Deleted!',
              'Xóa sản phẩm khỏi giỏ hàng thành công',
              'success'
            )
          })

        }
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
      let quantityItem = 0;
      this.listCart.forEach((element) => {
        element.cart_products.forEach((ele) => {
          this.quantity[ele.id] = ele.quantity;
          quantityItem += +ele.quantity;
        })
      });
      this.checkOutCart(this.listCart, this.quantity);
      this.totalQuantityShop = quantityItem;
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
            this.keyObject = ele.id;
            this.object[this.keyObject] = false;
            this.checkBoxItem = this.object;
          })
        })
      }).then(()=>{
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
    increasingProduct(listCartProduct, index, index2) {
      listCartProduct.quantity++;
      this.listCart[index].cart_products[index2].quantity = listCartProduct.quantity;
      this.listCart[index].cart_products[index2].price = listCartProduct.quantity * listCartProduct.unit_price_vn;
      let totalPriceCN = listCartProduct.quantity * listCartProduct.unit_price_cn;
      this.listCart[index].cart_products[index2].price_cn = totalPriceCN.toFixed(2);
      this.getTotalQuantity();
      this.getTotal(index);
      // this.checkOutCart();

    },
    decreasingProduct(listCartProduct, index, index2) {
      listCartProduct.quantity--;
      if (listCartProduct.quantity <= 0) {
        this.$swal("Số lượng không được nhỏ hơn 1");
        listCartProduct.quantity = 1;
      } else {
        this.listCart[index].cart_products[index2].quantity = listCartProduct.quantity;
        this.listCart[index].cart_products[index2].price = listCartProduct.quantity * listCartProduct.unit_price_vn;
        let totalPriceCN = listCartProduct.quantity * listCartProduct.unit_price_cn;
        this.listCart[index].cart_products[index2].price_cn = totalPriceCN.toFixed(2);
        this.getTotalQuantity();
        this.getTotal(index);
      }


      // this.checkOutCart();
    },

    checkOutCart(value = null, quantity = null) {
      const data = {
        ids: this.checkBoxItem,
        data: this.listCart || value,
        quantity: this.quantity || quantity,
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
        this.totalQuantityShop = data.product_quantity.reduce((partialSum, a) => partialSum + a, 0);
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
        'data': { ids: this.checkBoxItem, data: listCart, id_address: JSON.parse(window.localStorage.getItem("is_default_Address")).id, note: this.noteByShop, quantity: this.quantity, option: { ownGood: this.ownGood, goodWorking: this.woodWorking, inventory: this.feeCartByShop } },
      };
      createCart(data).then((response) => {
        // console.log(response);
        this.$swal('Thanh toán đơn hàng thành công');
        this.listCart = [];
        this.checkBoxItem = [];
        this.showModal = false;
      }).catch((error) => {
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