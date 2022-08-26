<template>
  <nav class="menu w-3/4 m-auto">
    <ul class="w-full m-auto">
      <li class="my-6"><router-link to="/" class="text-white flex font-semibold text-lg bg-gray-500/25 w-full pl-3 py-2 rounded-lg"><img src="/images/menu-icon/home.png" alt=""> <span class="pl-2">Trang chủ</span></router-link></li>
      <li class="my-6"><router-link to="/cart" class="text-white flex font-semibold text-lg pl-3 py-2 rounded-lg"><img src="/images/menu-icon/cart.png" alt=""><span class="pl-2">Giỏ hàng</span></router-link></li>
      <li class="my-6"><router-link to="order" class="text-white flex font-semibold text-lg pl-3 py-2 rounded-lg"><img src="/images/menu-icon/order.png" alt=""><span class="pl-2">Đơn hàng</span></router-link></li>
      <li class="my-6"><router-link to="transaction" class="text-white flex font-semibold text-lg pl-3 py-2 rounded-lg"><img src="/images/menu-icon/transaction.png" alt=""><span class="pl-2">Giao dịch</span></router-link></li>
      <li class="my-6"><router-link to="contact" class="text-white flex font-semibold text-lg pl-3 py-2 rounded-lg"><img src="/images/menu-icon/contact.png" alt=""><span class="pl-2">Liên hệ</span></router-link></li>
    </ul>
  </nav>
</template>

<script>

export default({
  
})
</script>




<style scoped>

</style>