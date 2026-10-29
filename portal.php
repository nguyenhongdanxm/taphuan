<?php
// Cổng tập huấn. Dữ liệu cũ chỉ được đọc để khởi tạo, không bị xóa/ghi đè.
function portal_defaults(&$st) {
 global $course;
 if(isset($st['portal']))return;
 $topics=array();$order=0;
 foreach($course['sections'] as $s){
  $lines=array($s['lead'],'','NỘI DUNG CHÍNH');
  foreach($s['points'] as $p)$lines[]=$p[0].': '.$p[1];
  if(!empty($s['model'])){$lines[]='';$lines[]='QUY TRÌNH / MÔ HÌNH';$lines[]=implode(' → ',$s['model']);}
  if(!empty($s['case'])){$lines[]='';$lines[]='TÌNH HUỐNG: '.$s['case']['title'];$lines[]=$s['case']['story'];$lines[]=$s['case']['question'];}
  $lines[]='';$lines[]='THỰC HÀNH';foreach($s['task'] as $t)$lines[]='• '.$t;
  $lines[]='';$lines[]='SẢN PHẨM: '.$s['deliverable'];
  if(!empty($s['rubric']))$lines[]='Tiêu chí: '.implode('; ',$s['rubric']);
  $group='';foreach($course['sessions'] as $session)if($session['id']===$s['session'])$group=$session['title'];
  $topics[$s['id']]=array('id'=>$s['id'],'title'=>$s['title'],'group'=>$group,'summary'=>$s['lead'],'body'=>implode("\n",$lines),'prompt'=>$s['prompt'],'minutes'=>$s['minutes'],'order'=>++$order,'published'=>true,'revision'=>1);
 }
 $tools=array();foreach($course['tools'] as $t)$tools[$t['id']]=array('id'=>$t['id'],'name'=>$t['name'],'group'=>$t['tier'],'url'=>$t['url'],'description'=>$t['use'],'prompt'=>'','revision'=>1);
 $st['portal']=array('revision'=>1,'event'=>array('welcome'=>'Chào mừng quý thầy cô!','title'=>$course['title'],'subtitle'=>'Tập huấn ứng dụng công nghệ số và trí tuệ nhân tạo trong quản lý nhà trường','presenter'=>$course['presenter'],'organizer'=>'','time'=>'','location'=>'','description'=>'Cùng chia sẻ thực trạng, thực hành công cụ và xây dựng sản phẩm có thể áp dụng tại đơn vị.','notice'=>'Chọn Kiểm diện để vào tài khoản, sau đó hoàn thành khảo sát đầu vào.'),'topics'=>$topics,'tools'=>$tools,'directory'=>require __DIR__.'/roster-seed.php');
}
function portal_directory($st){
 $units=array();foreach($st['portal']['directory'] as $u)$units[$u['school']]=$u['people'];
 $directoryPeople=$st['participants'];foreach(isset($st['portal']['roster_drafts'])?$st['portal']['roster_drafts']:array() as $draft)$directoryPeople[]=$draft;
 foreach($directoryPeople as $p){if(empty($p['school'])||empty($p['name']))continue;if(!isset($units[$p['school']]))$units[$p['school']]=array();$found=false;
  foreach($units[$p['school']] as &$person)if($person['name']===$p['name']){if(empty($person['role'])&&!empty($p['role']))$person['role']=$p['role'];$found=true;break;}unset($person);
  if(!$found)$units[$p['school']][]=array('name'=>$p['name'],'role'=>isset($p['role'])?$p['role']:'');
 }
 ksort($units,SORT_NATURAL);$out=array();foreach($units as $school=>$people){$out[]=array('school'=>$school,'people'=>$people);}return $out;
}
function portal_remember(&$st,$school,$name,$role){
 foreach(isset($st['portal']['roster_drafts'])?$st['portal']['roster_drafts']:array() as $id=>$draft)if($draft['school']===$school&&$draft['name']===$name)unset($st['portal']['roster_drafts'][$id]);
 foreach($st['portal']['directory'] as &$u)if($u['school']===$school){foreach($u['people'] as &$p)if($p['name']===$name){$p['role']=$role;return;}$u['people'][]=array('name'=>$name,'role'=>$role);return;}
 unset($u);$st['portal']['directory'][]=array('school'=>$school,'people'=>array(array('name'=>$name,'role'=>$role)));
}
function portal_sort($items){$out=array_values($items);usort($out,function($a,$b){$a=isset($a['order'])?$a['order']:0;$b=isset($b['order'])?$b['order']:0;return $a===$b?0:($a<$b?-1:1);});return $out;}
function portal_state($st,$is_admin){
 $p=$st['portal'];$pid=isset($_SESSION['participant'])?$_SESSION['participant']:'';$topics=array();foreach(portal_sort($p['topics']) as $t)if($is_admin||$t['published'])$topics[]=$t;
 $people=array();$count=0;foreach($st['participants'] as $id=>$person){if(empty($person['phone']))continue;$count++;if($is_admin){$person=clean_person($person);$person['id']=$id;$person['answered']=isset($st['survey']['responses'][$id]);$people[]=$person;}}
 return array('event'=>$p['event'],'event_revision'=>$p['revision'],'topics'=>$topics,'tools'=>array_values($p['tools']),'directory'=>portal_directory($st),'people'=>$people,'roster'=>$is_admin?roster_summary($st):null,'checked_in_count'=>$count,'survey'=>survey_summary($st,$is_admin),'ai'=>$is_admin?ai_meta():null,'me'=>isset($st['participants'][$pid])?clean_person($st['participants'][$pid]):null,'admin'=>$is_admin,'initialized'=>!empty($st['password_hash']),'csrf'=>$_SESSION['csrf'],'attendance'=>attendance_summary($st,$is_admin),'version'=>$st['version']);
}
function portal_field($input,$name,$max){return cut(isset($input[$name])?$input[$name]:'',$max);}
function portal_revision($input,$current){if(!isset($input['revision'])||(int)$input['revision']!==(int)$current)fail('Nội dung đã thay đổi ở phiên khác. Đóng biểu mẫu, tải lại và sửa bản mới.',409);}
function portal_actions($action,$input,$is_admin){
 global $config;
 if($action==='portal_state')return with_state(function(&$st)use($is_admin){return portal_state($st,$is_admin);},false);
 if(strpos($action,'portal_roster_')===0)return roster_actions($action,$input);
 if($action==='portal_survey_dashboard'){need_admin();return with_state(function(&$st)use($input){return survey_dashboard($st,$input);},false);}
 if($action==='portal_scan'||strpos($action,'portal_attendance_')===0)return attendance_actions($action,$input);
 if($action==='portal_checkin'){
  $school=portal_field($input,'school',180);$name=portal_field($input,'name',100);$role=portal_field($input,'role',100);$phone=phone_number(isset($input['phone'])?$input['phone']:'');
  if($school===''||$name===''||$role==='')fail('Chọn trường và bổ sung đủ họ tên, chức vụ.',400);
  return with_state(function(&$st)use($school,$name,$role,$phone,$config,$input){
   $grant=attendance_need_grant($st);if(portal_field($input,'session',100)!==$grant['session'])fail('Buổi điểm danh đã thay đổi. Quét lại mã QR của đúng buổi.',409);
   $pid=null;$same=null;foreach($st['participants'] as $id=>$p){
    if(!empty($p['phone'])&&$p['phone']===$phone){if($p['school']!==$school||$p['name']!==$name)fail('Số điện thoại đã gắn với thông tin khác. Kiểm tra lại hoặc nhờ quản trị hỗ trợ.',409);$pid=$id;}
    if($p['school']===$school&&$p['name']===$name&&!empty($p['phone'])&&$p['phone']!==$phone)$same=$id;
   }
   if($pid===null&&$same!==null)fail('Thầy/cô đã điểm danh bằng số điện thoại khác. Dùng số đã đăng ký hoặc nhờ quản trị hỗ trợ.',409);
   $new=$pid===null;if($new){if(count(array_filter($st['participants'],function($p){return !empty($p['phone']);}))>=$config['max_participants'])fail('Lớp đã đạt giới hạn đăng ký.',409);$pid=token();$st['participants'][$pid]=array('name'=>$name,'school'=>$school,'role'=>$role,'phone'=>$phone,'password_hash'=>password_hash(initial_student_password($name,$phone),PASSWORD_DEFAULT),'joined'=>gmdate('c'));}
   $st['participants'][$pid]['role']=$role;$st['participants'][$pid]['last_checkin']=gmdate('c');portal_remember($st,$school,$name,$role);
   attendance_record($st,$pid,$grant);
   $_SESSION['participant']=$pid;session_regenerate_id(true);audit($st,'Điểm danh theo buổi: '.$grant['title']);return array('ok'=>true,'created'=>$new,'session'=>$grant['session'],'initial_password'=>$new?initial_student_password($name,$phone):null);
  },true);
 }
 need_admin();
 return with_state(function(&$st)use($action,$input){$p=&$st['portal'];
  if($action==='portal_event_save'){
   portal_revision($input,$p['revision']);$event=array();foreach(array('welcome'=>160,'title'=>200,'subtitle'=>500,'presenter'=>200,'organizer'=>200,'time'=>200,'location'=>300,'description'=>6000,'notice'=>1000) as $k=>$max)$event[$k]=portal_field($input,$k,$max);
   if($event['title']==='')fail('Nhập tên đợt tập huấn.',400);$p['event']=$event;$p['revision']++;
  }elseif($action==='portal_topic_save'){
   $id=portal_field($input,'id',100);$old=null;if($id!==''){if(!isset($p['topics'][$id]))fail('Chuyên đề đã bị xóa. Tải lại danh sách.',409);$old=$p['topics'][$id];portal_revision($input,$old['revision']);}elseif(count($p['topics'])>=200)fail('Đã đạt giới hạn 200 chuyên đề.',409);
   $title=portal_field($input,'title',200);if($title==='')fail('Nhập tên chuyên đề.',400);if(!$old)$id='topic-'.substr(token(),0,16);
   $p['topics'][$id]=array('id'=>$id,'title'=>$title,'group'=>portal_field($input,'group',200),'summary'=>portal_field($input,'summary',1000),'body'=>portal_field($input,'body',30000),'prompt'=>portal_field($input,'prompt',6000),'minutes'=>max(0,min(600,(int)(isset($input['minutes'])?$input['minutes']:0))),'order'=>max(0,min(9999,(int)(isset($input['order'])?$input['order']:count($p['topics'])+1))),'published'=>!empty($input['published']),'revision'=>$old?$old['revision']+1:1);
  }elseif($action==='portal_topic_delete'){
   $id=portal_field($input,'id',100);if(!isset($p['topics'][$id]))fail('Không có chuyên đề này.',404);portal_revision($input,$p['topics'][$id]['revision']);unset($p['topics'][$id]);
  }elseif($action==='portal_tool_save'){
   $id=portal_field($input,'id',100);$old=null;if($id!==''){if(!isset($p['tools'][$id]))fail('Công cụ đã bị xóa.',409);$old=$p['tools'][$id];portal_revision($input,$old['revision']);}elseif(count($p['tools'])>=200)fail('Đã đạt giới hạn 200 công cụ.',409);
   $name=portal_field($input,'name',200);$url=portal_field($input,'url',1000);if($name==='')fail('Nhập tên công cụ / câu lệnh.',400);if($url!==''&&(!filter_var($url,FILTER_VALIDATE_URL)||!in_array(strtolower(parse_url($url,PHP_URL_SCHEME)),array('https','http'),true)))fail('Liên kết phải bắt đầu bằng https:// hoặc http://.',400);if(!$old)$id='tool-'.substr(token(),0,16);
   $p['tools'][$id]=array('id'=>$id,'name'=>$name,'group'=>portal_field($input,'group',200),'url'=>$url,'description'=>portal_field($input,'description',3000),'prompt'=>portal_field($input,'prompt',6000),'revision'=>$old?$old['revision']+1:1);
  }elseif($action==='portal_tool_delete'){
   $id=portal_field($input,'id',100);if(!isset($p['tools'][$id]))fail('Không có công cụ này.',404);portal_revision($input,$p['tools'][$id]['revision']);unset($p['tools'][$id]);
  }else fail('Thao tác không hợp lệ.',404);
  audit($st,'Cổng tập huấn: '.$action);return array('ok'=>true);
 },true);
}
