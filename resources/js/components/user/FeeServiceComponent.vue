<template>
    <div class="main overflow-scroll max-h-full">
        <div class="container p-10">
            <div class="grid grid-cols-12 mx-auto">
                <div class="col-span-9 pl-20 text-justify pr-12">
                    <div class="block-fee">
                        <section id="143">
                            <h2 class="text-3xl font-bold py-2">Cơ cấu phí nhập hàng</h2>
                            <div>
                                <div>
                                    <span
                                        style="color: #212121; font-family: Dejavu-Serif, Helvetica, Arial, sans-serif; ">Chi
                                        phí nhập một đơn hàng bao gồm:</span>
                                </div>
                                <div><span
                                        style="color: #212121; font-family: Dejavu-Serif, Helvetica, Arial, sans-serif;"><br></span>
                                </div>
                                <div>
                                    <span
                                        style="color: #212121; font-family: Dejavu-Serif, Helvetica, Arial, sans-serif;"><b>1.
                                            Giá vốn:</b> gồm
                                        tiền hàng và phí vận chuyển nội địa Trung Quốc từ địa điểm của người bán tới kho của
                                        NhapHang tại
                                        Trung
                                        Quốc. Đây là phí cố định NhapHang phải trả cho người bán.</span>
                                </div>
                                <div><span><br></span></div>
                                <div>
                                    <span><b>2. Phí dịch vụ mua hàng &amp; kiểm hàng:</b></span>
                                </div>
                                <div><span><br></span></div>
                                <div>
                                    <span>- Phí mua hàng là phí
                                        dịch vụ giao dịch với nhà cung cấp và thực hiện mua đơn hàng theo yêu cầu của Quý
                                        khách.</span>
                                </div>
                                <div><span><br></span></div>
                                <div>
                                    <span>- Phí kiểm hàng gói
                                        dịch
                                        vụ đảm bảo sản phẩm không bị người bán giao thiếu hoặc giao lỗi. Khi đặt hàng quý
                                        khách có thể tùy
                                        chọn
                                        sử dụng gói dịch vụ này.</span>
                                </div>
                                <div><span><br></span></div>
                                <div>
                                    <span><b>3. Phí vận chuyển
                                            quốc
                                            tế Trung Quốc - Việt Nam</b> là chi phí chuyển hàng từ Trung Quốc về các kho của
                                        NhapHang tại Việt
                                        Nam.</span>
                                </div>
                                <div><span><br></span></div>
                                <div>
                                    <span><b>4. Phí giao hàng nội
                                            địa Việt Nam </b>là chi phí chuyển hàng từ kho của NhapHang tới địa chỉ nhận
                                        hàng của Quý
                                        khách.&nbsp;</span>
                                </div>
                            </div>
                            <p><br></p>
                        </section>
                        <section id="144">
                            <h2 class="text-3xl font-bold py-2">Giá vốn</h2>
                            <div>
                                <p class="py-2">Giá vốn hàng hóa bao gồm:</p>
                                <p class="py-2">- Tiền hàng: được tính bằng đơn giá sản phẩm nhân với tỷ giá nhân
                                    dân tệ tại thời điểm đặt cọc đơn
                                    hàng.</p>
                                <p class="py-2">- Phí vận chuyển nội địa Trung Quốc thông thường được các hãng vận
                                    chuyển tính như sau:</p>
                                <p>
                                </p>
                                <table
                                    class="w-full text-slate-900 dark:text-gray-400 text-xs font-bold text-center border-collapse">
                                    <tbody>
                                        <tr class="border-b">
                                            <td class="p-2 border border-slate-600">Chuyển phát nhanh thông thường</td>
                                            <td class="p-2 border border-slate-600">Kg đầu: Dựa vào quy định của chủ shop
                                                trên trang chi tiết taobao, alibaba</td>
                                            <td class="p-2 border border-slate-600">Kg tiếp theo: Nếu shop thuộc tỉnh Quảng
                                                Đông là 6 NDT/kg Khác tỉnh Quảng Đông là 8 NDT/kg</td>
                                        </tr>
                                        <tr>
                                            <td class="p-2 border border-slate-600">Chuyên phát nhanh siêu tốc</td>
                                            <td class="p-2 border border-slate-600">Kg đầu: Dựa vào quy định của chù shop
                                                trên trang chi tiết taobao, alỉbaba</td>
                                            <td class="p-2 border border-slate-600">Mỗi 0,5kg tiếp theo: 5 NDT/kg</td>
                                        </tr>
                                        <tr>
                                            <td class="p-2 border border-slate-600">Chuyển phát thường ô tô tải</td>
                                            <td colspan="2" class="p-2 border border-slate-600">Mỗi kg 2 NDT/kg + 70 NDT/Đơn
                                                hàng</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <p><br></p>
                            </div>
                        </section>
                        <section id="145">
                            <h2 class="text-3xl font-bold py-2">Phí dịch vụ mua hàng</h2>
                            <div>
                                <p class="py-4">Phí dịch vụ mua hàng = Tiền hàng * % phí dịch vụ</p>
                                <table
                                    class="w-full text-slate-900 dark:text-gray-400 text-lg font-bold text-center border-collapse">
                                    <tbody>
                                        <tr class="text-white bg-info">
                                            <td colspan="2" class="bg-cyan-500 p-4">BẢNG PHẦN TRĂM PHÍ DỊCH VỤ MUA HÀNG</td>
                                        </tr>
                                        <tr class="bg-danger text-white bg-red-600">
                                            <td class="p-4 border border-slate-600">Giá trị đơn hàng</td>
                                            <td class="p-4 border border-slate-600">Phần trăm phí dịch vụ</td>
                                        </tr>
                                        <tr>
                                            <td class="p-4 border border-slate-600">0 - 500,000</td>
                                            <td class="p-4 border border-slate-600">2%</td>
                                        </tr>
                                        <tr>
                                            <td class="p-4 border border-slate-600">500,001 - 5,000,000</td>
                                            <td class="p-4 border border-slate-600">1.5%</td>
                                        </tr>
                                        <tr>
                                            <td class="p-4 border border-slate-600">&gt; 5,000,000</td>
                                            <td class="p-4 border border-slate-600">1.2%</td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" class="p-4 border border-slate-600">*Lưu ý: Mức phí mua hàng tối
                                                thiểu là 5,000 vnđ/đơn hàng</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <p><br></p>
                            </div>
                        </section>
                        <section id="146">
                            <h2 class="text-3xl font-bold py-2">Phí dịch vụ kiểm hàng</h2>
                            <div class="py-4">
                                <div style="text-align: center;">
                                    <table
                                        class="w-full text-slate-900 dark:text-gray-400 text-lg font-bold text-center border-collapse">
                                        <tbody>
                                            <tr class="bg-info text-white">
                                                <td colspan="3" class="bg-cyan-500 p-4">BẢNG PHÍ KIỂM TRA THEO SẢN PHẨM</td>
                                            </tr>
                                            <tr class="bg-red-600 text-white">
                                                <td style="vertical-align: middle;">Số lượng SP/Đơn</td>
                                                <td style="vertical-align: middle;">Mức phí thu (Nghìn/SP)</td>
                                                <td style="vertical-align: middle;">Mức phí thu SP Phụ kiện<br>(Giá sản phẩm
                                                    &lt; 10 tệ)</td>
                                            </tr>
                                            <tr>
                                                <td class="p-4 border border-slate-600">1 - 2 sản phẩm</td>
                                                <td class="p-4 border border-slate-600">7,000<sup>đ</sup></td>
                                                <td class="p-4 border border-slate-600">2,000<sup>đ</sup></td>
                                            </tr>
                                            <tr>
                                                <td class="p-4 border border-slate-600">3 - 10 sản phẩm</td>
                                                <td class="p-4 border border-slate-600">5,000<sup>đ</sup></td>
                                                <td class="p-4 border border-slate-600">1,500<sup>đ</sup></td>
                                            </tr>
                                            <tr>
                                                <td class="p-4 border border-slate-600">11 - 100 sản phẩm</td>
                                                <td class="p-4 border border-slate-600">3,000<sup>đ</sup></td>
                                                <td class="p-4 border border-slate-600">1,000<sup>đ</sup></td>
                                            </tr>
                                            <tr>
                                                <td class="p-4 border border-slate-600">101 - 500 sản phẩm</td>
                                                <td class="p-4 border border-slate-600">2,000<sup>đ</sup></td>
                                                <td class="p-4 border border-slate-600">1,000<sup>đ</sup></td>
                                            </tr>
                                            <tr>
                                                <td class="p-4 border border-slate-600">&gt; 500 sản phẩm</td>
                                                <td class="p-4 border border-slate-600">1,500<sup>đ</sup></td>
                                                <td class="p-4 border border-slate-600">700<sup>đ</sup></td>
                                            </tr>
                                            <tr>
                                                <td class="p-4 border border-slate-600" colspan="3">*Lưu ý: Trong trường hợp
                                                    đơn hàng có số lượng sản phẩm rất lớn và cùng chủng loại,
                                                    vui lòng liên hệ với bộ phận Chăm sóc khách hàng để được hướng dẫn
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div><br></div>
                            </div>

                        </section>
                        <section id="147">
                            <h2 class="text-3xl font-bold py-2">Phí vận chuyển TQ-VN</h2>
                            <div>
                                <p>
                                    <span><span style="text-align: justify;">Phí vận chuyển quốc tế = Phí cố định
                                            (5.000đ/đơn hàng) + Phí vận chuyển hàng hóa</span><br>NhapHang
                                        có 03 gói vận chuyển:</span>
                                </p>
                                <p>
                                    <span><span style="font-weight: 700; text-align: center;">1. Vận chuyển thường
                                            (VCT):</span><span style="text-align: center;">&nbsp;Thời gian hàng về Hà Nội từ
                                            03-05 ngày, thời gian hàng về TP.HCM từ 04-06 ngày trong điều kiện thông quan
                                            thông thường. Bảng phí như sau:</span></span>
                                </p>
                                <div>
                                    <div style="text-align: center;">
                                        <table
                                            class="w-full text-slate-900 dark:text-gray-400 text-base font-bold text-center border-collapse">
                                            <tbody>
                                                <tr class="bg-info text-white">
                                                    <td colspan="4" class="bg-cyan-500 p-4">CHÍNH SÁCH VCT THEO TRỌNG LƯỢNG
                                                        ĐƠN HÀNG</td>
                                                </tr>
                                                <tr class="bg-danger text-white bg-red-600 p-4">
                                                    <td class="p-4 border border-slate-600">Trọng lượng (kg)</td>
                                                    <td class="p-4 border border-slate-600">HÀ NỘI</td>
                                                    <td class="p-4 border border-slate-600">SÀI GÒN</td>
                                                </tr>
                                                <tr>
                                                    <td class="p-4 border border-slate-600">&lt;= 10kg</td>
                                                    <td class="p-4 border border-slate-600">29,000 VND/1kg</td>
                                                    <td class="p-4 border border-slate-600">39,000 VND/1kg</td>
                                                </tr>
                                                <tr>
                                                    <td class="p-4 border border-slate-600">10.1kg - 20kg</td>
                                                    <td class="p-4 border border-slate-600">27,000 VND/1kg</td>
                                                    <td class="p-4 border border-slate-600">37,000 VND/1kg</td>
                                                </tr>
                                                <tr>
                                                    <td class="p-4 border border-slate-600">20.1kg - 70kg</td>
                                                    <td class="p-4 border border-slate-600">25,000 VND/1kg</td>
                                                    <td class="p-4 border border-slate-600">35,000 VND/1kg</td>
                                                </tr>
                                                <tr>
                                                    <td class="p-4 border border-slate-600">70.1kg - 200kg</td>
                                                    <td class="p-4 border border-slate-600">24,000 VND/1kg</td>
                                                    <td class="p-4 border border-slate-600">34,000 VND/1kg</td>
                                                </tr>
                                                <tr>
                                                    <td class="p-4 border border-slate-600">&gt; 200.1kg</td>
                                                    <td class="p-4 border border-slate-600" colspan="3">Thoả thuận trước khi
                                                        lên đơn hàng</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div><br></div>
                                </div>
                                <div><br></div>
                                <div>
                                    <i><span>Biểu phí được điều chỉnh lần cuối ngày 18/05/2020.</span></i>
                                </div>
                                <div style="text-align: center;"><span><br></span></div>
                                <p style="text-align: center;">
                                    <span>&nbsp;Đối với đơn hàng cần thỏa thuận giá, NhapHang sẽ căn cứ vào trọng lượng và
                                        ưu tiên
                                        ngành hàng siêu nặng như máy móc, sắt thép.</span>
                                </p>
                                <p>
                                    <span><span style="font-weight: 700;">2. Chuyển phát nhanh (CPN):</span>&nbsp;cam kết
                                        thời gian
                                        hàng về Hà Nội từ 02-03 ngày, thời gian hàng về TP.HCM từ 03-04 ngày. Bảng phí như
                                        sau:</span>
                                </p>
                                <div style="text-align: center;">
                                    <table
                                        class="w-full text-slate-900 dark:text-gray-400 text-base font-bold text-center border-collapse">
                                        <tbody>
                                            <tr class="bg-info text-white">
                                                <td colspan="2" class="bg-cyan-500 p-4">PHÍ CHUYỂN PHÁT NHANH (CPN) QUỐC TẾ
                                                    - TRUNG QUỐC VIỆT NAM</td>
                                            </tr>
                                            <tr class="bg-danger text-white bg-red-600">
                                                <td class="p-4 border border-slate-600">Quảng Châu - Hà Nội</td>
                                                <td class="p-4 border border-slate-600">Quảng Châu - Sài Gòn</td>
                                            </tr>
                                            <tr>
                                                <td class="p-4 border border-slate-600">36,000 VND/1kg</td>
                                                <td class="p-4 border border-slate-600">50,000 VND/1kg</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <p style="text-align: center;"><span>Chi tiết cách tính phí và cam kết thời gian CPN, vui
                                        lòng
                                        xem.</span></p>
                                <p>
                                    <span><span
                                            style="font-weight: 700; color: rgb(33, 33, 33); font-family: Dejavu-Serif, Helvetica, Arial, sans-serif;">3.
                                            Chuyển phát tiết kiệm (CPTK):</span><span
                                            style="color: rgb(33, 33, 33); font-family: Dejavu-Serif, Helvetica, Arial, sans-serif;">&nbsp;</span><span
                                            style="color: rgb(33, 33, 33); font-family: Dejavu-Serif, Helvetica, Arial, sans-serif;">Chuyển
                                            phát Tiết kiệm áp dụng cho những đơn hàng có trọng lượng từ</span><span
                                            style="color: rgb(33, 33, 33); font-family: Dejavu-Serif, Helvetica, Arial, sans-serif; font-weight: 700;">&nbsp;50kg</span><span
                                            style="color: rgb(33, 33, 33); font-family: Dejavu-Serif, Helvetica, Arial, sans-serif;">&nbsp;trở
                                            lên, đồng thời áp dụng cho tất cả các loại hàng hóa, trừ mặt hàng Quốc cấm. Thời
                                            gian hàng về Hà Nội từ 05-07 ngày, thời gian hàng về Sài Gòn từ 07-10 ngày. Bảng
                                            phí như sau:&nbsp;</span></span>
                                </p>
                                <div style="text-align: center;">
                                    <table
                                        class="w-full text-slate-900 dark:text-gray-400 text-base font-bold text-center border-collapse">
                                        <tbody>
                                            <tr class="bg-info text-white">
                                                <td colspan="3" class="bg-cyan-500 p-4">CHÍNH SÁCH CHUYỂN PHÁT TIẾT
                                                    KIỆM<br>(Áp dụng đối với đơn hàng &gt;50kg)</td>
                                            </tr>
                                            <tr class="bg-danger text-white bg-red-600">
                                                <td class="p-4 border border-slate-600">Trọng lượng (kg)</td>
                                                <td class="p-4 border border-slate-600">Hà Nội</td>
                                                <td class="p-4 border border-slate-600">Sài Gòn</td>
                                            </tr>
                                            <tr>
                                                <td class="p-4 border border-slate-600">50kg - 200kg</td>
                                                <td class="p-4 border border-slate-600">21,500 VND/1kg</td>
                                                <td class="p-4 border border-slate-600">24,500 VND/1kg</td>
                                            </tr>
                                            <tr>
                                                <td class="p-4 border border-slate-600">&gt;201kg</td>
                                                <td class="p-4 border border-slate-600">19,500 VND/1kg</td>
                                                <td class="p-4 border border-slate-600">23,000 VND/1kg</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div style="text-align: center;">
                                    <div><i><span>Biểu phí trên được điều chỉnh và áp dụng từ ngày 01/09/2019.</span></i>
                                    </div>
                                </div>
                                <p></p>
                                <p></p>
                            </div>
                        </section>
                    </div>
                </div>

                <!-- BEGIN LISTING -->
                <div class="col-span-3 px-2">
                    <div class="sidebar-right-fee" style="position: sticky; top: 110px;">
                        <nav>
                            <h3 class="text-2xl font-bold py-2">BẢNG PHÍ DỊCH VỤ</h3>
                            <ul class="table-fee" id="table-fee">
                                <li class="py-2">
                                    <a href="#143"
                                        class="btn hover:border-l hover:border-red-600 pl-4 cursor-pointer hover:text-red-600">
                                        Cơ
                                        cấu phí nhập hàng</a>
                                </li>
                                <li class="py-2">
                                    <a href="#144"
                                        class="btn hover:border-l hover:border-red-600 pl-4 cursor-pointer hover:text-red-600">
                                        Giá
                                        vốn</a>
                                </li>
                                <li class="py-2">
                                    <a href="#145"
                                        class="btn hover:border-l hover:border-red-600 pl-4 cursor-pointer hover:text-red-600">
                                        Phí
                                        dịch vụ mua hàng</a>
                                </li>
                                <li class="py-2">
                                    <a href="#146"
                                        class="btn hover:border-l hover:border-red-600 pl-4 cursor-pointer hover:text-red-600">
                                        Phí
                                        dịch vụ kiểm hàng</a>
                                </li>
                                <li class="py-2">
                                    <a href="#147"
                                        class="btn hover:border-l hover:border-red-600 pl-4 cursor-pointer hover:text-red-600">
                                        Phí
                                        vận chuyển TQ-VN</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
                <!--/BEGIN LISTING FEE -->
            </div>
        </div>
    </div>
</template>
  
<script>
</script>
