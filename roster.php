<?php
// Biên tập danh sách gốc và hồ sơ tài khoản; không thay mã tài khoản hoặc lịch sử buổi.
function roster_rows($st){$rows=array();foreach(portal_directory($st) as $u)foreach($u['people'] as $person){$linked=array();foreach($st['participants'] as $id=>$p)if($p['school']===$u['school']&&$p['name']===$person['name']&&!empty($p['phone']))$linked[$id]=$p;$first=count($linked)?reset($linked):null;$key=attendance_identity($u['school'],$person['name']);$rows[]=array('key'=>$key,'school'=>$u['school'],'name'=>$person['name'],'role'=>$first?$first['role']:$person['role'],'phone'=>$first?$first['phone']:'','account_count'=>count($linked),'token'=>hash('sha256',json_encode(array($u['school'],$person,$linked))));}return $rows;}
function roster_school_token($st,$school){$unit=null;foreach(portal_directory($st) as $u)if($u['school']===$school)$unit=$u;$people=array();foreach($st['participants'] as $id=>$p)if($p['school']===$school)$people[$id]=$p;return hash('sha256',json_encode(array($unit,$people)));}
function roster_summary($st){$schools=array();foreach(portal_directory($st) as $u)$schools[]=array('name'=>$u['school'],'count'=>count($u['people']),'token'=>roster_school_token($st,$u['school']));return array('rows'=>roster_rows($st),'schools'=>$schools);}
function roster_import_token($st){return hash('sha256',json_encode(array($st['portal']['directory'],$st['participants'],isset($st['portal']['roster_removed'])?$st['portal']['roster_removed']:array(),isset($st['portal']['schools_removed'])?$st['portal']['schools_removed']:array())));}
function roster_actions($action,$input){need_admin();global $config;return with_state(function(&$st)use($action,$input,$config){
 if($action==='portal_roster_school_delete_many'){
  $items=isset($input['items'])?$input['items']:null;if(!is_array($items)||!count($items)||count($items)>500)fail('Chọn từ 1 đến 500 trường.',400);
  if(!isset($input['confirm'])||$input['confirm']!=='XOA '.count($items).' TRUONG')fail('Nhập đúng nội dung xác nhận xoá trường.',400);
  $known=array_column(roster_summary($st)['schools'],null,'name');$names=array();foreach($items as $item){if(!is_array($item)||!isset($item['name'],$item['token'])||!is_string($item['name'])||!is_string($item['token'])||!isset($known[$item['name']])||!hash_equals($known[$item['name']]['token'],$item['token']))fail('Danh sách trường vừa thay đổi. Tải lại rồi chọn lại.',409);if(isset($names[$item['name']]))fail('Trùng trường trong yêu cầu xoá.',400);$names[$item['name']]=true;}
  foreach($names as $name=>$yes)$st['portal']['schools_removed'][$name]=true;
  audit($st,'Xoá khỏi danh mục chọn điểm danh: '.count($names).' trường; giữ hồ sơ và lịch sử.');return array('ok'=>true,'deleted'=>count($names));
 }
 if($action==='portal_roster_school_import'){
  $items=isset($input['rows'])?$input['rows']:null;if(!is_array($items)||!count($items)||count($items)>200)fail('Mỗi lần nhập từ 1 đến 200 trường.',400);
  $snapshot=roster_import_token($st);$known=array_column(roster_summary($st)['schools'],null,'name');$seen=array();$pending=array();$skipped=0;$restored=0;
  foreach($items as $i=>$item){if(!is_array($item))fail('Dòng nhập không hợp lệ.',400);$name=portal_field($item,'school',180);if($name==='')fail('Dòng '.($i+2).': thiếu tên trường.',400);if(isset($seen[$name]))fail('Dòng '.($i+2).': trùng tên trường trong file.',409);$seen[$name]=true;if(isset($known[$name])){$skipped++;continue;}$pending[]=$name;if(!empty($st['portal']['schools_removed'][$name]))$restored++;}
  if(count($known)+count($pending)>500)fail('Vượt giới hạn 500 trường.',409);
  // Khôi phục trường cũng khôi phục các tên đang lưu, trừ các tên đã xoá riêng.
  $preview=$st;foreach($pending as $name){unset($preview['portal']['schools_removed'][$name]);$found=false;foreach($preview['portal']['directory'] as $u)if($u['school']===$name)$found=true;if(!$found)$preview['portal']['directory'][]=array('school'=>$name,'people'=>array());}
  if(count(roster_rows($preview))>1000)fail('Khôi phục trường sẽ vượt giới hạn 1000 người.',409);
  if(empty($input['commit']))return array('ok'=>true,'token'=>$snapshot,'added'=>count($pending),'skipped'=>$skipped,'restored'=>$restored);
  if(!isset($input['token'])||!is_string($input['token'])||!hash_equals($snapshot,$input['token']))fail('Danh sách vừa thay đổi. Xem trước lại file.',409);
  $st['portal']=$preview['portal'];audit($st,'Nhập danh sách trường Excel: '.count($pending).' trường.');return array('ok'=>true,'added'=>count($pending),'skipped'=>$skipped,'restored'=>$restored);
 }
 if($action==='portal_roster_delete_many'){
  $items=isset($input['items'])?$input['items']:null;if(!is_array($items)||!count($items)||count($items)>1000)fail('Chọn từ 1 đến 1000 người.',400);
  if(!isset($input['confirm'])||$input['confirm']!=='XOA '.count($items))fail('Nhập đúng nội dung xác nhận xoá.',400);
  $rows=array_column(roster_rows($st),null,'key');$keys=array();foreach($items as $item){if(!is_array($item)||!isset($item['key'],$item['token'])||!is_string($item['key'])||!is_string($item['token'])||!isset($rows[$item['key']])||!hash_equals($rows[$item['key']]['token'],$item['token']))fail('Danh sách vừa thay đổi. Tải lại rồi chọn lại.',409);$keys[$item['key']]=true;}
  foreach($keys as $key=>$yes)$st['portal']['roster_removed'][$key]=true;
  foreach($st['portal']['directory'] as &$unit)$unit['people']=array_values(array_filter($unit['people'],function($p)use($unit,$keys){return !isset($keys[attendance_identity($unit['school'],$p['name'])]);}));unset($unit);
  audit($st,'Xoá khỏi danh sách tập huấn: '.count($keys).' người; giữ tài khoản và lịch sử.');return array('ok'=>true,'deleted'=>count($keys));
 }
 if($action==='portal_roster_import'){
  $items=isset($input['rows'])?$input['rows']:null;if(!is_array($items)||!count($items)||count($items)>200)fail('Mỗi lần nhập từ 1 đến 200 dòng.',400);
  $snapshot=roster_import_token($st);
  $known=array_column(roster_rows($st),null,'key');$seen=array();$phones=array();foreach($st['participants'] as $p)if(!empty($p['phone']))$phones[$p['phone']]=true;
  $pending=array();$skipped=0;foreach($items as $i=>$item){if(!is_array($item))fail('Dòng nhập không hợp lệ.',400);$school=portal_field($item,'school',180);$name=portal_field($item,'name',100);$role=portal_field($item,'role',100);$raw=portal_field($item,'phone',30);$phone=$raw!==''?phone_number($raw):'';$line=$i+2;
   if($school===''||$name==='')fail('Dòng '.$line.': thiếu trường hoặc họ tên.',400);if($phone!==''&&$role==='')fail('Dòng '.$line.': có số điện thoại cần có chức vụ.',400);
   $key=attendance_identity($school,$name);if(isset($seen[$key]))fail('Dòng '.$line.': trùng trường và họ tên trong file.',409);$seen[$key]=true;
   if(isset($known[$key])){if(($role!==''&&$known[$key]['role']!==$role)||($phone!==''&&$known[$key]['phone']!==$phone))fail('Dòng '.$line.': người đã có thông tin khác. Sửa trực tiếp trong danh sách.',409);$skipped++;continue;}
   // Người đã xoá nhưng có tài khoản: khôi phục danh sách, không tạo tài khoản thứ hai.
   $linked=null;foreach($st['participants'] as $id=>$p)if($p['school']===$school&&$p['name']===$name&&!empty($p['phone'])){if($linked!==null)fail('Dòng '.$line.': trùng nhiều tài khoản.',409);$linked=$p;}
   if($linked){if(($phone!==''&&$phone!==$linked['phone'])||($role!==''&&$role!==$linked['role']))fail('Dòng '.$line.': khác hồ sơ tài khoản đã có.',409);$phone='';$role=$linked['role'];}
   if($phone!==''&&isset($phones[$phone]))fail('Dòng '.$line.': số điện thoại đã được sử dụng.',409);if($phone!=='')$phones[$phone]=true;
   $pending[]=array('school'=>$school,'name'=>$name,'role'=>$role,'phone'=>$phone);
  }
  if(count($known)+count($pending)>1000)fail('Danh sách vượt 1000 người.',409);$accounts=count(array_filter($st['participants'],function($p){return !empty($p['phone']);}));$newAccounts=count(array_filter($pending,function($p){return $p['phone']!=='';}));if($accounts+$newAccounts>$config['max_participants'])fail('Vượt giới hạn tài khoản cấu hình.',409);
  $schools=array();foreach(portal_directory($st) as $u)$schools[$u['school']]=true;foreach($pending as $p)$schools[$p['school']]=true;if(count($schools)>500)fail('Vượt giới hạn 500 trường.',409);
  $check=$st;foreach($pending as $p)portal_remember($check,$p['school'],$p['name'],$p['role']);if(count(roster_rows($check))>1000)fail('Khôi phục trường sẽ vượt giới hạn 1000 người.',409);
  if(empty($input['commit']))return array('ok'=>true,'token'=>$snapshot,'added'=>count($pending),'skipped'=>$skipped,'accounts'=>$newAccounts);
  if(!isset($input['token'])||!is_string($input['token'])||!hash_equals($snapshot,$input['token']))fail('Danh sách vừa thay đổi. Xem trước lại file.',409);
  foreach($pending as $p){portal_remember($st,$p['school'],$p['name'],$p['role']);if($p['phone']!==''){$id=token();$st['participants'][$id]=array_merge($p,array('joined'=>gmdate('c'),'password_hash'=>password_hash(initial_student_password($p['name'],$p['phone']),PASSWORD_DEFAULT)));}}
  audit($st,'Nhập danh sách Excel: '.count($pending).' người.');return array('ok'=>true,'added'=>count($pending),'skipped'=>$skipped);
 }
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
  portal_remember($st,$school,$name,$role);if(count(roster_rows($st))>1000||count(portal_directory($st))>500)fail('Vượt giới hạn danh sách 1000 người / 500 trường.',409);audit($st,'Cập nhật danh sách tập huấn: '.$name.' / '.$school);return array('ok'=>true,'initial_password'=>$password,'account'=>$phone);
 }
 if($action==='portal_roster_school_save'){
  $old=portal_field($input,'old_school',180);$name=portal_field($input,'school',180);if($name==='')fail('Nhập tên trường.',400);$exists=false;foreach(portal_directory($st) as $u){if($u['school']===$old)$exists=true;if($u['school']===$name&&$name!==$old)fail('Tên trường đã có. Sửa từng người nếu cần chuyển trường; không gộp tự động.',409);}
  if($old!==''&&$name!==$old&&!empty($st['portal']['schools_removed'][$name]))fail('Tên trường đang được lưu sau khi xoá. Thêm lại trường đó trước; không gộp hồ sơ tự động.',409);
  if($old!==''){if(!$exists||!isset($input['token'])||!is_string($input['token'])||!hash_equals(roster_school_token($st,$old),$input['token']))fail('Danh sách trường vừa thay đổi. Tải lại trước khi đổi tên.',409);foreach($st['portal']['directory'] as &$u)if($u['school']===$old)$u['school']=$name;unset($u);foreach($st['participants'] as &$p)if($p['school']===$old){$removed=attendance_identity($old,$p['name']);if(!empty($st['portal']['roster_removed'][$removed])){unset($st['portal']['roster_removed'][$removed]);$st['portal']['roster_removed'][attendance_identity($name,$p['name'])]=true;}$p['school']=$name;}unset($p);
   // Trường chỉ được suy ra từ tài khoản vẫn cần có đơn vị trong danh sách lưu.
   $found=false;foreach($st['portal']['directory'] as $u)if($u['school']===$name)$found=true;if(!$found)$st['portal']['directory'][]=array('school'=>$name,'people'=>array());
  }else{if(count(portal_directory($st))>=500)fail('Đã đạt giới hạn 500 trường.',409);$found=false;foreach($st['portal']['directory'] as $u)if($u['school']===$name)$found=true;if(!$found)$st['portal']['directory'][]=array('school'=>$name,'people'=>array());unset($st['portal']['schools_removed'][$name]);}
  if(count(roster_rows($st))>1000)fail('Khôi phục trường sẽ vượt giới hạn 1000 người.',409);
  audit($st,'Cập nhật trường tập huấn: '.$name);return array('ok'=>true);
 }
 fail('Thao tác danh sách không hợp lệ.',404);
 },true);}
