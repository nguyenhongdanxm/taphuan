<?php
// Kiểm tra ranh giới thời gian, không chờ thật và không dùng dữ liệu hosting.
require __DIR__.'/../attendance.php';
$config=array('setup_key'=>'only-for-attendance-unit-tests');
$s=array('id'=>'session-one','nonce'=>'random-server-secret','open'=>true);
function verify_test($ok,$message){if(!$ok){fwrite(STDERR,$message."\n");exit(1);}}
$a=attendance_proof($s,1000);$b=attendance_proof($s,1019);$c=attendance_proof($s,1020);
verify_test($a['signature']===$b['signature'],'Mã phải giữ trong cùng chu kỳ.');
verify_test($a['signature']!==$c['signature'],'Mã phải đổi đúng sau 20 giây.');
verify_test($a['expires_at']===1020,'Thời hạn không đúng.');
verify_test(attendance_valid_proof($s,$a,1019),'Mã còn hạn cần được chấp nhận.');
verify_test(!attendance_valid_proof($s,$a,1020),'Mã cũ phải hết hiệu lực ngay ở chu kỳ mới.');
verify_test(!attendance_valid_proof($s,$c,1019),'Không nhận mã chu kỳ tương lai.');
$other=$s;$other['id']='session-two';verify_test(!attendance_valid_proof($other,$a,1000),'Không dùng mã cho buổi khác.');
$other=$s;$other['nonce']='rotated-after-reopen';verify_test(!attendance_valid_proof($other,$a,1000),'Mở lại buổi phải vô hiệu mã cũ.');
$other=$s;$other['open']=false;verify_test(!attendance_valid_proof($other,$a,1000),'Không nhận mã khi buổi đã đóng.');
$bad=$a;$bad['slot']=(string)$a['slot'];verify_test(!attendance_valid_proof($s,$bad,1000),'Kiểm tra đúng kiểu dữ liệu chu kỳ.');
echo "PASS: exact 20-second rotation, expiry, future/tampered/cross-session/reopened/closed codes.\n";
