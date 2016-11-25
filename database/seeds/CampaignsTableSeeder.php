<?php

use Illuminate\Database\Seeder;

class CampaignsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$detail_enduser = '<div class="title-detail">Tuyển sinh du học Nhật Bản - Kỳ nhập học tháng 04/2017</div>
										<p class="mt15">Công ty CP Đào Tạo và Cung Ứng Nhân Lực Quốc Tế HAVICO thông báo tuyển sinh du học vừa học vừa làm tại Nhật Bản - như sau:</p>
										<p class="font600 mt15">I. Đối tượng, tiêu chuẩn chọn:</p>
										<p>- Nam, Nữ tuổi từ 18 - 25 đối với học sinh tốt nghiệp PTTH, dưới 32 tuổi đối với học sinh, sinh viên có bằng trung cấp nghề trở lên.</p>
										<p>- Có trình độ tiếng Nhật sơ cấp (Những người chưa biết tiếng Nhật sẽ được công ty tổ chức đào tạo).</p>
										<p class="font600 mt15">II. Quyền lợi của du học sinh:</p>
										<p>- Được học tập trong môi trường giáo dục có chất lượng hàng đầu trên thế giới với trang thiết bị hiện đại.</p>
										<p>- Có cơ hội ở lại Nhật Bản làm việc sau khi tốt nghiệp.</p>
										<p>- Sau khi về nước có cơ hội được làm việc cho các công ty, tập đoàn lớn của Nhật đầu tư tại Việt Nam.</p>
										<p>- Được làm thêm để tự trang trải chi phí học tập và sinh hoạt tại Nhật Bản.</p>';
    	$certificate_condition = '<p class="font600 mt15">III. Thời gian học tập và làm việc tại Nhật Bản:</p>
										<p class="font600 mt15">1. Thời gian học tập:</p>
										<p><span class="italic">Giai đoạn 1:</span> Học tiếng Nhật từ 1 - 2 năm và tham gia kỳ thi dành cho du học sinh.</p>
										<p><span class="italic">Giai đoạn 2:</span> Học chuyên môn từ 1,5 - 2,5 năm.</p>
										<p>- Đối với du học sinh đã có trình độ THPT, Trung cấp, Cao đẳng sẽ học chuyên ngành ở trình độ Cao đẳng, Đại học.</p>
										<p>- Đối với du học sinh đã có trình độ đại học sẽ học cao học hoặc nghiên cứu sinh, hoặc học thêm bằng 2 đại học.</p>
										<p>- Học ở cấp trình độ nào hoàn toàn phụ thuộc vào năng lực tiếng Nhật của du học sinh sau giai đoạn 1.</p>
										<p class="font600 mt15">2. Thời gian làm việc:</p>
										<p>- Sau khi sang Nhật trong tháng đầu tiên, Công ty sẽ phối hợp với nhà trường hướng dẫn học sinh phỏng vấn và giới thiệu xin công việc làm thêm cho học sinh. </p>
										<p>- Thời gian làm thêm trung bình 28 giờ/tuần, thu nhập phụ thuộc vào năng lực tiếng Nhật của du học sinh, trung bình từ 10 - 12 USD/ giờ. Các công việc làm thêm: đưa báo, đóng gói mỹ phẩm, hái hoa quả, làm việc tại các nhà hàng, nhà máy, bán hàng tại siêu thị, đóng cơm hộp, vận chuyển.</p>
										<p>- Những du học sinh đã có bằng tốt nghiệp Đại học tại Việt Nam, sau khóa học tiếng Nhật có thể đi làm toàn thời gian cho công ty Nhật Bản.</p>';
    	$condition_reward = '<p><span class="font600 mt15">Điều kiện công nhận kết quả:</span> Hoàn thành form (có kiểm tra xác thực thông tin).</p>
										<p class="font600 mt15">Điều kiện từ chối kết quả: </p>
										<p>- Số điện thoại không liên hệ được sau 3 lần gọi trong 2 ngày.</p>
										<p>- Không đúng thông tin, người dùng không TỰ ĐĂNG KÝ hoàn thành form.</p>
										<p>- Thông tin đã được đăng ký từ trang web khác trước đó. </p>';
		$detail_media = '<ul class="txt-noti">
												<li>Khi bạn hoàn thành nhiệm vụ theo đúng yêu cầu, chúng tôi sẽ xác nhận và cộng điểm vào tài khoản của bạn dựa trên kết quả mà đối tác xét duyệt.</li>
												<li>Điểm số sẽ được cộng trong vòng từ 30 đến 45 ngày sau khi nhiệm vụ hoàn thành.</li>
												<li>Thành viên cần click Nhận nhiệm vụ để chuyển sang trang liên kết.</li>
												<li>Nếu bạn không click Nhận nhiệm vụ và giữ trang liên kết để làm nhiệm vụ mà vào trực tiếp thì hệ thống sẽ không ghi nhận được kết quả.</li>
											</ul>';
    	$advertiser_name = array('JUPVIEC', 'AI&T', 'ADWAYS VN', 'FPT', 'FPT-SOFTWARE', 'VINAMILL', 'XI MANG BISOM', 'HONDA VN');
   		$campaigns = array(
    		array('item1.png', 'Đón trăng rằm cùng IT Bakery (Bánh trung thu Handmade không chất bảo quản) - Mua 10 bánh tặng 1 bánh'),
    		array('item2.png', 'Trường Trung cấp kỹ thuật Y - Dược Hà Nội thông báo tuyển sinh 2015 - 2016 (đào tạo hệ chính quy)'),
		    array('item3.png', 'IT Bakery - Đặt bánh online, free ship 5km. Giảm giá 50% bánh tươi vào thứ 4 hàng tuần'),
		    array('item4.png', 'Havico (Du học Nhật Bản). Uy tín và chất lượng. Luôn song hành cùng học viên và phụ huynh'),
		    array('re-item1.png', 'Mua Luxcity nhận nhà trước tết Nguyên Đán 2017. Miễn phí gửi xe hơi 2 năm (3PN) - 25 triệu đồng'),
		    array('re-item2.png', 'Rượu vang ngon mong muốn được chia sẻ kiến thức và kinh nghiệm chọn các loại rượu vang '),
		    array('re-item3.png', 'Trường Phổ thông Quốc tế Newton mở các lớp hè “Mùa hè Vui - Khỏe” cho học sinh từ lớp 1 đến lớp 9'),
		    array('re-item4.png', 'Đất Xanh công bố 20 dự án bất động sản mới tại Dat Xanh Expo 12/2016'),
		    array('re-item5.png', '(gmtvietnam.com) Chương trình khuyến mãi lớn. Giá chỉ còn 1.300.000 vnd'),
		    array('re-item6.png', 'Giày tăng chiều cao nam. Da thật GHK21. Giảm 56%.')
		);
   		$data = 'Chương trình khuyến mãi lớn.';
   		$money = array(50000, 60000, 70000, 80000, 90000, 100000);
    	for($i=1;$i<1000;$i++){
	        DB::table('campaigns')->insert([
	        	'id' => $i,
	            'advertiser_id' => $i,
	        	'promotion_id' => $i+1000000,
	        	'advertiser_name' => $advertiser_name[rand(0, 7)],
	        	'promotion_name' => $campaigns[rand(0, 9)][1],
	        	'category_id' => rand(1, 10),
	        	'banner_id' => rand(1, 1000),
	        	'detail_media' => $detail_media,
	        	'detail_enduser' => $detail_enduser,
	        	'certificate_condition' => $certificate_condition,
	         	'condition_reward' => $condition_reward,
	         	'image_filename' => $campaigns[rand(0, 9)][0],
	         	'start_time' => date('Y-m-d'),
	         	'end_time' => NULL,
	        	'created_at' => date('Y-m-d'),
	        	'updated_at' => date('Y-m-d')
	        ]);
	        DB::table('thanks')->insert([
	            'campaign_id' => $i,
	        	'promotion_id' => $i,
	        	'thanks_id' => rand(1, 2000),
	        	'thanks_name' => $data .'_'.$i,
	        	'thanks_type' => rand(3, 4),
	        	'normal_price' => $money[rand(0, 5)],
	        	'special_price' => 8000,
	        	'delete_flag' => 0,
	        	'created_at' => date('Y-m-d'),
	        	'updated_at' => date('Y-m-d')
	        ]);
        }
    }
}
