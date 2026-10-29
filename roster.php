<?php
// Biên tập danh sách gốc và hồ sơ tài khoản; không thay mã tài khoản hoặc lịch sử buổi.
function roster_rows($st){$rows=array();foreach(portal_directory($st) as $u)foreach($u['people'] as $person){$linked=array();foreach($st['participants'] as $id=>$p)if($p['school']===$u['school']&&$p['name']===$person['name']&&!empty($p['phone']))$linked[$id]=$p;$first=count($linked)?reset($linked):null;$key=attendance_identity($u['school'],$person['name']);$rows[]=array('key'=>$key,'school'=>$u['school'],'name'=>$person['name'],'role'=>$first?$first['role']:$person['role'],'phone'=>$first?$first['phone']:'','account_count'=>count($linked),'token'=>hash('sha256',json_encode(array($u['school'],$person,$linked))));}return $rows;}
function roster_school_token($st,$school){$unit=null;foreach(portal_directory($st) as $u)if($u['school']===$school)$unit=$u;$people=array();foreach($st['participants'] as $id=>$p)if($p['school']===$school)$people[$id]=$p;return hash('sha256',json_encode(array($unit,$people)));}
function roster_summary($st){$schools=array();foreach(portal_directory($st) as $u)$schools[]=array('name'=>$u['school'],'count'=>count($u['people']),'token'=>roster_school_token($st,$u['school']));return array('rows'=>roster_rows($st),'schools'=>$schools);}
function roster_actions($action,$input){need_admin();global $config;return with_state(function(&$st)use($action,$input,$config){
 if($action==='portal_roster_save'){
  $key=portal_field($input,'key',64);$old=null;foreach(roster_rows($st) as $r)if($r['key']===$key)$old=$r;
  if($key!==''&&(!$old||!isset($input['token'])||!is_string($input['token'])||!hash_equals($old['token'],$input['token'])))fail('Danh sách vừa thay đổi. Đóng biểu mẫu, tải lại rồi sửa.',409);
  if($old&&$old['account_count']>1)fail('Có nhiều tài khoản trùng tên trong cùng trường. Cần xử lý trùng trước khi sửa danh sách.',409);
  $school=portal_field($input,'school',180);$name=portal_field($input,'name',100);$role=portal_field($input,'role',100);$rawPhone=portal_field($input,'phone',30);$phone=$rawPhone!==''?phone_number($rawPhone):'';if($school===''||$name==='')fail('Nhập tên trường và họ tên.',400);
  $newKey=attendance_identity($school,$name);foreach(roster_rows($st) as $r)if($r['key']===$newKey&&$r['key']!==$key)fail('Người này đã có trong danh sách trường.',409);
  $pid=null;foreach($st['participants'] as $id=>$p){if($old&&$p['school']===$old['school']&&$p['name']===$old['name']&&!empty($p['phone']))$pid=$id;}
  if(($phone!==''||$pid!==null)&&$role==='')fail('Nhập chức vụ để tạo/cập nhật tài khoản.',400);if($pid!==null&&$phone==='')fail('Tài khoản đã có phải giữ số điện thoại đăng nhập hợp lệ.',400);
  foreach($st['participants'] as $id=>$p)if($phone!==''&&isset($p['phone'])&&$p['phone']===$phone&&$id!==$pid)fail('Số điện thoại đã thuộc tài khoản khác.',409);
  if(!$old&&count(roster_rows($st))>=1000)fail('Danh sách đã đạt giới hạn 1000 người.',409);
  $password=null;if($phone!==''&&$pid===null){if(count(array_filter($st['participants'],function($p){return !empty($p['phone']);}))>=$config['max_participants'])fail('Đã đạt giới hạn tài khoản cấu hình cho lớp.',409);$pid=token();$password=initial_student_password($name,$phone);$st['participants'][$pid]=array('joined'=>gmdate('c'),'password_hash'=>password_hash($password,PASSWORD_DEFAULT));}
  if($old){foreach($st['participants'] as &$person)if($person['school']===$old['school']&&$person['name']===$old['name']&&empty($person['phone'])){$person['school']=$school;$person['name']=$name;$person['role']=$role;}unset($person);}
  if($pid!==null){$st['participants'][$pid]['name']=$name;$st['participants'][$pid]['school']=$school;$st['participants'][$pid]['role']=$role;$st['participants'][$pid]['phone']=$phone;}
  if($old){foreach($st['portal']['directory'] as &$unit)if($unit['school']===$old['school']){$unit['people']=array_values(array_filter($unit['people'],function($p)use($old){return $p['name']!==$old['name'];}));}unset($unit);}
  portal_remember($st,$school,$name,$role);audit($st,'Cập nhật danh sách tập huấn: '.$name.' / '.$school);return array('ok'=>true,'initial_password'=>$password,'account'=>$phone);
 }
 if($action==='portal_roster_school_save'){
  $old=portal_field($input,'old_school',180);$name=portal_field($input,'school',180);if($name==='')fail('Nhập tên trường.',400);$exists=false;foreach(portal_directory($st) as $u){if($u['school']===$old)$exists=true;if($u['school']===$name&&$name!==$old)fail('Tên trường đã có. Sửa từng người nếu cần chuyển trường; không gộp tự động.',409);}
  if($old!==''){if(!$exists||!isset($input['token'])||!is_string($input['token'])||!hash_equals(roster_school_token($st,$old),$input['token']))fail('Danh sách trường vừa thay đổi. Tải lại trước khi đổi tên.',409);foreach($st['portal']['directory'] as &$u)if($u['school']===$old)$u['school']=$name;unset($u);foreach($st['participants'] as &$p)if($p['school']===$old)$p['school']=$name;unset($p);
   // Trường chỉ được suy ra từ tài khoản vẫn cần có đơn vị trong danh sách lưu.
   $found=false;foreach($st['portal']['directory'] as $u)if($u['school']===$name)$found=true;if(!$found)$st['portal']['directory'][]=array('school'=>$name,'people'=>array());
  }else{if(count(portal_directory($st))>=500)fail('Đã đạt giới hạn 500 trường.',409);$st['portal']['directory'][]=array('school'=>$name,'people'=>array());}
  audit($st,'Cập nhật trường tập huấn: '.$name);return array('ok'=>true);
 }
 fail('Thao tác danh sách không hợp lệ.',404);
 },true);}
