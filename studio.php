<?php
// Nội dung tự tạo và tài khoản học viên; chỉ được gọi từ API.
function studio_defaults(&$st) {
 if(!isset($st['studio']))$st['studio']=array('items'=>array(),'votes'=>array(),'assets'=>array(),'stage'=>array('kind'=>'welcome','item'=>null,'page'=>'learn','slide'=>0,'media_version'=>0,'playing'=>false,'sound'=>false));
}
function clean_person($p) { unset($p['password_hash']); return $p; }
function phone_number($p) { $p=preg_replace('/[\s().-]+/','',cut($p,30)); if(substr($p,0,3)==='+84')$p='0'.substr($p,3); if(!preg_match('/^0[0-9]{9}$/',$p))fail('Số điện thoại cần có 10 chữ số, bắt đầu bằng 0.',400); return $p; }
function initial_student_password($name,$phone) {
 $parts=preg_split('/\s+/u',trim($name));$last=end($parts);
 $groups=array('a'=>'àáạảãâầấậẩẫăằắặẳẵÀÁẠẢÃÂẦẤẬẨẪĂẰẮẶẲẴ','e'=>'èéẹẻẽêềếệểễÈÉẸẺẼÊỀẾỆỂỄ','i'=>'ìíịỉĩÌÍỊỈĨ','o'=>'òóọỏõôồốộổỗơờớợởỡÒÓỌỎÕÔỒỐỘỔỖƠỜỚỢỞỠ','u'=>'ùúụủũưừứựửữÙÚỤỦŨƯỪỨỰỬỮ','y'=>'ỳýỵỷỹỲÝỴỶỸ','d'=>'đĐ');
 foreach($groups as $to=>$chars){foreach(preg_split('//u',$chars,-1,PREG_SPLIT_NO_EMPTY) as $from)$last=str_replace($from,$to,$last);}
 $last=strtolower(preg_replace('/[^a-zA-Z0-9]/','',$last)); if($last==='')$last='hocvien';return $last.substr($phone,-3);
}
function studio_item($st,$id) { if(!is_string($id)||!isset($st['studio']['items'][$id]))fail('Không có nội dung này.',404);return $st['studio']['items'][$id]; }
function public_item($item) { if(empty($item['reveal']))unset($item['answer'],$item['explanation']);return $item; }
function studio_summary($st,$is_admin) {
 $ss=$st['studio'];$items=array();$stats=array();$leader=array();$active=null;
 foreach($ss['items'] as $id=>$item) {
  if($is_admin||!empty($item['open']))$items[]= $is_admin?$item:public_item($item);
  if($ss['stage']['kind']==='item'&&$ss['stage']['item']===$id)$active=$is_admin?$item:public_item($item);
  $counts=array_fill(0,count($item['options']),0);$total=0;
  if(isset($ss['votes'][$id]))foreach($ss['votes'][$id] as $pid=>$v){$total++;if(isset($counts[$v['choice']]))$counts[$v['choice']]++;if($item['type']==='game'&&isset($st['participants'][$pid])){if(!isset($leader[$pid]))$leader[$pid]=array('name'=>$st['participants'][$pid]['name'],'school'=>$st['participants'][$pid]['school'],'score'=>0,'answered'=>0);$leader[$pid]['score']+=isset($v['score'])?$v['score']:0;$leader[$pid]['answered']++;}}
  if($is_admin||(!empty($item['reveal'])&&!empty($item['open'])))$stats[$id]=array('total'=>$total,'counts'=>$counts);
 }
 // Chỉ công bố bảng điểm khi màn hiện tại cho phép công bố.
 $ranking=array_values($leader);usort($ranking,function($a,$b){return $b['score']-$a['score'];});
 if(!$is_admin&&(!$active||empty($active['reveal'])||$active['type']!=='game'))$ranking=array();
 $att=array();if($ss['stage']['kind']==='attendance'||$is_admin){foreach(array_slice(array_filter($st['participants'],function($p){return !empty($p['phone']);}),-12) as $p)$att[]=array('name'=>$p['name'],'role'=>$p['role'],'school'=>$p['school']);}
 $pid=isset($_SESSION['participant'])?$_SESSION['participant']:null;$mine=array();foreach($ss['votes'] as $id=>$votes){if($pid&&isset($votes[$pid])){$v=$votes[$pid];if(!$is_admin&&empty($ss['items'][$id]['reveal']))unset($v['score']);$mine[$id]=$v;}}
 $roster=array();if($is_admin&&$active&&in_array($active['type'],array('poll','game'),true)){foreach($st['participants'] as $id=>$p){if(empty($p['phone']))continue;$roster[]=array('name'=>$p['name'],'role'=>$p['role'],'school'=>$p['school'],'answered'=>isset($ss['votes'][$active['id']][$id]));}}
 $stage=$ss['stage'];return array('roster'=>$roster,'items'=>$items,'active'=>$active,'stage'=>$stage,'stats'=>$stats,'ranking'=>array_slice($ranking,0,20),'attendance'=>$att,'mine'=>$mine,'assets'=>$is_admin?array_values($ss['assets']):array());
}
function studio_actions($action,$input,$is_admin) {
 global $config;
 if($action==='student_register') {
  $name=cut(isset($input['name'])?$input['name']:'',100);$role=cut(isset($input['role'])?$input['role']:'',100);$school=cut(isset($input['school'])?$input['school']:'',180);$phone=phone_number(isset($input['phone'])?$input['phone']:'');
  if($name===''||$role===''||$school==='')fail('Họ tên, chức vụ, đơn vị và số điện thoại đều bắt buộc.',400);
  return with_state(function(&$st)use($name,$role,$school,$phone,$config){foreach($st['participants'] as $p){if(isset($p['phone'])&&$p['phone']===$phone)fail('Số điện thoại đã đăng ký. Chọn Đăng nhập bằng tài khoản đã có.',409);}
   $old=isset($_SESSION['participant'])?$_SESSION['participant']:null;$pid=$old&&isset($st['participants'][$old])&&empty($st['participants'][$old]['phone'])?$old:token();
   if(!isset($st['participants'][$pid])&&count($st['participants'])>=$config['max_participants'])fail('Đã đạt giới hạn đăng ký của lớp.',409);
   $pass=initial_student_password($name,$phone);$st['participants'][$pid]=array('name'=>$name,'role'=>$role,'school'=>$school,'phone'=>$phone,'password_hash'=>password_hash($pass,PASSWORD_DEFAULT),'joined'=>isset($st['participants'][$pid])?$st['participants'][$pid]['joined']:gmdate('c'));
   $_SESSION['participant']=$pid;session_regenerate_id(true);audit($st,'Kiểm diện và tạo tài khoản học viên.');return array('ok'=>true,'account'=>$phone,'initial_password'=>$pass);
  },true);
 }
 if($action==='student_login') {
  $phone=phone_number(isset($input['phone'])?$input['phone']:'');$pass=cut(isset($input['password'])?$input['password']:'',200);
  $r=with_state(function(&$st)use($phone,$pass){$ip=isset($_SERVER['REMOTE_ADDR'])?$_SERVER['REMOTE_ADDR']:'unknown';$key=hash('sha256','student:'.$ip.':'.$phone);$now=time();foreach($st['attempts'] as $k=>$v)if($now-$v['start']>900)unset($st['attempts'][$k]);$a=isset($st['attempts'][$key])?$st['attempts'][$key]:array('start'=>$now,'count'=>0);if($a['count']>=8)return array('error'=>'Thử quá nhiều lần. Đợi 15 phút hoặc nhờ báo cáo viên hỗ trợ.','status'=>429);
   foreach($st['participants'] as $pid=>$p){if(isset($p['phone'])&&$p['phone']===$phone&&!empty($p['password_hash'])&&password_verify($pass,$p['password_hash'])){$_SESSION['participant']=$pid;session_regenerate_id(true);unset($st['attempts'][$key]);return array('ok'=>true);}}
   $a['count']++;$st['attempts'][$key]=$a;return array('error'=>'Số điện thoại hoặc mật khẩu không đúng.','status'=>403);
  },true);if(isset($r['error']))fail($r['error'],$r['status']);return $r;
 }
 if($action==='student_logout'){unset($_SESSION['participant']);session_regenerate_id(true);return array('ok'=>true);}
 if($action==='upload')return studio_upload();
 if($action==='studio_save') {
  need_admin();return with_state(function(&$st)use($input){$id=isset($input['id'])?$input['id']:'';$existing=$id!==''?studio_item($st,$id):null;if($existing&&!empty($st['studio']['votes'][$id]))fail('Nội dung đã có phản hồi. Tạo nội dung mới để giữ nguyên kết quả đã nhận.',409);if(!$existing&&count($st['studio']['items'])>=100)fail('Đã có 100 nội dung. Vui lòng dùng nội dung hiện có.',409);
   $type=isset($input['type'])?$input['type']:'';if(!in_array($type,array('maket','text','document','poll','game'),true))fail('Loại nội dung không hợp lệ.',400);
   $title=cut(isset($input['title'])?$input['title']:'',160);$body=cut(isset($input['body'])?$input['body']:'',16000);if($title==='')fail('Nhập tiêu đề.',400);
   $options=array();if($type==='poll'||$type==='game'){if(!isset($input['options'])||!is_array($input['options']))fail('Nhập các phương án, mỗi phương án một dòng.',400);foreach($input['options'] as $x){$x=cut($x,300);if($x!=='')$options[]=$x;}if(count($options)<2||count($options)>6)fail('Cần từ 2 đến 6 phương án.',400);}
   $answer=isset($input['answer'])?(int)$input['answer']:0;if($type==='game'&&($answer<0||$answer>=count($options)))fail('Đáp án đúng không hợp lệ.',400);
   $asset=isset($input['asset'])?$input['asset']:'';if($asset!==''&&!isset($st['studio']['assets'][$asset]))fail('Tệp chưa được tải lên.',400);
   if($type==='maket'&&($asset===''||!in_array($st['studio']['assets'][$asset]['kind'],array('image','video'),true)))fail('Maket cần một ảnh hoặc video đã tải lên.',400);
   if(!$existing)$id='custom-'.substr(token(),0,16);
   $item=array('id'=>$id,'type'=>$type,'title'=>$title,'body'=>$body,'options'=>$options,'answer'=>$type==='game'?$answer:null,'explanation'=>cut(isset($input['explanation'])?$input['explanation']:'',2000),'seconds'=>max(10,min(300,(int)(isset($input['seconds'])?$input['seconds']:30))),'asset'=>$asset!==''?$st['studio']['assets'][$asset]:null,'fit'=>isset($input['fit'])&&$input['fit']==='contain'?'contain':'cover','open'=>$existing?$existing['open']:false,'accept'=>false,'reveal'=>false,'deadline'=>0);
   $st['studio']['items'][$id]=$item;audit($st,'Lưu nội dung tự tạo: '.$title);return array('ok'=>true,'id'=>$id);
  },true);
 }
 if($action==='studio_control') {
  need_admin();return with_state(function(&$st)use($input){$op=isset($input['op'])?$input['op']:'';$id=isset($input['id'])?$input['id']:'';
   if(in_array($op,array('welcome','attendance','blank'),true)){$st['studio']['stage']=array('kind'=>$op,'item'=>null,'page'=>'learn','slide'=>0,'media_version'=>time(),'playing'=>false,'sound'=>false);}
   elseif($op==='show_course'){section($id);$st['controls']['open'][$id]=true;$st['controls']['focus']=$id;$page=isset($input['page'])?$input['page']:'learn';$highlight=isset($input['highlight'])?max(-1,min(20,(int)$input['highlight'])):-1;if(!in_array($page,array('learn','case','practice','prompt'),true))fail('Trang không hợp lệ.',400);$st['studio']['stage']=array('kind'=>'course','item'=>$id,'page'=>$page,'highlight'=>$highlight,'media_version'=>time(),'playing'=>false,'sound'=>false);}
   elseif($op==='message'){$st['studio']['stage']=array('kind'=>'message','item'=>null,'title'=>cut(isset($input['title'])?$input['title']:'',160),'body'=>cut(isset($input['body'])?$input['body']:'',16000),'page'=>'learn','media_version'=>time(),'playing'=>false,'sound'=>false);}
   elseif($op==='show'){$item=studio_item($st,$id);$st['studio']['items'][$id]['open']=true;$st['studio']['stage']=array('kind'=>'item','item'=>$id,'page'=>'learn','slide'=>0,'media_version'=>time(),'playing'=>true,'sound'=>false);}
   elseif(in_array($op,array('accept','reveal','hide','start','stop'),true)){$item=studio_item($st,$id);if($op==='hide'){$st['studio']['items'][$id]['open']=false;$st['studio']['items'][$id]['accept']=false;if($st['studio']['stage']['item']===$id)$st['studio']['stage']['kind']='welcome';}
    elseif($op==='start'){if($item['type']!=='game')fail('Chỉ trò chơi có nút bắt đầu tính giờ.',400);if(empty($item['open']))fail('Đưa câu hỏi lên màn chiếu trước.',409);$st['studio']['items'][$id]['accept']=true;$st['studio']['items'][$id]['reveal']=false;$st['studio']['items'][$id]['deadline']=time()+$item['seconds'];}
    elseif($op==='stop')$st['studio']['items'][$id]['accept']=false;
    else{if(empty($item['open']))fail('Mở nội dung trước.',409);$st['studio']['items'][$id][$op]=!empty($input['value']);if($op==='reveal'&&!empty($input['value']))$st['studio']['items'][$id]['accept']=false;}
   }elseif($op==='page'){$stage=$st['studio']['stage'];if($stage['kind']!=='item')fail('Chọn nội dung tự tạo trước.',409);$item=studio_item($st,$stage['item']);$current=isset($stage['slide'])?$stage['slide']:0;$slide=isset($input['page'])?(int)$input['page']:$current+(isset($input['step'])?(int)$input['step']:0);$max=$item['asset']&&$item['asset']['kind']==='pdf'?999:count(preg_split('/\r?\n---\r?\n/',$item['body']))-1;$st['studio']['stage']['slide']=max(0,min($max,$slide));
   }elseif($op==='media'){$st['studio']['stage']['playing']=!empty($input['playing']);$st['studio']['stage']['sound']=!empty($input['sound']);if(!empty($input['restart']))$st['studio']['stage']['media_version']=time();}
   elseif($op==='reset_student'){if(!isset($st['participants'][$id])||empty($st['participants'][$id]['phone']))fail('Không có tài khoản này.',404);$p=$st['participants'][$id];$pass=initial_student_password($p['name'],$p['phone']);$st['participants'][$id]['password_hash']=password_hash($pass,PASSWORD_DEFAULT);audit($st,'Đặt lại mật khẩu học viên.');return array('ok'=>true,'account'=>$p['phone'],'initial_password'=>$pass);}
   else fail('Thao tác không hợp lệ.',400);
   audit($st,'Màn chiếu: '.$op);return array('ok'=>true);
  },true);
 }
 if($action==='studio_vote')return with_state(function(&$st)use($input){$pid=isset($_SESSION['participant'])?$_SESSION['participant']:'';if(!isset($st['participants'][$pid])||empty($st['participants'][$pid]['phone']))fail('Kiểm diện hoặc đăng nhập bằng số điện thoại trước khi trả lời.',401);$id=isset($input['id'])?$input['id']:'';$item=studio_item($st,$id);$choice=isset($input['choice'])?$input['choice']:null;if(!in_array($item['type'],array('poll','game'),true)||!is_int($choice)||$choice<0||$choice>=count($item['options']))fail('Lựa chọn không hợp lệ.',400);if(empty($item['open'])||empty($item['accept'])||!empty($item['reveal']))fail('Chưa mở nhận hoặc đã đóng nhận trả lời.',409);if($item['type']==='game'&&(!$item['deadline']||time()>=$item['deadline']))fail('Câu hỏi chưa bắt đầu hoặc đã hết giờ.',409);if($item['type']==='game'&&isset($st['studio']['votes'][$id][$pid]))fail('Mỗi tài khoản trả lời trò chơi một lần cho mỗi câu.',409);if(!isset($st['studio']['votes'][$id]))$st['studio']['votes'][$id]=array();$st['studio']['votes'][$id][$pid]=array('choice'=>$choice,'score'=>$item['type']==='game'&&$choice===$item['answer']?100:0,'time'=>gmdate('c'));return array('ok'=>true);},true);
 fail('Không có thao tác.',404);
}
function studio_upload() {
 need_admin();global $config;
 if(empty($_FILES['file'])||$_FILES['file']['error']!==UPLOAD_ERR_OK)fail('Tải tệp không thành công. Kiểm tra upload_max_filesize và post_max_size trên hosting.',400);
 $f=$_FILES['file'];if($f['size']>50*1024*1024)fail('Tệp tối đa 50 MB; hosting có thể đặt giới hạn thấp hơn.',413);
 $ext=strtolower(pathinfo($f['name'],PATHINFO_EXTENSION));$allowed=array('jpg'=>array('image/jpeg','image'),'jpeg'=>array('image/jpeg','image'),'png'=>array('image/png','image'),'webp'=>array('image/webp','image'),'gif'=>array('image/gif','image'),'mp4'=>array('video/mp4','video'),'webm'=>array('video/webm','video'),'pdf'=>array('application/pdf','pdf'),'txt'=>array('text/plain','text'),'docx'=>array('application/vnd.openxmlformats-officedocument.wordprocessingml.document','word'));
 if(!isset($allowed[$ext]))fail('Chỉ nhận JPG, PNG, WEBP, GIF, MP4, WEBM, PDF, TXT và DOCX.',400);
 $info=finfo_open(FILEINFO_MIME_TYPE);$mime=finfo_file($info,$f['tmp_name']);finfo_close($info);
 if($ext==='docx'){if(!class_exists('ZipArchive'))fail('Hosting chưa hỗ trợ kiểm tra DOCX. Xuất PDF rồi tải lên.',400);$zip=new ZipArchive();if($zip->open($f['tmp_name'])!==true)fail('DOCX không hợp lệ.',400);$valid=$zip->locateName('word/document.xml')!==false&&$zip->locateName('[Content_Types].xml')!==false;$zip->close();if(!$valid)fail('DOCX không hợp lệ.',400);}
 elseif($mime!==$allowed[$ext][0])fail('Định dạng thực tế của tệp không khớp phần mở rộng.',400);
 $dir=__DIR__.'/workshop-media';if(!is_dir($dir)&&!mkdir($dir,0755,true))fail('Không tạo được thư mục tải lên.',500);
 $ht="Options -Indexes\n<IfModule mod_rewrite.c>\nRewriteEngine Off\n</IfModule>\n<FilesMatch \"\\.(php[0-9]?|phtml|phar|cgi|pl|sh|htaccess)$\">\n<IfModule mod_authz_core.c>\nRequire all denied\n</IfModule>\n<IfModule !mod_authz_core.c>\nDeny from all\n</IfModule>\n</FilesMatch>\n";
 if(!file_exists($dir.'/.htaccess')&&file_put_contents($dir.'/.htaccess',$ht)===false)fail('Không bảo vệ được thư mục tải lên.',500);
 $id=substr(token(),0,32);$name=$id.'.'.$ext;if(!move_uploaded_file($f['tmp_name'],$dir.'/'.$name))fail('Không lưu được tệp tải lên.',500);chmod($dir.'/'.$name,0644);
 $asset=array('id'=>$id,'name'=>cut($f['name'],180),'url'=>'workshop-media/'.$name,'kind'=>$allowed[$ext][1],'size'=>$f['size']);
 try{return with_state(function(&$st)use($asset){$st['studio']['assets'][$asset['id']]=$asset;audit($st,'Tải tư liệu: '.$asset['name']);return array('ok'=>true,'asset'=>$asset);},true);}catch(Exception $e){@unlink($dir.'/'.$name);throw $e;}
}
