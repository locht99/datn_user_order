<template>
  <section class="relative">
    <div class="w-full h-48 bg-black bg-profile">
         <!-- <img src="/images/bg.png" alt="" class="w-full" /> -->
    </div>
    <i
      class="
        fa-solid fa-arrow-left-long
        absolute
        top-4
        left-8
        text-white text-2xl
        cursor-pointer
      "
      @click="$router.go(-1)"
    ></i>
  </section>
  <section class="image1">
    <img
      src="/images/user-default.png"
      alt=" "
      class="
        max-w-32 max-h-32
        w-auto
        h-auto
        m-auto
        rounded-full
        border-2 border-orange-500
        overflow-hidden
        select-auto
        cursor-pointer
        bg-white
      "
    />
    <h1 class="text-2xl mt-2 text-center font-bold">Đặng Khải</h1>

    <p class="mt-2 font-semibold text-center">Số dư: 0 đ</p>

    <div
      class="
        w-2/3
        m-auto
        shadow-md shadow-gray-400
        py-5
        mt-2
        px-24
      "
    >
      <div class="flex justify-between">
        <div>
          <div class="my-3">
            <label for="" class="block text-left font-semibold">Tên đăng nhập</label>
            <input type="text" class="w-72 h-10 mt-2 rounded-lg" value="Đặng Khải" :disabled="!username" />
            <i class="fa-solid fa-pen-to-square ml-3 text-xl text-gray-600 cursor-pointer" @click="username = true;"></i>
          </div>
          <div class="my-3">
            <label for="" class="block text-left font-semibold">Email</label>
            <input type="text" class="w-72 h-10 mt-2 rounded-lg" value="khaidang1123@gmail.com" :disabled="!email" />
            <i class="fa-solid fa-pen-to-square ml-3 text-xl text-gray-600 cursor-pointer" @click="email = true"></i>
          </div>
          <div class="my-3">
            <label for="" class="block text-left font-semibold">Số điện thoại</label>
            <input type="text" class="w-72 h-10 mt-2 rounded-lg" value="0962597441" :disabled="!phone" />
            <i class="fa-solid fa-pen-to-square ml-3 text-xl text-gray-600 cursor-pointer" @click="phone = true"></i>
          </div>
        </div>
        <div class="my-3">
          <label for="" class="block text-left font-semibold">Địa chỉ</label>
          <textarea name="" id="" class="h-36 resize-none mt-2 w-72 rounded-lg" :disabled="!address">thôn Xuân Áng, xã Chí Đám, huyện Đoan Hùng, tỉnh Phú Thọ</textarea>
          <i class="fa-solid fa-pen-to-square ml-3 text-xl text-gray-600 cursor-pointer" @click="address = true"></i>
        </div>
      </div>

      <button class="m-auto block text-white px-10 py-2 rounded-lg">Cập nhật</button>
    </div>
  </section>
</template>

<script>
export default {
    data(){
        return {
            active1: false,
            username: false,
            email: false,
            phone: false,
            address: false
        }
    }
};
</script>


<style scoped>
button {
  background-color: #ff3f3a;
}
.image1 {
  transform: translateY(-70px);
}
.bg-profile{
    background-image: url('/images/bg.png');
}
</style>