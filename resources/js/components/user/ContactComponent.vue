<template>
  <section class="grid grid-cols-2 border rounded-xl shadow-md shadow-gray-400 my-5 py-10 px-5">
    <section class="w-3/4">
      <p class="flex items-center">
        <img src="/images/contact-icon.png" alt="" />
        <span class="mx-2 text-lg font-semibold">Liên hệ với chúng tôi </span>
      </p>

      <ul class="my-3">
        <li class="font-bold">
          <i class="fa-solid fa-location-dot"></i>
            Trụ sở chính</li>
        <li class="list-disc ml-5">Số 1,Đường Trịnh Văn Bô, Nam Từ Liêm, Hà Nội</li>
      </ul>

      <ul class="my-3">
        <li class="font-bold">
          <i class="fa-solid fa-phone"></i>
          Hotline</li>
        <li class="list-disc ml-5">Hotline CSKH: 1900 8198</li>
        <li class="list-disc ml-5">Số điện thoại kho: 1900 8198</li>
      </ul>

      <ul class="my-3">
        <li class="font-bold">
          <i class="fa-solid fa-phone"></i>
          Liên hệ qua email</li>
        <li class="my-3">
            <label for="">Email*</label>
            <input type="email" class="block w-full rounded mt-1 border-2 border-gray-300" placeholder="Nhập email...">
        </li>
        <li class="my-3">
            <label for="">Lời nhắn*</label>
            <textarea name="" id="" class="block w-full rounded mt-1 border-2 border-gray-300 resize-none h-28" placeholder="Nhập lời nhắn..."></textarea>
        </li>
      </ul>
      <button class="border py-2 px-20 bg-red-500 text-white rounded font-bold">Gửi</button>
    </section>
    <section class="m-auto">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1862.583224976666!2d105.79279829269154!3d20.985963899019364!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ac9152459be9%3A0xfe4e7af64bc5f551!2zb3JkZXIgdGFvYmFvIC0gxJDhurd0IEjDoG5nIFRydW5nIFF14buRYw!5e0!3m2!1svi!2s!4v1661582478395!5m2!1svi!2s" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </section>
  </section>
</template>

<script>
export default {};
</script>
