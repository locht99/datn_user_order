<template>
    <div class="m-auto">
        <img src="images/background-user.png" alt="background" class="w-full h-screen">
        <div class="w-[460px] h-[610px] bg-white absolute top-0 right-0 left-0 bottom-0 z-[100] m-auto rounded-lg">
            <form class="mx-[55px] font-bold">
                <div class="text-[30px] my-11 ">
                    <p class="text-center">Đăng ký</p>
                </div>
                <div class="text-[#6B6B6B]">
                    <div class="mb-5">
                        <input type="text" placeholder="Tên tài khoản"
                            class="block w-full bg-gray-100 rounded-md border-none p-2 duration-300 shadow focus:outline-none focus:ring focus:ring-red-500 " />
                    </div>
                    <div class="mb-5">
                        <input type="text" placeholder="Địa chỉ"
                            class="block w-full bg-gray-100 rounded-md border-none p-2 duration-300 shadow focus:outline-none focus:ring focus:ring-red-500 " />
                    </div>
                    <div class="mb-5">
                        <input type="text" placeholder="Số điện thoại"
                            class="block w-full bg-gray-100 rounded-md border-none p-2 duration-300 shadow focus:outline-none focus:ring focus:ring-red-500 " />
                    </div>
                    <div class="mb-5">
                        <input type="password" placeholder="Mật khẩu"
                            class="block w-full bg-gray-100 rounded-md border-none p-2 duration-300 shadow focus:outline-none focus:ring focus:ring-red-500 " />
                    </div>
                    <div class="mb-5">
                        <input type="password" placeholder="Nhập lại mật khẩu"
                            class="block w-full bg-gray-100 rounded-md border-none p-2 duration-300 shadow focus:outline-none focus:ring focus:ring-red-500 " />
                    </div>
                    <div class="text-center m-5">
                        <button class="rounded-2xl text-white px-7 border-solid border-[#B6B4B4] bg-[#FF3F3A] p-6"><img src="images/menu-icon/right-arrow-30.png" alt="icon"></button>
                    </div>
                </div>
            </form>
            <div class="text-center font-semibold">
                <router-link class="hover:text-red-500" to="">Quên mật khẩu</router-link> / <router-link class="hover:text-red-500" to="/login">Đăng nhập</router-link>
            </div>
        </div>
    </div>
</template>
<script>
    export default {};
</script>
<style>
</style>