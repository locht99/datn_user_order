<template>
  <div class="flex m-auto w-[98%] overflow-hidden h-screen py-4">
    <aside class="w-72 rounded-xl h-full relative z-10 bg-[#ff3f3a]">
      <div class="logo w-3/4 m-auto p-6 border-b border-solid">
        <img class="border-none m-auto" src="/images/logo.png" alt="" />
      </div>
      <menu-user-component />
      <div class="bg-layout-bar w-full h-96 absolute bottom-0 -z-10 rounded-xl bg-top bg-cover"></div>
    </aside>
    <section class="w-full ml-4">
      <header
        class="border h-20 rounded-xl shadow-md shadow-gray-400 flex justify-between items-center px-5 select-none">
        <div class="buy-now-title flex items-center">
          <h1 class="font-bold text-2xl">Mua sắm ngay!</h1>
          <a href="https://world.taobao.com/" target="_blank">
            <img src="/images/taobao-logo.png" alt="" class="mx-2" />
          </a>
          <a href="https://www.tmall.com/" target="_blank">
            <img src="/images/tmall-logo.png" alt="" class="mx-2" />
          </a>
        </div>
        <div class="account-info flex items-center relative">
          <div class="mr-5">
            <b>{{ userInfo.username }}</b>
            <p>Ví: {{ formatPrice(userInfo.point) }}</p>
          </div>
          <img @click="boxUserInfo = !boxUserInfo" src="/images/user-default.png" alt=" "
            class="w-12 h-12 rounded-full border-2 border-orange-500 overflow-hidden select-auto cursor-pointer" />
          <Transition name="slide-fade">
            <div v-if="boxUserInfo"
              class="absolute top-14 right-0 w-60 rounded-lg shadow-md shadow-gray-400 bg-[#ff3f3a] text-white px-5 z-50">
              <ul>
                <li class="border-b py-3">
                  <router-link to="/profile" class="text-base font-semibold">Thông tin cá nhân</router-link>
                </li>
                <li class="border-b py-3">
                  <router-link to="" class="text-base font-semibold">Đổi mật khẩu</router-link>
                </li>
                <li class="border-b py-3">
                  <router-link to="" class="text-base font-semibold">Đổi mật khẩu</router-link>
                </li>
                <li class="border-b py-3">
                  <router-link to="" class="text-base font-semibold">Đổi mật khẩu</router-link>
                </li>
                <li class="py-3">
                  <router-link to="" @click="logout()" class="text-base font-semibold">Đăng xuất</router-link>
                </li>
              </ul>
            </div>
          </Transition>
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
import { getUser } from "../config/user";
export default {
  components: { MenuUserComponent },

  data() {
    return {
      userInfo: {},
      boxUserInfo: false
    };
  },
  mounted() {
    this.getUserInfo();
  },
  methods: {
    getUserInfo() {
      getUser().then((res) => {
        this.userInfo = res.data;
      });
    },
    formatPrice(value) {
      return new Intl.NumberFormat("en-US", {
        style: "currency",
        currency: "VND",
      }).format(value);
    },
    logout() {
      let token = localStorage.getItem('token')
      if (token) {
        localStorage.removeItem('token')
        this.$router.replace("/login")
      }
    }
  },
};
</script>

<style scoped>
.container {
  background-color: #f5f5f5;
}

.bg-layout-bar {
  background-image: url("/images/bg-layout-user.png");
}

.slide-fade-enter-active {
  transition: all 0.3s ease-out;
}

.slide-fade-leave-active {
  transition: all 0.3s cubic-bezier(1, 0.5, 0.8, 1);
}

.slide-fade-enter-from,
.slide-fade-leave-to {
  transform: translateX(20px);
  opacity: 0;
}
</style>
