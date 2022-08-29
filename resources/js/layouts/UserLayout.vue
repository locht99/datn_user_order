<template>
  <div class="flex m-auto wrapper overflow-hidden h-screen py-4">
    <aside class="w-72 rounded-xl h-full relative z-10">
      <div class="logo w-3/4 m-auto p-6 border-b border-solid">
        <img class="border-none m-auto" src="/images/logo.png" alt="" />
      </div>
      <menu-user-component />
      <div
        class="
          bg-layout-bar
          w-full
          h-96
          absolute
          bottom-0
          -z-10
          rounded-xl
          bg-top bg-cover
        "
      ></div>
    </aside>
    <section class="w-full ml-4">
      <header
        class="
          border
          h-20
          rounded-xl
          shadow-md shadow-gray-400
          flex
          justify-between
          items-center
          px-5
          select-none
        "
      >
        <div class="buy-now-title flex items-center">
          <h1 class="font-bold text-2xl">Mua sắm ngay!</h1>
          <img src="/images/1688-logo.png" alt="" class="mx-2" />
          <img src="/images/tmall-logo.png" alt="" class="mx-2" />
          <img src="/images/taobao-logo.png" alt="" class="mx-2" />
        </div>
        <div class="account-info flex items-center">
          <div class="mr-5">
            <b>Đặng Khải</b>
            <p>Ví: 0đ</p>
          </div>
          <router-link to="/profile">
            <img
              src="/images/user-default.png"
              alt=" "
              class="
                w-12
                h-12
                rounded-full
                border-2 border-orange-500
                overflow-hidden
                select-auto
                cursor-pointer
              "
            />
          </router-link>
        </div>
      </header>

      <main>
        <router-view></router-view>
      </main>
    </section>
  </div>
</template>

<script>
import MenuUserComponent from "../components/user/MenuUserComponent.vue";
export default {
  components: { MenuUserComponent },
};
</script>

<style scoped>
.container {
  background-color: #f5f5f5;
}

.wrapper {
  width: 98%;
}

aside {
  background-color: #ff3f3a;
}
.bg-layout-bar {
  background-image: url("/images/bg-layout-user.png");
}
</style>